<?php

namespace App\Services;

use App\Common\RequestHelper;
use App\Enum\AccessChannelType;
use App\Enum\ActivationStatusEnum;
use App\Enum\UserActionEnum;
use App\Enum\UserStatusEnum;
use App\Enum\UserWalletTypeEnum;
use App\Events\User\UserCreated;
use App\Events\User\UserCreating;
use App\Events\User\UserPasswordChanged;
use App\Events\User\UserProfileUpdated;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class UserService extends BaseService
{
    public $userRepository;
    public $userActionLogService;

    public function __construct(
        UserRepositoryContract $userRepository,
        UserActionLogService $userActionLogService
    ) {
        $this->userRepository = $userRepository;
        $this->userActionLogService = $userActionLogService;
    }

    public function searchByAdmin($data = [])
    {
        $builder = $this->userRepository
            ->with(data_get($data, 'with', []))
            ->whereColumnsLike(data_get($data, 'query'), ['id', 'username' , 'email', 'phone_number'])
            ->whereColumnsLike(data_get($data, 'username', null), ['username'])
            ->whereColumnsLike(data_get($data, 'email', null), ['email'])
            ->whereColumnsLike((string) phone(data_get($data, 'phone_number', null)), ['phone_number'])
            ->scopeQuery(function($q) use ($data) {
                if ($createdAtRange = data_get($data, 'created_at_range', [])) {
                    $q->whereBetween('created_at', $createdAtRange);
                }

                if (data_get($data, 'search_exact') && $username = data_get($data, 'username')) {
                    $q->where('username', $username);
                }

                $statuses = array_filter_empty(Arr::wrap(data_get($data, 'status')));

                if (! empty($statuses)) {
                    $q->whereIn('status', $statuses);
                }
            });

        return $builder->search([]);
    }

    public function allAvailable($data = [])
    {
        return $this->userRepository
            ->scopeQuery(function($q) {
                $q->where('status', UserStatusEnum::ACTIVE);
            })
            ->all();
    }

    public function create($attributes = [])
    {
        $attributes['status'] = ActivationStatusEnum::ACTIVE;

        $user = DB::transaction(function() use ($attributes) {
            /** @var User */
            $user = $this->userRepository->create($attributes);

            $user->userWallets()->create([
                'balance' => 0,
                'status' => ActivationStatusEnum::ACTIVE,
                'type' => UserWalletTypeEnum::SHOPPING,
                'currency_code' => $user->currency_code,
                'activated' => true,
            ]);

            UserCreating::dispatch($user);

            return $user;
        });

        $userEmailVerificationLink = !empty($user->email) ? $user->generateEmailVerificationUrl(data_get($attributes, 'email_verification_url')) : null;

        UserCreated::dispatch($user, $attributes, $userEmailVerificationLink);

        return $user;
    }

    public function show($id)
    {
        return $this->userRepository->findOrFail($id);
    }

    public function findByUsername($username = null, $data = [])
    {
        return $this->userRepository->with(data_get($data, 'with', []))->firstWhere(['username' => $username]);
    }

    public function findByPhoneNumber($phoneNumber)
    {
        return $this->userRepository->firstWhere(['phone_number' => $phoneNumber]);
    }

    public function findByEmail($email)
    {
        return $this->userRepository->firstWhere(['email' => $email]);
    }

    public function changePassword($userId, $password)
    {
        $user = $this->userRepository->update(['password' => $password], $userId);

        UserPasswordChanged::dispatch();

        return $user;
    }

    public function updateInfo($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $user = $this->show($id);

            $userData = Arr::only($attributes ?? [], [
                'email',
                'username',
                'name',
                'phone_number',
                'birthday',
                'access_channel_type',
                'meta',
                'allow_login'
            ]);

            // TODO: should separate update phone_number/email to another flow.
            if (! empty($userData)) {
                if ($phone_number = data_get($userData, 'phone_number')) {
                    if ($phone_number != $user->phone_number) {
                        $userData['phone_verified_at'] = null;
                    }
                } else {
                    $userData['phone_number'] = null;
                }
                if ($email = data_get($userData, 'email')) {
                    if ($email != $user->email) {
                        $userData['email_verified_at'] = null;
                    }
                }

                $user = $this->update($userData, $user->id);
            }

            UserProfileUpdated::dispatch($user);

            return $user;
        });
    }

    public function update($data = [], $userId)
    {
        $user = $this->userRepository->update($data, $userId);

        UserProfileUpdated::dispatch($user);

        return $user;
    }

    public function generateUsername($length = 8)
    {
        $username = mb_strtolower(Str::random($length));

        while ($this->userRepository->exists(['username' => $username])) {
            $username = mb_strtolower(Str::random($length));
        }

        return $username;
    }

    public function handleUserAction($data, $userId)
    {
        $attributes = [
            'user_id' => $userId,
            'type' => UserActionEnum::constant(data_get($data, 'type')),
            'reason' => data_get($data, 'reason'),
        ];

        $user = DB::transaction(function () use ($attributes, $userId) {
            $this->userActionLogService->create($attributes);

            $updateAction = [];

            switch (data_get($attributes, 'type')) {
                case UserActionEnum::ACTIVE:
                    $updateAction = ['status' => true];
                    break;
                case UserActionEnum::DEACTIVATE:
                    $updateAction = ['status' => false];
                    break;
                default:
                    break;
            }

            return $this->userRepository->update($updateAction, $userId);
        });

        return $user;
    }
}

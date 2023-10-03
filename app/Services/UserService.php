<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Events\User\UserCreated;
use App\Events\User\UserCreating;
use App\Events\User\UserPasswordChanged;
use App\Events\User\UserProfileUpdated;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\BaseService;
use App\Services\UserDetailService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    public $userRepository;
    public $userDetailService;

    public function __construct(
        UserRepositoryContract $userRepository,
        UserDetailService $userDetailService
    ) {
        $this->userRepository = $userRepository;
        $this->userDetailService = $userDetailService;
    }

    public function searchByAdmin($data = [])
    {
        $withRelations = array_merge(data_get($data, 'with', []), ['userDetail']);

        $builder = $this->userRepository
            ->with($withRelations)
            ->whereColumnsLike(data_get($data, 'query'), ['username' , 'email', 'phone_number'])
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
            });

        return $builder->search([]);
    }

    public function create($attributes = [])
    {
        $attributes['status'] = ActivationStatusEnum::ACTIVE;

        $user = DB::transaction(function() use ($attributes) {
            $user = $this->userRepository->create($attributes);

            UserCreating::dispatch($user);

            return $user;
        });

        $userEmailVerificationLink = $user->generateEmailVerificationUrl(data_get($attributes, 'email_verification_url'));

        UserCreated::dispatch($user, $attributes, $userEmailVerificationLink);

        return $user;
    }

    public function show($id)
    {
        return $this->userRepository->findOrFail($id);
    }

    public function findByUsername($username = null, $data = [])
    {
        $with = array_merge(Arr::wrap(data_get($data, 'with', [])), ['userDetail', 'systemCurrency']);

        return $this->userRepository->with($with)->firstWhere(['username' => $username]);
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

    public function updateInfo($data = [], $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $user = $this->show($userId);

            $userData = Arr::only($data ?? [], ['email', 'username', 'phone_number']);

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

            $user->userDetail = $this->userDetailService->updateByUser($user->id, $data);

            UserProfileUpdated::dispatch($user, $user->userDetail);

            return $user;
        });
    }

    public function update($data = [], $userId)
    {
        $user = $this->userRepository->update($data, $userId);

        UserProfileUpdated::dispatch($user);

        return $user;
    }
}

<?php

namespace App\Services;

use App\Enum\UserStatusEnum;
use App\Models\BaseModel;
use App\Repositories\Contracts\OauthUserRepositoryContract;
use App\Services\BaseService;
use App\Vendors\Localization\SystemCurrency;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OauthUserService extends BaseService
{
    public $oauthUserRepository;
    public $userService;

    public function __construct(OauthUserRepositoryContract $oauthUserRepository, UserService $userService)
    {
        $this->oauthUserRepository = $oauthUserRepository;
        $this->userService = $userService;
    }

    public function findOrCreate($provider, $oauthUser, $data = [])
	{
        $data = Arr::only($data, ['phone_number']);

		$user = DB::transaction(function () use ($provider, $oauthUser, $data) {
            $myOauthUser = $this->findByProviderUser($provider, data_get($oauthUser, 'id'));

			$user = optional($myOauthUser)->user;

            $meta = [];

            $needUpdateUser = true;

            if (empty($user)) {
                $attributes = $this->prepareUserAttributes($oauthUser);

                $email = data_get($attributes, 'email');

                if ($email) {
					$user = $this->userService->findByEmail($email);
				}

                if (! $user) {
					$user = $this->userService->create(array_merge($attributes, $data));

                    $needUpdateUser = false;
				}
            }

            if (! empty($data) && $needUpdateUser) {
                $user = $this->userService->update($data, get_model_key($user));
            }

            $this->oauthUserRepository->updateOrCreate([
                'provider' => $provider,
                'provider_user_id' => data_get($oauthUser, 'id'),
            ], [
                'user_id' => BaseModel::getModelKey($user),
                'meta' => array_merge($oauthUser->meta ?? [], $meta)
            ]);

            return $user;
		});

		return $user;
	}

    public function prepareUserAttributes($oauthUser = []): array {

		return [
			'username' => UserService::make()->generateUsername(),
			'name' => data_get($oauthUser, 'name'), // can be null if provider not provide
            'email' => data_get($oauthUser, 'email'), // can be null if provider not provide
            'password' => Str::random(12),
            'status' => UserStatusEnum::ACTIVE,
            'currency_code' => SystemCurrency::getDefaultCurrency()->code,
		];
    }

    public function findByProviderUser($provider, $providerUserId)
	{
		return $this->oauthUserRepository->firstWhere([
			'provider' => $provider,
			'provider_user_id' => $providerUserId,
		]);
	}
}

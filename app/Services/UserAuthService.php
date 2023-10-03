<?php

namespace App\Services;

use App\Classes\UserAuth;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthService extends BaseService
{
    public $userService;
    public $userAuth;

    public function __construct(UserService $userService, UserAuth $userAuth)
    {
        $this->userService = $userService;
        $this->userAuth = $userAuth;
    }

    public function signup($attributes = [])
    {
        $attributes['last_logged_in_at'] = now();

        $user = $this->userService->create($attributes);

        return $user;
    }

    public function signin($credentials = [])
    {
        return DB::transaction(function() use ($credentials) {
            $phoneNumber = data_get($credentials, 'phone_number');
            $passwordLogin = data_get($credentials, 'password');

            $user = $this->userService->findByPhoneNumber($phoneNumber);


            if (empty($user)) {
                throw ValidationException::withMessages(['username' => __('validation.custom.invalid_credential')]);
            }

            if (! Hash::check($passwordLogin, $user->password)) {
                throw ValidationException::withMessages(['password' => __('validation.custom.invalid_credential')]);
            }

            $this->userAuth->login($user);

            return $user;
        });
    }
}

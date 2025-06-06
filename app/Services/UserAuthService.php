<?php

namespace App\Services;

use App\Classes\Contracts\UserAuthContract;
use App\Common\RequestHelper;
use App\Enum\AccessChannelType;
use App\Models\User;
use App\Vendors\Localization\SystemCurrency;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthService extends BaseService
{
    public $userAuth;
    public $userService;

    public function __construct(UserAuthContract $userAuth, UserService $userService)
    {
        $this->userAuth = $userAuth;
        $this->userService = $userService;
    }

    public function signup($attributes = [])
    {
        $attributes = array_merge([
            'currency_code' => SystemCurrency::getDefaultCurrency()->getKey(),
            'access_channel_type' => AccessChannelType::WEBSITE,
            'allow_login' => true,
            'meta' => [
                'footprint' => RequestHelper::getDataFromRequest(request(), config('security.footprint_fields', []))
            ]
        ], $attributes);

        return  $this->userService->create($attributes);
    }

    public function signin($credentials = [])
    {
        $username = data_get($credentials, 'username');
        $password = data_get($credentials, 'password');

        $this->signinWithCredentials($username, $password);

        $user = $this->userAuth->user();

        $user->setLoggedInAt(now());

        return $user;
    }

    public function findUserForLogin($username)
    {
        $user = $this->userService->findByEmail($username);

        if (empty($user)) {
            $user = $this->userService->findByPhoneNumber($username);
        }

        return $user;
    }

    public function signinWithCredentials($username, $password)
    {
        $user = $this->findUserForLogin($username);

        if (! ($user instanceof User)) {
            throw ValidationException::withMessages(['username' => 'Thông tin đăng nhập không đúng.']);
        }

        if (! $user->isActive() || ! boolean($user->allow_login)) {
            throw ValidationException::withMessages(['username' => 'Không thể đăng nhập vào lúc này.']);
        }

        if (! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages(['password' => 'Thông tin đăng nhập không đúng.']);
        }

        return $this->userAuth->login($user);
    }

    public function signinByUser(User $user)
    {
        $this->userAuth->login($user);

        $user->setLoggedInAt(now());

        return $user;
    }
}

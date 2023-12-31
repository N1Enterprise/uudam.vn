<?php

namespace App\Classes;

use App\Classes\Contracts\UserAuthContract;
use Illuminate\Support\Facades\Password;
use Closure;

class UserAuth implements UserAuthContract
{
    public $guard = 'user';

    public $passwordBroker = 'users';

    public $ttl = 24 * 60;

    /** @return \Illuminate\Auth\SessionGuard */
    public function guard()
    {
        return auth($this->guard);
    }

    public function guardAs(string $guard)
    {
        $this->guard = $guard;

        return $this;
    }

    public function attempt(array $credentials = [])
    {

    }

    public function login($user)
    {
        return $this->guard()->login($user, true);
    }

    public function logout($forceForever = false): void
    {
        $this->guard()->logout($forceForever);
    }

    public function user()
    {
        return $this->guard()->user();
    }

    public function password()
    {
        return Password::broker($this->passwordBroker);
    }

    public function forgotPassword($credentials = [], $callback = null)
    {
        $status = $this->password()->sendResetLink($credentials, $callback);

        return $status;
    }

    public function resetPassword($credentials, Closure $callback)
    {
        $status = $this->password()->reset($credentials, $callback);

        return $status;
    }
}

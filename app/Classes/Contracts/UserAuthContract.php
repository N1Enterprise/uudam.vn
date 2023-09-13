<?php

namespace Modules\User\Classes\Contracts;

interface UserAuthContract
{
    /**
     * @return \Tymon\JWTAuth\JWTGuard
     */
    public function guard();

    public function guardAs(string $guard);

    public function attempt(array $credentials = []);

    public function login();

    public function logout($forceForever = false): void;

    /**
     * @return \Modules\User\Entities\User
     */
    public function user();

    /**
     * @return \Illuminate\Support\Facades\Password
     */
    public function password();

    public function forgotPassword($credentials = [], $callback = null);

    public function resetPassword($credentials, \Closure $callback);
}

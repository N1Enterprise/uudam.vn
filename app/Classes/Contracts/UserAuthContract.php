<?php

namespace App\Classes\Contracts;

use App\Models\User;

interface UserAuthContract
{
    public function guard();

    public function guardAs(string $guard);

    public function attempt(array $credentials = []);

    public function login(User $user);

    public function logout($forceForever = false): void;

    /**
     * @return \App\Models\User
     */
    public function user();

    /**
     * @return \Illuminate\Support\Facades\Password
     */
    public function password();

    public function forgotPassword($credentials = [], $callback = null);

    public function resetPassword($credentials, \Closure $callback);
}

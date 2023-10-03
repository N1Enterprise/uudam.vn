<?php

namespace App\Classes;

use App\Models\Admin;

class UserAuth
{
    public static $guard = 'user';

    /**
     * @return \Illuminate\Auth\SessionGuard
     */
    public static function guard()
    {
        return auth(static::$guard);
    }

    public static function logout($forceForever = false): void
    {
        static::guard()->logout($forceForever);
    }

    public static function login($user, $remember = false)
    {
        static::guard()->login($user, $remember);
    }

    /**
     * @return Admin
     */
    public static function user()
    {
        return static::guard()->user();
    }
}

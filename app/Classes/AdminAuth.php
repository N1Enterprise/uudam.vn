<?php

namespace App\Classes;

use App\Models\Admin;

class AdminAuth
{
    public static $guard = 'admin';

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

    /**
     * @return Admin
     */
    public static function user()
    {
        return static::guard()->user();
    }
}

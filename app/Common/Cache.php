<?php

namespace App\Common;

use Illuminate\Support\Facades\Cache as LaravelCache;

class Cache extends LaravelCache
{
    public static function forgetCacheByKeys($keys = [])
    {
        foreach ($keys as $key) {
            self::forget($key);
        }
    }

    public static function resolveKey($keyFormat, $values)
    {
        return vsprintf($keyFormat, ...$values);
    }
}

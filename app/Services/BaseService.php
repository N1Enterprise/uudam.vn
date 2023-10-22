<?php

namespace App\Services;

use App\Common\Cache;

abstract class BaseService
{
    public const DEFAULT_CACHE_LOCK_TTL = 10;
    public const DEFAULT_CACHE_LOCK_MAXIMUM_WAIT = 5;

    public function lock(\Closure $callback, $key, $seconds = self::DEFAULT_CACHE_LOCK_TTL, $maximumWait = self::DEFAULT_CACHE_LOCK_MAXIMUM_WAIT, $owner = null)
    {
        $lock = Cache::lock($key, $seconds, $owner);

        try {
            $lock->block($maximumWait, $callback);
        } catch (\Throwable $th) {
            throw $th;
        } finally {
            optional($lock)->release();
        }
    }

    public function generateLockKey($key = null)
    {
        return is_array($key) ? implode('-', $key) : $key;
    }
}

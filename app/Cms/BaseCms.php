<?php

namespace App\Cms;

use App\Common\Cache;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class BaseCms
{
    /**
     * @return static
     * @throws BindingResolutionException
     */
    public static function make()
    {
        return app(static::class);
    }

    abstract public function model();

    public static function flush()
    {
        Cache::tags(static::CACHE_TAG)->flush();
    }
}

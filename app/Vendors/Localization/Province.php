<?php

namespace App\Vendors\Localization;

use App\Common\Cache;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Models\Province as ProvinceEntity;

class Province
{
    public const CACHE_TAG = 'address';

    /**
     * @return static
     * @throws BindingResolutionException
     */
    public static function make()
    {
        return app(static::class);
    }

    /**
     * @return ProvinceEntity
     * @throws BindingResolutionException
     */
    public function model()
    {
        return app(ProvinceEntity::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        $cacheKey = 'province:all';

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() {
            return $this->model()->query()->get([
                'code',
                'name',
                'full_name'
            ]);
        });
    }
}

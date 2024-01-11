<?php

namespace App\Vendors\Localization;

use App\Common\Cache;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Models\District as DistrictEntity;

class District
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
     * @return DistrictEntity
     * @throws BindingResolutionException
     */
    public function model()
    {
        return app(DistrictEntity::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        $cacheKey = 'district:all';

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() {
            return $this->model()->query()->get([
                'code',
                'name',
                'full_name',
                'province_code'
            ]);
        });
    }

    public function getByProviceCode($provinceCode)
    {
        $districts = $this->all()->groupBy('province_code');

        return $districts[$provinceCode] ?? [];
    }
}

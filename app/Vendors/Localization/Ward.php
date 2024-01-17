<?php

namespace App\Vendors\Localization;

use App\Common\Cache;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Models\Ward as WardEntity;

class Ward
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
     * @return WardEntity
     * @throws BindingResolutionException
     */
    public function model()
    {
        return app(WardEntity::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        $cacheKey = 'ward:all';

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() {
            return $this->model()->query()->get([
                'code',
                'name',
                'full_name',
                'district_code'
            ]);
        });
    }

    public function getByDistrictCode($districtCode)
    {
        $wards = $this->all()->groupBy('district_code');

        return $wards[$districtCode] ?? [];
    }
}

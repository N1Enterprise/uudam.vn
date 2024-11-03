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

    public function all($data = [])
    {
        return $this->model()->query()
            ->with(data_get($data, 'with', []))
            ->get(array_merge(['code', 'name', 'full_name', 'province_code'], data_get($data, 'columns', [])));
    }

    public function find($id)
    {
        return $this->model()->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allInCache()
    {
        $cacheKey = 'district:all';

        return Cache::tags(self::CACHE_TAG)->rememberForever($cacheKey, function() {
            return $this->model()->query()->get([
                'code',
                'name',
                'full_name',
                'province_code',
                'full_name_en'
            ]);
        });
    }

    public function getByProviceCode($provinceCode)
    {
        $districts = $this->allInCache()->groupBy('province_code');

        return $districts[$provinceCode] ?? [];
    }
}

<?php

namespace App\Vendors\Localization;

use Illuminate\Contracts\Container\BindingResolutionException;
use App\Models\Currency as CurrencyEntity;
use App\Enum\ActivationStatusEnum;

class Currency
{
    /**
     * @return static
     * @throws BindingResolutionException
     */
    public static function make()
    {
        return app(static::class);
    }

    /**
     * @return CurrencyEntity
     * @throws BindingResolutionException
     */
    public function model()
    {
        return app(CurrencyEntity::class);
    }

    public function all($data = [])
    {
        $groupByTypeName = data_get($data, 'group_by_type_name', false);
        $currencies = $this->model()->query()
            ->orderBy('type', 'desc')
            ->orderBy(data_get($data, 'order_by', 'code'), data_get($data, 'sort_by', 'ASC'))
            ->when(data_get($data, 'type'), function($q, $type) {
                $q->where('type', $type);
            })
            ->where('status', ActivationStatusEnum::ACTIVE)
            ->get();

        if($groupByTypeName) {
            $currencies = $currencies->groupBy('type_name');
        }

        return $currencies;
    }

    public function find($id)
    {
        return $this->model()->find($id);
    }

    public function findByCode($code)
    {
        return $this->model()->firstWhere('code', $code);
    }

    public function findByCountry($country)
    {
        return $this->model()->whereJsonContains('used_countries', $country)->first();
    }
}

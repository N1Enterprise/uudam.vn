<?php

namespace App\Models\Traits;

use App\Models\SystemCurrency as SystemCurrencyEntity;
use App\Vendors\Localization\SystemCurrency;

trait HasCurrency
{
    public $cachedSystemCurrency = null; // for cache

    public function currency()
    {
        return SystemCurrency::get($this->{$this->getCurrencyCodeColumn()});
    }

    public function getCurrencyAttribute()
    {
        if(!$this->cachedSystemCurrency) {
            $this->cachedSystemCurrency = $this->relationLoaded('systemCurrency') ? $this->systemCurrency : $this->currency(); //get from systemCurrency relation or get new instance from currency_code column
        }

        return $this->cachedSystemCurrency;
    }

    public function getCurrencyCodeColumn()
    {
        return defined('static::CURRENCY_CODE') ? static::CURRENCY_CODE : 'currency_code';
    }

    public function systemCurrency()
    {
        return $this->belongsTo(SystemCurrencyEntity::class, $this->getCurrencyCodeColumn(), 'key');
    }
}

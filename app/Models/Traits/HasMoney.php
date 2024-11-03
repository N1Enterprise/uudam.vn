<?php

namespace App\Models\Traits;

use App\Vendors\Localization\Money;
use App\Vendors\Localization\SystemCurrency;

trait HasMoney
{
    public function toMoney($amountField = 'price')
    {
        return Money::make($this->{$amountField} ?? 0, SystemCurrency::getDefaultCurrency()->getKey());
    }
}

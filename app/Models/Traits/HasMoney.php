<?php

namespace App\Models\Traits;

use App\Vendors\Localization\Money;

trait HasMoney
{
    public function toMoney($amountField = 'price')
    {
        return Money::make($this->{$amountField} ?? 0, 'VND');
    }
}

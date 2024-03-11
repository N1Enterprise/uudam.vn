<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\PaymentOption;

class BaseTransaction extends BaseModel
{
    public function paymentOption()
    {
        return $this->belongsTo(PaymentOption::class);
    }

    public function paymentProvider()
    {
        return $this->paymentOption->paymentProvider();
    }

    public function getProviderRequestAttribute()
    {
        return $this->log['request'] ?? [];
    }

    public function getProviderResponseAttribute()
    {
        return $this->log['response'] ?? [];
    }
}

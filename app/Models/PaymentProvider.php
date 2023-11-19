<?php

namespace App\Models;

use App\Enum\PaymentTypeEnum;
use App\Models\Traits\Activatable;

class PaymentProvider extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'code',
        'params',
        'payment_type',
        'status'
    ];

    protected $casts = [
        'params' => 'json'
    ];

    public function getPaymentTypeNameAttribute()
    {
        return PaymentTypeEnum::findConstantLabel($this->payment_type);
    }
}

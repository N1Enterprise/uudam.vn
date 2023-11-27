<?php

namespace App\Models;

use App\Enum\PaymentOptionTypeEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasCurrency;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasMoney;

class PaymentOption extends BaseModel
{
    use HasMoney;
    use Activatable;
    use HasCurrency;
    use HasFeUsage;

    protected $fillable = [
        'name',
        'type',
        'min_amount',
        'max_amount',
        'currency_code',
        'logo',
        'status',
        'online_banking_code',
        'payment_provider_id',
        'params',
        'display_on_frontend',
    ];

    protected $casts = [
        'params' => 'json'
    ];

    public function getTypeNameAttribute()
    {
        return PaymentOptionTypeEnum::findConstantLabel($this->type);
    }

    public function paymentProvider()
    {
        return $this->belongsTo(PaymentProvider::class);
    }

    public function isThirdParty()
    {
        return PaymentOptionTypeEnum::isThirdParty($this->type);
    }

    public function isCashOnDelivery()
    {
        return PaymentOptionTypeEnum::isCashOnDelivery($this->type);
    }

    public function isLocalBank()
    {
        return PaymentOptionTypeEnum::isLocalBank($this->type);
    }
}

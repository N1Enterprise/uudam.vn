<?php

namespace App\Models;

use App\Enum\ActivationStatusEnum;
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
        'description',
        'order',
        'expanded_content'
    ];

    protected $casts = [
        'params' => 'json'
    ];

    public function scopePaymentProviderActive($query)
    {
        return $query->where(function ($q) {
            $q->whereHas('paymentProvider', function ($q) {
                $q->where('status', ActivationStatusEnum::ACTIVE);
            })
            ->orWhereNull('payment_provider_id');
        });
    }

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

    public function isNoneAmount()
    {
        return PaymentOptionTypeEnum::isNoneAmount($this->type);
    }

    public function isLocalBank()
    {
        return PaymentOptionTypeEnum::isLocalBank($this->type);
    }
}

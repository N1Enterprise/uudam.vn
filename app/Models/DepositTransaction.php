<?php

namespace App\Models;

use App\Enum\DepositStatusEnum;
use App\Models\Traits\HasCurrency;
use App\Models\Traits\HasImpactor;
use App\Models\Traits\HasMoney;

class DepositTransaction extends BaseTransaction
{
    use HasCurrency;
    use HasImpactor;
    use HasMoney;

    protected $fillable = [
        'user_id',
        'uuid',
        'amount',
        'status',
        'payment_option_id',
        'note',
        'log',
        'reference_id',
        'order_id',
        'currency_code',
        'approved_index',
        'provider_payload',
        'bank_transfer_info',
        'provider_response',
        'created_by_id',
        'created_by_type',
        'updated_by_id',
        'updated_by_type',
        'footprint'
    ];

    protected $casts = [
        'log' => 'json',
        'provider_payload' => 'json',
        'bank_transfer_info' => 'json',
        'provider_response' => 'json',
        'footprint' => 'json'
    ];

    public function getStatusNameAttribute()
    {
        return DepositStatusEnum::findConstantLabel($this->status);
    }

    public function paymentOption()
    {
        return $this->belongsTo(PaymentOption::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function isPending()
    {
        return $this->status == DepositStatusEnum::PENDING;
    }

    public function scopeApproved($query)
    {
        return $query->where('status', DepositStatusEnum::APPROVED);
    }
}

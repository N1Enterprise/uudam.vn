<?php

namespace App\Models;

use App\Models\Traits\HasCurrency;
use App\Models\Traits\HasMoney;

class DepositTransaction extends BaseModel
{
    use HasCurrency;
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
        'created_by_id',
        'created_by_type',
        'updated_by_id',
        'updated_by_type',
    ];

    protected $casts = [
        'log' => 'json',
        'provider_payload' => 'json',
        'bank_transfer_info' => 'json'
    ];

    public function paymentOption()
    {
        return $this->belongsTo(PaymentOption::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

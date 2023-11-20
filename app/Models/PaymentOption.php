<?php

namespace App\Models;

use App\Models\Traits\Activatable;
use App\Models\Traits\HasMoney;

class PaymentOption extends BaseModel
{
    use Activatable;
    use HasMoney;

    protected $fillable = [
        'name',
        'type',
        'min_amount',
        'max_amount',
        'currency_code',
        'icon',
        'status',
        'online_banking_code',
        'payment_provider_id',
        'params',
        'display_on_frontend',
    ];

    protected $casts = [
        'params' => 'json'
    ];
}

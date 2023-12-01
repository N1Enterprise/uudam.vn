<?php

namespace App\Models;

use App\Models\Traits\Activatable;
use App\Models\Traits\HasCurrency;
use App\Models\Traits\HasMoney;

class UserWallet extends BaseModel
{
    use Activatable;
    use HasMoney;
    use HasCurrency;

    protected $fillable = [
        'balance',
        'status',
        'type',
        'user_id',
        'currency_code',
        'order_id'
    ];
}

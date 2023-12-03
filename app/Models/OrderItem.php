<?php

namespace App\Models;

use App\Models\Traits\HasCurrency;
use App\Models\Traits\HasMoney;

class OrderItem extends BaseModel
{
    use HasCurrency;
    use HasMoney;

    protected $fillable = [
        'order_id',
        'inventory_id',
        'item_description',
        'quantity',
        'price',
        'user_id',
        'currency_code',
        'total_price'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

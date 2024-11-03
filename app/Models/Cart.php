<?php

namespace App\Models;

use App\Enum\CartItemStatusEnum;
use App\Models\Traits\HasCurrency;
use App\Models\Traits\HasMoney;

class Cart extends BaseModel
{
    use HasCurrency;
    use HasMoney;

    protected $fillable = [
        'uuid',
        'ip_address',
        'user_id',
        'currency_code',
        'address_id',
        'total_item',
        'total_quantity',
        'total_price',
        'order_id',
        'retry_parent_id',
        'retry_times'
    ];

    public function availableItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id')->where('status', CartItemStatusEnum::PENDING);
    }

    public function scopeNotOrdered($query)
    {
        return $query->whereNull('order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id');
    }
}

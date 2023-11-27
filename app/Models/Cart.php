<?php

namespace App\Models;

use App\Enum\CartItemStatusEnum;
use App\Models\Traits\HasCurrency;

class Cart extends BaseModel
{
    use HasCurrency;

    protected $fillable = [
        'user_id',
        'ip_address',
        'address_id',
        'currency_code',
        'total_item',
        'total_quantity',
        'total_price',
        'order_id',
        'uuid',
    ];

    public function availableItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id')->where('status', CartItemStatusEnum::PENDING);
    }

    public function scopeNotOrdered($query)
    {
        return $query->whereNull('order_id');
    }
}

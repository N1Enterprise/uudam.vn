<?php

namespace App\Models;

use App\Enum\CartItemStatusEnum;

class Cart extends BaseModel
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'address_id',
        'total_item',
        'total_quantity',
        'total_price',
        'payment_option_id'
    ];

    public function availableItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'id')->where('status', CartItemStatusEnum::PENDING);
    }
}

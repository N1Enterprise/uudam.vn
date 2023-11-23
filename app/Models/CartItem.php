<?php

namespace App\Models;

use App\Enum\CartItemStatusEnum;
use App\Models\Traits\HasCurrency;
use App\Models\Traits\HasMoney;

class CartItem extends BaseModel
{
    use HasMoney;
    use HasCurrency;

    protected $fillable = [
        'cart_id',
        'uuid',
        'inventory_id',
        'note',
        'has_combo',
        'quantity',
        'currency_code',
        'price',
        'total_price',
        'user_id',
        'status',
    ];

    public function scopePending($query)
    {
        return $query->where('status', CartItemStatusEnum::PENDING);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}

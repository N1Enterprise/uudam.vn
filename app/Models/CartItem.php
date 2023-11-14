<?php

namespace App\Models;

use App\Enum\CartItemStatusEnum;

class CartItem extends BaseModel
{
    protected $fillable = [
        'cart_id',
        'key',
        'uuid',
        'inventory_id',
        'note',
        'has_combo',
        'quantity',
        'price',
        'status',
    ];

    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function scopePending($query)
    {
        return $query->where('status', CartItemStatusEnum::PENDING);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }
}

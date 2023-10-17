<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class IncludedProduct extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'image',
        'sale_price',
        'status',
        'description'
    ];

    public function inventory()
    {
        return $this->belongsToMany(Inventory::class, 'included_product_inventories')
            ->withTimestamps();
    }
}

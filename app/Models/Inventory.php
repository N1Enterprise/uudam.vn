<?php

namespace App\Models;

use App\Models\Traits\Activatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends BaseModel
{
    use Activatable;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'product_id',
        'condition',
        'condition_note',
        'sku',
        'status',
        'description',
        'key_features',
        'purchase_price',
        'sale_price',
        'offer_price',
        'offer_start',
        'offer_end',
        'stock_quantity',
        'min_order_quantity',
        'available_from',
        'meta_title',
        'meta_description'
    ];

    protected $cats = [
        'description' => 'json',
        'key_features' => 'json',
    ];
}

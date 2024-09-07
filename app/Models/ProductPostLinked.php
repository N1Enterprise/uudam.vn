<?php

namespace App\Models;

class ProductPostLinked extends BaseModel
{
    protected $fillable = [
        'product_id',
        'post_id',
        'order'
    ];
}

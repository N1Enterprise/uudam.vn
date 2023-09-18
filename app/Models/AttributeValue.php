<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class AttributeValue extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'value',
        'color',
        'attribute_id',
        'order',
        'status'
    ];
}

<?php

namespace App\Models;

use App\Models\Traits\Activatable;

class AttributeValue extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'value',
        'attribute_id',
        'order',
        'status'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}

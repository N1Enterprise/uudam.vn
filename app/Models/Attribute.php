<?php

namespace App\Models;

use App\Enum\ProductAttributeTypeEnum;
use App\Models\Traits\Activatable;

class Attribute extends BaseModel
{
    use Activatable;

    protected $fillable = [
        'name',
        'attribute_type',
        'order',
        'status',
        'supported_categories',
    ];

    protected $casts = [
        'supported_categories' => 'json'
    ];

    public function getAttributeTypeNameAttribute()
    {
        return ProductAttributeTypeEnum::findConstantLabel($this->attribute_type);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}

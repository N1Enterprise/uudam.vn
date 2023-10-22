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
    ];

    public function getAttributeTypeNameAttribute()
    {
        return ProductAttributeTypeEnum::findConstantLabel($this->attribute_type);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'attribute_categories');
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }
}

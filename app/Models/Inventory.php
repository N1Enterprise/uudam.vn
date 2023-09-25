<?php

namespace App\Models;

use App\Enum\InventoryConditionEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasImpactor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends BaseModel
{
    use Activatable;
    use SoftDeletes;
    use HasImpactor;

    protected $fillable = [
        'title',
        'slug',
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
        'meta_description',
        'image',
        'created_by_type',
        'created_by_id',
        'updated_by_type',
        'updated_by_id',
    ];

    protected $casts = [
        'description' => 'json',
        'key_features' => 'json',
    ];

    public function getConditionNameAttribute()
    {
        return InventoryConditionEnum::findConstantLabel($this->condition);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_inventories')
            ->withPivot('attribute_value_id')
            ->withTimestamps();
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_inventories')
            ->withPivot('attribute_id')
            ->withTimestamps();
    }
}

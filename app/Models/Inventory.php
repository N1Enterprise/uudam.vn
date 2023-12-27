<?php

namespace App\Models;

use App\Enum\InventoryConditionEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasImpactor;
use App\Models\Traits\HasMoney;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends BaseModel
{
    use Activatable;
    use SoftDeletes;
    use HasImpactor;
    use HasMoney;
    use HasFeUsage;

    protected $fillable = [
        'title',
        'slug',
        'product_id',
        'condition',
        'condition_note',
        'sku',
        'status',
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
        'display_on_frontend',
        'allow_frontend_search'
    ];

    protected $casts = [
        'key_features' => 'json',
    ];

    protected $appends = [
        'final_price',
        'sub_price',
        'has_offer_price'
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

    public function productCombos()
    {
        return $this->belongsToMany(ProductCombo::class, 'product_combo_inventories')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getHasOfferPriceAttribute()
    {
        if ($this->offer_price) {
            $now       = now();
            $startDate = !empty($this->offer_start) ? Carbon::parse($this->offer_start) : $now;
            $endDate   = !empty($this->offer_end) ? Carbon::parse($this->offer_end) : $now->addDay();

            return $now->between($startDate, $endDate);
        }

        return 0;
    }

    public function getSubPriceAttribute()
    {
        return  $this->has_offer_price ? $this->sale_price : 0;
    }

    public function getFinalPriceAttribute()
    {
        return $this->has_offer_price ? $this->offer_price : $this->sale_price;
    }
}

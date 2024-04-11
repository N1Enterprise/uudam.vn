<?php

namespace App\Models;

use App\Enum\InventoryConditionEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasImpactor;
use App\Models\Traits\HasMoney;
use App\Models\Traits\HasHtmlSEO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends BaseModel
{
    use Activatable;
    use SoftDeletes;
    use HasImpactor;
    use HasMoney;
    use HasFeUsage;
    use HasHtmlSEO;

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
        'allow_frontend_search',
        'init_sold_count',
        'sold_count',
        'meta',
        'weight',
        'sale_channels',
    ];

    protected $casts = [
        'key_features' => 'json',
        'meta' => 'json',
        'sale_channels' => 'json'
    ];

    protected $appends = [
        'final_price',
        'sub_price',
        'has_offer_price',
        'final_sold_count'
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
        return boolean($this->isOngoingFlashSale());
    }

    public function getSubPriceAttribute()
    {
        return  $this->has_offer_price ? $this->sale_price : 0;
    }

    public function getFinalPriceAttribute()
    {
        return $this->has_offer_price ? $this->offer_price : $this->sale_price;
    }

    public function getFinalSoldCountAttribute()
    {
        return (int) $this->init_sold_count + (int) $this->sold_count;
    }

    public function isOngoingFlashSale()
    {
        if ($this->offer_price && $this->offer_start) {
            $now = now();
            $startDate = !empty($this->offer_start) ? Carbon::parse($this->offer_start) : $now;
            $endDate = !empty($this->offer_end) ? Carbon::parse($this->offer_end) : $now->addDay();

            return $now->between($startDate, $endDate);
        }

        return 0;
    }

    public function getOfferStartDateAttribute()
    {
        return Carbon::parse($this->offer_start)->toDateTimeString();
    }

    public function getOfferEndDateAttribute()
    {
        $endDate = $this->offer_end ?? Carbon::parse($this->offer_start)->addDays(10);

        return Carbon::parse($endDate)->toDateTimeString();
    }

    public function htmlSEOProperties()
    {
        return [
            'title' => $this->meta_title ?? $this->title,
            'desc' => $this->meta_description ?? ($this->meta_title ?? $this->title),
            'url' => route('fe.web.products.index', $this->slug),
            'image'  => $this->image,
            'amount' => $this->final_price,
        ];
    }
}

<?php

namespace App\Models;

use App\Enum\ShippingOptionTypeEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;

class ShippingOption extends BaseModel
{
    use Activatable;
    use HasFeUsage;

    protected $fillable = [
        'name',
        'type',
        'logo',
        'params',
        'status',
        'shipping_provider_id',
        'expanded_content',
        'supported_countries',
        'supported_provinces',
        'display_on_frontend',
        'order'
    ];

    protected $casts = [
        'params' => 'json',
        'supported_countries' => 'json',
        'supported_provinces' => 'json', 
    ];

    public function getTypeNameAttribute()
    {
        return ShippingOptionTypeEnum::findConstantLabel($this->type);
    }

    public function shippingProvider()
    {
        return $this->belongsTo(ShippingProvider::class);
    }

    public function isAtStore()
    {
        return $this->type == ShippingOptionTypeEnum::AT_STORE;
    }

    public function isThirdParty()
    {
        return $this->type == ShippingOptionTypeEnum::SHIPPING_PROVIDER;
    }
}

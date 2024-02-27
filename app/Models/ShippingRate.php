<?php

namespace App\Models;

use App\Enum\ShippingRateTypeEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasFeUsage;
use App\Models\Traits\HasMoney;

class ShippingRate extends BaseModel
{
    use Activatable;
    use HasFeUsage;
    use HasMoney;

    protected $fillable = [
        'name',
        'shipping_zone_id',
        'delivery_takes',
        'type',
        'minimum',
        'maximum',
        'rate',
        'status',
        'display_on_frontend'
    ];

    public function getTypeNameAttribute()
    {
        return ShippingRateTypeEnum::findConstantLabel($this->type);
    }

    public function shippingZone()
    {
        return $this->belongsTo(ShippingZone::class);
    }

    public function isFreeShipping()
    {
        return (int) $this->rate == 0;
    }
}

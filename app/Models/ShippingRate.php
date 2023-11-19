<?php

namespace App\Models;

use App\Enum\ShippingRateTypeEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasMoney;

class ShippingRate extends BaseModel
{
    use Activatable;
    use HasMoney;

    protected $fillable = [
        'name',
        'shipping_zone_id',
        'carrier_id',
        'delivery_takes',
        'type',
        'minimum',
        'maximum',
        'rate',
        'status'
    ];

    public function getTypeNameAttribute()
    {
        return ShippingRateTypeEnum::findConstantLabel($this->type);
    }

    public function shippingZone()
    {
        return $this->belongsTo(ShippingZone::class);
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function isFreeShipping()
    {
        return (int) $this->rate == 0;
    }
}

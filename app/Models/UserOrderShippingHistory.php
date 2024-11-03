<?php

namespace App\Models;

class UserOrderShippingHistory extends BaseModel
{
    public $fillable = [
        'user_id',
        'order_id',
        'shipping_option_id',
        'shipping_provider_id',
        'shipping_zone_id',
        'shipping_rate_id',
        'status',
        'transport_fee',
        'estimated_transport_fee',
        'total_weight',
        'total_invoice_amount',
        'provider_shipping_fee_history_id',
        'reference_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function shippingOption()
    {
        return $this->belongsTo(ShippingOption::class);
    }

    public function shippingProvider()
    {
        return $this->belongsTo(ShippingProvider::class);
    }

    public function shippingZone()
    {
        return $this->belongsTo(ShippingZone::class);
    }

    public function shippingRate()
    {
        return $this->belongsTo(ShippingRate::class);
    }

    public function providerShippingFeeHistory()
    {
        return $this->belongsTo(ProviderShippingFeeHistory::class);
    }
}

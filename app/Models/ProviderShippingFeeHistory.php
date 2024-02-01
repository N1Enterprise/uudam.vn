<?php

namespace App\Models;

class ProviderShippingFeeHistory extends BaseModel
{
    protected $fillable = [
        'cart_id',
        'shipping_option_id',
        'shipping_provider_id',
        'user_id',
        'address_id',
        'currency_code',
        'total_item',
        'total_quantity',
        'total_price',
        'transport_fee',
        'total_estimated_amount',
        'provider_payload',
        'log',
        'note',
        'total_weight'
    ];

    protected $casts = [
        'provider_payload' => 'json',
        'log' => 'json'
    ];
}

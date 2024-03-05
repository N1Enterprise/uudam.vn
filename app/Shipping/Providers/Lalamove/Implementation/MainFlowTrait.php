<?php

namespace App\Shipping\Providers\Lalamove\Implementation;

use App\Models\Address;
use App\Models\Cart;

trait MainFlowTrait 
{
    public function getShippingFeeEndpoint()
    {
        return $this->getProviderParam('endpoints.shipping_free');
    }

    public function parseProviderShippingFreePayload(Cart $cart, Address $address, $data = [])
    {
        $shippingOptionParams = data_get($this->shippingOption, 'params');

        return [
            // 'pick_address_id' => '',
            'pick_address'    => data_get($shippingOptionParams, 'provider_payload.pick_address'),
            'pick_province'   => data_get($shippingOptionParams, 'provider_payload.pick_province'),
            'pick_district'   => data_get($shippingOptionParams, 'provider_payload.pick_district'),
            'pick_ward'       => data_get($shippingOptionParams, 'provider_payload.pick_ward'),
            'pick_street'     => data_get($shippingOptionParams, 'provider_payload.pick_street'),
            'address'         => $address->full_address,
            'province'        => optional($address->province)->full_name,
            'district'        => optional($address->district)->full_name,
            'ward'            => optional($address->ward)->full_name,
            'street'          => $address->address_line,
            'weight'          => 100,
            'value'           => $cart->toMoney('total_price')->toFloat(),
            // 'transport'       => '',
            'deliver_option'  => data_get($shippingOptionParams, 'provider_payload.deliver_option'),
            'tags'            => []
        ];
    }

    public function getShippingFee(Cart $cart, Address $address, $data = [])
    {
        $payload = $this->parseProviderShippingFreePayload($cart, $address, $data);
    }
}
<?php

namespace App\Shipping\Providers\Ghtk\Implementation;

use App\Models\Address;
use App\Models\Cart;
use App\Shipping\Helpers\ShippingCartHelper;

trait MainFlowTrait 
{
    public function getShippingFeeEndpoint()
    {
        return $this->getProviderParam('endpoints.shipping_fee');
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
            'weight'          => ShippingCartHelper::getTotalWeightFromItems($cart->availableItems ?? []),
            'value'           => $cart->toMoney('total_price')->toFloat(),
            'transport'       => data_get($shippingOptionParams, 'provider_payload.transport', 'road'),
            'deliver_option'  => data_get($shippingOptionParams, 'provider_payload.deliver_option', 'none'),
            'tags'            => []
        ];
    }

    public function getShippingFee(Cart $cart, Address $address, $data = [])
    {
        $payload = $this->parseProviderShippingFreePayload($cart, $address, $data);

        $response = $this->sendRequest(
            $this->generateUrl($this->getShippingFeeEndpoint()),
            $payload,
            [],
            ['method' => 'get'],
            $this->getBaseApiURL($cart)
        );

        $responseJson = $response->json();

        if ($response->failed() || ! data_get($responseJson, 'success')) {
            $cart->update([
                'note' => '[GET SHIPPING FEE] '.data_get($responseJson, 'message'),
            ]);

            return $cart;
        }

        return [
            'provider_response' => $responseJson,
            'transport_fee' => data_get($responseJson, 'fee.fee')
        ];
    }
}
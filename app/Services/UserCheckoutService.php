<?php

namespace App\Services;

use App\Shipping\ShippingIntegrationService;
use App\Models\ShippingOption;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Shipping\BaseShippingIntegration;
use App\Models\Address;
use App\Models\ProviderShippingFeeHistory;
use App\Vendors\Localization\Money;

class UserCheckoutService extends BaseService
{
    public $shippingIntegrationService;
    public $shippingOptionService;
    public $userService;
    public $cartService;
    public $addressService;

    public function __construct(
        ShippingIntegrationService $shippingIntegrationService, 
        ShippingOptionService $shippingOptionService,
        UserService $userService,
        CartService $cartService,
        AddressService $addressService
    ) {
        $this->shippingIntegrationService = $shippingIntegrationService;
        $this->shippingOptionService = $shippingOptionService;
        $this->userService = $userService;
        $this->cartService = $cartService;
        $this->addressService = $addressService;
    }

    /**
     * @return ProviderShippingFeeHistory
     */
    public function handleCartShippingFeeByShippingOption($cartId, $shippingOptionId, $addressId)
    {
        /** @var ShippingOption */
        $shippingOption = $this->shippingOptionService->show($shippingOptionId);

        /** @var Cart */
        $cart = $this->cartService->show($cartId);

        /** @var Address */
        $address = $this->addressService->show($addressId);

        $shippingIntegrationService = null;

        if ($shippingOption->isThirdParty()) {
            $shippingIntegrationService = $this->shippingIntegrationService->resolveServiceClassByOption($shippingOption);
        }

        $history = DB::transaction(function() use ($shippingOption, $cart, $address, $shippingIntegrationService) {
            $history = ProviderShippingFeeHistoryService::make()->firstOrCreate([
                'cart_id'              => get_model_key($cart),
                'shipping_option_id'   => get_model_key($shippingOption),
                'shipping_provider_id' => $shippingOption->shipping_provider_id,
                'user_id'              => $cart->user_id,
                'address_id'           => get_model_key($address),
                'currency_code'        => $cart->currency_code
            ], [
                'total_item'     => $cart->total_item,
                'total_quantity' => $cart->total_quantity,
                'total_price'    => $cart->total_price,
            ]);

            if ($shippingOption->isAtStore()) {
                $history->update([ 
                    'transport_fee' => 0,
                    'total_estimated_amount' => $cart->total_price,
                ]);
            }

            if ($shippingOption->isThirdParty() && $shippingIntegrationService instanceof BaseShippingIntegration) {
                $response = $shippingIntegrationService->getShippingFee($cart, $address, []);

                $history->update([
                    'transport_fee' => data_get($response, 'transport_fee', 0),
                    'total_estimated_amount' => Money::make($cart->total_price, $cart->currency_code)->plus(data_get($response, 'transport_fee', 0))->toFloat(),
                    'log' => [
                        'provider_response' => data_get($response, 'provider_response', []),
                    ]
                ]);
            }

            return $history;
        });

        return $history;
    }
}

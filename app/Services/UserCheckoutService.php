<?php

namespace App\Services;

use App\Enum\ShippingRateTypeEnum;
use App\Shipping\ShippingIntegrationService;
use App\Models\ShippingOption;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Shipping\BaseShippingIntegration;
use App\Models\Address;
use App\Models\BaseModel;
use App\Models\ProviderShippingFeeHistory;
use App\Shipping\Helpers\ShippingCartHelper;
use App\Vendors\Localization\Money;

class UserCheckoutService extends BaseService
{
    public $shippingIntegrationService;
    public $shippingOptionService;
    public $userService;
    public $cartService;
    public $addressService;
    public $shippingZoneService;
    public $shippingRateService;

    public function __construct(
        ShippingIntegrationService $shippingIntegrationService, 
        ShippingOptionService $shippingOptionService,
        UserService $userService,
        CartService $cartService,
        AddressService $addressService,
        ShippingZoneService $shippingZoneService,
        ShippingRateService $shippingRateService
    ) {
        $this->shippingIntegrationService = $shippingIntegrationService;
        $this->shippingOptionService = $shippingOptionService;
        $this->userService = $userService;
        $this->cartService = $cartService;
        $this->addressService = $addressService;
        $this->shippingZoneService = $shippingZoneService;
        $this->shippingRateService = $shippingRateService;
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
                'cart_id' => get_model_key($cart),
                'shipping_option_id' => get_model_key($shippingOption),
                'user_id' => $cart->user_id,
                'address_id' => get_model_key($address),
                'currency_code' => $cart->currency_code
            ]);

            if ($shippingOption->isNoneAmount()) {
                $history->update([ 
                    'transport_fee' => 0,
                    'total_estimated_amount' => $cart->total_price,
                ]);
            }

            if ($shippingOption->isThirdParty() && $shippingIntegrationService instanceof BaseShippingIntegration) {
                $response = $shippingIntegrationService->getShippingFee($cart, $address, []);

                $history->update([
                    'shipping_provider_id' => $shippingOption->shipping_provider_id,
                    'transport_fee' => data_get($response, 'transport_fee', 0),
                    'total_estimated_amount' => Money::make($cart->total_price, $cart->currency_code)->plus(data_get($response, 'transport_fee', 0))->toFloat(),
                    'log' => [
                        'provider_response' => data_get($response, 'provider_response', []),
                    ]
                ]);
            }

            if ($shippingOption->isShippingZone()) {
                $shippingZone = $this->shippingZoneService->getByProvinceAndDistrict($address->province_code, $address->district_code);

                if (empty($shippingZone)) {
                    throw new \Exception('Unspecified Zone');
                }

                $shippingRate = $this->shippingRateService->getByShippingZone($shippingZone, ShippingRateTypeEnum::WEIGHT, ShippingCartHelper::getTotalWeightFromItems($cart->availableItems ?? []));

                if (empty($shippingZone)) {
                    throw new \Exception('Unspecified Rate');
                }

                $history->update([ 
                    'shipping_zone_id' => BaseModel::getModelKey($shippingZone),
                    'shipping_rate_id' => BaseModel::getModelKey($shippingRate),
                    'transport_fee' => data_get($shippingRate, 'rate', 0),
                    'total_estimated_amount' => Money::make($cart->total_price, $cart->currency_code)->plus(data_get($shippingRate, 'rate', 0))->toFloat(),
                ]);
            }

            return $history;
        });

        return $history;
    }
}

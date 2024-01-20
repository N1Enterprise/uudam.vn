<?php

namespace App\Services;

use App\Classes\Contracts\UserAuthContract;
use App\Models\User;
use App\Shipping\ShippingIntegrationService;
use App\Vendors\Localization\SystemCurrency;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserCheckoutService extends BaseService
{
    public $shippingProviderService;
    public $shippingIntegrationService;

    public function __construct(ShippingProviderService $shippingProviderService, ShippingIntegrationService $shippingIntegrationService)
    {
        $this->shippingProviderService = $shippingProviderService;    
        $this->shippingIntegrationService = $shippingIntegrationService;
    }

    public function getShippingRateByProviders($user, $providers, $cart)
    {
        $providers = $this->shippingProviderService->getAvailabelByIds($providers);

        $shippingRates = [];

        optional($providers)->each(function($provider) use ($user, $cart) {
            $shippingProviderIntegrationService = $this->shippingIntegrationService->resolveServiceClassByProvider($provider);

            $shippingProviderIntegrationService->setUser($user);
            $shippingProviderIntegrationService->setCart($cart);

            $quotation = $shippingProviderIntegrationService->getProviderQuotation();

            dd($quotation);
        });
    }
}

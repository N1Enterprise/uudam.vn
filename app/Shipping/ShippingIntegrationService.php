<?php

namespace App\Shipping;

use App\Exceptions\ExceptionCode;
use App\Services\ShippingOptionService;
use App\Shipping\BaseShippingIntegration;
use Illuminate\Contracts\Container\BindingResolutionException;

class ShippingIntegrationService
{
    public static function availableProviders()
    {
        $providers = [];

        foreach (config('shipping.shipping_provider_mappers', []) as $providerClass) {
            $providers[] = [
                'code' => $providerClass::providerCode(),
                'name' => $providerClass::providerName(),
            ];
        }

        return $providers;
    }

    /**
     * @param mixed $shippingOption
     * @return BaseShipping
     * @throws Exception
     * @throws BindingResolutionException
     */
    public function resolveServiceClassByOption($shippingOption)
    {
        $shippingOption = ShippingOptionService::make()->show($shippingOption);

        $shippingProvider = $shippingOption->shippingProvider;

        if (! ($shippingOption->isThirdParty() && $shippingProvider)) {
            throw new \Exception('Invalid shipping option.', ExceptionCode::INVALID_PAYMENT_OPTION);
        }

        if (! $shippingProvider || ! $shippingProvider->isActive()) {
            throw new \Exception("resolveProvider: shipping provider {$shippingProvider->code} is not activated");
        }

        $shippingProviderMappers = config('shipping.shipping_provider_mappers', []);

        $providerClass = data_get($shippingProviderMappers, $shippingProvider->code, null);

        if (! class_exists($providerClass)) {
            throw new \Exception("Unknown shipping provider: {$shippingProvider->code}");
        }

        $providerInstance = app($providerClass, ['shippingOption' => $shippingOption]);

        if (! $providerInstance instanceof BaseShippingIntegration) {
            throw new \Exception("Class $providerClass must be an instance of ".BaseShippingIntegration::class);
        }

        return $providerInstance;
    }
}

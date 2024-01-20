<?php

namespace App\Shipping;

use App\Services\ShippingProviderService;
use App\Models\ShippingProvider;

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

    public function resolveServiceClassByProvider($provider)
    {
        /** @var ShippingProvider */
        $shippingProvider = ShippingProviderService::make()->show($provider);

        if (! $shippingProvider || ! $shippingProvider->isActive()) {
            throw new \Exception("resolveProvider: shipping provider {$shippingProvider->code} is not activated");
        }

        $shippingProviderMappers = config('shipping.shipping_provider_mappers', []);

        $providerClass = data_get($shippingProviderMappers, $shippingProvider->code, null);

        if (! class_exists($providerClass)) {
            throw new \Exception("Unknown payment provider: {$shippingProvider->code}");
        }

        $providerInstance = app($providerClass, [
            'provider' => $shippingProvider
        ]);

        if (! $providerInstance instanceof BaseShippingIntegration) {
            throw new \Exception("Class $providerClass must be an instance of ".BaseShippingIntegration::class);
        }

        return $providerInstance;
    }
}

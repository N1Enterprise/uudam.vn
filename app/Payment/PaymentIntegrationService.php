<?php

namespace App\Payment;

class PaymentIntegrationService
{
    public static function availableProviders()
    {
        $providers = [];

        foreach (config('payment.payment_provider_mappers', []) as $providerClass) {
            $providers[] = [
                'code' => $providerClass::providerCode(),
                'name' => $providerClass::providerName(),
            ];
        }

        return $providers;
    }
}

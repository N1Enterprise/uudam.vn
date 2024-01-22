<?php

namespace App\Payment;

use App\Exceptions\ExceptionCode;
use App\Services\PaymentOptionService;
use Illuminate\Contracts\Container\BindingResolutionException;

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

    /**
     * @param mixed $paymentOption
     * @return BasePaymentIntegration
     * @throws Exception
     * @throws BindingResolutionException
     */
    public function resolveServiceClassByPaymentOption($paymentOption)
    {
        $paymentOption = app(PaymentOptionService::class)->show($paymentOption);

        $paymentProvider = $paymentOption->paymentProvider;

        if(! ($paymentOption->isThirdParty() && $paymentProvider)) {
            throw new \Exception('Invalid payment option.', ExceptionCode::INVALID_PAYMENT_OPTION);
        }

        if (! $paymentProvider || ! $paymentProvider->isActive()) {
            throw new \Exception("resolveProvider: payment provider {$paymentProvider->code} is not activated");
        }

        $paymentProviderMappers = config('payment.payment_provider_mappers', []);

        $providerClass = data_get($paymentProviderMappers, $paymentProvider->code, null);

        if (! class_exists($providerClass)) {
            throw new \Exception("Unknown payment provider: {$paymentProvider->code}");
        }

        $providerInstance = app($providerClass, ['paymentOption' => $paymentOption]);

        if (! $providerInstance instanceof BasePaymentIntegration) {
            throw new \Exception("Class $providerClass must be an instance of ".BasePaymentIntegration::class);
        }

        return $providerInstance;
    }
}

<?php

namespace App\Payment;

use App\Exceptions\ExceptionCode;
use App\Models\BaseTransaction;
use App\Services\PaymentOptionService;
use App\Services\PaymentProviderService;
use Illuminate\Contracts\Container\BindingResolutionException;

class PaymentIntegrationService
{
    protected $paymentProviderService;

    public function __construct(PaymentProviderService $paymentProviderService)
    {
        $this->paymentProviderService = $paymentProviderService;
    }

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
        $paymentOption = PaymentOptionService::make()->show($paymentOption);

        $paymentProvider = $paymentOption->paymentProvider;

        if (! ($paymentOption->isThirdParty() && $paymentProvider)) {
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

    public function handleTransaction(BaseTransaction $transaction, $providerCode = null)
    {
        $providerCode = $providerCode ?? $transaction->paymentProvider->code;
        $provider = $this->resolveProvider($providerCode);

        return $provider->handle($transaction);
    }

    public static function getProviderServiceClass($providerCode)
    {
        $paymentProviderMappers = config('payment.payment_provider_mappers', []);

        $providerClass = data_get($paymentProviderMappers, $providerCode, null);

        if (! class_exists($providerClass)) {
            throw new \Exception("Unknown payment provider class: $providerCode");
        }

        return $providerClass;
    }

    public function findProviderByCode($providerCode, $paymentType)
    {
        $paymentProvider = $this->paymentProviderService->firstWhereAndScope(['code' => $providerCode, 'payment_type' => $paymentType]);

        if (! $paymentProvider || ! $paymentProvider->isActive()) {
            throw new \Exception("Payment provider $providerCode was not found or inactivated");
        }

        return $paymentProvider;
    }
}

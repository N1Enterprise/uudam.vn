<?php

namespace App\Http\Controllers\Payment;

use App\Payment\BasePaymentIntegration;
use App\Payment\Concerns\WithHook;
use App\Payment\PaymentIntegrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebhookController
{
    public $paymentProviderService;

    public function __construct(PaymentIntegrationService $paymentProviderService)
    {
        $this->paymentProviderService = $paymentProviderService;
    }

    public function hook(Request $request, $paymentProvider, $endpoint)
    {
        $uuid = (string) Str::uuid();

        $providerClass = PaymentIntegrationService::getProviderServiceClass($paymentProvider);

        $paymentIntegrationService = app($providerClass, [
            'shouldValidatePaymentOption' => false,
        ]);

        if (! $paymentIntegrationService instanceof BasePaymentIntegration) {
            throw new \Exception("Payment provider service class {$providerClass} must implement interface ".BasePaymentIntegration::class);
        }

        if (! $paymentIntegrationService instanceof WithHook) {
            throw new \Exception("Payment provider service class {$providerClass} must implement interface ".WithHook::class);
        }

        $paymentIntegrationService->logger()->info("Tracking payment integration hook request: [$uuid]", [
            'url' => $request->fullUrl(),
            'uuid' => $uuid,
            'payload' => $request->all(),
        ]);

        $response = $paymentIntegrationService->hook($endpoint, $request);

        return $response;
    }
}

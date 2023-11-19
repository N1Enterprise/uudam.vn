<?php

namespace App\Payment;

abstract class BasePaymentProviderHandle
{
    public $service;

    public function __construct(BasePaymentIntegration $service)
    {
        $this->service = $service;
    }

    public abstract function paymentChannel();

    public abstract function paymentType();

    public abstract function getValidationRules($data = []): array;

    public abstract function parsePayload($data = []): array;

    public abstract function parseProviderRequestPayload($transaction, $data = []): array;

    public function prepareForValidation($data = []): array
    {
        return [];
    }
}

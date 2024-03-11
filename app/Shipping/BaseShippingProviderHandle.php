<?php

namespace App\Shipping;

abstract class BaseShippingProviderHandle
{
    public $service;

    public function __construct(BaseShippingIntegration $service)
    {
        $this->service = $service;
    }

    public abstract function parsePayload($data = []): array;
}

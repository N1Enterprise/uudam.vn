<?php

namespace App\Shipping\Providers\Ghtk;

use App\Shipping\BaseShippingIntegration;
use App\Shipping\Providers\Ghtk\Implementation\MainFlowTrait;

class Service extends BaseShippingIntegration
{
    use MainFlowTrait;

    public const PROVIDER_NAME = 'Ghtk';
    public const PROVIDER_CODE = 'ghtk';

    public static function providerName(): string
    {
        return self::PROVIDER_NAME;
    }

    public static function providerCode(): string
    {
        return self::PROVIDER_CODE;
    }
}
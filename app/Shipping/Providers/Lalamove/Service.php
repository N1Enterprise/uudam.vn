<?php

namespace App\Shipping\Providers\Lalamove;

use App\Shipping\BaseShippingIntegration;
use App\Shipping\Providers\Lalamove\Implementation\MainFlowTrait;

class Service extends BaseShippingIntegration
{
    use MainFlowTrait;

    public const PROVIDER_NAME = 'Lalamove';
    public const PROVIDER_CODE = 'lalamove';

    public static function providerName(): string
    {
        return self::PROVIDER_NAME;
    }

    public static function providerCode(): string
    {
        return self::PROVIDER_CODE;
    }   
}
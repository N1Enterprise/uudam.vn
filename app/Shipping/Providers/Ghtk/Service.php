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

    public function parsePayload($data = []): array
    {
        return [];
    }

    public function getBaseApiURL($cart = null, $data = [])
    {
        return $this->getHttpClient()
            ->baseUrl($this->getProviderParam('base_api_url'))
            ->withHeaders([
                'HTTP_CLIENT_IP' => data_get($cart, 'footprint.ip'),
                'Token' => $this->getProviderParam('credentials.api_token_key')
            ]);
    }
}
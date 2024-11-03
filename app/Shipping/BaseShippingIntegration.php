<?php

namespace App\Shipping;

use App\Http\Middleware\HttpClientMiddleware;
use App\Models\Address;
use App\Models\Cart;
use App\Shipping\Contracts\ProviderNamingContract;
use App\Models\ShippingOption;
use App\Services\ShippingOptionService;
use App\Models\ShippingProvider;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

/**
 * Base shipping integration class
 */
abstract class BaseShippingIntegration implements ProviderNamingContract
{
    /**
     * @var ShippingProvider
     */
    public $provider;

    /**
     * @var ShippingOption
     */
    public $shippingOption;

    public $shippingOptionService;

    public function __construct(
        ShippingOption $shippingOption,
        ShippingOptionService $shippingOptionService
    ) {
        $this->shippingOption = $shippingOption;

        $this->shippingOptionService = $shippingOptionService;

        $this->provider = optional($this->shippingOption)->shippingProvider;
    }

    public abstract function getShippingFee(Cart $cart, Address $address, $data = []);

    /**
     * Send transaction to payment provider
     */
    public function sendRequest($url, $data = [], $headers = [], $options = [], PendingRequest $client = null)
    {
        $method  = data_get($options, 'method', 'get');
        $timeout = data_get($options, 'timeout', 30);

        $httpClient = $client ?? $this->getHttpClient($data);

        $httpClient = $httpClient->withHeaders($headers)->timeout($timeout);

        /** @var Response */
        $response = $httpClient->{$method}($url, $data);

        return $response;
    }

     /**
     * Get Http client to call payment provider api
     */
    public function getHttpClient($data = [])
    {
        $trackingConfig = $this->getProviderParam('track_sending_request', [
            'prefix' => static::providerCode(),
        ]);

        $trackingConfig = array_merge($trackingConfig, [
            'tracking_uuid' => data_get($data, 'uuid')
        ]);

        return Http::withMiddleware(new HttpClientMiddleware($trackingConfig));
    }

    /**
     * Get param from payment provider configuration
     */
    public function getProviderParam($key, $default = null)
    {
        return data_get($this->provider->params ?? [], $key, $default);
    }

    public function generateUrl($url, $params = [])
    {
        return strtr($url, $params);
    }
}

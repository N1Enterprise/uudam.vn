<?php

namespace App\Payment;

use App\Http\Middleware\HttpClientMiddleware;
use App\Models\BaseModel;
use App\Payment\Contracts\ProviderNamingContract;
use App\Models\PaymentProvider;
use App\Models\PaymentOption;
use App\Services\DepositService;
use App\Services\DepositTransactionService;
use App\Services\PaymentOptionService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

/**
 * Base payment integration class
 */
abstract class BasePaymentIntegration implements ProviderNamingContract
{
    /**
     * @var PaymentProvider
     */
    public $provider;

    /**
     * @var PaymentOption
     */
    public $paymentOption;

    public $paymentOptionService;

    public $depositService;

    public $depositTransactionService;

    protected $shouldValidatePaymentOption = true;

    public const TRANSACTION_RETRY_PREFIX = 'retry_';

    public function __construct(
        $paymentOption = null,
        $shouldValidatePaymentOption = true,
        PaymentOptionService $paymentOptionService,
        DepositService $depositService,
        DepositTransactionService $depositTransactionService
    ) {
        $this->paymentOption = $paymentOption;
        
        $this->shouldValidatePaymentOption = $shouldValidatePaymentOption;

        $this->paymentOptionService = $paymentOptionService;

        $this->depositService = $depositService;

        $this->depositTransactionService = $depositTransactionService;

        $this->provider = optional($this->paymentOption)->paymentProvider;
    }

    /**
     * parse data before save transaction
     * @param array $data
     * @return array
     */
    public function parsePayload($data = []): array
    {
        $parsed = $this->getHandleClass($data)->parsePayload($data);

        return $parsed;
    }

    /**
     * @return BasePaymentProviderHandle
     */
    public abstract function getHandleClass($data = []);

    public abstract function handleTransaction($transaction, $data = []);

    public function resolveHandleClass(string $handleClass)
    {
        $handleClass = app($handleClass, [
            'service' => $this
        ]);

        if (! $handleClass instanceof BasePaymentProviderHandle) {
            throw new \Exception("The handle class $handleClass must be instance of ". BasePaymentProviderHandle::class);
        }

        return $handleClass;
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function isDepositTransaction()
    {
        return $this->getProvider()->isDeposit();
    }

    /**
     * For deposit
     * @return false
     */
    public function shouldHandleTransactionAfterCommit()
    {
        return false;
    }

    /**
     * Get param from payment provider configuration
     */
    public function getProviderParam($key, $default = null)
    {
        return data_get($this->provider->params ?? [], $key, $default);
    }

    public function parseToProviderCurrency($systemCurrency, $default = null)
    {
        $currencyMapper = $this->getProviderParam('currency_mappers', []);

        return data_get($currencyMapper, (string) $systemCurrency, $default ?? (string) $systemCurrency);
    }

    /**
     * Add prefix to our transaction id before sending to provider
     */
    public function getTransactionIdWithPrefix($transaction, $retry = false)
    {
        return $retry ? $this->getTransactionRetryPrefix($transaction) : $this->addPrefix($transaction);
    }

    public function getTransactionRetryPrefix($transaction)
    {
        $transaction = $this->depositTransactionService->show($transaction);

        $retriedTimes = $transaction->count_payout_retry;

        if($retriedTimes <= 0) {
            return $this->addPrefix($transaction);
        }

        return implode('', array_filter_empty([static::TRANSACTION_RETRY_PREFIX, $retriedTimes, '_', $this->addPrefix($transaction)]));
    }

    /**
     * Add prefix to our transaction id before sending to provider
     */
    protected function addPrefix($transaction)
    {
        return $this->getPrefix().BaseModel::getModelKey($transaction);
    }

    /**
     * Get transaction refix
     */
    protected function getPrefix()
    {
        return trim($this->getProviderParam(
            'transaction_prefix',
            config('payment.payment_request_prefix')
        ));
    }

    /**
     * Send transaction to payment provider
     */
    public function sendRequest($url, $data = [], $headers = [], $options = [], PendingRequest $client = null)
    {
        $method  = data_get($options, 'method', 'get');
        $timeout = data_get($options, 'timeout', 30);

        $httpClient = $client ?? $this->getHttpClient($data);

        // $trackingUuid = Str::uuid();

        // $logger = $this->integrationLogger()->cloneInstance();

        // $logger->setGroupId($trackingUuid);

        $httpClient = $httpClient->beforeSending(function($request, $options, $pendingRequest) use (&$logger) {
            // $logger->asRequest()->log($request);
        })->withHeaders($headers)->timeout($timeout);

        /** @var Response */
        $response = $httpClient->{$method}($url, $data);

        // $logger->setGroupId($trackingUuid)->asResponse()->log($response);

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

    public function generateUrl($url, $params = [])
    {
        return strtr($url, $params);
    }
}

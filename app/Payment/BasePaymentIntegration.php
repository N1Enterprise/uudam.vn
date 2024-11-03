<?php

namespace App\Payment;

use App\Enum\DepositStatusEnum;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Exceptions\PaymentIntegrationException;
use App\Http\Middleware\HttpClientMiddleware;
use App\Models\BaseModel;
use App\Models\DepositTransaction;
use App\Payment\Contracts\ProviderNamingContract;
use App\Models\PaymentProvider;
use App\Models\PaymentOption;
use App\Payment\Helpers\PaymentLogger;
use App\Services\DepositService;
use App\Services\DepositTransactionService;
use App\Services\PaymentOptionService;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;

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
     * @return BasePaymentProviderHandle
     */
    public abstract function getHandleClass($data = []);

    public abstract function handleTransaction($transaction, $data = []);

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

    protected function executeWebhookMethod($method, $request)
    {
        $this->beforeExecuteHook($method, $request);

        $this->delay($method);
        $response = $this->{$method}($request);
        $this->delay($method, 1);

        $this->afterExecuteHook($method, $response, $request);

        return $response;
    }

    public function beforeExecuteHook($method, $request)
    {
        // do something
    }

    public function afterExecuteHook($method, $response, $request)
    {
        // do something
    }

    /**
     * Delay response to payment provider use it for debug only.
     */
    public function delay($method, $type = 0)
    {
        $delay = $type === 0 ? $this->getProviderParam('delayBeforeHandle') : $this->getProviderParam('delayAfterHandle');

        if ($delay) {
            $seconds = intval(data_get($delay, 'seconds', 0));

            if ($seconds === 0) {
                return;
            }
            $methods = data_get($delay, 'methods');

            if (is_array($methods) && ! in_array($method, $methods)) {
                return;
            }

            $message = $type === 0 ? "Delay before handle $method" : "Delay after handle $method";
            $this->logger->warning("$message: $seconds seconds");
            sleep($seconds);

            if( data_get($delay, 'then') === 'exit') {
                exit();
            }
        }
    }

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

    public function setProvider($provider)
    {
        return $this->provider = $provider;
    }

    /**
     * @param mixed $paymentOption
     * @return PaymentOption
     * @throws PaymentIntegrationException
     */
    public function validatePaymentOption($paymentOption)
    {
        if ($this->shouldValidatePaymentOption) {
            $paymentOption = $this->paymentOptionService->show($paymentOption);

            if (! ($paymentOption->isThirdParty() && $paymentOption->paymentProvider)) {
                throw new PaymentIntegrationException('Invalid payment option.', ExceptionCode::INVALID_PAYMENT_OPTION);
            }

            return $paymentOption;
        }

        return null;
    }

    public function setPaymentOption($paymentOption)
    {
        $this->shouldValidatePaymentOption = true;

        $paymentOption = $this->validatePaymentOption($paymentOption);

        $this->paymentOption = $paymentOption;

        $this->provider = optional($paymentOption)->paymentProvider;

        return $this;
    }

    public function logger()
    {
        return PaymentLogger::provider(static::providerCode());
    }

    public function isDepositTransaction()
    {
        return $this->getProvider()->isDeposit();
    }

    public function isWithdrawalTransaction()
    {
        return $this->getProvider()->isWithdrawal();
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
     * Remove prefix out of our transaction id before query database
     */
    public function removePrefix($transaction)
    {
        return Str::afterLast(BaseModel::getModelKey($transaction), $this->getPrefix());
    }

    public function parseFromProviderCurrency($providerCurrencyCode, $default = null)
    {
        $currencyMapper = $this->getProviderParam('currency_mappers', []);

        return data_get(array_flip($currencyMapper), $providerCurrencyCode, $default ?? $providerCurrencyCode);
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

    /**
     * Get modifier for updating transaction
     */
    protected function getModifier()
    {
        return [
            'updated_by_type' => PaymentProvider::class,
            'updated_by_id' => $this->provider->getKey(),
        ];
    }

    public function updateTransactionStatus($transaction, $toStatus, $data = [], $ignoreCacheBlock = false)
    {
        if ($this->isDepositTransaction() && $transaction instanceof DepositTransaction) {
            $status = $transaction->status;

            if ($status == $toStatus) {
                return $transaction;
            }

            switch ($toStatus) {
                case DepositStatusEnum::APPROVED:
                    $transaction = $this->depositService->approve($transaction, array_merge($this->getModifier(), $data));

                    break;
                case DepositStatusEnum::DECLINED:
                    $transaction = $this->depositService->decline($transaction, array_merge($this->getModifier(), $data));

                    break;
                case DepositStatusEnum::FAILED:
                case DepositStatusEnum::CANCELED:
                    $transaction = $this->depositService->cancel($transaction, array_merge($this->getModifier(), array_merge($data, [
                        'status' => $toStatus
                    ])));

                    break;
                default:
                    throw new BusinessLogicException("Invalid deposit transaction ({$transaction->getKey()}) status $toStatus");
                    break;
            }

            return $transaction;
        }

        throw new BusinessLogicException('Invalid payment transaction type.');
    }

    public function findByTransactionId($transactionId, $throwIfNotExists = true)
    {
        if ($this->isDepositTransaction()) {
            $transaction = $this->depositTransactionService->find($transactionId);

            if ($throwIfNotExists && !$transaction) {
                BaseModel::throwNotFound(DepositTransaction::class, $transactionId);
            }

            return $transaction;
        } else if($this->isWithdrawalTransaction()) {
            // handle withdraw
        }

        throw new BusinessLogicException('Invalid payment type.');
    }

    public function generateUrl($url, $params = [])
    {
        return strtr($url, $params);
    }

    public function getRedirectOutput($container, $method = null, $url = null, $parameters = [], $html = null, $width = null, $height = null, $sizeUnit = null)
    {
        if ($container === null) {
            return [];
        }

        return [
            'container'  => $container,
            'method'     => $method ?? 'GET',
            'url'        => $url,
            'parameters' => $parameters ?? [],
            'html'       => $html,
            'width'      => $width ?? 600,
            'height'     => $height ?? 600,
            'size_unit'  => $sizeUnit ?? 'px',
        ];
    }
}

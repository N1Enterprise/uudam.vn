<?php

namespace App\Payment\Providers\VnPay;

use App\Exceptions\PaymentIntegrationException;
use App\Payment\BasePaymentIntegration;
use App\Payment\BasePaymentProviderHandle;
use App\Payment\Concerns\DepositByApi;
use App\Payment\Concerns\WithHook;
use App\Payment\Providers\VnPay\ProviderHandlers\HandlerHelper;
use App\Payment\Traits\HasHook;

class Service extends BasePaymentIntegration implements WithHook
{
    use HasHook;

    public ?BasePaymentProviderHandle $handleClass = null;

    public const PROVIDER_NAME = 'VnPay';
    public const PROVIDER_CODE = 'vnpay';

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
        $parsed = parent::parsePayload($data);

        return array_merge($parsed, [
            'attributes' => array_filter([
                'successUrl' => data_get($data, 'redirect_urls.payment_success'),
            ])
        ]);
    }

    public function getBaseApiURL($transaction = null, $data = [])
    {
        return $this->getHttpClient()
            ->baseUrl($this->getProviderParam('base_api_url'))
            ->withHeaders([
                'HTTP_CLIENT_IP' => data_get($transaction, 'footprint.ip')
            ]);
    }

    public function getVnPayProvider()
    {
        return $this->paymentOption->online_banking_code;
    }

    public function getHandleClass($data = [])
    {
        if ($this->handleClass) {
            return $this->handleClass;
        }

        if (! $this->paymentOption) {
            throw new PaymentIntegrationException('Unable to get handle class for provider '.self::PROVIDER_CODE.' due to invalid payment option.');
        }

        $this->handleClass = $this->resolveHandleClass(HandlerHelper::routingHandleClassByIntegrationService($this));

        return $this->handleClass;
    }

    public function handleTransaction($transaction, $data = [])
    {
        if ($this->isDepositTransaction()) {
            $handleClass = $this->getHandleClass();
        } else {
            // Withdraw
        }

        if ($handleClass instanceof DepositByApi) {
            return $handleClass->sendTransactionToProvider($transaction);
        }

        return $transaction;
    }
}

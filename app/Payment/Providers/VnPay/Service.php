<?php

namespace App\Payment\Providers\VnPay;

use App\Enum\PaymentTypeEnum;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\PaymentIntegrationException;
use App\Payment\BasePaymentIntegration;
use App\Payment\BasePaymentProviderHandle;
use App\Payment\Concerns\DepositByApi;
use App\Payment\Concerns\WithHook;
use App\Payment\Providers\VnPay\Constants\PaymentChannel;
use App\Payment\Providers\VnPay\ProviderHandlers\Deposit\BaseDepositHandle;
use App\Payment\Providers\VnPay\ProviderHandlers\HandlerHelper;
use App\Payment\Traits\HasHook;
use Illuminate\Support\Arr;

class Service extends BasePaymentIntegration implements WithHook
{
    use HasHook;

    public ?BasePaymentProviderHandle $handleClass = null;

    public const PROVIDER_NAME = 'VnPay';
    public const PROVIDER_CODE = 'vnpay';

    public static $paramHints = [];

    protected $webhookEndpointMappers = [
        'process-deposit' => 'processProviderDeposit',
    ];

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

    public function processProviderDeposit($request)
    {
        /** @var BaseDepositHandle */
        $handleClass = $this->handleClass ?? $this->getHandleClass();

        if (! method_exists($handleClass, 'processProviderDeposit')) {
            throw new BusinessLogicException('The handle class '.get_class($handleClass).' must be implements processProviderDeposit function.');
        }

        return $handleClass->processProviderDeposit($request);
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

    public function authorizeHook($request, $endpoint = null): bool
    {
        try {
            $this->routingPaymentOptionFromHook($request, $endpoint);

            $payload = $request->all();

            $validationPayload = Arr::only($payload, [
                'vnp_Amount',
                'vnp_BankCode',
                'vnp_BankTranNo',
                'vnp_CardType',
                'vnp_OrderInfo',
                'vnp_PayDate',
                'vnp_ResponseCode',
                'vnp_TmnCode',
                'vnp_TransactionNo',
                'vnp_TransactionStatus',
                'vnp_TxnRef',
            ]);

            $vnpSecureHash = HandlerHelper::encryptPayload($validationPayload, $this->getProviderParam('credentials.vnp_hash_secret'));

            return $vnpSecureHash == data_get($payload, 'vnp_SecureHash');
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function routingPaymentOptionFromHook($request, $endpoint)
    {
        $requestPayload = $request->all();

        $vnPayOrderInfo = data_get($requestPayload, 'vnp_OrderInfo');

        $orderInfoExtract = explode('.', $vnPayOrderInfo);

        $vnpChannel = data_get($orderInfoExtract, '1');

        if (! in_array($vnpChannel, [PaymentChannel::INTCARD, PaymentChannel::VNBANK, PaymentChannel::INTCARD, PaymentChannel::E_WALLET])) {
            throw new PaymentIntegrationException('Invalid VNPAY bank code');
        }

        $handleClass = HandlerHelper::routingHandleClassByPaymentChannel($vnpChannel);

        $handler = $this->resolveHandleClass($handleClass);

        if ($handler->paymentType() == PaymentTypeEnum::DEPOSIT) {
            $this->setPaymentOption(HandlerHelper::findPaymentOptionByClassHandler($handler));
        } else {
            //
        }

        return $this;
    }
}

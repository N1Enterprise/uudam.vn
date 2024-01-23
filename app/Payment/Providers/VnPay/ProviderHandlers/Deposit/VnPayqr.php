<?php

namespace App\Payment\Providers\VnPay\ProviderHandlers\Deposit;

use App\Payment\Concerns\DepositByApi;
use App\Payment\Providers\VnPay\Constants\OrderType;
use App\Payment\Providers\VnPay\Constants\PaymentChannel;
use App\Payment\Providers\VnPay\ProviderHandlers\HandlerHelper;
use Carbon\Carbon;

class VnPayqr extends BaseDepositHandle implements DepositByApi
{
    public function paymentChannel()
    {
        return PaymentChannel::VNPAYQR;
    }

    public function getValidationRules($data = []): array
    {
        return [
           
        ];
    }

    public function parsePayload($data = []): array
    {
        return [];
    }

    public function parseProviderRequestPayload($transaction, $data = []): array
    {
        $providerPayload = $transaction->provider_payload ?? [];

        $payload = [
            'vnp_Version'    => $this->service->getProviderParam('vnp_version'),
            'vnp_Command'    => $this->service->getProviderParam('vnp_command'),
            'vnp_TmnCode'    => $this->service->getProviderParam('credentials.vnp_tmn_code'),
            'vnp_Amount'     => $transaction->toMoney('amount')->toFloat(),
            'vnp_BankCode'   => PaymentChannel::VNPAYQR,
            'vnp_CreateDate' => Carbon::parse()->format('YmdHis'),
            'vnp_CurrCode'   => $this->service->parseToProviderCurrency($transaction->currency_code),
            'vnp_IpAddr'     => data_get($transaction, 'footprint.ip'),
            'vnp_Locale'     => 'vn',
            'vnp_OrderInfo'  => data_get($transaction, 'log.order_describing_payment_content'),
            'vnp_OrderType'  => OrderType::HEALTH_AND_BEAUTY,
            'vnp_ReturnUrl'  => HandlerHelper::parseRedirectUrl($transaction, data_get($providerPayload, 'attributes.successUrl', $this->service->getProviderParam('redirect_urls.payment_success'))),
            'vnp_ExpireDate' => Carbon::parse(now())->addMinutes(10)->format('YmdHis'),
            'vnp_TxnRef'     => $this->service->getTransactionIdWithPrefix($transaction),
        ];

        $queryString   = http_build_query($payload);
        $vnpSecureHash = hash('sha256', $this->service->getProviderParam('credentials.vnp_hash_secret') . '&' . $queryString);

        $payload['vnp_SecureHashType'] = 'SHA256';
        $payload['vnp_SecureHash']     = $vnpSecureHash;

        return $payload;
    }
}
<?php

namespace App\Payment\Providers\VnPay\ProviderHandlers\Deposit;

use App\Payment\Concerns\DepositByApi;
use App\Payment\Providers\VnPay\Constants\OrderType;
use App\Payment\Providers\VnPay\Constants\PaymentChannel;
use App\Payment\Providers\VnPay\Constants\VnpBankCode;
use App\Payment\Providers\VnPay\ProviderHandlers\HandlerHelper;
use Carbon\Carbon;
use App\Vendors\Localization\Money;
use App\Models\User;

class IntCard extends BaseDepositHandle implements DepositByApi
{
    public function paymentChannel()
    {
        return PaymentChannel::INTCARD;
    }

    public function getValidationRules($data = []): array
    {
        return [];
    }

    public function parsePayload($data = []): array
    {
        return [];
    }

    public function parseProviderRequestPayload($transaction, $data = []): array
    {
        $providerPayload = $transaction->provider_payload ?? [];
        $order = optional($transaction)->order;

        /** @var Money */
        $amount = $transaction->toMoney('amount');

        /** @var User */
        $user = $transaction->user;

        $payload = [
            'vnp_Version'    => $this->service->getProviderParam('vnp_version'),
            'vnp_Command'    => $this->service->getProviderParam('vnp_command'),
            'vnp_TmnCode'    => $this->service->getProviderParam('credentials.vnp_tmn_code'),
            'vnp_BankCode'   => VnpBankCode::INTCARD,
            'vnp_Amount'     => $amount->multipliedBy(100)->toFloat(),
            'vnp_CreateDate' => Carbon::parse()->format('YmdHis'),
            'vnp_CurrCode'   => $this->service->parseToProviderCurrency($transaction->currency_code),
            'vnp_IpAddr'     => data_get($transaction, 'footprint.ip'),
            'vnp_Locale'     => $this->service->getProviderParam('vnp_locale'),
            'vnp_OrderInfo'  => $this->getTransactionOrderInfo($user, $transaction, PaymentChannel::INTCARD),
            'vnp_OrderType'  => OrderType::HEALTH_AND_BEAUTY,
            'vnp_ReturnUrl'  => HandlerHelper::parseRedirectUrl($transaction, data_get($providerPayload, 'attributes.successUrl', $this->service->getProviderParam('redirect_urls.payment_success'))),
            'vnp_ExpireDate' => Carbon::parse(now())->addMinutes($this->service->getProviderParam('deposit_expires_in_min'))->format('YmdHis'),
            'vnp_TxnRef'     => optional($order)->order_code,
        ];

        return $payload;
    }
}

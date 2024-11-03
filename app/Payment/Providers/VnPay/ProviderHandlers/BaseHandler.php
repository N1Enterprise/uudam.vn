<?php

namespace App\Payment\Providers\VnPay\ProviderHandlers;

use App\Payment\BasePaymentProviderHandle;
use App\Payment\Providers\VnPay\Constants\IPNResponseCode;
use App\Payment\Providers\VnPay\Constants\StateResponseCode;
use App\Payment\Providers\VnPay\Service;

abstract class BaseHandler extends BasePaymentProviderHandle
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function appendProviderResponseMeta($transaction, $data = [])
    {
        $providerResponseMeta = data_get($transaction, 'log.provider_response_meta', []);

        $transaction->log = array_merge([
            'provider_response_meta' => array_merge($providerResponseMeta, $data)
        ], $transaction->log ?? []);

        return $transaction;
    }

    public function parseRedirectOutput($response, $options = [])
    {
        $container = 'redirect';
        $redirectContent = data_get($response, 'redirect_url');

        return $this->service->getRedirectOutput(
            $container,
            null,
            $redirectContent,
            [],
            null,
            null,
            null,
            null,
        );
    }

    public function parseSuccessResponse($data = [])
    {
        return [
            'Message' => 'Confirm Success',
            'RspCode' => StateResponseCode::CONFIRM_SUCCESS,
        ];
    }

    public function isProviderTransactionFailed($providerPayload)
    {
        $providerStatus = data_get($providerPayload, 'vnp_ResponseCode');

        return $providerStatus != IPNResponseCode::TRANSACTION_SUCCESS;
    }

    public function parseProviderTransactionErrorMessage($providerPayload)
    {
        $providerStatus = data_get($providerPayload, 'vnp_ResponseCode');
        $message = 'Other error';

        switch ($providerStatus) {
            case IPNResponseCode::TRANSACTION_SUSPECTED_FRAUD:
                $message = 'TRANSACTION_SUSPECTED_FRAUD';
                break;
            case IPNResponseCode::TRANSACTION_FAILED_CUSTOMER_NOT_REGISTERED:
                $message = 'TRANSACTION_FAILED_CUSTOMER_NOT_REGISTERED';
                break;
            case IPNResponseCode::TRANSACTION_FAILED_INCORRECT_AUTHENTICATION:
                $message = 'TRANSACTION_FAILED_INCORRECT_AUTHENTICATION';
                break;
            case IPNResponseCode::TRANSACTION_FAILED_EXPIRED:
                $message = 'TRANSACTION_FAILED_EXPIRED';
                break;
            case IPNResponseCode::TRANSACTION_FAILED_CUSTOMER_ACCOUNT_LOCKED:
                $message = 'TRANSACTION_FAILED_CUSTOMER_ACCOUNT_LOCKED';
                break;
            case IPNResponseCode::TRANSACTION_FAILED_INCORRECT_OTP:
                $message = 'TRANSACTION_FAILED_INCORRECT_OTP';
                break;
            case IPNResponseCode::TRANSACTION_CANCELLED_BY_CUSTOMER:
                $message = 'TRANSACTION_CANCELLED_BY_CUSTOMER';
                break;
            case IPNResponseCode::TRANSACTION_FAILED_INSUFFICIENT_BALANCE:
                $message = 'TRANSACTION_FAILED_INSUFFICIENT_BALANCE';
                break;
            case IPNResponseCode::TRANSACTION_FAILED_EXCEED_DAILY_LIMIT:
                $message = 'TRANSACTION_FAILED_EXCEED_DAILY_LIMIT';
                break;
            case IPNResponseCode::BANK_UNDER_MAINTENANCE:
                $message = 'BANK_UNDER_MAINTENANCE';
                break;
            case IPNResponseCode::TRANSACTION_FAILED_EXCEED_PAYMENT_ATTEMPTS:
                $message = 'TRANSACTION_FAILED_EXCEED_PAYMENT_ATTEMPTS';
                break;
            case IPNResponseCode::OTHER_ERRORS:
                $message = 'OTHER_ERRORS';
                break;
            default:
                $message = 'Other error';
                break;
        }

        return vsprintf('[%s] %s', [$providerStatus, $message]);
    }
}

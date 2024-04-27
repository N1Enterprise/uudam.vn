<?php

namespace App\Payment\Providers\VnPay\ProviderHandlers\Deposit;

use App\Enum\PaymentTypeEnum;
use App\Payment\Providers\VnPay\ProviderHandlers\BaseHandler;
use App\Payment\Providers\VnPay\Service;

abstract class BaseDepositHandle extends BaseHandler
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function paymentType()
    {
        return PaymentTypeEnum::DEPOSIT;
    }

    public function getDepositEndpoint()
    {
        return $this->service->getProviderParam('endpoints.deposit');
    }

    public function sendTransactionToProvider($transaction)
    {
        $requestPayload = $this->parseProviderRequestPayload($transaction);

        $queryString = $this->parseQueryString($requestPayload);

        $redirectUrl = $this->service->generateUrl($this->service->getProviderParam('base_api_url') . $this->getDepositEndpoint()). '?' . $queryString;

        $redirectOutput = $this->parseRedirectOutput(['redirect_url' => $redirectUrl]);

        $transaction = $this->appendProviderResponseMeta($transaction, [
            'redirect_output' => $redirectOutput,
        ]);

        $transaction->save();

        return $transaction;
    }

    public function verifyTransactionProactively($transaction)
    {
        return $transaction;
    }

    public function verifyTransactionPassively($data) {
        return [];
    }

    public function parseQueryString($payload)
    {
        ksort($payload);

        $query = "";
        $i = 0;
        $hashdata = "";

        foreach ($payload as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }

            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->service->getProviderParam('credentials.vnp_hash_secret'));

        $query .= 'vnp_SecureHash=' . $vnpSecureHash;

        return $query;
    }
}

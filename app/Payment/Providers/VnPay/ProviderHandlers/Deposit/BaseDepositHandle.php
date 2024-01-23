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

        $queryString = http_build_query($requestPayload);

        dd(
            $this->service->getProviderParam('base_api_url') . $this->service->generateUrl($this->getDepositEndpoint()) . '?' . $queryString
        );

        $response = $this->service->sendRequest(
            $this->service->generateUrl($this->getDepositEndpoint()) . '?' . $queryString,
            $requestPayload,
            [],
            ['method' => 'GET'],
            $this->service->getBaseApiURL($transaction)
        );

        dd($response);

        // $transaction = $transaction->fresh();

        // if ($response->failed()) {
        //     dd(1);
        // }

        // dd(
        //     $response->json()
        // );


    }

    public function verifyTransactionProactively($transaction)
    {
        return $transaction;
    }

    public function verifyTransactionPassively($data) {
        return [];
    }

    public function calculateSecureHash($payload)
    {
        $i = 0;
        $hashData = '';

        foreach ($payload as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . $key . "=" . $value;
            } else {
                $hashData .= $key . "=" . $value;
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $this->service->getProviderParam('credentials.vnp_hash_secret'));

        return $secureHash;
    }
}
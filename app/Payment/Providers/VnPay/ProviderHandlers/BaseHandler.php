<?php

namespace App\Payment\Providers\VnPay\ProviderHandlers;

use App\Payment\BasePaymentProviderHandle;
use App\Payment\Providers\VnPay\Constants\TransactionState;
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
        $callbackResponse = $this->service->getProviderParam('__callback_response.success', []) ?? [];

        return array_merge(['ok' => true], $data, $callbackResponse);
    }

    public function isProviderTransactionFailed($providerPayload)
    {
        $providerStatus = data_get($providerPayload, 'vnp_TransactionStatus');

        return in_array($providerStatus, [TransactionState::FAILED, TransactionState::SUSPECTED_OF_FRAUD]);
    }

    public function parseProviderTransactionErrorMessage($providerTransaction)
    {
        return '';
    }
}

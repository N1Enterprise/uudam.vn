<?php

namespace App\Payment\Providers\VnPay\ProviderHandlers;

use App\Models\BaseModel;
use App\Payment\Providers\VnPay\Constants\PaymentChannel;
use App\Payment\Providers\VnPay\Service;

class HandlerHelper
{
    public static function routingHandleClassByIntegrationService(Service $integrationService)
    {
        $vnpayProvider = $integrationService->getVnPayProvider();

        if ($integrationService->isDepositTransaction()) {
            switch ($vnpayProvider) {
                case PaymentChannel::VNPAYQR:
                    return Deposit\VnPayqr::class;
                case PaymentChannel::INTCARD:
                    return Deposit\IntCard::class;
                case PaymentChannel::VNBANK:
                    return Deposit\VnBank::class;
                default:
                    throw new \Exception('Invalid Payment Channel.');
            }
        }
    }

    public static function parseRedirectUrl($transaction, $redirectUrl)
    {
        return strtr($redirectUrl, [
            ':transaction_id' => BaseModel::getModelKey($transaction),
        ]);
    }
}
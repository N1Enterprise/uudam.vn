<?php

namespace App\Payment\Providers\VnPay\ProviderHandlers;

use App\Enum\PaymentTypeEnum;
use App\Exceptions\PaymentIntegrationException;
use App\Models\BaseModel;
use App\Payment\BasePaymentProviderHandle;
use App\Payment\PaymentIntegrationService;
use App\Payment\Providers\VnPay\Constants\PaymentChannel;
use App\Payment\Providers\VnPay\Service;
use App\Services\PaymentOptionService;

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
                case PaymentChannel::E_WALLET:
                    return Deposit\EWallet::class;
                default:
                    throw new \Exception('Invalid Payment Channel.');
            }
        }
    }

    public static function routingHandleClassByPaymentChannel($channel)
    {
        switch ($channel) {
            case PaymentChannel::VNPAYQR:
                return Deposit\VnPayqr::class;
            case PaymentChannel::INTCARD:
                return Deposit\IntCard::class;
            case PaymentChannel::VNBANK:
                return Deposit\VnBank::class;
            case PaymentChannel::E_WALLET:
                return Deposit\EWallet::class;
            default:
                throw new \Exception("Unable to routing handle class for vnpay transaction: ".$channel);
                break;
        }
    }

    public static function findPaymentOptionByClassHandler(BasePaymentProviderHandle $handler)
    {
        $paymentProvider = app(PaymentIntegrationService::class)->findProviderByCode($handler->service::providerCode(), $handler->paymentType());

        if ($handler->paymentType() == PaymentTypeEnum::DEPOSIT) {
            return PaymentOptionService::make()->firstWhere([
                'payment_provider_id' => get_model_key($paymentProvider),
                'online_banking_code' => $handler->paymentChannel(),
            ]);
        }

        throw new PaymentIntegrationException("Unable to find payment option due to invalid payment type {$handler->paymentType()}");
    }

    public static function parseRedirectUrl($transaction, $redirectUrl)
    {
        return strtr($redirectUrl, [
            ':transaction_id' => BaseModel::getModelKey($transaction),
        ]);
    }

    public static function encryptPayload($payload, $hashSecret)
    {
        ksort($payload);

        $query = '';
        $i = 0;
        $hashdata = '';

        foreach ($payload as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }

            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $hashSecret);

        return $vnpSecureHash;
    }
}

<?php

namespace App\Payment\Providers\VnPay;

use App\Payment\BasePaymentIntegration;
use App\Payment\BasePaymentProviderHandle;
use App\Payment\Concerns\WithHook;
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
}

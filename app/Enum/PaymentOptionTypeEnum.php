<?php

namespace App\Enum;

class PaymentOptionTypeEnum extends BaseEnum
{
    public const LOCAL_BANK = 1;
    public const PAYMENT_PROVIDER = 2;
    public const CASH_ON_DELIVERY = 3;

    public static function all(): array
    {
        return [
            self::LOCAL_BANK,
            self::PAYMENT_PROVIDER,
            self::CASH_ON_DELIVERY
        ];
    }

    public static function isThirdParty($key)
    {
        return $key == self::PAYMENT_PROVIDER;
    }
}

<?php

namespace App\Enum;

class PaymentOptionTypeEnum extends BaseEnum
{
    public const LOCAL_BANK = 1;
    public const PAYMENT_PROVIDER = 2;
    public const NONE_AMOUNT = 3;

    public static function all(): array
    {
        return [
            self::LOCAL_BANK,
            self::PAYMENT_PROVIDER,
            self::NONE_AMOUNT
        ];
    }

    public static function isLocalBank($key)
    {
        return $key == self::LOCAL_BANK;
    }

    public static function isThirdParty($key)
    {
        return $key == self::PAYMENT_PROVIDER;
    }

    public static function isNoneAmount($key)
    {
        return $key == self::NONE_AMOUNT;
    }
}

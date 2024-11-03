<?php

namespace App\Enum;

class ShippingOptionTypeEnum extends BaseEnum
{
    public const NONE_AMOUNT = 1;
    public const SHIPPING_PROVIDER = 2;
    public const SHIPPING_ZONE = 3;

    public static function all(): array
    {
        return [
            self::NONE_AMOUNT,
            self::SHIPPING_PROVIDER,
            self::SHIPPING_ZONE
        ];
    }

    public static function isThirdParty($key)
    {
        return $key == self::SHIPPING_PROVIDER;
    }

    public static function isShippingZone($key)
    {
        return $key == self::SHIPPING_ZONE;
    }

    public static function isNoneAmount($key)
    {
        return $key == self::SHIPPING_PROVIDER;
    }
}

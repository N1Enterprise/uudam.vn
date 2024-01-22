<?php

namespace App\Enum;

class ShippingOptionTypeEnum extends BaseEnum
{
    public const AT_STORE = 1;
    public const SHIPPING_PROVIDER = 2;

    public static function all(): array
    {
        return [
            self::AT_STORE,
            self::SHIPPING_PROVIDER,
        ];
    }

    public static function isThirdParty($key)
    {
        return $key == self::SHIPPING_PROVIDER;
    }

    public static function isAtStore($key)
    {
        return $key == self::SHIPPING_PROVIDER;
    }
}

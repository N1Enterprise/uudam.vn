<?php

namespace App\Enum;

class ShippingRateTypeEnum extends BaseEnum
{
    public const PRICE = 1;
    public const WEIGHT = 2;

    public static function all(): array
    {
        return [
            self::PRICE,
            self::WEIGHT,
        ];
    }
}

<?php

namespace App\Enum;

class UserWalletTypeEnum extends BaseEnum
{
    public const SHOPPING = 1;

    public static function all(): array
    {
        return [
            self::SHOPPING,
        ];
    }

    public static function isActive($key)
    {
        return $key == self::SHOPPING;
    }
}

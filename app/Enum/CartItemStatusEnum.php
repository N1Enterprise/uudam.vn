<?php

namespace App\Enum;

class CartItemStatusEnum extends BaseEnum
{
    public const CANCELED = 0;
    public const PENDING  = 1;
    public CONST APPROVED = 3;

    public static function all(): array
    {
        return [
            self::CANCELED,
            self::PENDING,
            self::APPROVED,
        ];
    }
}

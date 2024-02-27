<?php

namespace App\Enum;

class UserOrderShippingHistoryStatusEnum extends BaseEnum
{
    public const DECLINED = 0;
    public const PENDING = 1;
    public const APPROVED = 2;
    public const CANCELED = 3;
    public const FAILED = 4;

    public static function all(): array
    {
        return [
            self::DECLINED,
            self::PENDING,
            self::APPROVED,
            self::CANCELED,
            self::FAILED
        ];
    }
}

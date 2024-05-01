<?php

namespace App\Enum;

class DepositStatusEnum extends BaseEnum
{
    public const DECLINED = 0;
    public const PENDING = 1;
    public const APPROVED = 2;
    public const CANCELED = 3;
    public const FAILED = 4;
    public const WAIT_FOR_CONFIRMATION = 5;

    public static function all(): array
    {
        return [
            self::PENDING,
            self::APPROVED,
            self::DECLINED,
            self::FAILED,
            self::WAIT_FOR_CONFIRMATION
        ];
    }
}

<?php

namespace App\Enum;

class PaymentTypeEnum extends BaseEnum
{
    public const DEPOSIT = 1;

    public static function all(): array
    {
        return [
            self::DEPOSIT,
        ];
    }
}

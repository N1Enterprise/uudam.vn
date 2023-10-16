<?php

namespace App\Enum;

class ProductReviewStatusEnum extends BaseEnum
{
    public const DECLINED = 0;
    public const PENDING = 1;
    public const APPROVED = 2;

    public static function all(): array
    {
        return [
            self::DECLINED,
            self::PENDING,
            self::APPROVED,
        ];
    }
}

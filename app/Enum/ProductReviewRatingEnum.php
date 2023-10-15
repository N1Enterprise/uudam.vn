<?php

namespace App\Enum;

class ProductReviewRatingEnum extends BaseEnum
{
    public const VERY_GOOD = 1;
    public const GOOD = 2;
    public const NEED_TO_IMPROVE = 3;
    public const IS_NOT_GOOD = 4;

    public static $labels = [
        self::VERY_GOOD => 'Very Good',
        self::GOOD => 'Good',
        self::NEED_TO_IMPROVE => 'Need To Improve',
        self::IS_NOT_GOOD => 'Is Not Good',
    ];

    public static function all(): array
    {
        return [
            self::VERY_GOOD,
            self::GOOD,
            self::NEED_TO_IMPROVE,
            self::IS_NOT_GOOD,
        ];
    }

    public static function labelsInVietnamese() {
        return [
            self::VERY_GOOD => 'Sản phẩm rất tốt',
            self::GOOD => 'Sản phẩm tốt',
            self::NEED_TO_IMPROVE => 'Cần cải thiện sản phẩm',
            self::IS_NOT_GOOD => 'Sản phẩm không tốt',
        ];
    }
}

<?php

namespace App\Enum;

class HomePageDisplayType extends BaseEnum
{
    public const PRODUCT = 1;
    public const COLLECTION = 2;
    public const POST = 3;
    public const BLOG = 4;
    public const IN_APP_BANNER_100_PERCENT = 5;
    public const IN_APP_BANNER_50_PERCENT = 6;

    public static function all(): array
    {
        return [
            self::PRODUCT,
            self::COLLECTION,
            self::POST,
            self::BLOG,
            self::IN_APP_BANNER_100_PERCENT,
            self::IN_APP_BANNER_50_PERCENT,
        ];
    }
}

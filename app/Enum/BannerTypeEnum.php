<?php

namespace App\Enum;

class BannerTypeEnum extends BaseEnum
{
    public const HOME_BANNER = 1;

    public static function all(): array
    {
        return [
            self::HOME_BANNER,
        ];
    }
}

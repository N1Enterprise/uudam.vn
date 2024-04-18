<?php

namespace App\Enum;

class OrderChannelType extends BaseEnum
{
    public const WEBSITE = 1;
    public const SHOPEE = 2;
    public const LAZADA = 3;
    public const TIKI = 4;
    public const FACEBOOK = 5;
    public const TIKTOK = 6;
    public const INSTAGRAM = 7;

    public static function all(): array
    {
        return [
            self::WEBSITE,
            self::SHOPEE,
            self::LAZADA,
            self::TIKI,
            self::FACEBOOK,
            self::TIKTOK,
            self::INSTAGRAM
        ];
    }
}

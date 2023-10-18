<?php

namespace App\Enum;

class PageDisplayTypeEnum extends BaseEnum
{
    public const LEFT_SHOW_DIRECT = 1;
    public const MENU = 2;

    public static function all(): array
    {
        return [
            self::LEFT_SHOW_DIRECT,
            self::MENU,
        ];
    }
}

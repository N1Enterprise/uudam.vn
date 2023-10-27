<?php

namespace App\Enum;

class PageDisplayTypeEnum extends BaseEnum
{
    public const MENU = 1;

    public static function all(): array
    {
        return [
            self::MENU,
        ];
    }
}

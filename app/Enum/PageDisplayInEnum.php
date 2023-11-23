<?php

namespace App\Enum;

class PageDisplayInEnum extends BaseEnum
{
    public const HOME = 'home';
    public const CHECKOUT = 'checkout';
    public const FOOTER = 'footer';

    public static function all(): array
    {
        return [
            self::HOME,
            self::CHECKOUT,
            self::FOOTER,
        ];
    }
}

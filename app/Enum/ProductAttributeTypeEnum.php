<?php

namespace App\Enum;

class ProductAttributeTypeEnum extends BaseEnum
{
    public const COLOR_PATTERN = 1;
    public const RADIO = 2;
    public const SELECT = 3;

    public static $labels = [
        self::COLOR_PATTERN => 'Color/Pattern',
        self::RADIO => 'Radio',
        self::SELECT => 'Select',
    ];

    public static function all(): array
    {
        return [
            self::COLOR_PATTERN,
            self::RADIO,
            self::SELECT,
        ];
    }
}

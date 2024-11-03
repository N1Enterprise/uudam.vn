<?php

namespace App\Enum;

class VideoTypeEnum extends BaseEnum
{
    public const PRODUCT_DESCRIPTION = 1;
    public const INSTRUCTION = 2;
    public const TROUBLESHOOTING = 3;

    public static function all(): array
    {
        return [
            self::PRODUCT_DESCRIPTION,
            self::INSTRUCTION,
            self::TROUBLESHOOTING,
        ];
    }
}

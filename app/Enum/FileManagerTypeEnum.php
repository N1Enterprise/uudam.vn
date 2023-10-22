<?php

namespace App\Enum;

class FileManagerTypeEnum extends BaseEnum
{
    public const IMAGE = 1;

    public static function all(): array
    {
        return [
            self::IMAGE,
        ];
    }
}

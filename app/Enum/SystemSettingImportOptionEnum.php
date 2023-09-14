<?php

namespace App\Enum;

class SystemSettingImportOptionEnum extends BaseEnum
{
    public const MERGE = 'merge';
    public const OVERRIDE = 'override';

    public static function all(): array
    {
        return [
            self::MERGE,
            self::OVERRIDE,
        ];
    }
}

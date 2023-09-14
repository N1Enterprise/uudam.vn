<?php

namespace App\Enum;

class SystemSettingValueTypeEnum extends BaseEnum
{
    public const BOOL_TYPE = 'boolean';
    public const JSON_TYPE = 'json';
    public const STRING_TYPE = 'string';
    public const NUMBER_TYPE = 'number';
    public const DATE_TIME_TYPE = 'datetime';

    public static function all(): array
    {
        return [
            self::BOOL_TYPE,
            self::JSON_TYPE,
            self::STRING_TYPE,
            self::NUMBER_TYPE,
            self::DATE_TIME_TYPE,
        ];
    }

    public static $labels = [
        self::BOOL_TYPE => 'Boolean',
        self::JSON_TYPE => 'Json',
        self::STRING_TYPE => 'String',
        self::NUMBER_TYPE => 'Number',
        self::DATE_TIME_TYPE => 'DateTime'
    ];
}

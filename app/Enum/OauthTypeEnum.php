<?php

namespace App\Enum;

class OauthTypeEnum extends BaseEnum
{
    public const OAUTH2 = 'oauth2';
    public const WEB3 = 'web3';
    public const OPENID = 'openid';

    public static function all(): array
    {
        return [
            self::OAUTH2,
            self::WEB3,
            self::OPENID,
        ];
    }

    public static function supportedTypes(): array
    {
        return [
            self::OAUTH2,
            self::WEB3,
            self::OPENID,
        ];
    }
}

<?php

namespace App\Enum;

class BannerTypeEnum extends BaseEnum
{
    public const HOME_BANNER = 1;
    public const IN_APP_100_PERCENT = 2;
    public const IN_APP_50_PERCENT = 3;

    public static $labels = [
        self::HOME_BANNER => 'Home Banner',
        self::IN_APP_100_PERCENT => 'In-App 100%',
        self::IN_APP_50_PERCENT => 'In-App 50%',
    ];

    public static function all(): array
    {
        return [
            self::HOME_BANNER,
            self::IN_APP_100_PERCENT,
            self::IN_APP_50_PERCENT
        ];
    }

    public static function getImageConfigByType($type)
    {
        $config = [
            self::HOME_BANNER => [
                'mobile' => 'mobile_image', 
                'desktop' => 'desktop_image'
            ],
            self::IN_APP_100_PERCENT => [
                'mobile' => 'in_app_100_percent_mobile',
                'desktop' => 'in_app_100_percent_desktop',
            ],
            self::IN_APP_50_PERCENT => [
                'mobile' => 'in_app_50_percent_mobile',
                'desktop' => 'in_app_50_percent_desktop',
            ],
        ];

        if (empty($config[$type])) {
            throw new \Exception('Invalid banner type.');
        }

        return $config[$type];
    }
}

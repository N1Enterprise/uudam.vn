<?php

namespace App\Enum;

class SystemSettingKeyEnum extends BaseEnum
{
    public const TELESCOPE = 'telescope';
    public const IS_MAINTENANCE = 'is_maintenance';
    public const MAINTENANCE_START_DATE = 'maintenance_start_date';
    public const MAINTENANCE_END_DATE = 'maintenance_end_date';
    public const MAINTENANCE_MESSAGE = 'maintenance_message';
    public const PRODUCT_ATTRIBUTE_TYPES = 'product_attribute_types';
    public const ENABLE_USER_EMAIL_VERIFICATION = 'enable_user_email_verification';

    // Shop Setting
    public const PAGE_SETTINGS = 'page_settings';
    public const SOCIAL_NETWORKS = 'social_networks';
    public const RECEIVE_NEW_POST_SETTING = 'receive_new_post_setting';
    public const PAGE_HIGHLIGHT_INFORMATION = 'page_highlight_information';
    public const VIDEO_OUTSIDE_UI = 'video_outside_ui';
    public const SEARCH_SETTING = 'search_setting';

    public static function all(): array
    {
        return [
            self::TELESCOPE,
            self::IS_MAINTENANCE,
            self::MAINTENANCE_START_DATE,
            self::MAINTENANCE_END_DATE,
            self::MAINTENANCE_MESSAGE,
            self::PRODUCT_ATTRIBUTE_TYPES,
            self::PAGE_SETTINGS,
            self::SOCIAL_NETWORKS,
            self::RECEIVE_NEW_POST_SETTING,
            self::PAGE_HIGHLIGHT_INFORMATION,
            self::VIDEO_OUTSIDE_UI,
            self::SEARCH_SETTING,
            self::ENABLE_USER_EMAIL_VERIFICATION,
        ];
    }
}

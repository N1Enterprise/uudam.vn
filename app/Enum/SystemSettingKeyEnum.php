<?php

namespace App\Enum;

class SystemSettingKeyEnum extends BaseEnum
{
    public const TELESCOPE = 'telescope';

    public const IS_MAINTENANCE = 'is_maintenance';
    public const MAINTENANCE_START_DATE = 'maintenance_start_date';
    public const MAINTENANCE_END_DATE = 'maintenance_end_date';
    public const MAINTENANCE_MESSAGE = 'maintenance_message';
    public const MAINTENANCE_ALLOW_IPS_ACCESS = 'maintenance_allow_ips_access';
    public const USER_FE_RESET_PASSWORD_LINK = 'user_fe_reset_password_link';

    public const PRODUCT_ATTRIBUTE_TYPES = 'product_attribute_types';
    public const ENABLE_USER_EMAIL_VERIFICATION = 'enable_user_email_verification';

    // Shop Setting
    public const PAGE_SETTINGS = 'page_settings';
    public const SOCIAL_NETWORKS = 'social_networks';
    public const RECEIVE_NEW_POST_SETTING = 'receive_new_post_setting';
    public const PAGE_HIGHLIGHT_INFORMATION = 'page_highlight_information';
    public const VIDEO_OUTSIDE_UI = 'video_outside_ui';
    public const SEARCH_SETTING = 'search_setting';
    public const ADMIN_TOP_NAVIGATION = 'admin_top_navigation';
    public const SHOP_LOGOS = 'shop_logos';
    public const SHOP_FAVICONS = 'shop_favicons';
    public const QUEUE_NAMES = 'queue_names';
    public const FOOTER_MENUS = 'footer_menus';
    public const MOST_SEARCHED = 'most_searched';
    public const BUSINESS_INFORMATION = 'business_information';
    public const ZALO_WIDGET_CHAT_SDK = 'zalo_widget_chat_sdk';
    public const REQUIRED_OAUTH_USER_COMPLETE_INFORMATION_BEFORE_SIGNIN = 'required_oauth_user_complete_information_before_signin';

    public const COMMON_INVENTORY_KEY_FEATURED = 'common_inventory_key_featured';

    // Image
    public const IMAGE_CONFIGURATION = 'image_configuration';

    // OAuth
    public const SUPPORTED_OAUTH_PROVIDERS = 'supported_oauth_providers';

    // SEO
    public const GOOGLE_ANALYTICS_TAG = 'google_analytics_tag';

    public const ENABLE_SEND_NEW_ORDER_TO_ADMIN = 'enable_send_new_order_to_admin';

    public const DMCA_SITE_VERIFICATION = 'dmca_site_verification';

    public const AFFILIATE_SALES_CHANNELS = 'affiliate_sales_channels';

    public const PROVIDER_CALLBACK_WHITELIST_IPS = 'provider_callback_whitelist_ips';

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
            self::IMAGE_CONFIGURATION,
            self::ADMIN_TOP_NAVIGATION,
            self::SUPPORTED_OAUTH_PROVIDERS,
            self::MAINTENANCE_ALLOW_IPS_ACCESS,
            self::USER_FE_RESET_PASSWORD_LINK,
            self::ENABLE_SEND_NEW_ORDER_TO_ADMIN,
            self::SHOP_LOGOS,
            self::SHOP_FAVICONS,
            self::QUEUE_NAMES,
            self::FOOTER_MENUS,
            self::GOOGLE_ANALYTICS_TAG,
            self::DMCA_SITE_VERIFICATION,
            self::AFFILIATE_SALES_CHANNELS,
            self::PROVIDER_CALLBACK_WHITELIST_IPS,
        ];
    }
}

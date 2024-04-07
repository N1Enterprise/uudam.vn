<?php

namespace App\Providers;

use App\Classes\Contracts\UserAuthContract;
use App\Cms\MenuCms;
use App\Cms\PageCms;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class FrontendViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerViewComposer();
        $this->registerBladeComponent();
        $this->registerDirectives();
    }

    private function registerBladeComponent()
    {
    }

    private function registerViewComposer()
    {
        View::composer('frontend.*', function ($view) {
            $view->with('APP_NAME', config('name'));

            $view->with('APP_URL', config('app.url'));

            $view->with('APP_MENU_AVAILABEL', MenuCms::make()->availabel());

            /** @var UserAuthContract */
            $userAuth = app(UserAuthContract::class);

            $view->with('AUTHENTICATED_USER', optional($userAuth->user())->only(['id', 'email', 'birthday', 'name', 'phone_number']));

            $view->with('SYSTEM_SETTING', $this->getSystemSetting());

            $feAvailabelPages = PageCms::make()->ofFooter();

            $view->with('FOOTER_PAGES', $feAvailabelPages);

            $view->with('CONSTANTS_SHARED', [
                'bo_host' => config('app.url'),
                'fe_host' => config('app.user_host'),
                'app_id'  => config('app.app_id'),
                'app_env' => config('app.env'),
                'fe_view_only_mode' => config('app.fe_view_only_mode')
            ]);
        });
    }

    private function registerDirectives()
    {

    }

    protected function getSystemSetting()
    {
        return [
            'admin_top_navigation' => SystemSetting::from(SystemSettingKeyEnum::ADMIN_TOP_NAVIGATION)->get(null, []),

            'page_settings' => SystemSetting::from(SystemSettingKeyEnum::PAGE_SETTINGS)->get(null, []),
            'shop_logos' => SystemSetting::from(SystemSettingKeyEnum::SHOP_LOGOS)->get(null, []),
            'shop_favicons' => SystemSetting::from(SystemSettingKeyEnum::SHOP_FAVICONS)->get(null, []),

            'footer_menus' => SystemSetting::from(SystemSettingKeyEnum::FOOTER_MENUS)->get(null, []),

            'social_networks' => collect(SystemSetting::from(SystemSettingKeyEnum::SOCIAL_NETWORKS)->get(null, []))->filter(fn($item) => data_get($item, 'enable')),
            'receive_new_post_setting' => SystemSetting::from(SystemSettingKeyEnum::RECEIVE_NEW_POST_SETTING)->get(null, []),
            'search_setting' => SystemSetting::from(SystemSettingKeyEnum::SEARCH_SETTING)->get(null, []),
            'page_highlight_information' => SystemSetting::from(SystemSettingKeyEnum::PAGE_HIGHLIGHT_INFORMATION)->get(null, []),
            'oauth_providers' => collect(SystemSetting::from(SystemSettingKeyEnum::SUPPORTED_OAUTH_PROVIDERS)->get(null, []))
                ->filter(fn($provider) => boolean(data_get($provider, 'enable')))
                ->sortBy('order')
                ->map(function($provider) {
                    return [
                        'logo' => data_get($provider, 'logo'),
                        'button_label' => data_get($provider, 'button_label')
                    ];
                }),

            // SEO
            'google_analytics_tag' => SystemSetting::from(SystemSettingKeyEnum::GOOGLE_ANALYTICS_TAG)->get(null, ''),

            'most_searched' => SystemSetting::from(SystemSettingKeyEnum::MOST_SEARCHED)->get(null, []),

            'business_information' => SystemSetting::from(SystemSettingKeyEnum::BUSINESS_INFORMATION)->get(null, []),

            'zalo_widget_chat_sdk' => SystemSetting::from(SystemSettingKeyEnum::ZALO_WIDGET_CHAT_SDK)->get(null, []),

            'dmca_site_verification' => SystemSetting::from(SystemSettingKeyEnum::DMCA_SITE_VERIFICATION)->get(null, []),
        ];
    }
}

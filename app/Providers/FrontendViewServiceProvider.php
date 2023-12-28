<?php

namespace App\Providers;

use App\Classes\Contracts\UserAuthContract;
use App\Common\Menu;
use App\Enum\PageDisplayInEnum;
use App\Enum\SystemSettingKeyEnum;
use App\Models\Page;
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

            $view->with('APP_MENU_GROUPS', $this->getAppMenus());

            /** @var UserAuthContract */
            $userAuth = app(UserAuthContract::class);

            $view->with('AUTHENTICATED_USER', optional($userAuth->user())->only(['id', 'email', 'birthday', 'name', 'phone_number']));

            $view->with('SYSTEM_SETTING', $this->getSystemSetting());

            $feAvailabelPages = Page::allFromCacheForGuest(PageDisplayInEnum::FOOTER);

            $view->with('FOOTER_PAGES', $feAvailabelPages);
        });
    }

    private function registerDirectives()
    {

    }

    public function getAppMenus()
    {
        $menuGroups = Menu::getMenus();

        return $menuGroups;
    }

    protected function getSystemSetting()
    {
        return [
            'admin_top_navigation' => SystemSetting::from(SystemSettingKeyEnum::ADMIN_TOP_NAVIGATION)->get(null, []),
            'page_settings' => SystemSetting::from(SystemSettingKeyEnum::PAGE_SETTINGS)->get(null, []),
            'social_networks' => collect(SystemSetting::from(SystemSettingKeyEnum::SOCIAL_NETWORKS)->get(null, []))->filter(fn($item) => data_get($item, 'enable')),
            'receive_new_post_setting' => SystemSetting::from(SystemSettingKeyEnum::RECEIVE_NEW_POST_SETTING)->get(null, []),
            'search_setting' => SystemSetting::from(SystemSettingKeyEnum::SEARCH_SETTING)->get(null, []),
            'page_highlight_information' => SystemSetting::from(SystemSettingKeyEnum::PAGE_HIGHLIGHT_INFORMATION)->get(null, []),
        ];
    }
}

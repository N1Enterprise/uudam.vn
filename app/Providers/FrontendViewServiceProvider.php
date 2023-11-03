<?php

namespace App\Providers;

use App\Enum\PageDisplayTypeEnum;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use App\Services\MenuGroupService;
use App\Services\PageService;
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

            $view->with('PAGE_SETTINGS', SystemSetting::from(SystemSettingKeyEnum::PAGE_SETTINGS)->get(null, []));

            $view->with(
                'SOCIAL_NETWORKS',
                collect(SystemSetting::from(SystemSettingKeyEnum::SOCIAL_NETWORKS)->get(null, []))
                    ->filter(fn($item) => data_get($item, 'enable'))
            );

            $view->with('RECEIVE_NEW_POST_SETTING', SystemSetting::from(SystemSettingKeyEnum::RECEIVE_NEW_POST_SETTING)->get(null, []));

            $view->with('PAGES_BELONGTO_MENU', app(PageService::class)->allAvailable(['columns' => ['id', 'name', 'slug'], 'scopes' => ['menu']]));

            $view->with('APP_MENU_GROUPS', $this->getAppMenus());

            $view->with('SEARCH_SETTING', SystemSetting::from(SystemSettingKeyEnum::SEARCH_SETTING)->get(null, []));
        });
    }

    private function registerDirectives()
    {

    }

    public function getAppMenus()
    {
        $menuGroups = app(MenuGroupService::class)->allAvailable(['columns' => ['id', 'name', 'redirect_url']]);

        return $menuGroups;
    }
}

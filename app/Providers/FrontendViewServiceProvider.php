<?php

namespace App\Providers;

use App\Classes\Contracts\UserAuthContract;
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

            $view->with('PAGES_DISPLAY_IN_FOOTER', app(PageService::class)->listByUser(['columns' => ['id', 'name', 'slug'], 'scopes' => ['displayInFooter']]));

            $view->with('APP_MENU_GROUPS', $this->getAppMenus());

            $view->with('SEARCH_SETTING', SystemSetting::from(SystemSettingKeyEnum::SEARCH_SETTING)->get(null, []));

            /** @var UserAuthContract */
            $userAuth = app(UserAuthContract::class);

            $view->with('AUTHENTICATED_USER', optional($userAuth->user())->only(['id', 'email', 'birthday', 'name', 'phone_number']));
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

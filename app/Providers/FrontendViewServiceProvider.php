<?php

namespace App\Providers;

use App\Enum\PageDisplayTypeEnum;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
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
            $view->with('SOCIAL_NETWORKS', SystemSetting::from(SystemSettingKeyEnum::SOCIAL_NETWORKS)->get(null, []));
            $view->with('RECEIVE_NEW_POST_SETTING', SystemSetting::from(SystemSettingKeyEnum::RECEIVE_NEW_POST_SETTING)->get(null, []));
            $view->with(
                'PAGE_HIGHLIGHT_INFORMATION',
                collect(SystemSetting::from(SystemSettingKeyEnum::PAGE_HIGHLIGHT_INFORMATION)->get(null, []))
                    ->filter(fn($item) => data_get($item, 'enable'))
                    ->toArray()
            );

            $pages = app(PageService::class)->allAvailable();

            $view->with('PAGES_BY_LEFT_SHOW_DIRECT', $pages->filter(fn($item) => $item->display_type == PageDisplayTypeEnum::LEFT_SHOW_DIRECT));
            $view->with('PAGES_BY_MENUS', $pages->filter(fn($item) => $item->display_type == PageDisplayTypeEnum::MENU));
        });
    }

    private function registerDirectives()
    {

    }
}

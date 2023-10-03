<?php

namespace App\Providers;

use App\Classes\UserAuth;
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
        View::composer('frontend.*', function ($view) {
            $view->with('APP_NAME', config('name'));
            $view->with('AUTHENTICATED_USER',  UserAuth::user());
        });
    }

    private function registerViewComposer()
    {

    }

    private function registerDirectives()
    {

    }
}

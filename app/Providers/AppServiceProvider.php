<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(BackofficeViewServiceProvider::class);
        $this->app->register(FrontendViewServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerUtils();
    }

    public function registerUtils()
    {
        if (file_exists($file = app_path('Utils/Helpers.php'))) {
            require $file;
        }
    }
}

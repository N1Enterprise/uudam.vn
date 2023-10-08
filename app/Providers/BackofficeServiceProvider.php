<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackofficeServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'backoffice';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLangs();

        $this->app->register(BackofficeRouteServiceProvider::class);
        $this->app->register(BackofficeFormRequestServiceProvider::class);
        $this->app->register(BackofficeResponseServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    protected function registerLangs()
    {
        $langPath = resource_path('lang/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        }
    }
}

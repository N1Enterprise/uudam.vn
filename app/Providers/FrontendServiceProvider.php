<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FrontendServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'frontend';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(FrontendViewServiceProvider::class);
        $this->app->register(FrontendRouteServiceProvider::class);
        $this->app->register(FrontendResponseServiceProvider::class);
        $this->app->register(FrontendFormRequestServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class FrontendServiceProvider extends ServiceProvider
{
    public $singletons = [
        \App\Classes\Contracts\UserAuthContract::class => \App\Classes\UserAuth::class
    ];

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
        $this->app->register(FrontendAuthenticationServiceProvider::class);
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
        $this->registerMiddleware();
    }

    public function registerMiddleware()
    {
        /** @var Router */
        $router = $this->app['router'];

        $router->middlewareGroup('user_api', ['security.xss_prevention']);
    }
}

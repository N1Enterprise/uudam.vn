<?php

namespace App\Providers;

use App\Http\Middleware\MaintenanceMiddleware;
use App\Http\Middleware\ToggleFeatureMiddleware;
use App\Http\Middleware\XssPreventionMiddleware;
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
        $this->app->register(TelescopeServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerUtils();
        $this->aliasMiddleware();

        $this->app['router']->aliasMiddleware('security.xss_prevention', XssPreventionMiddleware::class);
    }

    protected function registerUtils()
    {
        if (file_exists($file = app_path('Utils/Helpers.php'))) {
            require $file;
        }
    }

    protected function aliasMiddleware()
    {
        /** @var Illuminate\Routing\Router */
        $router = $this->app['router'];

        $router->aliasMiddleware('system.feature_toggle', ToggleFeatureMiddleware::class);
        $router->aliasMiddleware('system.maintenance', MaintenanceMiddleware::class);
    }
}

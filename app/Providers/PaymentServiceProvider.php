<?php

namespace App\Providers;

use App\Http\Middleware\AuthentiateProviderCallbackIPsMiddleware;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'payment';

    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers\Payment';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(PaymentRouteServiceProvider::class);
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

        $router->aliasMiddleware('security.authenticate_provider_callback_ips', AuthentiateProviderCallbackIPsMiddleware::class);
    }
}

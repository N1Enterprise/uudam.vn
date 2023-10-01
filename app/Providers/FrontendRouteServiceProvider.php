<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class FrontendRouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers\Frontend';

    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware(['web'])
            ->namespace($this->namespace)
            ->as('fe.web.')
            ->group(base_path('routes/frontend/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::middleware(['web', 'auth:admin'])
            ->as('bo.api.')
            ->prefix('fe/api')
            ->group(base_path('routes/frontend/api.php'));
    }
}

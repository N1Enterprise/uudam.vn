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
            ->as('fe.user.web.')
            ->group(base_path('routes/frontend/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::as('fe.user.api.')
            ->prefix('fe/user/api')
            ->group(base_path('routes/frontend/api.php'));
    }
}

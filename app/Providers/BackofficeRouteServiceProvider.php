<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class BackofficeRouteServiceProvider extends ServiceProvider
{
    public const HOME = '/backoffice';

    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers\Backoffice';

    public function map()
    {
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'auth:admin'])
            ->prefix('backoffice')
            ->namespace($this->namespace)
            ->as('bo.web.')
            ->group(base_path('routes/backoffice/web.php'));
    }
}

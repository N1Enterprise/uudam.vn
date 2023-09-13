<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the application events
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRouteMacro();
        $this->registerBuilderMacro();
    }

    protected function registerRouteMacro()
    {
        Route::macro('findByName', function($name, $parameters = [], $absolute = true) {
            try {
                return app('url')->route($name, $parameters, $absolute);
            } catch (\Throwable $th) {
                if ($th instanceof \Symfony\Component\Routing\Exception\RouteNotFoundException) {
                    return;
                }

                throw $th;
            }
        });
    }

    protected function registerBuilderMacro()
    {
    }
}

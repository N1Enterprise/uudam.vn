<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FrontendServiceProvider extends ServiceProvider
{
    public $singletons = [
        \App\Classes\Contracts\UserAuthContract::class => \App\Classes\UserAuth::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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

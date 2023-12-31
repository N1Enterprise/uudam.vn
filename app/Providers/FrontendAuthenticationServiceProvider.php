<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;

class FrontendAuthenticationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('fe.api.user.signin', function($request) {
           
        });
    }
}

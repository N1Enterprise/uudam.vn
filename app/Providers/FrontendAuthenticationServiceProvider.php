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
        $this->configureRateLimiting();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('fe.api.user.signin', function($request) {
           
        });
    }
}

<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\FortifyServiceProvider as LaravelFortifyServiceProvider;
use Illuminate\Support\Facades\Config;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(LaravelFortifyServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerAuth();
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        $this->configureRateLimiting();

        Fortify::loginView(function () {
            return view('backoffice.auth.login-v1');
        });

        Fortify::registerView(function () {
            return view('backoffice.auth.login-v1');
        });
    }

    protected function registerAuth()
    {
        Config::set('auth.guards.admin', [
            'driver' => 'session',
            'provider' => 'admins'
        ]);

        Config::set('auth.providers.admins', [
            'driver' => 'eloquent',
            'model' => \App\Models\Admin::class
        ]);

        Config::set('auth.passwords.admins', [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 1,
        ]);

        Config::set('auth.guards.user', [
            'driver' => 'session',
            'provider' => 'users'
        ]);

        Config::set('auth.providers.users', [
            'driver' => 'eloquent',
            'model' => \App\Models\Admin::class
        ]);

        Config::set('auth.passwords.users', [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 1,
        ]);
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('login', function ($request) {
            return Limit::perMinute(10)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}

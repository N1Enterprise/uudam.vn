<?php

namespace App\Providers;

use App\Providers\Events as EventProviders;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(EventProviders\OrderEventServiceProvider::class);
        $this->app->register(EventProviders\NotificationEventServiceProvider::class);
        $this->app->register(EventProviders\ProductEventServiceProvider::class);
    }
}

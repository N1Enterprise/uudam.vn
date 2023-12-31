<?php

namespace App\Providers;

use App\Providers\Events\NotificationEventServiceProvider;
use App\Providers\Events\OrderEventServiceProvider;
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
        $this->app->register(OrderEventServiceProvider::class);
        $this->app->register(NotificationEventServiceProvider::class);
    }
}

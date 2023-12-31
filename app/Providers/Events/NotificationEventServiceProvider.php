<?php

namespace App\Providers\Events;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events;
use App\Listeners;

class NotificationEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Events\Order\OrderCreated::class => [
            Listeners\Notifications\ProcessSendMailNewOrderToAdmin::class,  
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

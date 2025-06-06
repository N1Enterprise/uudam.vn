<?php

namespace App\Providers\Events;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events;
use App\Listeners;

class OrderEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Events\Deposit\DepositDeclined::class => [
            Listeners\Order\DeclineOrderPayment::class
        ],
        Events\Deposit\DepositCancelled::class => [
            Listeners\Order\CancelOrderPayment::class
        ],
        Events\Deposit\DepositApproved::class => [
            Listeners\Order\ApprovedOrderPayment::class
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

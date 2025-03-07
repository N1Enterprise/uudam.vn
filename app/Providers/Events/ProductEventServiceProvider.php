<?php

namespace App\Providers\Events;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events;
use App\Listeners;

class ProductEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Events\Order\OrderCompleted::class => [
            Listeners\Catalog\IncreaseInventoriesSoldQuantity::class,
            Listeners\Catalog\DecreaseInventoryStockQuantity::class
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

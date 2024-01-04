<?php

namespace App\Listeners\Catalog;

use App\Events\Order\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class IncreaseInventoriesSoldQuantity implements ShouldQueue
{
    public $timeout = 300;

    public $tries = 30;

    public $backoff = 5;

    public $afterCommit = true;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;

        logger('IncreaseInventoriesSoldQuantity');

        collect(data_get($order, 'orderItems', []))->each(function($item) {
            DB::table('inventories')
                ->where('id', $item->inventory_id)
                ->update([
                    'sold_count' => DB::raw("sold_count + ".$item->quantity."")
                ]);
        });
    }
}

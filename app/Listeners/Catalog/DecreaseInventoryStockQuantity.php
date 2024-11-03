<?php

namespace App\Listeners\Catalog;

use App\Events\Order\OrderCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class DecreaseInventoryStockQuantity implements ShouldQueue
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
    public function handle(OrderCompleted $event)
    {
        $order = $event->order;

        collect(data_get($order, 'orderItems', []))->each(function($item) {
            DB::table('inventories')
                ->where('id', $item->inventory_id)
                ->update([
                    'stock_quantity' => DB::raw("stock_quantity - ".$item->quantity."")
                ]);
        });
    }
}

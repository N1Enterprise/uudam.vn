<?php

namespace App\Listeners\Order;

use App\Enum\OrderStatusEnum;
use App\Events\Deposit\DepositDeclined;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\DepositTransaction;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;

class CancelOrderPayment implements ShouldQueue
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
    public function handle(DepositDeclined $event)
    {
        /** @var DepositTransaction */
        $transaction = $event->transaction;

        DB::table('orders')->update([
            'order_status' => OrderStatusEnum::DECLINED,
            'log' => array_merge($transaction->order->log ?? [], [
                ["[".now()."] DECLINED BY DEPOSIT DECLINED"]
            ])
        ]);
    }

    public function shouldQueue($event)
    {
        $transaction = $event->transaction;

        return $transaction->order_id;
    }
}

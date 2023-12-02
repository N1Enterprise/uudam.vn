<?php

namespace App\Listeners\Order;

use App\Events\Deposit\DepositDeclined;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\DepositTransaction;
use App\Services\OrderService;

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

        OrderService::make()->declined($transaction->order->id, [
            'log' => [["[".now()."] DECLINED BY DEPOSIT DECLINED"]]
        ]);
    }

    public function shouldQueue($event)
    {
        $transaction = $event->transaction;

        return $transaction->order_id;
    }
}

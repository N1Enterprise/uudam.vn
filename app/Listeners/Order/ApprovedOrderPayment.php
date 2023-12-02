<?php

namespace App\Listeners\Order;

use App\Events\Deposit\DepositApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\DepositTransaction;
use App\Services\OrderService;

class ApprovedOrderPayment implements ShouldQueue
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
    public function handle(DepositApproved $event)
    {
        /** @var DepositTransaction */
        $transaction = $event->transaction;

        OrderService::make()->approvePayment($transaction->order->id);
    }

    public function shouldQueue($event)
    {
        $transaction = $event->transaction;

        return $transaction->order_id;
    }
}

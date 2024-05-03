<?php

namespace App\Listeners\Order;

use App\Models\DepositTransaction;
use App\Services\OrderPaymentService;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    public function handle($event)
    {
        /** @var DepositTransaction */
        $transaction = $event->transaction;

        OrderPaymentService::make()->cancel($transaction->order);
    }
}

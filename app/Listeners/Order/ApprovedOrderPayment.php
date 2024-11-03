<?php

namespace App\Listeners\Order;

use App\Events\Deposit\DepositApproved;
use App\Models\DepositTransaction;
use App\Services\OrderPaymentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;

class ApprovedOrderPayment
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

        /** @var Order */
        $order = $transaction->order;

        if (! $order->isPendingPayment()) {
            return;
        }

        OrderPaymentService::make()->approve($transaction->order);
    }
}

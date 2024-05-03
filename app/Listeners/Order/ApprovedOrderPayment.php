<?php

namespace App\Listeners\Order;

use App\Events\Deposit\DepositApproved;
use App\Models\DepositTransaction;
use App\Services\OrderPaymentService;
use Illuminate\Contracts\Queue\ShouldQueue;

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

        OrderPaymentService::make()->approve($transaction->order);
    }
}

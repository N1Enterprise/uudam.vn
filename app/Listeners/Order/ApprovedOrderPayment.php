<?php

namespace App\Listeners\Order;

use App\Enum\PaymentStatusEnum;
use App\Events\Deposit\DepositApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\DepositTransaction;
use App\Services\OrderPaymentService;
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

        OrderPaymentService::make()->approve($transaction->order);
    }

    public function shouldQueue($event)
    {
        $transaction = $event->transaction;

        $order = OrderService::make()->show($transaction->order->id);

        return boolean($transaction->order_id) && $order->payment_status == PaymentStatusEnum::PENDING;
    }
}

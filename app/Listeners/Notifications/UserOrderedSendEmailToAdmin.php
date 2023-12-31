<?php

namespace App\Listeners\Order;

use App\Events\Order\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserOrderedSendEmailToAdmin implements ShouldQueue
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
        dd($event);      
    }
}

<?php

namespace App\Events\Deposit;

use App\Common\RequestHelper;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Deposited
{
    use SerializesModels;
    use Dispatchable;

    public $transaction;
    public $isUserRequest;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($deposit)
    {
        $this->transaction   = $deposit;
        $this->isUserRequest = app(RequestHelper::class)->isUserRequest(request());
    }
}

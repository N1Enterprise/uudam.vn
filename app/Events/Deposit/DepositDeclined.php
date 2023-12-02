<?php

namespace App\Events\Deposit;

use App\Models\DepositTransaction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DepositDeclined
{
    use SerializesModels;
    use Dispatchable;

    public $transaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DepositTransaction $transaction)
    {
        $this->transaction = $transaction;
    }
}

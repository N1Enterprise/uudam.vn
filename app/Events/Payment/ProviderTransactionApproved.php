<?php

namespace App\Events\Payment;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProviderTransactionApproved
{
    use SerializesModels;
    use Dispatchable;

    public $transaction;

    public $providerResponse;
    public $paymentChannel;
    public $paymentType;
    public $paymentProviderCode;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($transaction, $providerResponse, $paymentChannel, $paymentType, $paymentProviderCode)
    {
        $this->transaction = $transaction;
        $this->providerResponse = $providerResponse;
        $this->paymentChannel = $paymentChannel;
        $this->paymentType = $paymentType;
        $this->paymentProviderCode = $paymentProviderCode;
    }
}

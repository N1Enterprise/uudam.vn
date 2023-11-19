<?php

namespace App\Payment;

use App\Payment\Contracts\ProviderNamingContract;
use App\Models\PaymentProvider;
use App\Models\PaymentOption;

/**
 * Base payment integration class
 */
abstract class BasePaymentIntegration implements ProviderNamingContract
{
    /**
     * @var PaymentProvider
     */
    public $provider;

    /**
     * @var PaymentOption
     */
    public $paymentOption;
}

<?php

namespace App\Payment\Providers\VnPay\Constants;

class TransactionState
{
    public const APPROVED = '00';

    public const PENDING = '01';

    public const FAILED = '02';

    public const SUSPECTED_OF_FRAUD = '07';
}

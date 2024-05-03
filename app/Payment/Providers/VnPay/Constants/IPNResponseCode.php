<?php

namespace App\Payment\Providers\VnPay\Constants;

class IPNResponseCode
{
    public const TRANSACTION_SUCCESS = '00';

    public const TRANSACTION_SUSPECTED_FRAUD = '07';

    public const TRANSACTION_FAILED_CUSTOMER_NOT_REGISTERED = '09';

    public const TRANSACTION_FAILED_INCORRECT_AUTHENTICATION = '10';

    public const TRANSACTION_FAILED_EXPIRED = '11';

    public const TRANSACTION_FAILED_CUSTOMER_ACCOUNT_LOCKED = '12';

    public const TRANSACTION_FAILED_INCORRECT_OTP = '13';

    public const TRANSACTION_CANCELLED_BY_CUSTOMER = '24';

    public const TRANSACTION_FAILED_INSUFFICIENT_BALANCE = '51';

    public const TRANSACTION_FAILED_EXCEED_DAILY_LIMIT = '65';

    public const BANK_UNDER_MAINTENANCE = '75';

    public const TRANSACTION_FAILED_EXCEED_PAYMENT_ATTEMPTS = '79';

    public const OTHER_ERRORS = '99';
}

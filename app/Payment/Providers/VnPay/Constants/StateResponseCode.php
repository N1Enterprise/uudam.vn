<?php

namespace App\Payment\Providers\VnPay\Constants;

class StateResponseCode
{
    public const INVALID_CHECKSUM = '97';

    public const INVALID_AMOUNT = '04';

    public const ORDER_ALREADY_CONFIRMED = '02';

    public const ORDER_NOT_FOUND = '01';

    public const CONFIRM_SUCCESS = '00';

    public const UNKNOWN_ERROR = '99';
}

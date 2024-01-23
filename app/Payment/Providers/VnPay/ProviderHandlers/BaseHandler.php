<?php

namespace App\Payment\Providers\VnPay\ProviderHandlers;

use App\Payment\BasePaymentProviderHandle;
use App\Payment\Providers\VnPay\Service;

abstract class BaseHandler extends BasePaymentProviderHandle
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function appendProviderResponseMeta($transaction, $data = [])
    {
        
    }

    public function parseRedirectOutput($response, $options = [])
    {
        
    }
}

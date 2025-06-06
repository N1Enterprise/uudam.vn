<?php

return [
    'payment_provider_mappers' => [
        'vnpay' => \App\Payment\Providers\VnPay\Service::class,
        'momo'  => \App\Payment\Providers\Momo\Service::class,
    ],

    'payment_request_prefix' => env('PAYMENT_REQUEST_PREFIX', ''),
];

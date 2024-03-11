<?php

return [
    'shipping_provider_mappers' => [
        'ghtk' => \App\Shipping\Providers\Ghtk\Service::class,
        'lalamove'  => \App\Shipping\Providers\Lalamove\Service::class,
    ],
];

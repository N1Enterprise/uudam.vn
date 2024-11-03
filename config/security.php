<?php

return [
    'footprint_fields' => [
        'headers' => [
            'ip' => 'ip',
            'domain' => 'domain',
            'platform' => 'platform',
            'client_id' =>'x-client-id',
            'session_id' => 'x-client-session-id',
        ]
    ],
    'xss_prevention' => [
        'ignore_params' => [
            'password',
            'password_confirmation',
            'new_password',
            'new_password_confirmation',
            '_token',
        ]
    ]
];

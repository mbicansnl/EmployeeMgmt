<?php

declare(strict_types=1);

return [
    'connections' => [
        'default' => [
            'hosts' => array_filter(explode(',', (string) env('AD_HOSTS'))),
            'base_dn' => env('AD_BASE_DN'),
            'username' => env('AD_BIND_DN'),
            'password' => env('AD_BIND_PASSWORD'),
            'use_ssl' => (bool) env('AD_USE_SSL', false),
            'use_tls' => (bool) env('AD_USE_TLS', true),
            'timeout' => 5,
        ],
    ],
];

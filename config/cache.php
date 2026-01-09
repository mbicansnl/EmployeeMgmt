<?php

declare(strict_types=1);

return [
    'default' => env('CACHE_STORE', 'database'),
    'stores' => [
        'database' => [
            'driver' => 'database',
            'table' => 'cache',
        ],
        'array' => [
            'driver' => 'array',
        ],
    ],
    'prefix' => env('CACHE_PREFIX', 'empmgr_cache'),
];

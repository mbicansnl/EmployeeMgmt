<?php

declare(strict_types=1);

return [
    'okta' => [
        'base_url' => env('OKTA_ISSUER'),
        'client_id' => env('OKTA_CLIENT_ID'),
        'client_secret' => env('OKTA_CLIENT_SECRET'),
        'redirect' => env('OKTA_REDIRECT_URI'),
    ],
];

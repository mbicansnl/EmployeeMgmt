<?php

declare(strict_types=1);

return [
    'directory_provider' => env('DIRECTORY_PROVIDER', 'local'),
    'local_auth_enabled' => (bool) env('LOCAL_AUTH_ENABLED', false),
    'directory_sync_interval' => (int) env('DIRECTORY_SYNC_INTERVAL', 15),
    'app_subdirectory' => env('APP_SUBDIRECTORY'),
];

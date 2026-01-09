<?php

declare(strict_types=1);

use App\Jobs\SyncDirectoryJob;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new SyncDirectoryJob())
    ->everyMinutes((int) config('empmgr.directory_sync_interval', 15))
    ->name('directory-sync');

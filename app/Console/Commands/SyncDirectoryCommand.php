<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\DirectorySyncService;
use Illuminate\Console\Command;

class SyncDirectoryCommand extends Command
{
    protected $signature = 'directory:sync';

    protected $description = 'Synchronize people from the configured directory provider.';

    public function handle(DirectorySyncService $syncService): int
    {
        $count = $syncService->sync();
        $this->info("Synced {$count} people.");

        return Command::SUCCESS;
    }
}

<?php

declare(strict_types=1);

namespace App\Providers;

use App\Providers\Directory\ActiveDirectoryProvider;
use App\Providers\Directory\DirectoryProviderInterface;
use App\Providers\Directory\LocalDirectoryProvider;
use App\Models\Assignment;
use App\Models\Domain;
use App\Models\Person;
use App\Models\Project;
use App\Observers\AuditObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DirectoryProviderInterface::class, function () {
            $provider = config('empmgr.directory_provider');

            return match ($provider) {
                'ad' => app(ActiveDirectoryProvider::class),
                default => app(LocalDirectoryProvider::class),
            };
        });
    }

    public function boot(): void
    {
        Person::observe(AuditObserver::class);
        Domain::observe(AuditObserver::class);
        Project::observe(AuditObserver::class);
        Assignment::observe(AuditObserver::class);
    }
}

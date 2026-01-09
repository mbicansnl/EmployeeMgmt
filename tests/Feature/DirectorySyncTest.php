<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Person;
use App\Providers\Directory\DirectoryProviderInterface;
use App\Services\DirectorySyncService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DirectorySyncTest extends TestCase
{
    use RefreshDatabase;

    public function test_missing_people_are_marked_as_leavers(): void
    {
        $person = Person::factory()->create([
            'status' => 'active',
            'leave_date' => null,
        ]);

        $provider = new class implements DirectoryProviderInterface {
            public function fetchPeople(): array
            {
                return [];
            }

            public function fetchHierarchy(int $leaderPersonId): array
            {
                return [];
            }

            public function fetchJoiners(string $sinceDate): array
            {
                return [];
            }

            public function fetchLeavers(string $sinceDate): array
            {
                return [];
            }

            public function isAvailable(): bool
            {
                return true;
            }
        };

        $syncService = new DirectorySyncService($provider);
        $syncService->sync();

        $person->refresh();
        $this->assertSame('inactive', $person->status);
        $this->assertNotNull($person->leave_date);
    }
}

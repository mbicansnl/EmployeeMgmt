<?php

declare(strict_types=1);

namespace App\Providers\Directory;

use App\Models\Person;

class LocalDirectoryProvider implements DirectoryProviderInterface
{
    public function fetchPeople(): array
    {
        return Person::query()->get()->map(fn (Person $person) => $person->toArray())->all();
    }

    public function fetchHierarchy(int $leaderPersonId): array
    {
        return Person::query()
            ->where('manager_id', $leaderPersonId)
            ->get()
            ->map(fn (Person $person) => $person->toArray())
            ->all();
    }

    public function fetchJoiners(string $sinceDate): array
    {
        return Person::query()
            ->where('join_date', '>=', $sinceDate)
            ->get()
            ->map(fn (Person $person) => $person->toArray())
            ->all();
    }

    public function fetchLeavers(string $sinceDate): array
    {
        return Person::query()
            ->whereNotNull('leave_date')
            ->where('leave_date', '>=', $sinceDate)
            ->get()
            ->map(fn (Person $person) => $person->toArray())
            ->all();
    }

    public function isAvailable(): bool
    {
        return true;
    }
}

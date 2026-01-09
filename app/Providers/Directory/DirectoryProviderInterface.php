<?php

declare(strict_types=1);

namespace App\Providers\Directory;

interface DirectoryProviderInterface
{
    public function fetchPeople(): array;

    public function fetchHierarchy(int $leaderPersonId): array;

    public function fetchJoiners(string $sinceDate): array;

    public function fetchLeavers(string $sinceDate): array;

    public function isAvailable(): bool;
}

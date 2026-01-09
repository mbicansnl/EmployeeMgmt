<?php

declare(strict_types=1);

namespace App\Providers\Directory;

use Illuminate\Support\Arr;
use LdapRecord\Container;
use LdapRecord\Models\ActiveDirectory\User as AdUser;

class ActiveDirectoryProvider implements DirectoryProviderInterface
{
    public function fetchPeople(): array
    {
        return AdUser::query()->get()->map($this->mapUser(...))->all();
    }

    public function fetchHierarchy(int $leaderPersonId): array
    {
        $leader = AdUser::find($leaderPersonId);
        if (! $leader) {
            return [];
        }

        return $leader->directReports()->get()->map($this->mapUser(...))->all();
    }

    public function fetchJoiners(string $sinceDate): array
    {
        return AdUser::query()
            ->where('whenCreated', '>=', $sinceDate)
            ->get()
            ->map($this->mapUser(...))
            ->all();
    }

    public function fetchLeavers(string $sinceDate): array
    {
        return AdUser::query()
            ->where('whenChanged', '>=', $sinceDate)
            ->get()
            ->filter(fn (AdUser $user) => ! $user->isEnabled())
            ->map($this->mapUser(...))
            ->all();
    }

    public function isAvailable(): bool
    {
        try {
            return Container::getConnection('default')->isConnected();
        } catch (\Throwable) {
            return false;
        }
    }

    private function mapUser(AdUser $user): array
    {
        return [
            'ad_guid' => (string) $user->getConvertedGuid(),
            'employee_id' => Arr::first($user->getAttribute('employeeId')),
            'username' => $user->getFirstAttribute('sAMAccountName') ?? $user->getFirstAttribute('userPrincipalName'),
            'email' => $user->getFirstAttribute('mail'),
            'name' => $user->getFirstAttribute('displayName')
                ?? trim(($user->getFirstAttribute('givenName') ?? '') . ' ' . ($user->getFirstAttribute('sn') ?? '')),
            'job_title' => $user->getFirstAttribute('title'),
            'location' => $user->getFirstAttribute('physicalDeliveryOfficeName'),
            'address' => implode(', ', array_filter([
                $user->getFirstAttribute('streetAddress'),
                $user->getFirstAttribute('l'),
                $user->getFirstAttribute('postalCode'),
                $user->getFirstAttribute('co'),
            ])),
            'manager_dn' => $user->getFirstAttribute('manager'),
            'enabled' => $user->isEnabled(),
            'employee_type' => $user->getFirstAttribute('employeeType') ?? 'employee',
            'join_date' => $user->getFirstAttribute('whenCreated'),
        ];
    }
}

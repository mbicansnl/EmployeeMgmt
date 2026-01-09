<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ChangeLog;
use App\Models\Person;
use App\Providers\Directory\DirectoryProviderInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DirectorySyncService
{
    public function __construct(private readonly DirectoryProviderInterface $provider)
    {
    }

    public function sync(): int
    {
        if (! $this->provider->isAvailable()) {
            Log::warning('Directory provider unavailable.');

            return 0;
        }

        $people = $this->provider->fetchPeople();
        $syncedIds = [];

        foreach ($people as $payload) {
            if (empty($payload['email']) && empty($payload['ad_guid'])) {
                continue;
            }
            $person = Person::query()
                ->when($payload['ad_guid'] ?? null, fn ($query) => $query->where('ad_guid', $payload['ad_guid']))
                ->when($payload['email'] ?? null, fn ($query) => $query->orWhere('email', $payload['email']))
                ->first();

            $person ??= new Person();

            $person->fill([
                'ad_guid' => $payload['ad_guid'] ?? $person->ad_guid,
                'email' => $payload['email'] ?? $person->email,
                'employee_id' => $payload['employee_id'] ?? null,
                'username' => $payload['username'] ?? null,
                'name' => $payload['name'] ?? $person->name,
                'job_title' => $payload['job_title'] ?? null,
                'location' => $payload['location'] ?? null,
                'address' => $payload['address'] ?? null,
                'employee_type' => $payload['employee_type'] ?? 'employee',
                'status' => ($payload['enabled'] ?? true) ? 'active' : 'inactive',
                'join_date' => $payload['join_date'] ? Carbon::parse($payload['join_date']) : ($person->join_date ?? now()),
                'last_synced_at' => now(),
                'source' => config('empmgr.directory_provider'),
            ]);

            $person->save();

            $syncedIds[] = $person->id;

            ChangeLog::query()->create([
                'person_id' => $person->id,
                'change_type' => 'sync',
                'summary' => 'Person synced from directory.',
                'payload' => $payload,
            ]);
        }

        $missingPeople = Person::query()
            ->whereNotNull('id')
            ->when($syncedIds !== [], fn ($query) => $query->whereNotIn('id', $syncedIds))
            ->get();

        foreach ($missingPeople as $person) {
            if ($person->leave_date) {
                continue;
            }

            $person->update([
                'status' => 'inactive',
                'leave_date' => now(),
            ]);

            ChangeLog::query()->create([
                'person_id' => $person->id,
                'change_type' => 'leave',
                'summary' => 'Marked inactive after missing from directory sync.',
                'payload' => ['reason' => 'missing'],
            ]);
        }

        return count($syncedIds);
    }
}

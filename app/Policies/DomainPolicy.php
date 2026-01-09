<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Domain;
use App\Models\User;

class DomainPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('domains.manage') || $user->can('people.view');
    }

    public function view(User $user, Domain $domain): bool
    {
        return $user->can('domains.manage') || $user->can('people.view');
    }

    public function create(User $user): bool
    {
        return $user->can('domains.manage');
    }

    public function update(User $user, Domain $domain): bool
    {
        return $user->can('domains.manage');
    }

    public function delete(User $user, Domain $domain): bool
    {
        return $user->can('domains.manage');
    }
}

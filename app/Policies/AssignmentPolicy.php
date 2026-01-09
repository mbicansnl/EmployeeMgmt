<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;

class AssignmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('assignments.manage') || $user->can('people.view');
    }

    public function view(User $user, Assignment $assignment): bool
    {
        return $user->can('assignments.manage') || $user->can('people.view');
    }

    public function create(User $user): bool
    {
        return $user->can('assignments.manage');
    }

    public function update(User $user, Assignment $assignment): bool
    {
        return $user->can('assignments.manage');
    }

    public function delete(User $user, Assignment $assignment): bool
    {
        return $user->can('assignments.manage');
    }
}

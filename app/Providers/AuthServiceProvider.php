<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Domain;
use App\Models\Person;
use App\Models\Project;
use App\Policies\AssignmentPolicy;
use App\Policies\DomainPolicy;
use App\Policies\PersonPolicy;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Person::class => PersonPolicy::class,
        Domain::class => DomainPolicy::class,
        Project::class => ProjectPolicy::class,
        Assignment::class => AssignmentPolicy::class,
    ];
}

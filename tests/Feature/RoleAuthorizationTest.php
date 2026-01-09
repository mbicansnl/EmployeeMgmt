<?php

declare(strict_types=1);

namespace Tests\Feature;

use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_roles_have_expected_permissions(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $superAdmin = Role::where('name', 'SuperAdmin')->firstOrFail();
        $this->assertTrue($superAdmin->hasPermissionTo('people.manage'));
        $this->assertTrue($superAdmin->hasPermissionTo('dashboards.view_management'));

        $viewer = Role::where('name', 'Viewer')->firstOrFail();
        $this->assertTrue($viewer->hasPermissionTo('people.view'));
        $this->assertFalse($viewer->hasPermissionTo('people.manage'));
    }
}

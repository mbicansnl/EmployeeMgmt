<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    private const PERMISSIONS = [
        'people.view',
        'people.manage',
        'domains.manage',
        'projects.manage',
        'assignments.manage',
        'dashboards.view_management',
    ];

    public function run(): void
    {
        foreach (self::PERMISSIONS as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $viewer = Role::firstOrCreate(['name' => 'Viewer', 'guard_name' => 'web']);

        $superAdmin->syncPermissions(self::PERMISSIONS);
        $admin->syncPermissions(['people.manage', 'domains.manage', 'projects.manage', 'assignments.manage']);
        $manager->syncPermissions(['people.view', 'dashboards.view_management']);
        $viewer->syncPermissions(['people.view']);
    }
}

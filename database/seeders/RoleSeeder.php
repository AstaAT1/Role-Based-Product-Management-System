<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $admin = Role::findOrCreate('Admin', 'web');
        $editor = Role::findOrCreate('Editor', 'web');
        $viewer = Role::findOrCreate('Viewer', 'web');

        $admin->syncPermissions(Permission::query()->pluck('name')->all());

        $editor->syncPermissions([
            'view products',
            'create products',
            'edit products',
        ]);

        $viewer->syncPermissions([
            'view products',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        // Events permissions
        Permission::create(['name' => 'create events']);
        Permission::create(['name' => 'edit events']);
        Permission::create(['name' => 'delete events']);
        Permission::create(['name' => 'view events']);

        // Agreements permissions
        Permission::create(['name' => 'create agreements']);
        Permission::create(['name' => 'edit agreements']);
        Permission::create(['name' => 'delete agreements']);
        Permission::create(['name' => 'view agreements']);

        // Programs permissions
        Permission::create(['name' => 'create programs']);
        Permission::create(['name' => 'edit programs']);
        Permission::create(['name' => 'delete programs']);
        Permission::create(['name' => 'view programs']);

        // Activities permissions
        Permission::create(['name' => 'create activities']);
        Permission::create(['name' => 'edit activities']);
        Permission::create(['name' => 'delete activities']);
        Permission::create(['name' => 'view activities']);

        // Universities permissions
        Permission::create(['name' => 'create universities']);
        Permission::create(['name' => 'edit universities']);
        Permission::create(['name' => 'delete universities']);
        Permission::create(['name' => 'view universities']);

        // Other system permissions - add more as needed
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage roles']);
        Permission::create(['name' => 'access dashboard']);
        Permission::create(['name' => 'generate reports']);

        // Create roles and assign permissions
        
        // Admin role - can do everything
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Auxiliary role - has limited permissions
        $auxiliaryRole = Role::create(['name' => 'auxiliar']);
        $auxiliaryRole->givePermissionTo([
            'create events',
            'edit events',
            'view events',
            'create agreements',
            'edit agreements',
            'view agreements',
            'create programs',
            'edit programs',
            'view programs',
            'create activities',
            'edit activities',
            'view activities',
            'create universities',
            'edit universities',
            'view universities',
            'access dashboard'
        ]);
    }
}

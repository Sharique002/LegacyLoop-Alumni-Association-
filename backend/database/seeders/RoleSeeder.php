<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $alumni = Role::create(['name' => 'alumni']);

        // Create permissions
        $permissions = [
            // User management
            'manage users',
            'view users',
            
            // Content management
            'approve stories',
            'reject stories',
            'manage jobs',
            'manage events',
            
            // Analytics
            'view analytics',
            'view dashboard',
            
            // Alumni permissions
            'post job',
            'apply job',
            'create event',
            'register event',
            'post story',
            'donate',
            'send message',
            'connect alumni',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign all permissions to admin
        $admin->givePermissionTo(Permission::all());

        // Assign specific permissions to alumni
        $alumni->givePermissionTo([
            'post job',
            'apply job',
            'create event',
            'register event',
            'post story',
            'donate',
            'send message',
            'connect alumni',
        ]);
    }
}

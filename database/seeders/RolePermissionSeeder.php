<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'view articles',
            'create articles',
            'edit articles',
            'delete articles',
            'publish articles',
            'unpublish articles',
            
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            'manage roles',
            'manage users',
            'manage permissions',
        ];
        
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles
        $adminRole = Role::updateOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $editorRole = Role::updateOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $writerRole = Role::updateOrCreate(['name' => 'writer', 'guard_name' => 'web']);
        $userRole = Role::updateOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Assign permissions
        $adminRole->givePermissionTo(Permission::all());
        
        $editorRole->givePermissionTo([
            'view articles',
            'create articles',
            'edit articles',
            'publish articles',
            'unpublish articles'
        ]);
        
        $writerRole->givePermissionTo([
            'view articles',
            'create articles',
            'edit articles' // seulement leurs propres articles
        ]);
        
        $userRole->givePermissionTo([
            'view articles'
        ]);
        
        // Assigner le rôle admin au premier utilisateur
        // $firstUser = \App\Models\User::first();
        // if ($firstUser && !$firstUser->hasRole('admin')) {
        //     $firstUser->assignRole('admin');
        // }

    }
}

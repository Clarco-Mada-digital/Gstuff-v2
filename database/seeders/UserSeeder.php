<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        
        // Créer un admin
        $admin = User::factory()->create([
            'pseudo' => 'Administrateur',
            'profile_type' => 'admin',
            'email' => 'admin@email.com',
            'genre' => 'Homme',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole($adminRole);
        \App\Models\User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) use ($userRole) {
                $user->assignRole($userRole);
            });
    }
}

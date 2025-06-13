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

        // Vérifiez si l'utilisateur admin existe déjà
        $adminEmail = 'admin@email.com';
        $admin = User::where('email', $adminEmail)->first();

        if (!$admin) {
            // Créez un admin uniquement s'il n'existe pas déjà
            $admin = User::factory()->create([
                'pseudo' => 'Administrateur',
                'profile_type' => 'admin',
                'email' => $adminEmail,
                'genre_id' => 1,
                'password' => bcrypt('password'),
            ]);

            $admin->assignRole($adminRole);
        }

        // Créez d'autres utilisateurs
        \App\Models\User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) use ($userRole) {
                $user->assignRole($userRole);
            });
    }
}

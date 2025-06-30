<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class UserServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer tous les utilisateurs
        $users = User::all();
        
        // Pour chaque utilisateur, assigner des services aléatoires
        foreach ($users as $user) {
            // Récupérer tous les services
            $services = Service::all();
            
            // Sélectionner un nombre aléatoire de services (entre 0 et le nombre total de services)
            $randomCount = rand(0, $services->count());
            
            // Sélectionner les services aléatoires
            $randomServices = $services->random($randomCount);
            
            // Pour chaque service sélectionné, créer une entrée dans la table pivot
            foreach ($randomServices as $service) {
                DB::table('user_service')->insert([
                    'user_id' => $user->id,
                    'service_id' => $service->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

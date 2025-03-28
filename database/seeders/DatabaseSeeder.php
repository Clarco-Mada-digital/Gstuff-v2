<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CantonSeeder::class, // Exécute CantonSeeder en premier
            VilleSeeder::class,  // Puis exécute VilleSeeder
            CategorieSeeder::class,  // Puis exécute CategorieSeeder
            ServiceSeeder::class,  // Puis exécute ServiceSeeder
            UserSeeder::class,  // Puis exécute UserSeeder
        ]);
    }

   
}

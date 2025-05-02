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
            RolePermissionSeeder::class,  // Puis exécute RolePermissionSeeder
            UserSeeder::class,  // Puis exécute UserSeeder
            ArticleCategorySeeder::class, //Pour exécute ArticleCategorySeeder
            ArticleSeeder::class, //Pour exécute ArticleSeeder
            CommentaireSeeder::class,
            DistanceMaxSeeder::class,

            GenreSeeder::class,
            PratiqueSexuelleSeeder::class,
            OrientationSexuelleSeeder::class,
            OrigineSeeder::class,
            CouleurYeuxSeeder::class,
            CouleurCheveuxSeeder::class,
            MensurationSeeder::class,
            PoitrineSeeder::class,
            TaillePoitrineSeeder::class,
            SilhouetteSeeder::class,
            PubisSeeder::class,
            TatouageSeeder::class,
            MobiliteSeeder::class,
            PaiementSeeder::class,
            NombreFilleSeeder::class,
            LangueSeeder::class,
            TarifSeeder::class,
        ]);
    }

   
}

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

        $this->call([
            GenreSeeder::class,
            PratiqueSexuelleSeeder::class,
            OrientationSexuelleSeeder::class,
            CouleurYeuxSeeder::class,
            CouleurCheveuxSeeder::class,
            PubisTypeSeeder::class,
            MensurationSeeder::class,
            PoitrineSeeder::class,
            SilhouetteSeeder::class,
            TattooSeeder::class,
            MobiliteSeeder::class,
            NombreFilleSeeder::class,
            CantonVilleSeeder::class,
            // CantonSeeder::class, // Exécute CantonSeeder en premier
            // VilleSeeder::class,  // Puis exécute VilleSeeder
            CategorieSeeder::class,  // Puis exécute CategorieSeeder
            ServiceSeeder::class,  // Puis exécute ServiceSeeder
            RolePermissionSeeder::class,  // Puis exécute RolePermissionSeeder
            UserSeeder::class,  // Puis exécute UserSeeder
            UserServiceSeeder::class, // Puis exécute UserServiceSeeder
            ArticleCategorySeeder::class, //Pour exécute ArticleCategorySeeder
            ArticleSeeder::class, //Pour exécute ArticleSeeder
            CommentaireSeeder::class,
            DistanceMaxSeeder::class,

        ]);
    }

   
}

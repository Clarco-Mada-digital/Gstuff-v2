<?php

namespace Database\Seeders;

use App\Models\Canton;
use App\Models\Ville;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CantonVilleSeeder extends Seeder
{
    use DisableForeignKeys;
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider les tables en commençant par les villes (pour éviter les contraintes de clé étrangère)
        $this->disableForeignKeys();
        
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            // Utiliser delete() au lieu de truncate() pour SQLite
            Ville::query()->delete();
            Canton::query()->delete();
            // Réinitialiser les séquences d'auto-incrémentation pour SQLite
            DB::statement('DELETE FROM sqlite_sequence WHERE name IN ("cantons", "villes")');
        } elseif ($driver === 'pgsql') {
            // Pour PostgreSQL, on utilise TRUNCATE avec CASCADE pour vider les tables
            DB::statement('TRUNCATE TABLE villes CASCADE');
            DB::statement('TRUNCATE TABLE cantons CASCADE');
            
            // Réinitialiser les séquences d'auto-incrémentation pour PostgreSQL
            DB::statement('ALTER SEQUENCE cantons_id_seq RESTART WITH 1');
            DB::statement('ALTER SEQUENCE villes_id_seq RESTART WITH 1');
        } else {
            // Pour MySQL/MariaDB
            Ville::truncate();
            Canton::truncate();
        }
        
        $this->enableForeignKeys();

        // Chemin vers le fichier JSON
        $json = File::get(database_path('seeders/dataJson/cantons_et_villes_geolocalises.json'));
        $cantons = json_decode($json, true);

        $bar = $this->command->getOutput()->createProgressBar(count($cantons));
        $bar->start();

        foreach ($cantons as $cantonData) {
            // Créer le canton
            $canton = Canton::create([
                'nom' => $cantonData['nom_canton'],
            ]);

            // Préparer les données des villes pour l'insertion en masse
            $villes = [];
            foreach ($cantonData['villeListe'] as $villeData) {
                $villes[] = [
                    'nom' => trim($villeData['nom_ville']),
                    'canton_id' => $canton->id,
                ];
            }

            // Insérer les villes par lots de 100 pour optimiser les performances
            $chunks = array_chunk($villes, 100);
            foreach ($chunks as $chunk) {
                Ville::insert($chunk);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('Les cantons et villes ont été importés avec succès !');
    }
}

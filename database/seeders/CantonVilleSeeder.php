<?php

namespace Database\Seeders;

use App\Models\Canton;
use App\Models\Ville;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CantonVilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider les tables en commençant par les villes (pour éviter les contraintes de clé étrangère)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Ville::truncate();
        Canton::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

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

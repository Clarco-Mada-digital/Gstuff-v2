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
        // Désactiver temporairement les contraintes de clé étrangère
        $this->disableForeignKeys();
        
        // Pour PostgreSQL, on utilise TRUNCATE avec CASCADE pour vider les tables
        DB::statement('TRUNCATE TABLE villes CASCADE');
        DB::statement('TRUNCATE TABLE cantons CASCADE');
        
        // Réinitialiser les séquences d'auto-incrémentation pour PostgreSQL
        DB::statement('ALTER SEQUENCE cantons_id_seq RESTART WITH 1');
        DB::statement('ALTER SEQUENCE villes_id_seq RESTART WITH 1');
        
        // Réactiver les contraintes de clé étrangère
        $this->enableForeignKeys();

        // Charger le fichier JSON
        $json = File::get(database_path('seeders/dataJson/cantons_et_villes_geolocalises.json'));
        $cantons = json_decode($json, true);

        $bar = $this->command->getOutput()->createProgressBar(count($cantons));
        $bar->start();

        // Désactiver temporairement les index pour améliorer les performances
        DB::statement('ALTER TABLE cantons DISABLE TRIGGER ALL');
        DB::statement('ALTER TABLE villes DISABLE TRIGGER ALL');
        
        // Utilisation d'une transaction pour améliorer les performances
        DB::beginTransaction();
        
        try {
            $allVilles = [];
            $now = now();
            
            // Insérer d'abord tous les cantons
            $cantonsData = [];
            foreach ($cantons as $cantonData) {
                $cantonsData[] = [
                    'nom' => $cantonData['nom_canton'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            
            // Insertion en masse des cantons
            DB::table('cantons')->insert($cantonsData);
            
            // Récupérer tous les cantons avec leurs IDs
            $allCantons = Canton::all()->keyBy('nom');
            
            // Préparer les données des villes
            foreach ($cantons as $cantonData) {
                $canton = $allCantons[$cantonData['nom_canton']];
                
                foreach ($cantonData['villeListe'] as $villeData) {
                    $allVilles[] = [
                        'nom' => trim($villeData['nom_ville']),
                        'canton_id' => $canton->id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                $bar->advance();
            }
            
            // Insertion en masse des villes par lots de 1000
            $chunks = array_chunk($allVilles, 1000);
            foreach ($chunks as $chunk) {
                DB::table('villes')->insert($chunk);
            }
            
            DB::commit();
            
            // Réactiver les index
            DB::statement('ALTER TABLE cantons ENABLE TRIGGER ALL');
            DB::statement('ALTER TABLE villes ENABLE TRIGGER ALL');
            
            // Mettre à jour les statistiques de la base de données
            DB::statement('VACUUM ANALYZE cantons');
            DB::statement('VACUUM ANALYZE villes');
            
            $bar->finish();
            $this->command->newLine();
            $this->command->info('Les cantons et villes ont été importés avec succès !');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // S'assurer que les triggers sont réactivés en cas d'erreur
            DB::statement('ALTER TABLE cantons ENABLE TRIGGER ALL');
            DB::statement('ALTER TABLE villes ENABLE TRIGGER ALL');
            
            $this->command->error('Erreur lors de l\'importation : ' . $e->getMessage());
            throw $e;
        }
    }
}

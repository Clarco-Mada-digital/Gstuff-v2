<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Importez la classe DB

class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Exemple simple sans relation canton_id (si vous n'avez pas de relation)
        /*
        DB::table('villes')->insert([ // Assurez-vous que 'villes' est le nom de votre table
            [ 'nom' => 'Zurich' ],
            [ 'nom' => 'Genève' ],
            [ 'nom' => 'Lausanne' ],
            // Ajoutez d'autres villes ici
        ]);
        */

        // Exemple avec relation canton_id (si vous avez une relation avec la table 'cantons')
        $cantons = DB::table('cantons')->pluck('id', 'nom')->toArray(); // Récupérer les IDs des cantons

        DB::table('villes')->insert([
            // Canton de Zürich
            ['nom' => 'Bassersdorf', 'canton_id' => $cantons['Zürich'] ?? null],
            ['nom' => 'Dietikon', 'canton_id' => $cantons['Zürich'] ?? null],
            ['nom' => 'Dübendorf', 'canton_id' => $cantons['Zürich'] ?? null],
            ['nom' => 'Pläffikon', 'canton_id' => $cantons['Zürich'] ?? null],
            ['nom' => 'Schwerzenbach', 'canton_id' => $cantons['Zürich'] ?? null],
            ['nom' => 'Zürich', 'canton_id' => $cantons['Zürich'] ?? null],
            ['nom' => 'Winterthur', 'canton_id' => $cantons['Zürich'] ?? null],
            ['nom' => 'Wald', 'canton_id' => $cantons['Zürich'] ?? null],

            // Canton de Bern
            ['nom' => 'Berne', 'canton_id' => $cantons['Bern'] ?? null],
            ['nom' => 'Bienne', 'canton_id' => $cantons['Bern'] ?? null],
            ['nom' => 'Gstaad', 'canton_id' => $cantons['Bern'] ?? null],
            ['nom' => 'Granges', 'canton_id' => $cantons['Bern'] ?? null],
            ['nom' => 'Interlaken', 'canton_id' => $cantons['Bern'] ?? null],
            ['nom' => 'Thoune', 'canton_id' => $cantons['Bern'] ?? null],
            ['nom' => 'Zollikofen', 'canton_id' => $cantons['Bern'] ?? null],
            [ 'nom' => 'Romont', 'canton_id' => $cantons['Fribourg'] ?? null ], // Utilisez l'ID du canton de Fribourg

            [ 'nom' => 'Bassecour', 'canton_id' => $cantons['Jura'] ?? null ], // Utilisez l'ID du canton de Jura
            [ 'nom' => 'Boncourt', 'canton_id' => $cantons['Jura'] ?? null ], // Utilisez l'ID du canton de Jura
            [ 'nom' => 'Courrendin', 'canton_id' => $cantons['Jura'] ?? null ], // Utilisez l'ID du canton de Jura
            [ 'nom' => 'Delémont', 'canton_id' => $cantons['Jura'] ?? null ], // Utilisez l'ID du canton de Jura
            [ 'nom' => 'Moutier', 'canton_id' => $cantons['Jura'] ?? null ], // Utilisez l'ID du canton de Jura
            [ 'nom' => 'Porrentruy', 'canton_id' => $cantons['Jura'] ?? null ], // Utilisez l'ID du canton de Jura

            [ 'nom' => 'La Chaux-de-Fonds', 'canton_id' => $cantons['Neuchâtel'] ?? null ], // Utilisez l'ID du canton de Neuchâtel
            [ 'nom' => 'Le Locle', 'canton_id' => $cantons['Neuchâtel'] ?? null ], // Utilisez l'ID du canton de Neuchâtel
            [ 'nom' => 'Neuchâtel', 'canton_id' => $cantons['Neuchâtel'] ?? null ], // Utilisez l'ID du canton de Neuchâtel

            [ 'nom' => 'Genève', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Carouge', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Chambésy', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Champel', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Cité-Centre', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Cornavin', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Eaux-vives', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Plainpalais', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Plan-les-Ouates', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Servette', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Thônex', 'canton_id' => $cantons['Genève'] ?? null ],
            [ 'nom' => 'Versoix', 'canton_id' => $cantons['Genève'] ?? null ],

            [ 'nom' => 'Aproz', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Ardon', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Brig', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Collombey', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Conthey', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Crans-Montana', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Grône', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Martigny', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Massongex', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Monthey', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Riddes', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Saillon', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Saint-Léonard', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Saint-Maurice', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Saxon', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Sierre', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Sion', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Turtmann', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Verbier', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Vétroz', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais
            [ 'nom' => 'Visp', 'canton_id' => $cantons['Valais'] ?? null ], // Utilisez l'ID du canton de Valais

            [ 'nom' => 'Aigle', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Aubonne', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Bex', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Bussigny', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Chavannes-Renens', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Clarens', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Coppet', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Corcelles-près-Payenne', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Crissier', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Gland', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Lausanne', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Montreux', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Morges', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Moudon', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Nyon', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Oron', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Payenne', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Prilly', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Renes', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Roche', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Vevey', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Villeneuve', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Yverdon-les-Bains', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud

            // Ajoutez d'autres villes ici et associez-les à leur canton_id approprié
        ]);
    }
}

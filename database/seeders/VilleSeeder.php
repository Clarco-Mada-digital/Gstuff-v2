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

        DB::table('villes')->insert([ // Assurez-vous que 'villes' est le nom de votre table
            [ 'nom' => 'Zurich', 'canton_id' => $cantons['Zurich'] ?? null ], // Utilisez l'ID du canton de Zurich
            [ 'nom' => 'Winterthour', 'canton_id' => $cantons['Zurich'] ?? null ], // Utilisez l'ID du canton de Zurich
            [ 'nom' => 'Genève', 'canton_id' => $cantons['Genève'] ?? null ], // Utilisez l'ID du canton de Genève
            [ 'nom' => 'Vernier', 'canton_id' => $cantons['Genève'] ?? null ], // Utilisez l'ID du canton de Genève
            [ 'nom' => 'Lausanne', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            [ 'nom' => 'Yverdon-les-Bains', 'canton_id' => $cantons['Vaud'] ?? null ], // Utilisez l'ID du canton de Vaud
            // Ajoutez d'autres villes ici et associez-les à leur canton_id approprié
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Importez la classe DB

class CantonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cantons')->insert([ 
            ['nom' => 'Suisse Alémanique'],
            [ 'nom' => 'Zurich' ],
            [ 'nom' => 'Berne' ],
            [ 'nom' => 'Friboug' ],
            [ 'nom' => 'Jura' ],
            [ 'nom' => 'Neuchâtel' ],
            [ 'nom' => 'Genève' ],
            [ 'nom' => 'Valais' ],
            [ 'nom' => 'Vaud' ],
            // Ajoutez d'autres cantons ici
        ]);
    }
}

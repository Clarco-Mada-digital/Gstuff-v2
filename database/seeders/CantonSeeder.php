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
        DB::table('cantons')->insert([ // Assurez-vous que 'cantons' est le nom de votre table
            [ 'nom' => 'Zurich' ],
            [ 'nom' => 'Berne' ],
            [ 'nom' => 'Lucerne' ],
            [ 'nom' => 'Uri' ],
            [ 'nom' => 'Schwytz' ],
            [ 'nom' => 'Obwald' ],
            [ 'nom' => 'Nidwald' ],
            [ 'nom' => 'Glaris' ],
            [ 'nom' => 'Zoug' ],
            [ 'nom' => 'Fribourg' ],
            [ 'nom' => 'Soleure' ],
            [ 'nom' => 'Bâle-Ville' ],
            [ 'nom' => 'Bâle-Campagne' ],
            [ 'nom' => 'Schaffhouse' ],
            [ 'nom' => 'Appenzell Rhodes-Extérieures' ],
            [ 'nom' => 'Appenzell Rhodes-Intérieures' ],
            [ 'nom' => 'Saint-Gall' ],
            [ 'nom' => 'Grisons' ],
            [ 'nom' => 'Argovie' ],
            [ 'nom' => 'Thurgovie' ],
            [ 'nom' => 'Tessin' ],
            [ 'nom' => 'Vaud' ],
            [ 'nom' => 'Valais' ],
            [ 'nom' => 'Neuchâtel' ],
            [ 'nom' => 'Genève' ],
            [ 'nom' => 'Jura' ],
            // Ajoutez d'autres cantons ici
        ]);
    }
}

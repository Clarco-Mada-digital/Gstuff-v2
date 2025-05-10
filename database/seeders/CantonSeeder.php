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
            ['nom' => 'Zürich'],
            ['nom' => 'Bern'],
            ['nom' => 'Fribourg'],
            ['nom' => 'Jura'],
            ['nom' => 'Neuchâtel'],
            ['nom' => 'Genève'],
            ['nom' => 'Valais'],
            ['nom' => 'Vaud'],
            ['nom' => 'Aargau'],
            ['nom' => 'Appenzell Rhodes-Intérieures'],
            ['nom' => 'Appenzell Rhodes-Extérieures'],
            ['nom' => 'Bâle-Campagne'],
            ['nom' => 'Bâle-Ville'],
            ['nom' => 'Glaris'],
            ['nom' => 'Grisons'],
            ['nom' => 'Lucerne'],
            ['nom' => 'Neuchâtel'],
            ['nom' => 'Saint-Gall'],
            ['nom' => 'Schaffhouse'],
            ['nom' => 'Schwytz'],
            ['nom' => 'Soleure'],
            ['nom' => 'Thurgovie'],
            ['nom' => 'Tessin'],
            ['nom' => 'Uri'],
            ['nom' => 'Valais'],
            ['nom' => 'Zoug']
        ]);
    }
}

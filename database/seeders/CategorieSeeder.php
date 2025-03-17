<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['nom' => 'Escort', 'display_name' => 'escort'],
            ['nom' => 'Masseuse (no sexe)', 'display_name' => 'masseuse-no-sex'],
            ['nom' => 'Dominatrice BDSM', 'display_name' => 'dominatrice-bdsm'],
            ['nom' => 'Trans', 'display_name' => 'trans'],
            // Ajoutez d'autres cantons ici
        ]);
    }
}

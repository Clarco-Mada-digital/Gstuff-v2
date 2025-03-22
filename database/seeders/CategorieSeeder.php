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
            // Partie pour escort
            ['nom' => 'Escort', 'display_name' => 'escort', 'type' => 'escort'],
            ['nom' => 'Masseuse (no sexe)', 'display_name' => 'masseuse-no-sex', 'type' => 'escort'],
            ['nom' => 'Dominatrice BDSM', 'display_name' => 'dominatrice-bdsm', 'type' => 'escort'],
            ['nom' => 'Trans', 'display_name' => 'trans', 'type' => 'escort'],
            // Partie pour salon
            ['nom' => "Agence d'escort", 'display_name' => 'agence-escort', 'type' => 'salon'],
            ['nom' => 'Salon erotique', 'display_name' => 'salon-erotique', 'type' => 'salon'],
            ['nom' => 'Institut de massage', 'display_name' => 'institut-de-massage', 'type' => 'salon'],
            ['nom' => 'Sauna', 'display_name' => 'sauna', 'type' => 'salon'],
            // Ajoutez d'autres cantons ici
        ]);
    }
}

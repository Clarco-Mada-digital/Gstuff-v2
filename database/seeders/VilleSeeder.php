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
        $cantons = DB::table('cantons')->pluck('id', 'nom')->toArray(); // Récupérer les IDs des cantons
        $cities = ['Aubonne', 'Genève', 'Berne', 'Aurau', 'Bassecour', 'Thoune', 'Lausanne', 'Bulle'];
        $cantonNames = ['Vaud', 'Genève', 'Berne', 'Suise Alémanique', 'Jura', 'Fribourg'];

        $data = [];
        foreach ($cantonNames as $cantonName) {
            foreach ($cities as $city) {
                $data[] = [
                    'nom' => $city,
                    'canton_id' => $cantons[$cantonName] ?? null
                ];
            }
        }

        DB::table('villes')->insert($data);
    }
}

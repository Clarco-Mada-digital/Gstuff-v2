<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Origine;

class OrigineSeeder extends Seeder
{
    public function run()
    {
        $origines = ['Africaine', 'Allemande', 'Asiatique', 'Brésilienne', 'Caucasienne', 'Espagnole', 'Européene', 'Française', 'Indienne', 'Italienne', 'Latine', 'Métisse', 'Orientale', 'Russe', 'Suisesse'];

        foreach ($origines as $origine) {
            Origine::create(['name' => $origine]);
        }
    }
}

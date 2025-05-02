<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Poitrine;

class PoitrineSeeder extends Seeder
{
    public function run()
    {
        $poitrines = ['Naturelle', 'Améliorée'];

        foreach ($poitrines as $poitrine) {
            Poitrine::create(['name' => $poitrine]);
        }
    }
}

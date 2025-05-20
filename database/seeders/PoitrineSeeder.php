<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Poitrine;

class PoitrineSeeder extends Seeder
{
    public function run()
    {
        $poitrines = [
            [
                'fr' => 'Naturelle',
                'en' => 'Natural',
                'de' => 'Natürlich',
                'it' => 'Naturale',
                'es' => 'Natural'
            ],
            [
                'fr' => 'Améliorée',
                'en' => 'Enhanced',
                'de' => 'Verbessert',
                'it' => 'Migliorata',
                'es' => 'Mejorada'
            ]
        ];

        foreach ($poitrines as $poitrine) {
            Poitrine::create([
                'name' => $poitrine
            ]);
        }
    }
}

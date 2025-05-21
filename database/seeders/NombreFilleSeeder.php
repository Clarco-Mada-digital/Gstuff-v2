<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NombreFille;

class NombreFilleSeeder extends Seeder
{
    public function run()
    {
        $nombreFilles = [
            [
                'fr' => '1 à 5',
                'en-US' => '1 to 5',
                'de' => '1 bis 5',
                'it' => '1 a 5',
                'es' => '1 a 5'
            ],
            [
                'fr' => '5 à 15',
                'en-US' => '5 to 15',
                'de' => '5 bis 15',
                'it' => '5 a 15',
                'es' => '5 a 15'
            ],
            [
                'fr' => 'plus de 15',
                'en-US' => 'more than 15',
                'de' => 'mehr als 15',
                'it' => 'più di 15',
                'es' => 'más de 15'
            ]
        ];

        foreach ($nombreFilles as $nombreFilleData) {
            NombreFille::create([
                'name' => $nombreFilleData
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mensuration;

class MensurationSeeder extends Seeder
{
    public function run()
    {
        $mensurations = [
            [
                'fr' => 'Mince',
                'en' => 'Slim',
                'de' => 'Schlank',
                'it' => 'Magro',
                'es' => 'Delgado'
            ],
            [
                'fr' => 'Normale',
                'en' => 'Average',
                'de' => 'Durchschnittlich',
                'it' => 'Normale',
                'es' => 'Promedio'
            ],
            [
                'fr' => 'Pulpeuse',
                'en' => 'Curvy',
                'de' => 'Kurvig',
                'it' => 'Formosa',
                'es' => 'Curvilínea'
            ],
            [
                'fr' => 'Ronde',
                'en' => 'Plump',
                'de' => 'Rundlich',
                'it' => 'Morbida',
                'es' => 'Rellenita'
            ],
            [
                'fr' => 'Sportive',
                'en' => 'Athletic',
                'de' => 'Sportlich',
                'it' => 'Atletica',
                'es' => 'Atlética'
            ],
        ];

        foreach ($mensurations as $mensuration) {
            Mensuration::create([
                'name' => $mensuration
            ]);
        }
    }
}

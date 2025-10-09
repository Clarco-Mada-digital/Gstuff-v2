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
                'en-US' => 'Slim',
                'de' => 'Schlank',
                'it' => 'Magro',
                'es' => 'Delgado'
            ],
            [
                'fr' => 'Normale',
                'en-US' => 'Average',
                'de' => 'Durchschnittlich',
                'it' => 'Normale',
                'es' => 'Promedio'
            ],
            [
                'fr' => 'Pulpeuse',
                'en-US' => 'Curvy',
                'de' => 'Kurvig',
                'it' => 'Formosa',
                'es' => 'Curvilínea'
            ],
            [
                'fr' => 'Ronde',
                'en-US' => 'Plump',
                'de' => 'Rundlich',
                'it' => 'Morbida',
                'es' => 'Rellenita'
            ],
            [
                'fr' => 'Sportive',
                'en-US' => 'Athletic',
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

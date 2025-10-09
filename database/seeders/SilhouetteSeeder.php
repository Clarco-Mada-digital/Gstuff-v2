<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Silhouette;

class SilhouetteSeeder extends Seeder
{
    public function run()
    {
        $silhouettes = [
            [
                'fr' => 'Fine',
                'en-US' => 'Slim',
                'de' => 'Schlank',
                'it' => 'Magra',
                'es' => 'Delgada'
            ],
            [
                'fr' => 'Mince',
                'en-US' => 'Thin',
                'de' => 'Dünn',
                'it' => 'Sottile',
                'es' => 'Flaca'
            ],
            [
                'fr' => 'Normale',
                'en-US' => 'Average',
                'de' => 'Durchschnittlich',
                'it' => 'Normale',
                'es' => 'Promedio'
            ],
            [
                'fr' => 'Sportive',
                'en-US' => 'Athletic',
                'de' => 'Athletisch',
                'it' => 'Atletica',
                'es' => 'Atlética'
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
                'es' => 'Rechoncha'
            ]
        ];

        foreach ($silhouettes as $silhouette) {
            Silhouette::create([
                'name' => $silhouette
            ]);
        }
    }
}

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
                'en' => 'Slim',
                'de' => 'Schlank',
                'it' => 'Magra',
                'es' => 'Delgada'
            ],
            [
                'fr' => 'Mince',
                'en' => 'Thin',
                'de' => 'Dünn',
                'it' => 'Sottile',
                'es' => 'Flaca'
            ],
            [
                'fr' => 'Normale',
                'en' => 'Average',
                'de' => 'Durchschnittlich',
                'it' => 'Normale',
                'es' => 'Promedio'
            ],
            [
                'fr' => 'Sportive',
                'en' => 'Athletic',
                'de' => 'Athletisch',
                'it' => 'Atletica',
                'es' => 'Atlética'
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

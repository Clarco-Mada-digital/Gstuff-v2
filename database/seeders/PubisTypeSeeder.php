<?php

namespace Database\Seeders;

use App\Models\PubisType;
use Illuminate\Database\Seeder;

class PubisTypeSeeder extends Seeder
{
    public function run()
    {
        $pubisTypes = [
            [
                'fr' => 'Entièrement rasé',
                'en-US' => 'Fully shaved',
                'de' => 'Vollständig rasiert',
                'it' => 'Completamente rasato',
                'es' => 'Totalmente afeitado'
            ],
            [
                'fr' => 'Partiellement rasé',
                'en-US' => 'Partially shaved',
                'de' => 'Teilweise rasiert',
                'it' => 'Parzialmente rasato',
                'es' => 'Parcialmente afeitado'
            ],
            [
                'fr' => 'Tout naturel',
                'en-US' => 'Natural',
                'de' => 'Natürlich',
                'it' => 'Naturale',
                'es' => 'Natural'
            ]
        ];

        foreach ($pubisTypes as $pubisTypeData) {
            PubisType::create([
                'name' => $pubisTypeData
            ]);
        }
    }
}

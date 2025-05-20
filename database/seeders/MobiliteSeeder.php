<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mobilite;

class MobiliteSeeder extends Seeder
{
    public function run()
    {
        $mobilites = [
            [
                'fr' => 'Je reçois',
                'en' => 'I receive',
                'de' => 'Ich empfange',
                'it' => 'Ricevo',
                'es' => 'Recibo'
            ],
            [
                'fr' => 'Je me déplace',
                'en' => 'I travel',
                'de' => 'Ich reise',
                'it' => 'Mi sposto',
                'es' => 'Me muevo'
            ]
        ];

        foreach ($mobilites as $mobiliteData) {
            Mobilite::create([
                'name' => $mobiliteData
            ]);
        }
    }
}

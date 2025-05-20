<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tattoo;

class TattooSeeder extends Seeder
{
    public function run()
    {
        $tattoos = [
            [
                'fr' => 'Avec tatouages',
                'en' => 'With tattoos',
                'de' => 'Mit Tattoos',
                'it' => 'Con tatuaggi',
                'es' => 'Con tatuajes'
            ],
            [
                'fr' => 'Sans tatouages',
                'en' => 'Without tattoos',
                'de' => 'Ohne Tattoos',
                'it' => 'Senza tatuaggi',
                'es' => 'Sin tatuajes'
            ]
        ];

        foreach ($tattoos as $tattooData) {

            Tattoo::create([
                'name' => $tattooData
            ]);
        }
    }
}

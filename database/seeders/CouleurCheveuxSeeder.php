<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CouleurCheveux;

class CouleurCheveuxSeeder extends Seeder
{
    public function run()
    {
        $couleursCheveux = [
            [
                'fr' => 'Blonds',
                'en' => 'Blonde',
                'de' => 'Blond',
                'it' => 'Biondi',
                'es' => 'Rubio'
            ],
            [
                'fr' => 'Brune',
                'en' => 'Brunette',
                'de' => 'Brünett',
                'it' => 'Castana',
                'es' => 'Morena'
            ],
            [
                'fr' => 'Châtain',
                'en' => 'Chestnut',
                'de' => 'Kastanienbraun',
                'it' => 'Castano',
                'es' => 'Castaño'
            ],
            [
                'fr' => 'Gris',
                'en' => 'Gray',
                'de' => 'Grau',
                'it' => 'Grigio',
                'es' => 'Gris'
            ],
            [
                'fr' => 'Noiraude',
                'en' => 'Dark-haired',
                'de' => 'Dunkelhaarig',
                'it' => 'Capelli scuri',
                'es' => 'Pelo oscuro'
            ],
            [
                'fr' => 'Rousse',
                'en' => 'Redhead',
                'de' => 'Rothaarig',
                'it' => 'Rossi',
                'es' => 'Pelirrojo'
            ],
            [
                'fr' => 'Autre',
                'en' => 'Other',
                'de' => 'Andere',
                'it' => 'Altro',
                'es' => 'Otro'
            ],
        ];

        foreach ($couleursCheveux as $couleur) {
            CouleurCheveux::create([
                'name' => $couleur
            ]);
        }
    }
}

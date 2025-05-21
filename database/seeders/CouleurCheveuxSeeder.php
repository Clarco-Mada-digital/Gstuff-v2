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
                'en-US' => 'Blonde',
                'de' => 'Blond',
                'it' => 'Biondi',
                'es' => 'Rubio'
            ],
            [
                'fr' => 'Brune',
                'en-US' => 'Brunette',
                'de' => 'Brünett',
                'it' => 'Castana',
                'es' => 'Morena'
            ],
            [
                'fr' => 'Châtain',
                'en-US' => 'Chestnut',
                'de' => 'Kastanienbraun',
                'it' => 'Castano',
                'es' => 'Castaño'
            ],
            [
                'fr' => 'Gris',
                'en-US' => 'Gray',
                'de' => 'Grau',
                'it' => 'Grigio',
                'es' => 'Gris'
            ],
            [
                'fr' => 'Noiraude',
                'en-US' => 'Dark-haired',
                'de' => 'Dunkelhaarig',
                'it' => 'Capelli scuri',
                'es' => 'Pelo oscuro'
            ],
            [
                'fr' => 'Rousse',
                'en-US' => 'Redhead',
                'de' => 'Rothaarig',
                'it' => 'Rossi',
                'es' => 'Pelirrojo'
            ],
            [
                'fr' => 'Autre',
                'en-US' => 'Other',
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

<?php

namespace Database\Seeders;

use App\Models\CouleurYeux;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CouleurYeuxSeeder extends Seeder
{
    public function run(): void
    {
        $couleurs = [
            [
                'name' => [
                    'fr' => 'Bleus',
                    'en' => 'Blue',
                    'es' => 'Azules',
                    'it' => 'Blu',
                    'de' => 'Blau',
                ],
                'slug' => 'bleus',
            ],
            [
                'name' => [
                    'fr' => 'Bruns',
                    'en' => 'Brown',
                    'es' => 'Marrones',
                    'it' => 'Marrone',
                    'de' => 'Braun',
                ],
                'slug' => 'bruns',
            ],
            [
                'name' => [
                    'fr' => 'Bruns clairs',
                    'en' => 'Light brown',
                    'es' => 'Marrones claros',
                    'it' => 'Marrone chiaro',
                    'de' => 'Hellbraun',
                ],
                'slug' => 'bruns-clairs',
            ],
            [
                'name' => [
                    'fr' => 'Gris',
                    'en' => 'Gray',
                    'es' => 'Grises',
                    'it' => 'Grigi',
                    'de' => 'Grau',
                ],
                'slug' => 'gris',
            ],
            [
                'name' => [
                    'fr' => 'Jaunes',
                    'en' => 'Hazel',
                    'es' => 'Ámbar',
                    'it' => 'Ambra',
                    'de' => 'Bernstein',
                ],
                'slug' => 'jaunes',
            ],
            [
                'name' => [
                    'fr' => 'Marrons',
                    'en' => 'Dark brown',
                    'es' => 'Castaño oscuro',
                    'it' => 'Marrone scuro',
                    'de' => 'Dunkelbraun',
                ],
                'slug' => 'marrons',
            ],
            [
                'name' => [
                    'fr' => 'Noirs',
                    'en' => 'Black',
                    'es' => 'Negros',
                    'it' => 'Neri',
                    'de' => 'Schwarz',
                ],
                'slug' => 'noirs',
            ],
            [
                'name' => [
                    'fr' => 'Verts',
                    'en' => 'Green',
                    'es' => 'Verdes',
                    'it' => 'Verdi',
                    'de' => 'Grün',
                ],
                'slug' => 'verts',
            ],
            [
                'name' => [
                    'fr' => 'Autre',
                    'en' => 'Other',
                    'es' => 'Otro',
                    'it' => 'Altro',
                    'de' => 'Andere',
                ],
                'slug' => 'autre',
            ],
        ];

        foreach ($couleurs as $couleur) {
            CouleurYeux::firstOrCreate(
                ['slug' => $couleur['slug']],
                $couleur
            );
        }
    }
}

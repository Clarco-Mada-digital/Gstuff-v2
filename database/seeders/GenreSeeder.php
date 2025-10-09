<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            [
                'name' => [
                    'fr' => 'Femme',
                    'en-US' => 'Woman',
                    'es' => 'Mujer',
                    'it' => 'Donna',
                    'de' => 'Frau',
                ],
                'slug' => 'femme',
            ],
            [
                'name' => [
                    'fr' => 'Homme',
                    'en-US' => 'Man',
                    'es' => 'Hombre',
                    'it' => 'Uomo',
                    'de' => 'Mann',
                ],
                'slug' => 'homme',
            ],
            [
                'name' => [
                    'fr' => 'Trans',
                    'en-US' => 'Trans',
                    'es' => 'Trans',
                    'it' => 'Trans',
                    'de' => 'Trans',
                ],
                'slug' => 'trans',
            ],
            // [
            //     'name' => [
            //         'fr' => 'Gay',
            //         'en-US' => 'Gay',
            //         'es' => 'Gay',
            //         'it' => 'Gay',
            //         'de' => 'Schwul',
            //     ],
            //     'slug' => 'gay',
            // ],
            // [
            //     'name' => [
            //         'fr' => 'Lesbienne',
            //         'en-US' => 'Lesbian',
            //         'es' => 'Lesbiana',
            //         'it' => 'Lesbica',
            //         'de' => 'Lesbisch',
            //     ],
            //     'slug' => 'lesbienne',
            // ],
            // [
            //     'name' => [
            //         'fr' => 'Bisexuelle',
            //         'en-US' => 'Bisexual',
            //         'es' => 'Bisexual',
            //         'it' => 'Bisessuale',
            //         'de' => 'Bisexuell',
            //     ],
            //     'slug' => 'bisexuelle',
            // ],
            // [
            //     'name' => [
            //         'fr' => 'Queer',
            //         'en-US' => 'Queer',
            //         'es' => 'Queer',
            //         'it' => 'Queer',
            //         'de' => 'Queer',
            //     ],
            //     'slug' => 'queer',
            // ],
        ];

        foreach ($genres as $genreData) {
            Genre::firstOrCreate(
                ['slug' => $genreData['slug']],
                $genreData
            );
        }
    }
}

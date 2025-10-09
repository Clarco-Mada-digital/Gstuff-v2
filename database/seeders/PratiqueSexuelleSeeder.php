<?php

namespace Database\Seeders;

use App\Models\PratiqueSexuelle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PratiqueSexuelleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pratiques = [
            [
                'name' => [
                    'fr' => '69',
                    'en-US' => '69',
                    'es' => '69',
                    'it' => '69',
                    'de' => '69',
                ],
                'slug' => '69',
            ],
            [
                'name' => [
                    'fr' => 'Cunnilingus',
                    'en-US' => 'Cunnilingus',
                    'es' => 'Cunnilingus',
                    'it' => 'Cunnilingus',
                    'de' => 'Cunnilingus',
                ],
                'slug' => 'cunnilingus',
            ],
            [
                'name' => [
                    'fr' => 'Ejaculation sur le corps',
                    'en-US' => 'Body ejaculation',
                    'es' => 'Eyaculación en el cuerpo',
                    'it' => 'Eiaculazione sul corpo',
                    'de' => 'Körperliche Ejakulation',
                ],
                'slug' => 'ejaculation-corps',
            ],
            [
                'name' => [
                    'fr' => 'Ejaculation faciale',
                    'en-US' => 'Facial ejaculation',
                    'es' => 'Eyaculación facial',
                    'it' => 'Eiaculazione facciale',
                    'de' => 'Gesichtsejakulation',
                ],
                'slug' => 'ejaculation-faciale',
            ],
            [
                'name' => [
                    'fr' => 'Face-sitting',
                    'en-US' => 'Face-sitting',
                    'es' => 'Face-sitting',
                    'it' => 'Face-sitting',
                    'de' => 'Facesitting',
                ],
                'slug' => 'face-sitting',
            ],
            [
                'name' => [
                    'fr' => 'Fellation',
                    'en-US' => 'Blowjob',
                    'es' => 'Mamada',
                    'it' => 'Pompino',
                    'de' => 'Blowjob',
                ],
                'slug' => 'fellation',
            ],
            [
                'name' => [
                    'fr' => 'Fétichisme',
                    'en-US' => 'Fetishism',
                    'es' => 'Fetichismo',
                    'it' => 'Feticismo',
                    'de' => 'Fetischismus',
                ],
                'slug' => 'fetichisme',
            ],
            [
                'name' => [
                    'fr' => 'GFE (Girlfriend Experience)',
                    'en-US' => 'GFE (Girlfriend Experience)',
                    'es' => 'GFE (Experiencia de novia)',
                    'it' => 'GFE (Esperienza da fidanzata)',
                    'de' => 'GFE (Freundin-Erlebnis)',
                ],
                'slug' => 'gfe',
            ],
            [
                'name' => [
                    'fr' => 'Gorge profonde',
                    'en-US' => 'Deep throat',
                    'es' => 'Garganta profunda',
                    'it' => 'Gola profonda',
                    'de' => 'Tiefer Rachen',
                ],
                'slug' => 'gorge-profonde',
            ],
            [
                'name' => [
                    'fr' => 'Lingerie',
                    'en-US' => 'Lingerie',
                    'es' => 'Lencería',
                    'it' => 'Lingerie',
                    'de' => 'Unterwäsche',
                ],
                'slug' => 'lingerie',
            ],
            [
                'name' => [
                    'fr' => 'Massage érotique',
                    'en-US' => 'Erotic massage',
                    'es' => 'Masaje erótico',
                    'it' => 'Massaggio erotico',
                    'de' => 'Erotische Massage',
                ],
                'slug' => 'massage-erotique',
            ],
            [
                'name' => [
                    'fr' => 'Rapport sexuel',
                    'en-US' => 'Sexual intercourse',
                    'es' => 'Relación sexual',
                    'it' => 'Rapporto sessuale',
                    'de' => 'Geschlechtsverkehr',
                ],
                'slug' => 'rapport-sexuel',
            ],
            [
                'name' => [
                    'fr' => 'Hand job',
                    'en-US' => 'Hand job',
                    'es' => 'Masturbación con la mano',
                    'it' => 'Masturbazione con la mano',
                    'de' => 'Handjob',
                ],
                'slug' => 'hand-job',
            ],
        ];

        foreach ($pratiques as $pratique) {
            PratiqueSexuelle::firstOrCreate(
                ['slug' => $pratique['slug']],
                $pratique
            );
        }
    }
}

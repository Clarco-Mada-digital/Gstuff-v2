<?php

namespace Database\Seeders;

use App\Models\OrientationSexuelle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrientationSexuelleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orientations = [
            [
                'name' => [
                    'fr' => 'Bisexuelle',
                    'en-US' => 'Bisexual',
                    'es' => 'Bisexual',
                    'it' => 'Bisessuale',
                    'de' => 'Bisexuell',
                ],
                'slug' => 'bisexuelle',
            ],
            [
                'name' => [
                    'fr' => 'Hétéro',
                    'en-US' => 'Straight',
                    'es' => 'Heterosexual',
                    'it' => 'Eterosessuale',
                    'de' => 'Heterosexuell',
                ],
                'slug' => 'hetero',
            ],
            [
                'name' => [
                    'fr' => 'Lesbienne',
                    'en-US' => 'Lesbian',
                    'es' => 'Lesbiana',
                    'it' => 'Lesbica',
                    'de' => 'Lesbisch',
                ],
                'slug' => 'lesbienne',
            ],
            [
                'name' => [
                    'fr' => 'Polyamoureux',
                    'en-US' => 'Polyamorous (male)',
                    'es' => 'Poliamoroso',
                    'it' => 'Poliamoroso',
                    'de' => 'Polyamorös (männlich)',
                ],
                'slug' => 'polyamoureux',
            ],
            [
                'name' => [
                    'fr' => 'Polyamoureuse',
                    'en-US' => 'Polyamorous (female)',
                    'es' => 'Poliamorosa',
                    'it' => 'Poliamorosa',
                    'de' => 'Polyamorös (weiblich)',
                ],
                'slug' => 'polyamoureuse',
            ],
            [
                'name' => [
                    'fr' => 'Autre',
                    'en-US' => 'Other',
                    'es' => 'Otro',
                    'it' => 'Altro',
                    'de' => 'Andere',
                ],
                'slug' => 'autre',
            ],
        ];

        foreach ($orientations as $orientation) {
            OrientationSexuelle::firstOrCreate(
                ['slug' => $orientation['slug']],
                $orientation
            );
        }
    }
}

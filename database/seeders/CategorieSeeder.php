<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des catégories avec traductions
        $categories = [
            // Partie pour escort
            [
                'nom' => [
                    'fr' => 'Escort',
                    'en-US' => 'Escort',
                    'es' => 'Escort',
                    'de' => 'Escort',
                    'it' => 'Escort'
                ],
                'display_name' => 'escort',
                'type' => 'escort'
            ],
            [
                'nom' => [
                    'fr' => 'Masseuse (no sexe)',
                    'en-US' => 'Massage (no sex)',
                    'es' => 'Masajista (sin sexo)',
                    'de' => 'Masseuse (kein Sex)',
                    'it' => 'Massaggiatrice (senza sesso)'
                ],
                'display_name' => 'masseuse-no-sex',
                'type' => 'escort'
            ],
            [
                'nom' => [
                    'fr' => 'Dominatrice BDSM',
                    'en-US' => 'BDSM Dominatrix',
                    'es' => 'Dominatrix BDSM',
                    'de' => 'BDSM-Dominatrix',
                    'it' => 'Dominatrix BDSM'
                ],
                'display_name' => 'dominatrice-bdsm',
                'type' => 'escort'
            ],
            [
                'nom' => [
                    'fr' => 'Trans',
                    'en-US' => 'Trans',
                    'es' => 'Trans',
                    'de' => 'Trans',
                    'it' => 'Trans'
                ],
                'display_name' => 'trans',
                'type' => 'escort'
            ],
            // Partie pour salon
            [
                'nom' => [
                    'fr' => "Agence d'escort",
                    'en-US' => 'Escort Agency',
                    'es' => 'Agencia de Escort',
                    'de' => 'Escort-Agentur',
                    'it' => 'Agenzia di Escort'
                ],
                'display_name' => 'agence-escort',
                'type' => 'salon'
            ],
            [
                'nom' => [
                    'fr' => 'Salon erotique',
                    'en-US' => 'Erotic Salon',
                    'es' => 'Salón Erótico',
                    'de' => ' Erotik Salon',
                    'it' => 'Salone Erotico'
                ],
                'display_name' => 'salon-erotique',
                'type' => 'salon'
            ],
            [
                'nom' => [
                    'fr' => 'Institut de massage',
                    'en-US' => 'Massage Institute',
                    'es' => 'Instituto de Masaje',
                    'de' => 'Massageinstitut',
                    'it' => 'Istituto di Massaggio'
                ],
                'display_name' => 'institut-de-massage',
                'type' => 'salon'
            ],
            [
                'nom' => [
                    'fr' => 'Sauna',
                    'en-US' => 'Sauna',
                    'es' => 'Sauna',
                    'de' => 'Sauna',
                    'it' => 'Sauna'
                ],
                'display_name' => 'sauna',
                'type' => 'salon'
            ]
        ];

        foreach ($categories as $category) {
            $categorie = new Categorie();
            foreach ($category['nom'] as $locale => $translation) {
                $categorie->setTranslation('nom', $locale, $translation);
            }
            $categorie->display_name = $category['display_name'];
            $categorie->type = $category['type'];
            $categorie->save();
        }
    }
}
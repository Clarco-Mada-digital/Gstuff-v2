<?php

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;

// class ArticleCategorySeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         $categories = [
//             [
//                 'name' => 'Glossaires',
//                 'slug' => 'glossaires',
//                 'description' => 'Pour les glossaires'
//             ],
//             [
//                 'name' => 'Articles',
//                 'slug' => 'articles',
//                 'description' => 'Articles pour mes applications'
//             ],
//             [
//                 'name' => 'Astuces',
//                 'slug' => 'astuces',
//                 'description' => 'Conseils pratiques'
//             ],
//         ];

//         foreach ($categories as $category) {
//             DB::table('article_categories')->updateOrInsert(
//                 ['slug' => $category['slug']],
//                 $category + [
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]
//             );
//         }
//     }
// }


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ArticleCategory;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'fr' => 'Glossaires',
                    'en-US' => 'Glossaries',
                    'es' => 'Glosarios',
                    'de' => 'Glossare',
                    'it' => 'Glossari'
                ],
                'slug' => 'glossaires',
                'description' => [
                    'fr' => 'Pour les glossaires',
                    'en-US' => 'For glossaries',
                    'es' => 'Para glosarios',
                    'de' => 'Für Glossare',
                    'it' => 'Per i glossari'
                ]
            ],
            [
                'name' => [
                    'fr' => 'Articles',
                    'en-US' => 'Articles',
                    'es' => 'Artículos',
                    'de' => 'Artikel',
                    'it' => 'Articoli'
                ],
                'slug' => 'articles',
                'description' => [
                    'fr' => 'Articles pour mes applications',
                    'en-US' => 'Articles for my applications',
                    'es' => 'Artículos para mis aplicaciones',
                    'de' => 'Artikel für meine Anwendungen',
                    'it' => 'Articoli per le mie applicazioni'
                ]
            ],
            [
                'name' => [
                    'fr' => 'Astuces',
                    'en-US' => 'Tips',
                    'es' => 'Consejos',
                    'de' => 'Tipps',
                    'it' => 'Consigli'
                ],
                'slug' => 'astuces',
                'description' => [
                    'fr' => 'Conseils pratiques',
                    'en-US' => 'Practical advice',
                    'es' => 'Consejos prácticos',
                    'de' => 'Praktische Ratschläge',
                    'it' => 'Consigli pratici'
                ]
            ],
        ];

        foreach ($categories as $category) {
            ArticleCategory::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Glossaires',
                'slug' => 'glossaires',
                'description' => 'Pour les glossaires'
            ],
            [
                'name' => 'Articles',
                'slug' => 'articles',
                'description' => 'Articles pour mes applications'
            ],
            [
                'name' => 'Astuces',
                'slug' => 'astuces',
                'description' => 'Conseils pratiques'
            ],
        ];

        foreach ($categories as $category) {
            DB::table('article_categories')->updateOrInsert(
                ['slug' => $category['slug']],
                $category + [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

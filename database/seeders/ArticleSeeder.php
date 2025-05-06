<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $glossaire = Http::get('https://gstuff.ch/wp-json/wp/v2/posts')->json();
        $glossaire_category = ArticleCategory::where('name', 'LIKE', 'glossaires')->first();

        foreach ($glossaire as $value) {
            $baseSlug = $value['slug'];
            $slug = $baseSlug;
            $slugCount = DB::table('articles')->whereRaw("slug REGEXP '^{$baseSlug}(-[0-9]+)?$'")->count();

            // Si des articles avec ce slug existent, ajoutez un suffixe numérique
            if ($slugCount > 0) {
                $slug = "{$baseSlug}-" . ($slugCount + 1);
            }

            DB::table('articles')->insert([
                'title' => $value['title']['rendered'],
                'slug' => $slug,
                'excerpt' => $value['excerpt']['rendered'],
                'content' => $value['content']['rendered'],
                'article_category_id' => $glossaire_category->id,
                'article_user_id' => 1,
                'is_published' => true,
                'published_at' => now(),
            ]);
        }
    }
}


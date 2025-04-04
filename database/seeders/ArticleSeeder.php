<?php

namespace Database\Seeders;

use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
            DB::table('articles')->insert([ 
                ['title'=>$value['title']['rendered'], 'slug'=>$value['slug'], 'excerpt'=>$value['excerpt']['rendered'], 'content'=>$value['content']['rendered'], 'article_category_id'=>$glossaire_category->id, 'article_user_id'=>1, 'is_published'=>true, 'published_at'=>now() ] ]);
        }
    }
}

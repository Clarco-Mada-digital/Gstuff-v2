<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class ArticleCategory extends Model
{
    use HasFactory, LogsActivity, HasTranslations;
    
    protected $table = 'article_categories';
    
    protected $fillable = ['name', 'slug', 'description'];

    public $translatable = ['name', 'description'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'article_category_id');
    }
}

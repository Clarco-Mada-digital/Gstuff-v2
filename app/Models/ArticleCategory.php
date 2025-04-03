<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleCategory extends Model
{
    use HasFactory;
    protected $table = 'article_categories';
    
    protected $fillable = ['name', 'slug', 'description'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'article_category_id');
    }
}

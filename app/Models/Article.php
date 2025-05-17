<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasFactory, LogsActivity, HasTranslations;

    protected $fillable = [
        'title', 
        'slug', 
        'content', 
        'excerpt', 
        'article_category_id',
        'article_user_id',
        'is_published',
        'published_at'
    ];

    public $translatable = ['title', 'content', 'excerpt'];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'article_user_id');
    }
    
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
    
    // Scope pour les articles publiés
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }
}

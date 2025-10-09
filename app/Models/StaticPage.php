<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;
use Spatie\Translatable\HasTranslations;

class StaticPage extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['slug', 'title', 'content', 'meta_title', 'meta_description'];

    protected $casts = [
        'content' => 'string' // Assure que le contenu est bien traité comme une chaîne
    ];

    public $translatable = ['content' , 'title'];
    
    public static function boot()
    {
        parent::boot();
    
        static::saving(function ($page) {
            
        });
    }

    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->firstOrFail();
    }
}

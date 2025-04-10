<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class StaticPage extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'content', 'meta_title', 'meta_description'];

    protected $casts = [
        'content' => 'string' // Assure que le contenu est bien traité comme une chaîne
    ];
    
    public static function boot()
    {
        parent::boot();
    
        static::saving(function ($page) {
            // Nettoyage basique du contenu HTML
            // $page->content = Purifier::clean($page->content);

            // Validation basique - permet les balises HTML communes
            // $page->content = strip_tags($page->content, [
            //     'p', 'a', 'ul', 'ol', 'li', 
            //     'h1', 'h2', 'h3', 'h4', 
            //     'strong', 'em', 'br', 'img'
            // ]);
        });
    }

    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->firstOrFail();
    }
}

<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\ArticleCategory;
use Livewire\Component;

class GlossaireList extends Component
{
    // public $glossaires;
    public $lettreSearche = [];

    public function render()
    {
        $artile_glossaire = ArticleCategory::where('slug', 'glossaires')->first();
    
        $query = Article::where('article_category_id', $artile_glossaire->id)
                     ->with(['category', 'tags']);
    
        if (!empty($this->lettreSearche)) {
            $query->where(function($q) {
                foreach($this->lettreSearche as $lettre) {
                    // Conversion en minuscule pour la recherche
                    $lowerLetter = strtolower($lettre);
                    $q->orWhere('slug', 'LIKE', $lowerLetter . '%');
                }
            });
        }
    
        $glossaires = $query->orderBy('title', 'ASC')->paginate(10);
    
        // Pour le débogage
        if($this->lettreSearche) {
            \Log::info('Lettres recherchées:', $this->lettreSearche);
            \Log::info('Requête SQL:', [$query->toSql(), $query->getBindings()]);
        }
                             
        return view('livewire.glossaire-list', compact('glossaires'));
    }
}

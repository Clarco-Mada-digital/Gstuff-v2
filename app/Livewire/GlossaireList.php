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
                    $q->orWhere('slug', 'LIKE', $lettre . '%');
                }
            });
        }

        $glossaires = $query->orderBy('title', 'ASC')->paginate(10);
                         
        return view('livewire.glossaire-list', compact('glossaires'));
    }
}

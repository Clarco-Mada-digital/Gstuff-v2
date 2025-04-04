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
        $artile_glossaire = ArticleCategory::where('name', 'LIKE', 'glossaires')->first();

        $glossaires = Article::where('article_category_id', 'LIKE', $artile_glossaire->id)
                         ->where(function ($q) {
                            foreach($this->lettreSearche as $lettre){
                            $q->orwhere('title', 'LIKE', $lettre.'%');
                            }
                        })
                         ->with(['category', 'tags'])
                         ->orderBy('title', 'ASC')
                         ->paginate(10);
                         
        return view('livewire.glossaire-list', compact('glossaires'));
    }
}

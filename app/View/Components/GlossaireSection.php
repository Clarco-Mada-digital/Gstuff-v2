<?php

namespace App\View\Components;

use App\Models\Article;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;

class GlossaireSection extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $glossaires = Cache::remember('all_articles', 3600, function () {
            return Article::all();
        });
        return view('components.glossaire-section', ['glossaires'=>$glossaires]);
    }
}

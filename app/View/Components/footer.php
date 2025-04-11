<?php

namespace App\View\Components;

use App\Models\Canton;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class footer extends Component
{
    public $cantons;
    public $categories;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->cantons = Canton::all();
        // $this->categories = Categorie::where('type', 'escort')->get();
        // $this->glossaires = Article::where('article_category_id', '=', $glossaire_category_id->id)->get();        
        // $this->escorts = User::where('profile_type', 'escorte')->get();
        // $this->salons = User::where('profile_type', 'salon')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer', ['cantons' => $this->cantons]);
    }
}

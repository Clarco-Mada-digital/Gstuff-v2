<?php

namespace App\View\Components;

use Closure;
use App\Models\Categorie;
use App\Models\Canton;
use App\Models\Ville;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class header extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $categories = '',
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->categories = Categorie::where('type', 'escort')->get();
        $cantons = Canton::all();
        $villes = Ville::all();
        $escorts = User::where('profile_type', 'escorte')->get();
        
        foreach ($escorts as $escort) {
          $escort['categorie'] = Categorie::find($escort->categorie);
          $escort['ville'] = Ville::find($escort->ville);
          $escort['canton'] = Canton::find($escort->canton);
        }

        return view('components.header', ['categories' => $this->categories, 'cantons' => $cantons, 'escorts' => $escorts, 'villes'=> $villes]);
    }
}

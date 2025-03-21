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
    public $categories;
    public $cantons;
    public $villes;
    public $escorts;

    public function __construct()
    {

        $this->categories = Categorie::where('type', 'escort')->get();
        $this->cantons = Canton::all();
        $this->villes = Ville::all();
        $this->escorts = User::where('profile_type', 'escorte')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        foreach ($this->escorts as $escort) {
          $escort['categorie'] = Categorie::find($escort->categorie);
          $escort['ville'] = Ville::find($escort->ville);
          $escort['canton'] = Canton::find($escort->canton);
        }

        return view('components.header', ['categories' => $this->categories, 'cantons' => $this->cantons, 'escorts' => $this->escorts, 'villes'=> $this->villes]);
    }
}

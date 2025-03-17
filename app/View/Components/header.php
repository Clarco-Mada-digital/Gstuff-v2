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
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = Categorie::all();
        $cantons = Canton::all();
        $villes = Ville::all();
        $escorts = User::where('profile_type', 'escorte')->get();

        return view('components.header', ['categories' => $categories, 'cantons' => $cantons, 'escorts' => $escorts, 'villes'=> $villes]);
    }
}

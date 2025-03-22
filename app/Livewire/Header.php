<?php

namespace App\Livewire;

use App\Models\Canton;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Ville;
use Livewire\Component;

class Header extends Component
{
    public $categories;
    public $cantons;
    public $villes;
    public $escorts;

    public function render()
    {
        $this->categories = Categorie::where('type', 'escort')->get();
        $this->cantons = Canton::all();
        $this->villes = Ville::all();
        $this->escorts = User::where('profile_type', 'escorte')->get();
        
        foreach ($this->escorts as $escort) {
          $escort['categorie'] = Categorie::find($escort->categorie);
          $escort['ville'] = Ville::find($escort->ville);
          $escort['canton'] = Canton::find($escort->canton);
        }
        
        return view('livewire.header');
    }
}

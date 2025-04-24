<?php

namespace App\Livewire;

use App\Models\Canton;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Ville;
use App\Models\SalonEscorte;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    public $categories = [];
    public $cantons = [];
    public $villes = [];
    public $escorts = [];
    public $salonCreator = null;

    public function render()
    {
        // Charger les catégories pour les escorts
        $this->categories = Categorie::where('type', 'escort')->get();
        
        // Charger les cantons et villes
        $this->cantons = Canton::all();
        $this->villes = Ville::all();

        // Charger les utilisateurs ayant le type 'escorte'
        $this->escorts = User::where('profile_type', 'escorte')->get();

        // Vérifier si l'utilisateur est authentifié
        $userConnected = Auth::user();

      
        if ($userConnected) {
          if ($userConnected->profile_type === 'escorte') {
            // Récupérer le salon associé à l'utilisateur connecté
            $salonEscorte = SalonEscorte::where('escorte_id', $userConnected->id)->first();
            if ($salonEscorte) {
                $this->salonCreator = User::find($salonEscorte->salon_id);
            }
        }
      }

        // Charger les relations pour chaque utilisateur dans les escorts
        $this->escorts->each(function ($escort) {
            $escort->categorie = Categorie::find($escort->categorie);
            $escort->ville = Ville::find($escort->ville);
            $escort->canton = Canton::find($escort->canton);
        });

        return view('livewire.header');
    }
}

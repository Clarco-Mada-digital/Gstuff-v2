<?php

namespace App\Livewire;

use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Genre;
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
    public $genres = [];
    public $escorts;
    public $salonCreator = null;
    public $activeLink = '';


    public function setActiveLink($link)
    {
        $this->activeLink = $link;
    }
    
    public function render()
    {
        // Charger les catégories pour les escorts
        $this->categories = Categorie::where('type', 'escort')
        ->orderBy('id', 'asc')
        ->take(4)
        ->get();

        
        // Charger les cantons avec le nombre d'utilisateurs
        $this->cantons = Canton::select('cantons.*')
            ->selectRaw('(SELECT COUNT(*) FROM users WHERE users.canton::text = cantons.id::text) as users_count')
            ->orderBy('users_count', 'desc')
            ->get();
            
        $this->villes = Ville::all();
        $this->genres = Genre::all();
        
        // Charger les utilisateurs ayant le type 'escorte' avec leurs relations
        $this->escorts = User::with(['cantonRelation', 'villeRelation', 'categorieRelation'])
            ->where('profile_type', 'escorte')
            ->get();

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

        // Les relations sont déjà chargées via le with() plus haut
        // On s'assure que les propriétés sont accessibles depuis la vue
        $this->escorts->each(function ($escort) {
            $escort->categorie = $escort->categorieRelation;
            $escort->ville = $escort->villeRelation;
            $escort->canton = $escort->cantonRelation;
        });

        return view('livewire.header');
    }
}

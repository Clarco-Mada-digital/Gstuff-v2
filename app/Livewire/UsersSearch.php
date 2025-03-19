<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Ville;

class UsersSearch extends Component
{
    public string $search = '';
    public string $selectedCanton = '';
    public string $selectedVille = '';
    public $cantons = '';
    public $villes = '';
 
    public function render()
    {
        $query = User::query()->where(function ($q) {
            $q->where('profile_type', 'escorte')
              ->orWhere('profile_type', 'salon');
        });        
        $this->cantons = Canton::all();
        $this->villes = Ville::all();

        // Recherche principale (OR sur nom, prénom et salon)
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('prenom', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('nom', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('nom_salon', 'LIKE', '%' . $this->search . '%');
            });
        }

        // Filtres supplémentaires
        if ($this->selectedCanton) {
            $query->where('canton', $this->selectedCanton);
        }

        if ($this->selectedVille) {
            $query->where('ville', $this->selectedVille);
        }

        $users = $query->paginate(10);
        foreach ($users as $user) {
          $user['categorie'] = Categorie::find($user->categorie);
          $user['canton'] = Canton::find($user->canton);
          $user['ville'] = Ville::find($user->ville);
        }

        return view('livewire.users-search', [
            'users' => $users
        ]);
    }
}

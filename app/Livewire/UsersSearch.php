<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Ville;
use App\Models\Genre;
use Stevebauman\Location\Facades\Location;

class UsersSearch extends Component
{
    public string $search = '';
    public string $selectedCanton = '';
    public string $selectedVille = '';
    public string $selectedGenre = '';
    public array $selectedCategories = [];
    public $escortCategories;
    public $salonCategories;
    public $cantons = '';
    public $villes = '';
    public $users;
    public $genres;

    public function mount()
    {
        $this->listeners = ['modalUserClosed' => 'handleModalClosed'];
    }

    public function handleModalClosed()
    {
        $this->search = '';
        $this->selectedCanton = '';
        $this->selectedVille = '';
        $this->selectedGenre = '';
        $this->selectedCategories = [];
        $this->escortCategories = [];
        $this->salonCategories = [];
        $this->cantons = [];
        $this->villes = [];
    }

    private function getEscorts($escorts)
    {
      $esc = [];

      // Détection du pays via IP
      $position = Location::get(request()->ip());
      $viewerCountry = $position?->countryCode ?? null;

      // dd($viewerCountry);

      foreach ($escorts as $escort) {
          if ($escort->isProfileVisibleTo($viewerCountry)) {
              $esc[] = $escort;
          }
      }

      return $esc;
    }

    public function render()
    {
        $query = User::query()->where(function ($q) {
            $q->where('profile_type', 'escorte')
              ->orWhere('profile_type', 'salon');
        });
        $this->escortCategories = Categorie::where('type', 'escort')->get();
        $this->salonCategories = Categorie::where('type', 'salon')->get();
        $this->cantons = Canton::all();
        $this->villes = Ville::all();
        $this->genres = Genre::all();

        // Recherche principale (OR sur nom, prénom et salon)
        if ($this->search) {
          // dd($this->search);
            $query->where(function ($q) {
                $q->where('pseudo', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('prenom', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('nom_salon', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('apropos', 'LIKE', '%' . $this->search . '%');
            });
        }

        // Filtres supplémentaires
        if ($this->selectedCanton) {
            $query->where('canton', $this->selectedCanton);
        }
        if ($this->selectedCanton == '') {
            $this->selectedVille = '';
        }

        if ($this->selectedVille) {
            $query->where('ville', $this->selectedVille);
        }

        if ($this->selectedGenre) {
            $query->where('genre_id', $this->selectedGenre);
        }

        if ($this->selectedCategories){
          $query->where(function ($q) {
            foreach($this->selectedCategories as $categorie){
              $q->orwhere('categorie', 'LIKE', '%'.$categorie.'%');
            }
          });
        }

        $this->users = $query->get();
        foreach ($this->users as $user) {
          $user['categorie'] = Categorie::find($user->categorie);
          $user['canton'] = Canton::find($user->canton);
          $user['ville'] = Ville::find($user->ville);
        }

        $this->users = $this->getEscorts($this->users);

        return view('livewire.users-search');
    }
}

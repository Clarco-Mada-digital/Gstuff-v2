<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Ville;
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

    public function mount()
    {
        $this->listeners = ['modalUserClosed' => 'handleModalClosed'];
        $this->cantons = Canton::all();
        $this->villes = collect([]);
        $this->salonCategories = Categorie::where('type', 'salon')->get();
        $this->escortCategories = Categorie::where('type', 'escort')->get();
        $this->users = collect([]);

        // $this->search();
    }

    public function updatedSelectedCanton($value)
    {
        $this->villes = $value ? Ville::where('canton_id', $value)->get() : collect([]);
        $this->selectedVille = ''; // Réinitialiser la ville sélectionnée
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

    public function search()
    {
        $query = User::query()->where(function ($q) {
          $q->where('profile_type', 'escorte')
            ->orWhere('profile_type', 'salon');
        });

        if ($this->search) {
            $query->where(function ($q) {
              $q->where('pseudo', 'LIKE', '%' . $this->search . '%')
              ->orWhere('prenom', 'LIKE', '%' . $this->search . '%')
              ->orWhere('nom_salon', 'LIKE', '%' . $this->search . '%')
              ->orWhere('apropos', 'LIKE', '%' . $this->search . '%');
            });
        }

        if ($this->selectedCanton) {
            $query->where('canton', $this->selectedCanton);
        }

        if ($this->selectedVille) {
            $query->where('ville', $this->selectedVille);
        }

        if ($this->selectedGenre) {
            $query->where('genre', $this->selectedGenre);
        }

        if ($this->selectedCategories) {
            $query->whereIn('categorie', $this->selectedCategories);
        }

        $this->users = $query->get();
        foreach ($this->users as $user) {
          $user['categorie'] = Categorie::find($user->categorie);
          $user['canton'] = Canton::find($user->canton);
          $user['ville'] = Ville::find($user->ville);
        }
        $this->users = $this->getEscorts($this->users);

    }

    public function render()
    {
    //     $query = User::query()->where(function ($q) {
    //         $q->where('profile_type', 'escorte')
    //           ->orWhere('profile_type', 'salon');
    //     });
    //     $this->escortCategories = Categorie::where('type', 'escort')->get();
    //     $this->salonCategories = Categorie::where('type', 'salon')->get();
    //     $this->cantons = Canton::all();
    //     $this->villes = Ville::all();

        // Recherche principale (OR sur nom, prénom et salon)
        // if ($this->search) {
        //   // dd($this->search);
        //     $query->where(function ($q) {
        //         $q->where('pseudo', 'LIKE', '%' . $this->search . '%')
        //           ->orWhere('prenom', 'LIKE', '%' . $this->search . '%')
        //           ->orWhere('nom_salon', 'LIKE', '%' . $this->search . '%')
        //           ->orWhere('apropos', 'LIKE', '%' . $this->search . '%');
        //     });
        // }

        // Filtres supplémentaires
        // if ($this->selectedCanton) {
        //     $query->where('canton', $this->selectedCanton);
        // }
        // if ($this->selectedCanton == '') {
        //     $this->selectedVille = '';
        // }

        // if ($this->selectedVille) {
        //     $query->where('ville', $this->selectedVille);
        // }

        // if ($this->selectedGenre) {
        //     $query->where('genre', $this->selectedGenre);
        // }

        // if ($this->selectedCategories){
        //   $query->where(function ($q) {
        //     foreach($this->selectedCategories as $categorie){
        //       $q->orwhere('categorie', 'LIKE', '%'.$categorie.'%');
        //     }
        //   });
        // }

        // $this->users = $query->get();
        // foreach ($this->users as $user) {
        //   $user['categorie'] = Categorie::find($user->categorie);
        //   $user['canton'] = Canton::find($user->canton);
        //   $user['ville'] = Ville::find($user->ville);
        // }

        // $this->users = $this->getEscorts($this->users);
        $this->search();
        return view('livewire.users-search');
    }
}

/*
class UsersSearche extends Component
{
    public $search = '';
    public $selectedCanton = '';
    public $selectedVille = '';
    public $selectedGenre = '';
    public $selectedCategories = [];
    public $salonCategories;
    public $escortCategories;
    public $users;
    public $cantons = [];
    public $villes = [];
    public $results = [];

    public function mount()
    {
        $this->cantons = Canton::all();
        $this->villes = collect([]);
        $this->salonCategories = Categorie::where('type', 'salon')->get();
        $this->escortCategories = Categorie::where('type', 'escort')->get();
        $this->users = collect([]);
    }

    public function updatedSelectedCanton($value)
    {
        $this->villes = $value ? Ville::where('canton_id', $value)->get() : collect([]);
        $this->selectedVille = ''; // Réinitialiser la ville sélectionnée
    }

    public function search()
    {
        $query = User::query();

        if ($this->search) {
            $query->where('prenom', 'like', "%{$this->search}%")
                  ->orWhere('nom_salon', 'like', "%{$this->search}%");
        }

        if ($this->selectedCanton) {
            $query->where('canton_id', $this->selectedCanton);
        }

        if ($this->selectedVille) {
            $query->where('ville_id', $this->selectedVille);
        }

        if ($this->selectedGenre) {
            $query->where('genre', $this->selectedGenre);
        }

        if ($this->selectedCategories) {
            $query->whereIn('category_id', $this->selectedCategories);
        }

        $this->users = $query->get();
    }

    public function render()
    {
        return view('livewire.users-search', [
            'salonCategories' => $this->salonCategories,
            'escortCategories' => $this->escortCategories,
            'users' => $this->users,
        ]);
    }
}
*/
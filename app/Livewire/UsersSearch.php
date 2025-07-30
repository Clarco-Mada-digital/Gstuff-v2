<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Ville;
use App\Models\Genre;
use Illuminate\Pagination\LengthAwarePaginator;
use Stevebauman\Location\Facades\Location;

class UsersSearch extends Component
{
    use WithPagination; // Ajoutez ce trait
    
    public string $search = '';
    public string $selectedCanton = '';
    public string $selectedVille = '';
    public string $selectedGenre = '';
    public array $selectedCategories = [];
    public $escortCategories;
    public $salonCategories;
    public $cantons = '';
    public $villes = '';
    public $perPage = 8; // Nombre d'éléments par page
    public $page = 1;
    public $genres;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCanton' => ['except' => ''],
        'selectedVille' => ['except' => ''],
        'selectedGenre' => ['except' => ''],
        'selectedCategories' => ['except' => []],
        'page' => ['except' => 1]
    ];

    public function mount()
    {
        $this->listeners = ['modalUserClosed' => 'handleModalClosed'];
        $this->cantons = Canton::all();
        $this->villes = collect([]);
        $this->salonCategories = Categorie::where('type', 'salon')->get();
        $this->escortCategories = Categorie::where('type', 'escort')->get();
        $this->page = request()->get('page', 1);
        $listeGenresExist = User::where('profile_type', 'escorte')->pluck('genre_id')->unique();
        $this->genres= Genre::whereIn('id', $listeGenresExist)->get();
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Réinitialise la pagination quand la recherche change
    }


    public function updated($property)
    {
        // Réinitialise la pagination quand un filtre change
        if (in_array($property, ['search', 'selectedCanton', 'selectedVille', 'selectedGenre', 'selectedCategories'])) {
            $this->resetPage();
        }
    }

    public function updatedSelectedCanton($value)
    {
        $this->villes = $value ? Ville::where('canton_id', $value)->get() : collect([]);
        $this->selectedVille = '';
    }

    public function handleModalClosed()
    {
        $this->resetExcept(['cantons', 'villes', 'escortCategories', 'salonCategories']);
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset([
            'search',
            'selectedCanton',
            'selectedVille',
            'selectedGenre',
            'selectedCategories',
            'page'
        ]);
        $this->villes = collect([]);
    }

    private function getVisibleUsers($users)
    {
        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? null;

        return $users->filter(function ($user) use ($viewerCountry) {
            return $user->isProfileVisibleTo($viewerCountry);
        });
    }

    public function render()
    {   
        $cacheKey = md5(serialize([
            $this->search,
            $this->selectedCanton,
            $this->selectedVille,
            $this->selectedGenre,
            $this->selectedCategories,
            request()->ip()
        ]));

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
            $query->where('genre_id', $this->selectedGenre);
        }

        if (!empty($this->selectedCategories)) {
            $query->where(function($q) {
                foreach ($this->selectedCategories as $category) {
                    $q->orWhere('categorie', 'LIKE', '%' . $category . '%');
                }
            });
        }

        $filteredUsers = $query->get();

        $filteredUsers->transform(function ($user) {
            $categoriesIds = !empty($user->categorie) ? explode(',', $user->categorie) : [];
            $user->categorie = Categorie::whereIn('id', $categoriesIds)->get();
            
            $user->canton = Canton::find($user->canton);
            $user->ville = Ville::find($user->ville);
            return $user;
        });

        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? null;
        
        $visibleUsers = $filteredUsers->filter(function ($user) use ($viewerCountry) {
            return $user->isProfileVisibleTo($viewerCountry);
        });

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $this->perPage;
        $results = $visibleUsers->slice(($page - 1) * $perPage, $perPage)->values();
        
        $paginatedUsers = new LengthAwarePaginator(
            $results,
            $visibleUsers->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $this->queryString
            ]
        );

        return view('livewire.users-search', [
            'users' => $paginatedUsers
        ]);
    }
}
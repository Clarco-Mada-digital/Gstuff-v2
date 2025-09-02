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

class UsersSearch02 extends Component
{
    use WithPagination; // Ajoutez ce trait
    
    public string $search = '';
    public string $selectedCanton = '';
    public string $selectedVille = '';
    public string $selectedGenre = '';
    public string $selectedSalonCategories = '';
    public array $selectedEscortCategories = [];
    public $escortCategories;
    public $salonCategories;
    public $cantons = '';
    public $villes = '';
    public $perPage = 8; // Nombre d'éléments par page
    public $page = 1;
    public $genres;
    public $userType = 'all';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCanton' => ['except' => ''],
        'selectedVille' => ['except' => ''],
        'selectedGenre' => ['except' => ''],
        'selectedCategories' => ['except' => ''],
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
        $this->genres= Genre::all()->take(3);
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Réinitialise la pagination quand la recherche change
    }


    public function updated($property)
    {
        // Réinitialise la pagination quand un filtre change
        if (in_array($property, ['search', 'selectedCanton', 'selectedVille', 'selectedGenre', 'selectedSalonCategories', 'selectedEscortCategories'])) {
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
            'selectedSalonCategories',
            'selectedEscortCategories',
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

    public function setUserType($type)
    {
        $this->userType = $type;
        $this->reset([
            'selectedCanton',
            'selectedVille',
            'selectedGenre',
            'selectedSalonCategories',
            'selectedEscortCategories',
            'page'
        ]);
        $this->villes = collect([]);
        // Pas de rechargement automatique ici
    }


    public function render()
    {   
        $cacheKey = md5(serialize([
            $this->search,
            $this->selectedCanton,
            $this->selectedVille,
            $this->selectedGenre,
            $this->selectedSalonCategories,
            $this->selectedEscortCategories,
            request()->ip()
        ]));

        $query = User::query()->where(function ($q) {

            if($this->userType === 'escort'){
                $q->where('profile_type', 'escorte');
            }elseif($this->userType === 'salon'){
                $q->where('profile_type', 'salon');
            }elseif($this->userType === 'all'){
                $q->where('profile_type', 'escorte')
                  ->orWhere('profile_type', 'salon');
            }
        })->orderByDesc('rate_activity')          // 1️⃣ Taux d'activité élevé en premier
        ->orderByDesc('last_activity')          // 2️⃣ Activité récente ensuite
        ->orderBy('is_profil_pause')            // 3️⃣ Profil actif (0) avant pause (1)
        ;

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

        if($this->userType === 'escort'){
            

        if (!empty($this->selectedEscortCategories)) {
            $query->where(function($q) {
                foreach ($this->selectedEscortCategories as $category) {
                    $q->Where('categorie', 'LIKE', '%' . $category . '%');
                }
            });
        }
        }elseif($this->userType === 'salon'){

        if (!empty($this->selectedSalonCategories)) {
            $query->where('categorie', 'LIKE', '%' . $this->selectedSalonCategories . '%');
        }
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

        $selecterCantonInfo = null;
        $selecterVilleInfo = null;
        $selecterGenreInfo = null;
        $selecterEscortCategoriesInfo = null;
        $selecterSalonCategoriesInfo = null;
        $searchInfo = null;

        if($this->search){
            $searchInfo = $this->search;
        }
        if($this->selectedCanton){
            $selecterCantonInfo = Canton::find($this->selectedCanton);
        }
        if($this->selectedVille){
            $selecterVilleInfo = Ville::find($this->selectedVille);
        }
        if($this->selectedGenre){
            $selecterGenreInfo = Genre::find($this->selectedGenre);
        }
        if($this->selectedEscortCategories){
            $selecterEscortCategoriesInfo = Categorie::whereIn('id', $this->selectedEscortCategories)->get();
        }
        if (!empty($this->selectedSalonCategories)) {
            $selecterSalonCategoriesInfo = Categorie::where('id', $this->selectedSalonCategories)->get();
        }
        
     

        $filterApplay = [
            'selectedCanton' => $selecterCantonInfo,
            'selectedVille' => $selecterVilleInfo,
            'selectedGenre' => $selecterGenreInfo,
            'selectedEscortCategories' => $selecterEscortCategoriesInfo,
            'selectedSalonCategories' => $selecterSalonCategoriesInfo,
            'search' => $searchInfo,
          
        ];

        return view('livewire.users-search02', [
            'users' => $paginatedUsers,
            'filterApplay' => $filterApplay
        ]);
    }
}
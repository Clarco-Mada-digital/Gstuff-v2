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
    use WithPagination;

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
    public $perPage = 8;
    public $page = 1;
    public $genres;
    public $userType = 'all';
    public $approximite = false;
    public $showClosestOnly = false;
    #[Url]
    public $minDistance = 0;
    #[Url]
    public $maxDistanceSelected = 0;
    public $maxAvailableDistance = 0;
    public $latitudeUser;
    public $longitudeUser;
    public $isFirstLoad = true;
    public $isFirstLoadClosestOnly = true;
    public $isFirstLoadApproximite = true;

    public array $autreFiltres = [];
    public $autre = false;
    public $ageMin = 18;
    public $ageMax = 100;
    public $tailleMin = 90;
    public $tailleMax = 200;
    public $tarifMin = 100;
    public $tarifMax = 1000;

    public $ageInterval = [];
    public $tailleInterval = [];
    public $tarifInterval = [];
    public $escortCount = 0;

    

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCanton' => ['except' => ''],
        'selectedVille' => ['except' => ''],
        'selectedGenre' => ['except' => ''],
        'selectedCategories' => ['except' => ''],
        'page' => ['except' => 1],
        'minDistance' => ['except' => 0],
        'maxDistanceSelected' => ['except' => 0],
        'maxAvailableDistance' => ['except' => 0],
    ];

    public function mount()
    {
        $this->listeners = ['modalUserClosed' => 'handleModalClosed'];
        $this->cantons = Canton::all();
        $this->villes = collect([]);
        $this->salonCategories = Categorie::where('type', 'salon')->get();
        $this->escortCategories = Categorie::where('type', 'escort')->get();
        $this->page = request()->get('page', 1);
        $this->genres = Genre::all()->take(3);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($property)
    {
        if (in_array($property, ['search', 'selectedCanton', 'selectedVille', 'selectedGenre', 'selectedSalonCategories', 'selectedEscortCategories' ,'autreFiltres'])) {
            $this->resetPage();
        }
    }

    public function updatedApproximite($value)
    {
        $this->isFirstLoadApproximite = true;
        $this->maxDistanceSelected = 0;
        $this->showClosestOnly = false;
    }

    public function updatedShowClosestOnly($value)
    {
        $this->isFirstLoadClosestOnly = true;
        $this->maxDistanceSelected = 0;
        $this->approximite = false;
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
            'page',
            'approximite',
            'showClosestOnly',
            'maxDistanceSelected',
            'autreFiltres'
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
            'page',
            'approximite',
            'showClosestOnly',
            'maxDistanceSelected',
            'autreFiltres'
        ]);
        $this->villes = collect([]);
    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return round($angle * $earthRadius, 0);
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
            $this->approximite,
            $this->showClosestOnly,
            $this->minDistance,
            $this->maxDistanceSelected,
            $this->maxAvailableDistance,
            request()->ip()
        ]));

        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? 'FR';
        $viewerLatitude = $position?->latitude ?? 0;
        $viewerLongitude = $position?->longitude ?? 0;

        $query = User::query()->where(function ($q) {
            if($this->userType === 'escort'){
                $q->where('profile_type', 'escorte');
            }elseif($this->userType === 'salon'){
                $q->where('profile_type', 'salon');
            }elseif($this->userType === 'all'){
                $q->where('profile_type', 'escorte')
                  ->orWhere('profile_type', 'salon');
            }
        })
        ->orderByDesc('rate_activity')
        ->orderByDesc('last_activity')
        ->orderBy('is_profil_pause');

        $query->where(function($q) {
            if ($this->search) {
                $q->orWhere('pseudo', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('prenom', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('nom_salon', 'LIKE', '%' . $this->search . '%')
                  ->orWhere('apropos', 'LIKE', '%' . $this->search . '%');
            }
            if ($this->selectedCanton) {
                $q->orWhere('canton', $this->selectedCanton);
            }
            if ($this->selectedVille) {
                $q->orWhere('ville', $this->selectedVille);
            }
            if ($this->selectedGenre) {
                $q->orWhere('genre_id', $this->selectedGenre);
            }
            if($this->userType === 'escort' && !empty($this->selectedEscortCategories)) {
                foreach ($this->selectedEscortCategories as $category) {
                    $q->orWhere('categorie', 'LIKE', '%' . $category . '%');
                }
            }elseif($this->userType === 'salon' && !empty($this->selectedSalonCategories)) {
                $q->orWhere('categorie', 'LIKE', '%' . $this->selectedSalonCategories . '%');
            }

            if($this->userType === 'escort' && !empty($this->autreFiltres)) {
                foreach ($this->autreFiltres as $key => $value) {
                    if (!empty($value)) {
                        switch ($key) {
                            case 'mensuration':
                                $q->orWhere('mensuration_id', $value);
                                break;
                            case 'orientation':
                                $q->orWhere('orientation_sexuelle_id', (int) $value);
                                break;
                            case 'couleur_yeux':
                                $q->orWhere('couleur_yeux_id', (int) $value);
                                break;
                            case 'couleur_cheveux':
                                $q->orWhere('couleur_cheveux_id', (int) $value);
                                break;
                            case 'pubis':
                                $q->orWhere('pubis_type_id', (int) $value);
                                break;
                            case 'tatouages':
                                $q->orWhere('tattoo_id', (int) $value);
                                break;
                            case 'taille_poitrine':
                                $poitrineValues = [
                                    'petite' => ['A', 'B', 'C'],
                                    'moyenne' => ['D', 'E', 'F'],
                                    'grosse' => ['G', 'H'],
                                ];
                                    if (array_key_exists($value, $poitrineValues)) {
                                        $taillesCorrespondantes = $poitrineValues[$value];
                                        $q->orWhereIn('taille_poitrine', $taillesCorrespondantes);
                                    }
                                break;
                            case 'silhouette':
                                $q->orWhere('silhouette_id', (int) $value);
                                break;
                            case 'taille_poitrine_detail':
                                $q->orWhere('taille_poitrine', 'LIKE', "%{$value}%");
                                break;
                            case 'mobilite':
                                $q->orWhere('mobilite_id', (int) $value);
                                break;
                            default:
                                $q->orWhere($key, 'LIKE', '%' . $value . '%');
                                break;
                        }
                    }
                }
            }
        });

        $filteredUsers = $query->get();
       

        if($this->approximite || $this->showClosestOnly){
            $filteredUsers = $filteredUsers->filter(function ($user) {
                return $user->lat && $user->lon;
            })->transform(function ($user) use ($viewerLatitude, $viewerLongitude) {
                $user->distance = $this->haversineGreatCircleDistance($viewerLatitude, $viewerLongitude, $user->lat, $user->lon);
                return $user;
            });

            $this->minDistance = $filteredUsers->min('distance');
            $this->maxAvailableDistance = $filteredUsers->max('distance');

            if($this->isFirstLoad && $this->maxDistanceSelected == 0 ){
                $this->maxDistanceSelected = $this->maxAvailableDistance;
            }

            if($this->showClosestOnly){
                $filteredUsers = $filteredUsers->sortBy('distance')->take(4);
                $this->maxAvailableDistance = $filteredUsers->max('distance');
                if($this->isFirstLoadClosestOnly){
                    $this->isFirstLoadClosestOnly = false;
                    $this->maxDistanceSelected = $filteredUsers->max('distance');
                }
                $filteredUsers = $filteredUsers->filter(function ($user) {
                    return $user->distance <= $this->maxDistanceSelected;
                });
            }

            if($this->approximite){
                $filteredUsers = $filteredUsers->sortBy('distance');
                $this->maxAvailableDistance = $filteredUsers->max('distance');
                if($this->isFirstLoadApproximite){
                    $this->isFirstLoadApproximite = false;
                    $this->maxDistanceSelected = $filteredUsers->max('distance');
                }
                $filteredUsers = $filteredUsers->filter(function ($user) {
                    return $user->distance <= $this->maxDistanceSelected;
                });
            }
        }

        // $this->ageMin = $filteredUsers->min('age');
        // $this->ageMax = $filteredUsers->max('age');
        // $this->tailleMin = $filteredUsers->min('tailles');
        // $this->tailleMax = $filteredUsers->max('tailles');
        // $this->tarifMin = $filteredUsers->min('tarif');
        // $this->tarifMax = $filteredUsers->max('tarif');

        // $minAge = isset($this->ageInterval['min']) ? (int) $this->ageInterval['min'] : null;
        // $maxAge = isset($this->ageInterval['max']) ? (int) $this->ageInterval['max'] : null;
        // if ($minAge !== null && $maxAge !== null && $minAge <= $maxAge) {
        //     $filteredUsers = $filteredUsers->merge(
        //         $baseUsers->filter(function ($user) use ($minAge, $maxAge) {
        //             return $user->age >= $minAge && $user->age <= $maxAge;
        //         })
        //     );
        // }





        $filteredUsers->transform(function ($user) {
            $categoriesIds = !empty($user->categorie) ? explode(',', $user->categorie) : [];
            $user->categorie = Categorie::whereIn('id', $categoriesIds)->get();
            $user->canton = Canton::find($user->canton);
            $user->ville = Ville::find($user->ville);
            return $user;
        });

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

        $selecterCantonInfo = $this->selectedCanton ? Canton::find($this->selectedCanton) : null;
        $selecterVilleInfo = $this->selectedVille ? Ville::find($this->selectedVille) : null;
        $selecterGenreInfo = $this->selectedGenre ? Genre::find($this->selectedGenre) : null;
        $selecterEscortCategoriesInfo = !empty($this->selectedEscortCategories) ? Categorie::whereIn('id', $this->selectedEscortCategories)->get() : null;
        $selecterSalonCategoriesInfo = !empty($this->selectedSalonCategories) ? Categorie::where('id', $this->selectedSalonCategories)->get() : null;
        $searchInfo = $this->search ?: null;

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

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
use Illuminate\Database\Eloquent\Collection;

use App\Models\CouleurCheveux;
use App\Models\CouleurYeux;
use App\Models\Mensuration;
use App\Models\Poitrine;
use App\Models\PubisType;
use App\Models\Silhouette;
use App\Models\Tattoo;
use App\Models\Mobilite;
use App\Models\NombreFille;
use App\Models\OrientationSexuelle;
use Illuminate\Support\Facades\Log;
class EscortSearch extends Component
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
    public $perPage = 12;
    public $page = 1;
    public $genres;
    public $userType = 'escort';
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
    public $isFirstLoadAge = true;
    public $isFirstLoadTaille = true;
    public $isFirstLoadTarif = true;

    public array $autreFiltres = [];
    public $autre = false;
    public $ageMin = 18;
    public $ageMax = 58;
    public $tailleMin = 140;
    public $tailleMax = 180;
    public $tarifMin = 80;
    public $tarifMax = 800;

    public $ageInterval = [];
    public $tailleInterval = [];
    public $tarifInterval = [];
    public $escortCount = 0;

    public $isModalOpenSide = false;

    public $origineData = ['Italienne','Allemande', 'Française', 'Espagnole', 'Suissesse', 'Européene (Autres)', 'Asiatique', 'Africaine', 'Orientale', 'Brésilienne', 'Métissée', 'Autre'];
    #[Url]
    public array $selectedOrigine = [];

    public $langueData = ['Allemand', 'Anglais', 'Arabe', 'Espagnol', 'Français', 'Italien', 'Portugais', 'Russe', 'Autre'];
    #[Url]
    public array $selectedLangue = [];

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

    /**
     * Détermine si au moins un filtre est appliqué.
     *
     * @return bool
     */
    public function isAnyFilterApplied(): bool
    {
        return !empty($this->search)
            || !empty($this->selectedCanton)
            || !empty($this->selectedVille)
            || !empty($this->selectedGenre)
            || !empty($this->selectedSalonCategories)
            || !empty($this->selectedEscortCategories)
            || $this->approximite
            || $this->showClosestOnly
         
            || !empty($this->ageInterval)
            || !empty($this->tailleInterval)
            || !empty($this->tarifInterval)
            || !empty($this->selectedOrigine)
            || !empty($this->selectedLangue)
            || !empty($this->autreFiltres);
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

    public function handleModalClosed()
    {
        logger()->info('Modal closed pour reloder la page ');
        $this->userType = 'escort';
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
            'autreFiltres',
            'ageInterval',
            'tailleInterval',
            'tarifInterval',
            'selectedOrigine',
            'selectedLangue',
        ]);
        $this->villes = collect([]);
        return redirect('escortes');
    }

    public function openModalside()
{
    logger()->info('Modal opened');
    $this->isModalOpenSide = true;
}

public function closeModalside()
{
    logger()->info('Modal closed');
    $this->isModalOpenSide = false;
}

    public function resetFilterModal()
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
            'autreFiltres',
            'selectedOrigine',
            'selectedLangue',
            
        ]);
        $this->villes = collect([]);
        return redirect('escortes');
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

    protected function filterByInterval(Collection $users, array $interval, string $attribute): Collection
    {
     

        $min = isset($interval['min']) ? (int) $interval['min'] : null;
        $max = isset($interval['max']) ? (int) $interval['max'] : null;

        logger()->info("{$attribute} min: " . $min);
        logger()->info("{$attribute} max: " . $max);

        if ($min !== null && $max !== null && $min <= $max) {
            $users = $users->filter(function ($user) use ($min, $max, $attribute) {
                return isset($user->$attribute) && $user->$attribute >= $min && $user->$attribute <= $max;
            });
        }

        $users = $users->values(); // réindexe proprement

        return $users;
    }

    public function formatTaille($taille){
        if ($taille) {
            $min = $taille['min'];
            $max = $taille['max'];
        
            $minFormatted = floor($min / 100) . 'm' . str_pad($min % 100, 2, '0', STR_PAD_LEFT);
            $maxFormatted = floor($max / 100) . 'm' . str_pad($max % 100, 2, '0', STR_PAD_LEFT);
        
            return __('escort-search.taille_interval', [
                'min' => $minFormatted,
                'max' => $maxFormatted
            ]);
        }
        return "";
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

            if($this->userType === 'escort' && !empty($this->selectedOrigine)) {
                logger()->info('selectedOrigine', ['selectedOrigine' => $this->selectedOrigine]);
                foreach ($this->selectedOrigine as $origine) {
                    $q->orWhere('origine', 'LIKE', '%' . $origine . '%');
                }
            }

            if($this->userType === 'escort' && !empty($this->selectedLangue)) {
                logger()->info('selectedLangue', ['selectedLangue' => $this->selectedLangue]);
                foreach ($this->selectedLangue as $langue) {
                    $q->orWhere('langues', 'LIKE', '%' . $langue . '%');
                }
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
                                $q->orWhere('tatoo_id', (int) $value);
                                break;
                            case 'poitrine':
                                $q->orWhere('poitrine_id', (int) $value);
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
        $baseUsers = $filteredUsers;
       

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
        if($this->isFirstLoadAge){
            $this->isFirstLoadAge = false;
            // $this->ageMin = $filteredUsers->min('age');
            // $this->ageMax = $filteredUsers->max('age');
        }
        if ($this->isFirstLoadTaille) {
            $this->isFirstLoadTaille = false;
        
            $validTailleUsers = $filteredUsers->filter(function ($user) {
                return isset($user->tailles) && $user->tailles > 0;
            });
        
            // $this->tailleMin = $validTailleUsers->min('tailles');
            // $this->tailleMax = $validTailleUsers->max('tailles');

            // $this->tailleMin = $filteredUsers->min('tailles');
            // $this->tailleMax = $filteredUsers->max('tailles');
        }
        
        if($this->isFirstLoadTarif){
            $this->isFirstLoadTarif = false;
            // $this->tarifMin = $filteredUsers->min('tarif');
            // $this->tarifMax = $filteredUsers->max('tarif');
        }

        $filteredUsers = $this->filterByInterval($filteredUsers, $this->ageInterval, 'age');
        $filteredUsers = $this->filterByInterval($filteredUsers, $this->tailleInterval, 'tailles');
        $filteredUsers = $this->filterByInterval($filteredUsers, $this->tarifInterval, 'tarif');





        // $filteredUsers->transform(function ($user) {
        //     $categoriesIds = !empty($user->categorie) ? explode(',', $user->categorie) : [];
        //     $user->categorie = Categorie::whereIn('id', $categoriesIds)->get();
        //     $user->canton = Canton::find($user->canton);
        //     $user->ville = Ville::find($user->ville);
        //     return $user;
        // });

        // $visibleUsers = $filteredUsers->filter(function ($user) use ($viewerCountry) {
        //     return $user->isProfileVisibleTo($viewerCountry);
        // });

        // $visibleUsers = $filteredUsers
        // ->filter(function ($user) use ($viewerCountry) {
        //     return $user->isProfileVisibleTo($viewerCountry);
        // })
        // ->transform(function ($user) {
        //     $categoriesIds = !empty($user->categorie) ? explode(',', $user->categorie) : [];
        //     $user->categorie = Categorie::whereIn('id', $categoriesIds)->get();
        //     $user->canton = Canton::find($user->canton);
        //     $user->ville = Ville::find($user->ville);

        //     Log::info("User ID {$user->id} - Rate Activity: {$user->rate_activity}");

        //     return $user;
        // })
        // ->sortBy(function ($user) {
        //     // Priorité 0 : avatar présent (0 = a un avatar, 1 = pas d'avatar)
        //     $hasNoAvatar = empty($user->avatar) ? 1 : 0;

        //     // Priorité 1 : profil en pause (0 = actif, 1 = en pause)
        //     $pauseScore = $user->is_profil_pause ? 1 : 0;

        //     // Priorité 2 : rate_activity inversé (plus haut = mieux)
        //     $rateScore = $user->rate_activity * -1;

        //     // Priorité 3 : last_activity inversé (plus récent = mieux)
        //     $lastActivityScore = strtotime($user->last_activity) * -1;

        //     return [$hasNoAvatar, $pauseScore, $rateScore, $lastActivityScore];
        // })
        // ->values(); // Réindexer proprement

        $tabNoAvatar = collect();
        $tabPause = collect();
        $tabBest = collect();

        $filteredUsers
            ->filter(function ($user) use ($viewerCountry) {
                return $user->isProfileVisibleTo($viewerCountry);
            })
            ->each(function ($user) use (&$tabNoAvatar, &$tabPause, &$tabBest) {
                // Enrichir les données
                $categoriesIds = !empty($user->categorie) ? explode(',', $user->categorie) : [];
                $user->categorie = Categorie::whereIn('id', $categoriesIds)->get();
                $user->canton = Canton::find($user->canton);
                $user->ville = Ville::find($user->ville);

                Log::info("User ID {$user->id} - Rate Activity: {$user->rate_activity}");

                // Organisation par catégorie
                if (empty($user->avatar)) {
                    $tabNoAvatar->push($user);
                } elseif ($user->is_profil_pause) {
                    $tabPause->push($user);
                } else {
                    $tabBest->push($user);
                }
            });

        // 🔢 Tri des tableaux

        $tabBest = $tabBest->sortByDesc('rate_activity')
                        ->sortByDesc(function ($user) {
                            return strtotime($user->last_activity);
                        })
                        ->values();

        $tabPause = $tabPause->sortByDesc('rate_activity')
                            ->sortByDesc(function ($user) {
                                return strtotime($user->last_activity);
                            })
                            ->values();

        $tabNoAvatar = $tabNoAvatar->sortBy(function ($user) {
                                return $user->is_profil_pause ? 0 : 1; // pause en premier
                            })
                            ->sortByDesc('rate_activity')
                            ->sortByDesc(function ($user) {
                                return strtotime($user->last_activity);
                            })
                            ->values();

        // 🧩 Fusion finale
        $visibleUsers = $tabBest->concat($tabPause)->concat($tabNoAvatar);








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
        $ageInterval = $this->ageInterval;
        $tailleInterval = $this->tailleInterval;
        $tarifInterval = $this->tarifInterval;
        $selectedOrigine = $this->selectedOrigine;
        $selectedLangue = $this->selectedLangue;
        $selecterAutreFiltresInfo = [];
        $countSelectedAutreFiltres = 0;
        if($ageInterval){
        $selecterAutreFiltresInfo['ageInterval'] = __('escort-search.age_interval', [
            'min' => $ageInterval['min'],
            'max' => $ageInterval['max']
        ]);
        $countSelectedAutreFiltres++;
        }
        if($tailleInterval){
        $selecterAutreFiltresInfo['tailleInterval'] = $this->formatTaille($tailleInterval);
        $countSelectedAutreFiltres++;
        }
        if($tarifInterval){
        $selecterAutreFiltresInfo['tarifInterval'] = __('escort-search.tarif_interval', [
            'min' => $tarifInterval['min'],
            'max' => $tarifInterval['max']
        ]);
        $countSelectedAutreFiltres++;
        }
        if($selectedOrigine){
            $countSelectedAutreFiltres =count($selectedOrigine) + $countSelectedAutreFiltres;
            $normalize = null;
            foreach ($selectedOrigine as $key => $value) 
                {
                    $normalize .= $value . ', ';
                }
            $selecterAutreFiltresInfo['origine'] = $normalize;
        }
        if($selectedLangue){
            $countSelectedAutreFiltres = count($selectedLangue) + $countSelectedAutreFiltres;
            $normalize = null;
            foreach ($selectedLangue as $key => $value) 
                {
                    $normalize .= $value . ', ';
                }
            $selecterAutreFiltresInfo['langue'] = __('escort-search.speak', [
                'langue' => $normalize
            ]);
        }
        foreach ($this->autreFiltres as $key => $value) {
            if (!empty($value)) {
                switch ($key) {
                    case 'origine':
                        $origine = $value;
                        $selecterAutreFiltresInfo['origine'] = $origine;
                        $countSelectedAutreFiltres++;
                        break;
                    case 'mensuration':
                        $countSelectedAutreFiltres++;
                        $mensuration = Mensuration::find($value);
                        $selecterAutreFiltresInfo['mensuration'] = $mensuration->name;
                      
                        break;
                    case 'orientation':
                        $countSelectedAutreFiltres++;
                        $orientation = OrientationSexuelle::find($value);
                        $selecterAutreFiltresInfo['orientation'] = $orientation->name;
                        break;
                    case 'couleur_yeux':
                        $countSelectedAutreFiltres++;
                        $couleur_yeux = CouleurYeux::find($value);
                        $selecterAutreFiltresInfo['couleur_yeux'] = $couleur_yeux->name;
                        break;
                    case 'couleur_cheveux':
                        $countSelectedAutreFiltres++;
                        $couleur_cheveux = CouleurCheveux::find($value);
                        $selecterAutreFiltresInfo['couleur_cheveux'] = $couleur_cheveux->name;
                        break;
                    case 'poitrine':
                        $countSelectedAutreFiltres++;
                        $poitrine = Poitrine::find($value);
                        $selecterAutreFiltresInfo['poitrine'] = $poitrine->name;
                        break;
                    case 'langues':
                        $countSelectedAutreFiltres++;
                        $langue = $value;
                        $selecterAutreFiltresInfo['langue'] = $langue;
                        break;
                    case 'pubis':
                        $countSelectedAutreFiltres++;
                        $pubis = PubisType::find($value);
                        $selecterAutreFiltresInfo['pubis'] = $pubis->name;
                        break;
                    case 'tatouages':
                        $countSelectedAutreFiltres++;
                        $tatouages = Tattoo::find($value);
                        $selecterAutreFiltresInfo['tatouages'] = $tatouages->name;
                        break;
                    case 'taille_poitrine':
                        $countSelectedAutreFiltres++;
                        if($value == 'petite'){
                        $selecterAutreFiltresInfo['taille_poitrine'] = __('escort-search.petite');
                        }
                        if($value == 'moyenne'){
                        $selecterAutreFiltresInfo['taille_poitrine'] = __('escort-search.moyenne');
                        }
                        if($value == 'grosse'){
                        $selecterAutreFiltresInfo['taille_poitrine'] = __('escort-search.grosse');
                        }
                        break;
                    case 'taille_poitrine_detail':
                        $countSelectedAutreFiltres++;
                        $taille_poitrine_detail = $value;
                        $selecterAutreFiltresInfo['taille_poitrine_detail'] = $taille_poitrine_detail->name;
                        break;
                    case 'mobilite':
                        $countSelectedAutreFiltres++;
                        $mobilite = Mobilite::find($value);
                        $selecterAutreFiltresInfo['mobilite'] = $mobilite->name;
                        break;

                    default:
                        break;
                }
            }
        }
        logger()->info('autreFiltres', $selecterAutreFiltresInfo);
        logger()->info('autreFiltres count: ' . $countSelectedAutreFiltres);



        $filterApplay = [
            'selectedCanton' => $selecterCantonInfo,
            'selectedVille' => $selecterVilleInfo,
            'selectedGenre' => $selecterGenreInfo,
            'selectedEscortCategories' => $selecterEscortCategoriesInfo,
            'selectedSalonCategories' => $selecterSalonCategoriesInfo,
            'search' => $searchInfo,
            'ageInterval' => $ageInterval,
            'tailleInterval' => $tailleInterval,
            'tarifInterval' => $tarifInterval,
            'selectedOrigine' => $selectedOrigine,
            'selectedLangue' => $selectedLangue,
            // 'autreFiltres' => $autreFiltres,
        ];

        $this->escortCount = $visibleUsers->count();

        return view('livewire.escort-search', [
            'users' => $paginatedUsers,
            'filterApplay' => $filterApplay,
            'countSelectedAutreFiltres' => $countSelectedAutreFiltres,
            'selecterAutreFiltresInfo' => $selecterAutreFiltresInfo,
        ]);
    }
}

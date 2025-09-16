<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Genre;
use App\Models\Service;
use App\Models\User;
use App\Models\Ville;
use Livewire\Component;
use Livewire\WithPagination;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

class EscortSearch extends Component
{
    use WithPagination;

    #[Url]
    public string $selectedCanton = '';
    #[Url]
    public string $selectedVille = '';
    #[Url]
    public string $selectedGenre = '';
    #[Url]
    public array $selectedCategories = [];
    #[Url]
    public array $selectedServices = [];
    #[Url]
    public $minDistance = 0; // Distance minimale

    #[Url]
    public $maxDistanceSelected = 0; // Distance maximale sélectionnée

    public $maxAvailableDistance = 0; // Distance maximale disponible

    public array $autreFiltres = [];
    public $categories;
    public $cantons;
    public $availableVilles;
    public $villes = [];
    public $maxDistance = 0;
    public $escortCount = 0;
    public $genres;

    public $ageMin = 18;
    public $ageMax = 100;
    public $tailleMin = 90;
    public $tailleMax = 200;
    public $tarifMin = 100;
    public $tarifMax = 1000;

    public $origineData = ['Italienne','Allemande', 'Française', 'Espagnole', 'Suissesse', 'Européene (Autres)', 'Asiatique', 'Africaine', 'Orientale', 'Brésilienne', 'Métissée', 'Autre'];
    #[Url]
    public array $selectedOrigine = [];

    public $langueData = ['Allemand', 'Anglais', 'Arabe', 'Espagnol', 'Français', 'Italien', 'Portugais', 'Russe', 'Autre'];
    #[Url]
    public array $selectedLangue = [];

    // public $ageInterval = [];
    public $tailleInterval = [];
    public $tarifInterval = [];

    public $ageInterval = ['min' => 18, 'max' => 100];
    // public $tailleInterval = ['min' => 90, 'max' => 200];
    // public $tarifInterval = ['min' => 100, 'max' => 1000];

    public $approximite = false;
    public $latitudeUser;
    public $longitudeUser;

    public $autre = false;

    #[Url]
    public bool $showClosestOnly = false; // Nouvelle propriété pour le filtre des plus proches

    public $showFiltreCanton = true;

    public $showMore = false;

    public $firstLoadShowClosestOnly = true;

    public function openModalMore()
    {
        logger()->info("openModalMore");
        $this->showMore = true;
    }
    public function closeModalMore()
    {
        logger()->info("closeModalMore");
        $this->showMore = false;
    }


    public function filtreIsActif()
    {
        if (
            empty($this->selectedCanton) 
            && empty($this->selectedVille) 
            && empty($this->selectedGenre) 
            && empty($this->selectedCategories) 
            && empty($this->selectedServices) 
            && empty($this->autreFiltres)
            && empty($this->selectedOrigine)
            && empty($this->selectedLangue)
            && !$this->showClosestOnly
            && !$this->approximite
            ) {
            return false;
        }
        return true;
    }

    public function getPaginatedHydratedEscorts($filteredEscorts)
    {
       
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $perPage = 12;
        $currentItems = $filteredEscorts->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedEscorts = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $filteredEscorts->count(), $perPage, $currentPage, ['path' => request()->url(), 'query' => request()->query()]);

        // Hydrate relations
        foreach ($paginatedEscorts as &$escort) {
            // 🔍 Accès à la propriété 'categorie'
            $rawCategorie = is_array($escort) ? ($escort['categorie'] ?? null) : ($escort->categorie ?? null);
        
            $categoriesIds = [];
        
            if (!empty($rawCategorie)) {
                if (is_string($rawCategorie)) {
                    $categoriesIds = explode(',', $rawCategorie);
                } elseif (is_array($rawCategorie)) {
                    $categoriesIds = collect($rawCategorie)
                        ->pluck('id')
                        ->filter()
                        ->values()
                        ->toArray();
                }
            }
        
            // 🧬 Hydratation des relations
            $categorie = Categorie::whereIn('id', $categoriesIds)->get();
            $canton    = Canton::find(is_array($escort) ? ($escort['canton'] ?? null) : ($escort->canton ?? null));
            $ville     = Ville::find(is_array($escort) ? ($escort['ville'] ?? null) : ($escort->ville ?? null));
        
            // 🧩 Mise à jour des données
            if (is_array($escort)) {
                $escort['categorie'] = $categorie;
                $escort['canton']    = $canton;
                $escort['ville']     = $ville;
            } elseif (is_object($escort)) {
                $escort->categorie = $categorie;
                $escort->canton    = $canton;
                $escort->ville     = $ville;
            }
        }
        

        return $paginatedEscorts;
    }

    public function getBaseEscorts()
    {
        logger()->info("getBaseEscorts 👍 ✅ /////////////////////////////////////////");
        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? 'FR';
        $viewerLatitude = $position?->latitude ?? 0;
        $viewerLongitude = $position?->longitude ?? 0;

        if(!$this->showClosestOnly && !$this->approximite){
            $query = User::query()
                    ->where('profile_type', 'escorte')
                    ->orderBy('is_profil_pause')
                    ->orderByDesc('rate_activity')
                    ->orderByDesc('last_activity');
            if (Auth::user()) {
                $query->where('id', '!=', Auth::user()->id);
            }
            $baseEscorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
                return $escort->isProfileVisibleTo($viewerCountry);
            }); 

        }else {
            
            $userLatitude = $this->latitudeUser;
            $userLongitude = $this->longitudeUser;

            
            if (!$userLatitude || !$userLongitude) {
                $userLatitude = $viewerLatitude;
                $userLongitude = $viewerLongitude;
            }

            $minDistance = PHP_FLOAT_MAX;
            $maxAvailableDistance = 0;
            $escortCount = 0;
     
            if(Auth::user()){
                $baseEscorts = User::where('profile_type', 'escorte')
                    ->where('id', '!=', Auth::user()->id)
                    ->whereNotNull('lat')
                    ->whereNotNull('lon')
                    ->orderBy('is_profil_pause')            // 1️⃣ Profil actif (0) avant pause (1)
                    ->orderByDesc('rate_activity')          // 2️⃣ Taux d'activité élevé en premier
                    ->orderByDesc('last_activity')          // 3️⃣ Activité récente ensuite
                    ->get()
                    ->filter(function ($escort) use ($viewerCountry) {
                        return $escort->isProfileVisibleTo($viewerCountry);
                    })
                    ->map(function ($escort) use ($userLatitude, $userLongitude, &$minDistance, &$maxAvailableDistance, &$escortCount) {
                        $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon);

                        // Mettre à jour les distances min et max
                        $minDistance = min($minDistance, $distance);
                        $maxAvailableDistance = max($maxAvailableDistance, $distance);

                        $escortCount++;

                        return [
                            'escort' => $escort,
                            'distance' => $distance,
                        ];
                    });
                }else{
                    $baseEscorts = User::where('profile_type', 'escorte')
                    ->whereNotNull('lat')
                    ->whereNotNull('lon')
                    ->orderBy('is_profil_pause')            // 1️⃣ Profil actif (0) avant pause (1)
                    ->orderByDesc('rate_activity')          // 2️⃣ Taux d'activité élevé en premier
                    ->orderByDesc('last_activity')          // 3️⃣ Activité récente ensuite
                    ->get()
                    ->filter(function ($escort) use ($viewerCountry) {
                        return $escort->isProfileVisibleTo($viewerCountry);
                    })
                    ->map(function ($escort) use ($userLatitude, $userLongitude, &$minDistance, &$maxAvailableDistance, &$escortCount) {
                        $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon);

                        // Mettre à jour les distances min et max
                        $minDistance = min($minDistance, $distance);
                        $maxAvailableDistance = max($maxAvailableDistance, $distance);

                        $escortCount++;

                        return [
                            'escort' => $escort,
                            'distance' => $distance,
                        ];
                    });
            } 
            if($this->showClosestOnly){
                $baseEscorts = $baseEscorts->sortBy('distance');
                $baseEscorts = $baseEscorts->take(4);
                $this->minDistance = $minDistance;
                $this->maxAvailableDistance = $maxAvailableDistance;
                
            }
        }

       // Initialisation sécurisée des bornes
        $this->ageMin    = $baseEscorts->whereNotNull('age')->min('age') ?? 0;
        $this->ageMax    = $baseEscorts->whereNotNull('age')->max('age') ?? 0;

        $this->tailleMin = $baseEscorts->whereNotNull('tailles')->filter(function ($escort) {
            return is_numeric($escort->tailles) && $escort->tailles > 0;
        })->min('tailles') ?? 0;

        $this->tailleMax = $baseEscorts->whereNotNull('tailles')->filter(function ($escort) {
            return is_numeric($escort->tailles);
        })->max('tailles') ?? 0;

        $this->tarifMin  = $baseEscorts->whereNotNull('tarif')->filter(function ($escort) {
            return is_numeric($escort->tarif) && $escort->tarif > 0;
        })->min('tarif') ?? 0;

        $this->tarifMax  = $baseEscorts->whereNotNull('tarif')->filter(function ($escort) {
            return is_numeric($escort->tarif);
        })->max('tarif') ?? 0;

        return $baseEscorts;
    }

    private function updateDistanceBounds($escortsCollection)
{
    if ($escortsCollection->isEmpty()) {
        $this->minDistance = 0;
        $this->maxAvailableDistance = 0;
        return;
    }

    $this->minDistance = $escortsCollection->min('distance');
    $this->maxAvailableDistance = $escortsCollection->max('distance');
}


    public function getDataEscortsClosestOnlyTest()
{
    logger('getDataEscortsClosestOnlyTest *************************************************');
    $position = Location::get(request()->ip());
    $viewerCountry = $position?->countryCode ?? 'FR';
    $viewerLatitude = $position?->latitude ?? 0;
    $viewerLongitude = $position?->longitude ?? 0;

    $userLatitude = $this->latitudeUser ?? $viewerLatitude;
    $userLongitude = $this->longitudeUser ?? $viewerLongitude;

    $baseEscorts = User::where('profile_type', 'escorte')
        ->whereNotNull('lat')
        ->whereNotNull('lon')
        ->orderBy('is_profil_pause')
        ->orderByDesc('rate_activity')
        ->orderByDesc('last_activity');

    if (Auth::user()) {
        $baseEscorts->where('id', '!=', Auth::user()->id);
    }

    $baseEscorts = $baseEscorts->get()
        ->filter(fn($escort) => $escort->isProfileVisibleTo($viewerCountry))
        ->map(function ($escort) use ($userLatitude, $userLongitude) {
            $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon);
            return [
                'escort' => $escort,
                'distance' => $distance,
            ];
        });

    // Mise à jour des bornes de distance
    $this->updateDistanceBounds($baseEscorts);

    // Initialisation sécurisée des bornes
    $this->ageMin = $baseEscorts->whereNotNull('escort.age')->min('escort.age') ?? 0;
    $this->ageMax = $baseEscorts->whereNotNull('escort.age')->max('escort.age') ?? 0;
    $this->tailleMin = $baseEscorts->whereNotNull('escort.tailles')->filter(fn($e) => is_numeric($e['escort']->tailles) && $e['escort']->tailles > 0)->min('escort.tailles') ?? 0;
    $this->tailleMax = $baseEscorts->whereNotNull('escort.tailles')->filter(fn($e) => is_numeric($e['escort']->tailles))->max('escort.tailles') ?? 0;
    $this->tarifMin = $baseEscorts->whereNotNull('escort.tarif')->filter(fn($e) => is_numeric($e['escort']->tarif) && $e['escort']->tarif > 0)->min('escort.tarif') ?? 0;
    $this->tarifMax = $baseEscorts->whereNotNull('escort.tarif')->filter(fn($e) => is_numeric($e['escort']->tarif))->max('escort.tarif') ?? 0;

    return $baseEscorts;
}


    public function filtreEscortsByCantonVilleGenreService($baseEscorts)
    {
        $filteredEscorts = collect();

       if ($this->selectedCanton) {
           $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('canton', $this->selectedCanton));
       }

 
       if ($this->selectedVille) {

           $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('ville', $this->selectedVille));
       }

       if ($this->selectedGenre) {
   
           $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('genre_id', $this->selectedGenre));
       }


    //    probleme sur le filtre de categorie ???? ici valeur toujour null alors quil exist dans la base de donnes

    if (!empty($this->selectedCategories)) {
        logger()->info('Filtre categories', ['categories' => $this->selectedCategories]);
    
        $filteredEscorts = $baseEscorts->filter(function ($escort) {
            $raw = $escort->categorie ?? null;
            logger()->info('categories', ['categories' => $raw]);
    
            if (is_string($raw)) {
                $categories = explode(',', $raw);
            } elseif (is_array($raw)) {
                $categories = $raw;
            } else {
                $categories = [];
            }
    
            $categories = array_map('strval', $categories);
            logger()->info('categories', ['categories' => $categories]);
    
            return count(array_intersect($categories, array_map('strval', $this->selectedCategories))) > 0;
        });
    }
    
    
   
       if (!empty($this->selectedServices)) {
           foreach ($this->selectedServices as $service) {
               $filteredEscorts = $filteredEscorts->merge(
                   $baseEscorts->filter(function ($escort) use ($service) {
                       return str_contains($escort->service, (string) $service);
                   })
               );
           }
       }
       return $filteredEscorts;
    }
    public function updatedShowClosestOnly($value)
    {
        $this->showClosestOnly = $value;

        $this->firstLoadShowClosestOnly = true;
    
        logger()->info('Filtre proximité modifié', ['valeur' => $this->showClosestOnly]);
    }
    
    public function getBaseEscortsClosestOnly($baseEscorts)
    {
     
        $this->selectedCanton = '';
        $this->selectedVille = '';

        $escortCount = $baseEscorts->count();
        if ($escortCount > 4) {
            $baseEscorts = $baseEscorts->take(4);
            $maxAvailableDistance = $baseEscorts->last()['distance'];
        }
        // Mettre à jour les propriétés de la classe
        $this->escortCount = $escortCount;

        // Si c'est le premier chargement, initialiser maxDistanceSelected
        if ($this->firstLoadShowClosestOnly) {
            $this->maxDistanceSelected = $this->maxAvailableDistance;
            $this->firstLoadShowClosestOnly = false;
        }
        if($this->maxDistanceSelected > $this->maxAvailableDistance || $this->maxDistanceSelected < $this->minDistance){
            $this->maxDistanceSelected = $this->maxAvailableDistance;
        }
        logger()->info("getBaseEscortsClosestOnly 👍 ✅", ["count" => $baseEscorts->count(), 
            "maxDistanceSelected" => $this->maxDistanceSelected, 
            "minDistance" => $this->minDistance,
            "maxAvailableDistance" => $this->maxAvailableDistance,
            "firstLoadShowClosestOnly" => $this->firstLoadShowClosestOnly ,
        ]);
        logger()->info("escortes 👍 ✅", ["escortes" => $baseEscorts]);
        logger()->info("minDistance 👍 ✅", ["minDistance" => $minDistance]);

        logger()->info("maxAvailableDistance 👍 ✅", ["maxAvailableDistance" => $maxAvailableDistance]);

        return $baseEscorts;
    }
    























    public function mount()
    {
        $this->ageInterval = ['min' => 18, 'max' => 100];
    
    }

protected $listeners = ['updateInterval' => 'handleUpdateInterval'];

public function handleUpdateInterval($data)
{
    $model = $data['model'];
    $min = $data['min'];
    $max = $data['max'];

    if ($model === 'ageInterval') {
        $this->ageInterval = [
            'min' => (int)$min,
            'max' => (int)$max
        ];
        $this->ageMin = (int)$min;
        $this->ageMax = (int)$max;
    } elseif ($model === 'tailleInterval') {
        $this->tailleInterval = [
            'min' => (int)$min,
            'max' => (int)$max
        ];
        $this->tailleMin = (int)$min;
        $this->tailleMax = (int)$max;
    } elseif ($model === 'tarifInterval') {
        $this->tarifInterval = [
            'min' => (int)$min,
            'max' => (int)$max
        ];
        $this->tarifMin = (int)$min;
        $this->tarifMax = (int)$max;
    }
    
    $this->resetPage();
}

    private function getEscorts($escorts)
    {
        // Détection du pays via IP
        $position = \Stevebauman\Location\Facades\Location::get(request()->ip());

        $viewerCountry = $position?->countryCode ?? 'FR'; // fallback pour dev

        $esc = [];
        foreach ($escorts as $escort) {
            if ($escort->isProfileVisibleTo($viewerCountry)) {
                $esc[] = $escort;
            }
        }
        return $esc;
    }

    public function approximiteFunc()
    {
        $this->approximite = !$this->approximite;
        if ($this->approximite) {
            $this->showClosestOnly = false;
            $this->reset('maxDistanceSelected');
        }
        $this->resetPage();
    }

    public function updateUserLatitude($latitude)
    {
        $this->latitudeUser = $latitude;
    }

    public function updateUserLongitude($longitude)
    {
        $this->longitudeUser = $longitude;
    }

    public function resetFilter()
    {
        $this->selectedCanton = '';
        $this->selectedVille = '';
        $this->selectedGenre = '';
        $this->selectedCategories = [];
        $this->selectedServices = [];
        $this->autreFiltres = [];
        $this->approximite = false;
        $this->showClosestOnly = false;
        $this->villes = [];
        $this->ageInterval = [];
        $this->tailleInterval = [];
        $this->tarifInterval = [];
        $this->getValueRange();
        $this->resetPage();
        $this->render();
    }

    public function resetFilterModal()
    {
        $this->selectedCanton = '';
        $this->selectedVille = '';
        $this->selectedGenre = '';
        $this->selectedCategories = [];
        $this->selectedServices = [];
        $this->autreFiltres = [];
        $this->approximite = false;
        $this->showClosestOnly = false;
        $this->villes = [];
        $this->ageInterval = [];
        $this->tailleInterval = [];
        $this->tarifInterval = [];
        $this->getValueRange();
        $this->resetPage();
        return redirect('escortes');
    }

    public function chargeVille()
    {
        if (!empty($this->selectedCanton)) {
            $this->villes = Ville::where('canton_id', $this->selectedCanton)->get();
        } else {
            $this->villes = collect();
        }
    }


    public function updatedMinDistance($value)
    {
        // S'assurer que la distance minimale ne dépasse pas la distance maximale
        if ($value > $this->maxDistanceSelected) {
            $this->maxDistanceSelected = $value;
        }
        $this->resetPage();
    }

    public function updatedMaxDistanceSelected($value)
    {
        // S'assurer que la distance maximale n'est pas inférieure à la distance minimale
        if ($value < $this->minDistance) {
            $this->minDistance = $value;
        }
        $this->resetPage();
    }


    public function filtreOrigineAndLangue( $baseEscorts, $filteredEscorts)
    {
        if (!empty($this->selectedOrigine)) {

                
            if ($filteredEscorts->isEmpty() && empty($this->selectedCanton) && empty($this->selectedVille) && empty($this->selectedGenre) && empty($this->selectedCategories) && empty($this->selectedServices) && empty($this->autreFiltres)) {
                $filteredEscorts = $baseEscorts;
            }

            $filteredEscorts = $filteredEscorts->filter(function ($escort) {
              
        
                $origine = is_array($escort) ? ($escort['origine'] ?? null) : $escort->origine;
        
                if (is_string($origine)) {
                    $origine = array_map('trim', explode(',', $origine));
                } elseif (!is_array($origine)) {
                    $origine = [];
                
                }
        
                // Vérifie s’il y a une correspondance avec au moins une langue sélectionnée
                return count(array_intersect($origine, $this->selectedOrigine)) > 0;
            });
        }


        if (!empty($this->selectedLangue)) {

            
            if ($filteredEscorts->isEmpty() && empty($this->selectedCanton) && empty($this->selectedVille) && empty($this->selectedGenre) && empty($this->selectedCategories) && empty($this->selectedServices) && empty($this->autreFiltres)) {
                $filteredEscorts = $baseEscorts;
            }

            $filteredEscorts = $filteredEscorts->filter(function ($escort) {
                $langue= $escort->langues;
        
                if (is_string($langue)) {
                    $langue = array_map('trim', explode(',', $langue));
                } elseif (!is_array($langue)) {
                    $langue = [];
                }
        
                // Vérifie s’il y a une correspondance avec au moins une langue sélectionnée
                return count(array_intersect($langue, $this->selectedLangue)) > 0;
            });
        }

        return $filteredEscorts;

    }
    
    public function updated($propertyName)
    {
        // Réinitialiser la pagination à 1 lors de la modification des filtres principaux
        $filterProperties = [
            'selectedCanton',
            'selectedVille',
            'selectedGenre',
            'selectedCategories',
            'selectedServices',
            'autreFiltres',
            'approximite',
            'showClosestOnly',
            'minDistance',
            'maxDistanceSelected'
        ];
        
        if (in_array($propertyName, $filterProperties)) {
            $this->resetPage();
        }
    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return round($angle * $earthRadius, 0);
    }

    private function getValueRange(){

        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? 'FR';
            $query = User::query()
            ->where('profile_type', 'escorte')
            ->orderBy('is_profil_pause')
            ->orderByDesc('rate_activity')
            ->orderByDesc('last_activity');
        if (Auth::user()) {
            $query->where('id', '!=', Auth::user()->id);
        }
        $baseEscorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
            return $escort->isProfileVisibleTo($viewerCountry);
        });
        $this->ageMin = $baseEscorts->min('age');
        $this->ageMax = $baseEscorts->max('age');
        foreach ($baseEscorts as $escort) {
            $min = $escort->tailles; // Assure-toi que le nom de la méthode est correct
        
            if ($min > 0 && $min < $this->tailleMin) {
                $this->tailleMin = $min;
            }
        }
        
        $this->tailleMax = $baseEscorts->max('tailles');
        $this->tarifMin = $baseEscorts->min('tarif');
        $this->tarifMax = $baseEscorts->max('tarif');
    }

    public function render()
    {

        // Gestion des états mutuellement exclusifs
        if ($this->approximite && $this->showClosestOnly) {
            $this->showClosestOnly = false;
        }

        // Déterminer si le filtre canton doit être affiché
        $this->showFiltreCanton = !($this->approximite || $this->showClosestOnly);

        $currentLocale = app()->getLocale();
        $this->cantons = Cache::remember('all_cantons', 3600, function () {
            return Canton::all();
        });
        $this->availableVilles = Ville::all();
        $this->categories = Cache::remember('all_categories', 3600, function () {
            return Categorie::where('type', 'escort')->get();
        });
        $serviceQuery = Service::query();

        $this->genres = Genre::all()->take(3);

        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? 'FR'; // fallback pour dev
        $viewerLatitude = $position?->latitude ?? 0;
        $viewerLongitude = $position?->longitude ?? 0;
        $paginatedEscorts = [];

        $this->getValueRange();

        if($this->filtreIsActif()) {
            logger()->info("filtreIsActif 👍 ✅");
            $filteredEscorts = collect();
            if(!$this->showClosestOnly && !$this->approximite){
                $baseEscorts = $this->getBaseEscorts();
                $filteredEscorts = $this->filtreEscortsByCantonVilleGenreService($baseEscorts);
            }

            if ($this->showClosestOnly) {
                $baseEscortsSorted = $this->getDataEscortsClosestOnlyTest();
                $baseEscortsSorted = $baseEscortsSorted->sortBy('distance');
                $baseEscortsClosestOnly = $baseEscortsSorted->take(4);
            
                // Mise à jour des bornes de distance pour les 4 plus proches
                $this->updateDistanceBounds($baseEscortsClosestOnly);
            
                logger()->info("minDistance 👍 ✅", ["minDistance" => $this->minDistance]);
                logger()->info("maxAvailableDistance 👍 ✅", ["maxAvailableDistance" => $this->maxAvailableDistance]);
            
                // Filtrer par distance
                $baseEscortsClosestOnly = $baseEscortsClosestOnly->filter(function ($item) {
                    return $item['distance'] >= $this->minDistance && $item['distance'] <= $this->maxDistanceSelected;
                });
            
                // Filtrer par service et genre
                if ($this->selectedGenre || $this->selectedCategories || $this->selectedServices) {
                    $filteredEscorts = $this->filtreEscortsByCantonVilleGenreService($baseEscortsClosestOnly);
                } else {
                    $filteredEscorts = $baseEscortsClosestOnly;
                }
            
                $paginatedEscorts = $this->getPaginatedHydratedEscorts($filteredEscorts);
                $this->escortCount = $filteredEscorts->count();
            }
            



            $paginatedEscorts = $this->getPaginatedHydratedEscorts($filteredEscorts);
            $this->escortCount = $filteredEscorts->count();
        }else{
            logger()->info("filtreIsNotActif 👎 ❌");
            $paginatedEscorts = $this->getPaginatedHydratedEscorts($this->getBaseEscorts());
            $this->escortCount = $this->getBaseEscorts()->count();
        }

       
        $selecterCantonInfo = null;
        $selecterVilleInfo = null;
        $selecterGenreInfo = null;
        $selecterCategoriesInfo = null;
        $selecterServicesInfo = null;
        $selecterAutreFiltresInfo = null;
        if($this->selectedCanton){
            $selecterCantonInfo = Canton::find($this->selectedCanton);
        }
        if($this->selectedVille){
            $selecterVilleInfo = Ville::find($this->selectedVille);
        }
        if($this->selectedGenre){
            $selecterGenreInfo = Genre::find($this->selectedGenre);
        }
        if($this->selectedCategories){
            $selecterCategoriesInfo = Categorie::whereIn('id', $this->selectedCategories)->get();
        }
        if($this->selectedServices){
            $selecterServicesInfo = Service::whereIn('id', $this->selectedServices)->get();
        }
        $ageInterval = $this->ageInterval;
        $tailleInterval = $this->tailleInterval;
        $tarifInterval = $this->tarifInterval;

        foreach ($this->autreFiltres as $key => $value) {
            if (!empty($value)) {
                switch ($key) {
                    case 'origine':
                        $origine = $value;
                        $selecterAutreFiltresInfo['origine'] = $origine;
                        break;
                    case 'mensuration':

                        $mensuration = Mensuration::find($value);
                        $selecterAutreFiltresInfo['mensuration'] = $mensuration;
                      
                        break;
                    case 'orientation':
                        $orientation = OrientationSexuelle::find($value);
                        $selecterAutreFiltresInfo['orientation'] = $orientation;
                        break;
                    case 'couleur_yeux':
                        $couleur_yeux = CouleurYeux::find($value);
                        $selecterAutreFiltresInfo['couleur_yeux'] = $couleur_yeux;
                        break;
                    case 'couleur_cheveux':
                        $couleur_cheveux = CouleurCheveux::find($value);
                        $selecterAutreFiltresInfo['couleur_cheveux'] = $couleur_cheveux;
                        break;
                    case 'poitrine':
                        $poitrine = Poitrine::find($value);
                        $selecterAutreFiltresInfo['poitrine'] = $poitrine;
                        break;
                    case 'langues':
                        $langue = $value;
                        $selecterAutreFiltresInfo['langue'] = $langue;
                        break;
                    case 'pubis':
                        $pubis = PubisType::find($value);
                        $selecterAutreFiltresInfo['pubis'] = $pubis;
                        break;
                    case 'tatouages':
                        $tatouages = Tattoo::find($value);
                        $selecterAutreFiltresInfo['tatouages'] = $tatouages;
                        break;
                    case 'taille_poitrine':
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
                        $taille_poitrine_detail = $value;
                        $selecterAutreFiltresInfo['taille_poitrine_detail'] = $taille_poitrine_detail;
                        break;
                    case 'mobilite':
                        $mobilite = Mobilite::find($value);
                        $selecterAutreFiltresInfo['mobilite'] = $mobilite;
                        break;

                    default:
                        break;
                }
            }
        }

        $filterApplay = [
            'selectedCanton' => $selecterCantonInfo,
            'selectedVille' => $selecterVilleInfo,
            'selectedGenre' => $selecterGenreInfo,
            'selectedCategories' => $selecterCategoriesInfo,
            'selectedServices' => $selecterServicesInfo,
            'autreFiltres' => $selecterAutreFiltresInfo,
            'approximite' => $this->approximite,
            'showClosestOnly' => $this->showClosestOnly,
            'ageInterval' => $ageInterval,
            'tailleInterval' => $tailleInterval,
            'tarifInterval' => $tarifInterval,
        ];

        return view('livewire.escort-search', [
            'escorts' => $paginatedEscorts,
           'services' => $serviceQuery->simplePaginate(20, ['*'], 'servicesPage'),
            'maxDistance' => $this->maxDistance,
            'escortCount' => $this->escortCount,
            'currentLocale' => $currentLocale,
            'filterApplay' => $filterApplay,
        ]);
    }
}

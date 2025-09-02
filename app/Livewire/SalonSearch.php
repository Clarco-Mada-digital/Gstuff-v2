<?php

namespace App\Livewire;

use App\Models\Canton;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Ville;
use App\Models\NombreFille;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class SalonSearch extends Component
{
    use WithPagination;

    #[Url]
    public $selectedSalonCanton = '';
    #[Url]
    public string $selectedSalonVille = '';
    #[Url]
    public string $selectedSalonCategories = '';
    #[Url]
    public $villes = [];
    #[Url]
    public $nbFilles = '';
    public $categories;
    public $cantons;
    public $availableVilles;
    public $maxDistance = 0;
    public $salonCount = 0;
    public $nombreFilles;

    public $approximite = false;
    public $latitudeUser;
    public $longitudeUser;

    #[Url]
    public $minDistance = 0;
    #[Url]
    public $maxDistanceSelected = 0;
    public $maxAvailableDistance = 0;

    #[Url]
    public $showClosestOnly = false;

    public $showFiltreCanton = true;

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
        $this->selectedSalonCanton = '';
        $this->selectedSalonVille = '';
        $this->selectedSalonCategories = '';
        $this->villes = [];
        $this->nbFilles = '';
        $this->approximite = false;
        $this->showClosestOnly = false;
        $this->resetPage();
        $this->render();
    }

    public function chargeVille()
    {
        if (!empty($this->selectedSalonCanton)) {
            $this->villes = Ville::where('canton_id', $this->selectedSalonCanton)->get();
        } else {
            $this->villes = collect();
        }
    }

    public function updatedShowClosestOnly($value)
    {
        if ($value) {
            $this->approximite = false;
            $this->reset('minDistance');
            $this->reset('maxAvailableDistance');
            $this->reset('maxDistanceSelected');
        }
        $this->resetPage();
    }

    public function updatedMinDistance($value)
    {
        if ($value > $this->maxDistanceSelected) {
            $this->maxDistanceSelected = $value;
        }
        $this->resetPage();
    }

    public function updatedMaxDistanceSelected($value)
    {
        if ($value < $this->minDistance) {
            $this->minDistance = $value;
        }
        $this->resetPage();
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
        return $angle * $earthRadius;
    }

    public function render()
    {
        if ($this->approximite && $this->showClosestOnly) {
            $this->showClosestOnly = false;
        }

        $this->showFiltreCanton = !($this->approximite || $this->showClosestOnly);

        $this->cantons = Cache::remember('all_cantons', 3600, function () {
            return Canton::all();
        });
        
        $this->availableVilles = Ville::all();
        
        $this->categories = Cache::remember('categories_salon', 3600, function () {
            return Categorie::where('type', 'salon')->get();
        });
        
        $this->nombreFilles = Cache::remember('all_nombre_filles', 3600, function () {
            return NombreFille::all();
        });

        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? 'FR';
        $viewerLatitude = $position?->latitude ?? 0;
        $viewerLongitude = $position?->longitude ?? 0;

        $allSalons = collect();
        $salons = collect();
        if (!$this->approximite) {
            if(Auth::user()){
                $query = User::query()->where('profile_type', 'salon')->where('id', '!=', Auth::user()->id)
                ->orderBy('is_profil_pause')            // 1️⃣ Profil actif (0) avant pause (1)
                ->orderByDesc('rate_activity')          // 2️⃣ Taux d'activité élevé en premier
                ->orderByDesc('last_activity')          // 3️⃣ Activité récente ensuite
                ;
            }else{
                $query = User::query()->where('profile_type', 'salon')
                ->orderBy('is_profil_pause')            // 1️⃣ Taux d'activité élevé en premier
                ->orderByDesc('rate_activity')          // 2️⃣ Activité récente ensuite
                ->orderByDesc('last_activity')          // 3️⃣ Profil actif (0) avant pause (1)
                ;
            }

            if ($this->selectedSalonCanton) {
                $query->where('canton', $this->selectedSalonCanton);
            }

            if ($this->selectedSalonVille) {
                $query->where('ville', $this->selectedSalonVille);
            }

            // if ($this->selectedSalonCategories) {
            //     $query->where(function ($q) {
            //         foreach ($this->selectedSalonCategories as $categorie) {
            //             $q->where('categorie', 'LIKE', '%' . $categorie . '%');
            //         }
            //     });
            // }

            if ($this->selectedSalonCategories) {
                $query->where('categorie', 'LIKE', '%' . $this->selectedSalonCategories . '%');
            }
            

            // if ($this->nbFilles) {
            //     $query->where(function ($q) {
            //         foreach ($this->nbFilles as $nbFilles) {
            //             $q->Where('nombre_fille_id', $nbFilles);
            //             // $q->orWhere('nombre_fille_id', $nbFilles);
            //         }
            //     });
            //     $this->resetPage();
            // }

            if ($this->nbFilles) {
                $query->where('nombre_fille_id', $this->nbFilles);
                $this->resetPage();
            }
            

            $salons = $query->get()->filter(function ($salon) use ($viewerCountry) {
                return $salon->isProfileVisibleTo($viewerCountry);
            });

            // Si aucun résultat, chercher dans les villes proches
            if ($salons->isEmpty() && !empty($this->selectedSalonVille)) {
                $nearbyVilles = Ville::where('canton_id', $this->selectedSalonCanton)->where('id', '!=', $this->selectedSalonVille)->get();

                foreach ($nearbyVilles as $ville) {
                    $query = User::query()->where('profile_type', 'salon')->where('ville', $ville->id)
                    ->orderBy('is_profil_pause')            // 1️⃣ Taux d'activité élevé en premier
                    ->orderByDesc('rate_activity')          // 2️⃣ Activité récente ensuite
                    ->orderByDesc('last_activity')          // 3️⃣ Profil actif (0) avant pause (1)
                    ;

                    // if ($this->selectedSalonCategories) {
                    //     $query->where(function ($q) {
                    //         foreach ($this->selectedSalonCategories as $categorie) {
                    //             $q->where('categorie', 'LIKE', '%' . $categorie . '%');
                    //         }
                    //     });
                    // }

                    if ($this->selectedSalonCategories) {
                        $query->where('categorie', 'LIKE', '%' . $this->selectedSalonCategories . '%');
                    }
                    

                    // if ($this->nbFilles) {
                    //     $query->where(function ($q) {
                    //         foreach ($this->nbFilles as $nbFilles) {
                    //             $q->Where('nombre_fille_id', $nbFilles);
                    //             // $q->orWhere('nombre_fille_id', $nbFilles);
                    //         }
                    //     });
                    // }
                    if ($this->nbFilles) {
                        $query->where('nombre_fille_id', $this->nbFilles);
                        $this->resetPage();
                    }
                    

                    $salons = $query->get()->filter(function ($salon) use ($viewerCountry) {
                        return $salon->isProfileVisibleTo($viewerCountry);
                    });

                    if (!$salons->isEmpty()) {
                        break;
                    }
                }
            }

            // Compter le nombre d'escorts trouvés
            $this->salonCount = $salons->count();

            // Calculer la distance maximale
            $this->maxDistance = 0;
            foreach ($salons as $salon) {
                if ($salon->lat && $salon->lon) {
                    $distance = $this->haversineGreatCircleDistance($viewerLatitude, $viewerLongitude, $salon->lat, $salon->lon);
                    if ($distance > $this->maxDistance) {
                        $this->maxDistance = $distance;
                    }
                }
            }

            $this->maxDistance = round($this->maxDistance);

            // Convertir en pagination manuelle après filtrage
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
            $perPage = 12;
            $currentItems = $salons->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedSalons = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $salons->count(), $perPage, $currentPage, ['path' => request()->url(), 'query' => request()->query()]);

            // Hydrate relations
            foreach ($paginatedSalons as $salon) {
                $categoriesIds = !empty($salon->categorie) ? explode(',', $salon->categorie) : [];
                $salon['categorie'] = Categorie::whereIn('id', $categoriesIds)->get();
                $salon['canton'] = Canton::find($salon->canton);
                $salon['ville'] = Ville::find($salon->ville);
            }
        }

        if ($this->approximite) {
            $userLatitude = $this->latitudeUser;
            $userLongitude = $this->longitudeUser;

            if (!$userLatitude || !$userLongitude) {
                $userLatitude = $viewerLatitude;
                $userLongitude = $viewerLongitude;
            }

            // Initialiser les variables
            $minDistance = PHP_FLOAT_MAX;
            $maxAvailableDistance = 0;
            $escortCount = 0;

            if(Auth::user()){
                $salons = User::where('profile_type', 'salon')
                ->where('id', '!=', Auth::user()->id)
                ->whereNotNull('lat')
                ->whereNotNull('lon')
                ->orderBy('is_profil_pause')            // 1️⃣ Taux d'activité élevé en premier
                ->orderByDesc('rate_activity')          // 2️⃣ Activité récente ensuite
                ->orderByDesc('last_activity')          // 3️⃣ Profil actif (0) avant pause (1)
                ->get()
                ->filter(function ($salon) use ($viewerCountry) {
                    return $salon->isProfileVisibleTo($viewerCountry);
                })
                ->map(function ($salon) use ($userLatitude, $userLongitude, &$minDistance, &$maxAvailableDistance, &$salonCount) {
                    $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $salon->lat, $salon->lon);

                    // Mettre à jour les distances min et max
                    $minDistance = min($minDistance, $distance);
                    $maxAvailableDistance = max($maxAvailableDistance, $distance);

                    $salonCount++;

                    return [
                        'salon' => $salon,
                        'distance' => $distance,
                    ];
                });
            }else{
                $salons = User::where('profile_type', 'salon')
                ->whereNotNull('lat')
                ->whereNotNull('lon')
                ->orderBy('is_profil_pause')            // 1️⃣ Taux d'activité élevé en premier
                ->orderByDesc('rate_activity')          // 2️⃣ Activité récente ensuite
                ->orderByDesc('last_activity')          // 3️⃣ Profil actif (0) avant pause (1)
                ->get()
                ->filter(function ($salon) use ($viewerCountry) {
                    return $salon->isProfileVisibleTo($viewerCountry);
                })
                ->map(function ($salon) use ($userLatitude, $userLongitude, &$minDistance, &$maxAvailableDistance, &$salonCount) {
                    $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $salon->lat, $salon->lon);

                    // Mettre à jour les distances min et max
                    $minDistance = min($minDistance, $distance);
                    $maxAvailableDistance = max($maxAvailableDistance, $distance);

                    $salonCount++;

                    return [
                        'salon' => $salon,
                        'distance' => $distance,
                    ];
                });
            }

            // Mettre à jour les propriétés de la classe
            $this->minDistance = $salonCount > 0 ? $minDistance : 0;
            $this->maxAvailableDistance = $salonCount > 0 ? ceil($maxAvailableDistance) : 0;
            $this->salonCount = $salonCount;

            // Si c'est le premier chargement, initialiser maxDistanceSelected
            if (!$this->maxDistanceSelected && $salonCount > 0) {
                $this->maxDistanceSelected = $this->maxAvailableDistance;
            }

            // Filtrer par plage de distance, catégories et genre si sélectionnés
            if ($salonCount > 0) {
                $salons = $salons->filter(function ($item) {
                    // Vérifier la distance
                    $distanceMatch = $item['distance'] >= $this->minDistance && $item['distance'] <= $this->maxDistanceSelected;

                    if (!$distanceMatch) {
                        return false;
                    }

                    // Vérifier le nombre de filles si sélectionné
                    // if (!empty($this->nbFilles)) {
                    //     $salonNbFilles = $item['salon']->nombre_fille_id;
                    //     if (!in_array($salonNbFilles, $this->nbFilles)) {
                    //         return false;
                    //     }
                    // }
                    if ($this->nbFilles) {
                        $query->where('nombre_fille_id', $this->nbFilles);
                        $this->resetPage();
                    }
                    

                    // Vérifier les catégories si sélectionnées
                    // if (!empty($this->selectedSalonCategories)) {
                    //     // Convertir la catégorie de l'escort en tableau si ce n'est pas déjà le cas
                    //     $salonCategory = $item['salon']->categorie;
                    //     $salonCategories = is_array($salonCategory) ? $salonCategory : [(string) $salonCategory];

                    //     // Convertir les IDs en chaînes pour la comparaison
                    //     $salonCategories = array_map('strval', $salonCategories);
                    //     $selectedCategories = array_map('strval', $this->selectedSalonCategories);

                    //     // Vérifier s'il y a une correspondance
                    //     $hasMatchingCategory = count(array_intersect($selectedCategories, $salonCategories)) > 0;
                    //     if (!$hasMatchingCategory) {
                    //         return false;
                    //     }
                    // }

                    // Vérifier la catégorie si sélectionnée
                    if (!empty($this->selectedSalonCategories)) {
                        $salonCategory = $item['salon']->categorie;

                        // Si la catégorie du salon est un tableau, on vérifie s'il contient la sélection
                        if (is_array($salonCategory)) {
                            $salonCategories = array_map('strval', $salonCategory);
                            $selectedCategory = (string) $this->selectedSalonCategories;

                            if (!in_array($selectedCategory, $salonCategories)) {
                                return false;
                            }
                        } else {
                            // Comparaison directe si c’est une seule valeur
                            if ((string) $salonCategory !== (string) $this->selectedSalonCategories) {
                                return false;
                            }
                        }
                    }


                    return true;
                });
            }

            // Trier par distance
            $salons = $salons->sortBy('distance');
            $this->salonCount = $salons->count();

            // Convertir en pagination
            $perPage = 12;
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
            $currentItems = $salons->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedSalons = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $salons->count(), $perPage, $currentPage, ['path' => request()->url(), 'query' => request()->query()]);

            // Hydrater les relations
            foreach ($paginatedSalons as $salonData) {
                $salon = $salonData['salon'];
                $salon['categorie'] = Categorie::find($salon->categorie);
                $salon['canton'] = Canton::find($salon->canton);
                $salon['ville'] = Ville::find($salon->ville);
            }
        }

        if ($this->showClosestOnly) {
            $userLatitude = $this->latitudeUser;
            $userLongitude = $this->longitudeUser;

            if (!$userLatitude || !$userLongitude) {
                $userLatitude = $viewerLatitude;
                $userLongitude = $viewerLongitude;
            }

            // Initialiser les variables
            $minDistance = PHP_FLOAT_MAX;
            $maxAvailableDistance = 0;
            $salonCount = 0;
           
            if(Auth::user()){
                $salons = User::where('profile_type', 'salon')
                ->where('id', '!=', Auth::user()->id)
                ->whereNotNull('lat')
                ->whereNotNull('lon')
                ->orderBy('is_profil_pause')            // 1️⃣ Taux d'activité élevé en premier
                ->orderByDesc('rate_activity')          // 2️⃣ Activité récente ensuite
                ->orderByDesc('last_activity')          // 3️⃣ Profil actif (0) avant pause (1)
                ->get()
                ->filter(function ($salon) use ($viewerCountry) {
                    return $salon->isProfileVisibleTo($viewerCountry);
                })
                ->map(function ($salon) use ($userLatitude, $userLongitude, &$minDistance, &$maxAvailableDistance, &$salonCount) {
                    $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $salon->lat, $salon->lon);

                    // Mettre à jour les distances min et max
                    $minDistance = min($minDistance, $distance);
                    $maxAvailableDistance = max($maxAvailableDistance, $distance);

                    $salonCount++;

                    return [
                        'salon' => $salon,
                        'distance' => $distance,
                    ];
                });
            }else{
                $salons = User::where('profile_type', 'salon')
                ->whereNotNull('lat')
                ->whereNotNull('lon')
                ->orderBy('is_profil_pause')            // 1️⃣ Taux d'activité élevé en premier
                ->orderByDesc('rate_activity')          // 2️⃣ Activité récente ensuite
                ->orderByDesc('last_activity')          // 3️⃣ Profil actif (0) avant pause (1)
                ->get()
                ->filter(function ($salon) use ($viewerCountry) {
                    return $salon->isProfileVisibleTo($viewerCountry);
                })
                ->map(function ($salon) use ($userLatitude, $userLongitude, &$minDistance, &$maxAvailableDistance, &$salonCount) {
                    $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $salon->lat, $salon->lon);

                    // Mettre à jour les distances min et max
                    $minDistance = min($minDistance, $distance);
                    $maxAvailableDistance = max($maxAvailableDistance, $distance);

                    $salonCount++;

                    return [
                        'salon' => $salon,
                        'distance' => $distance,
                    ];
                });
            }

            if ($salonCount >= 4) {
                $salons = $salons->sortBy('distance')->take(4);
                $maxAvailableDistance = $salons->last()['distance'];
            }

            // Mettre à jour les propriétés de la classe
            $this->minDistance = $salonCount > 0 ? $minDistance : 0;
            $this->maxAvailableDistance = $salonCount > 0 ? ceil($maxAvailableDistance) : 0;
            $this->salonCount = $salonCount;

            // Si c'est le premier chargement, initialiser maxDistanceSelected
            if (!$this->maxDistanceSelected && $salonCount > 0) {
                $this->maxDistanceSelected = $this->maxAvailableDistance;
            }

            // Filtrer par plage de distance, catégories et genre si sélectionnés
            if ($salonCount > 0) {
                $salons = $salons->filter(function ($item) {
                    // Vérifier la distance
                    $distanceMatch = $item['distance'] >= $this->minDistance && $item['distance'] <= $this->maxDistanceSelected;

                    if (!$distanceMatch) {
                        return false;
                    }

                    // Vérifier les catégories si sélectionnées
                    // if (!empty($this->selectedSalonCategories)) {
                    //     $salonCategory = $item['salon']->categorie;
                    //     $salonCategories = is_array($salonCategory) ? $salonCategory : [(string) $salonCategory];

                    //     $salonCategories = array_map('strval', $salonCategories);
                    //     $selectedCategories = array_map('strval', $this->selectedSalonCategories);

                    //     $hasMatchingCategory = count(array_intersect($selectedCategories, $salonCategories)) > 0;
                    //     if (!$hasMatchingCategory) {
                    //         return false;
                    //     }
                    // }

                    // Vérifier la catégorie si sélectionnée
                    if (!empty($this->selectedSalonCategories)) {
                        $salonCategory = $item['salon']->categorie;

                        // Si la catégorie du salon est un tableau
                        if (is_array($salonCategory)) {
                            $salonCategories = array_map('strval', $salonCategory);
                            $selectedCategory = (string) $this->selectedSalonCategories;

                            if (!in_array($selectedCategory, $salonCategories)) {
                                return false;
                            }
                        } else {
                            // Comparaison directe si c’est une seule valeur
                            if ((string) $salonCategory !== (string) $this->selectedSalonCategories) {
                                return false;
                            }
                        }
                    }


                    return true;
                });
            }

            if ($salonCount >= 4) {
                $salons = $salons->sortBy('distance')->take(4);
                $this->salonCount = $salons->count();
            }

            // Convertir en collection paginée
            $perPage = 12;
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
            $currentItems = $salons->slice(0, $perPage)->values();

            $paginatedSalons = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $salons->count(), $perPage, $currentPage, ['path' => request()->url(), 'query' => request()->query()]);

            // Hydrater les relations
            foreach ($paginatedSalons as $salonData) {
                $salon = $salonData['salon'];
                $salon['categorie'] = Categorie::find($salon->categorie);
                $salon['canton'] = Canton::find($salon->canton);
                $salon['ville'] = Ville::find($salon->ville);
            }
        }



        $selecterCantonInfo = null;
        $selecterVilleInfo = null;
        $selecterCategoriesInfo = null;
        $selecterNombreFilleInfo = null;
        if($this->selectedSalonCanton){
            $selecterCantonInfo = Canton::find($this->selectedSalonCanton);
        }
        if($this->selectedSalonVille){
            $selecterVilleInfo = Ville::find($this->selectedSalonVille);
        }

        if($this->selectedSalonCategories){
            $selecterCategoriesInfo = Categorie::where('id', $this->selectedSalonCategories)->first();
        }

        
        if($this->nbFilles){
            $selecterNombreFilleInfo = NombreFille::where('id', $this->nbFilles)->get();
        }

      
        $filterApplay = [
            'selectedCanton' => $selecterCantonInfo,
            'selectedVille' => $selecterVilleInfo,
            'selectedCategories' => $selecterCategoriesInfo,
            'nbFilles' => $selecterNombreFilleInfo,
        ];

        return view('livewire.salon-search', [
            'salons' => $paginatedSalons,
            'maxDistance' => $this->maxDistance,
            'salonCount' => $this->salonCount,
            'filterApplay' => $filterApplay,
        ]);
    }
}

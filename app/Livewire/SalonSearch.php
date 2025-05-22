<?php

namespace App\Livewire;

use App\Models\Canton;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NombreFille;
use Stevebauman\Location\Facades\Location;

class SalonSearch extends Component
{
    use WithPagination;

    #[Url]
    public $selectedSalonCanton = '';
    #[Url]
    public string $selectedSalonVille = '';
    #[Url]
    public array $selectedSalonCategories = [];
    #[Url]
    public $villes = [];
    #[Url]
    public array $nbFilles = [];
    public $categories;
    public $cantons;
    public $availableVilles;
    public $maxDistance = 0;
    public $salonCount = 0; // Ajout de la propriété pour le nombre de salons trouvés
    public $nombreFilles;
    

    
    public $approximite = false;
    public $latitudeUser;
    public $longitudeUser;

    #[Url]
    public $minDistance = 0;  // Distance minimale
    #[Url]
    public $maxDistanceSelected = 0; // Distance maximale sélectionnée
    public $maxAvailableDistance = 0; // Distance maximale disponible


    public function approximiteFunc()
    {
        $this->approximite = !$this->approximite;
    }

    public function updateUserLatitude($latitude)
    {
        $this->latitudeUser = $latitude;
    }

    public function updateUserLongitude($longitude)
    {
        $this->longitudeUser = $longitude;
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


    public function resetFilter()
    {
        $this->selectedSalonCanton = '';
        $this->selectedSalonVille = '';
        $this->selectedSalonCategories = [];
        $this->villes = [];
        $this->nbFilles = [];
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

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    // public function render()
    // {
    //     $this->cantons = Canton::all();
    //     $this->availableVilles = Ville::all();
    //     $this->categories = Categorie::where('type', 'salon')->get();
    //     $this->nombreFilles = NombreFille::all();

    //     // Récupération du pays du visiteur via IP
    //     $position = Location::get(request()->ip());
    //     $viewerCountry = $position?->countryCode ?? 'FR'; // fallback utile
    //     $viewerLatitude = $position?->latitude ?? 0;
    //     $viewerLongitude = $position?->longitude ?? 0;


    //     if ($this->approximite) {
    //         // Logique de filtrage par distance
    //         $minDistance = PHP_FLOAT_MAX;
    //         $maxAvailableDistance = 0;
    //         $salonCount = 0;
    
    //         $salons = User::where('profile_type', 'salon')
    //             ->whereNotNull('lat')
    //             ->whereNotNull('lon')
    //             ->get()
    //             ->filter(function ($salon) use ($viewerCountry) {
    //                 return $salon->isProfileVisibleTo($viewerCountry);
    //             })
    //             ->map(function ($salon) use ($viewerLatitude, $viewerLongitude, &$minDistance, &$maxAvailableDistance, &$salonCount) {
    //                 $distance = $this->haversineGreatCircleDistance(
    //                     $viewerLatitude,
    //                     $viewerLongitude,
    //                     $salon->lat,
    //                     $salon->lon
    //                 );
                    
    //                 $minDistance = min($minDistance, $distance);
    //                 $maxAvailableDistance = max($maxAvailableDistance, $distance);
    //                 $salonCount++;
                    
    //                 return [
    //                     'salon' => $salon,
    //                     'distance' => $distance,
    //                 ];
    //             });
    
    //         $this->minDistance = $salonCount > 0 ? floor($minDistance) : 0;
    //         $this->maxAvailableDistance = $salonCount > 0 ? ceil($maxAvailableDistance) : 0;
    //         $this->salonCount = $salonCount;
    
    //         if (!$this->maxDistanceSelected && $salonCount > 0) {
    //             $this->maxDistanceSelected = $this->maxAvailableDistance;
    //         }
    
    //         if ($salonCount > 0) {
    //             $salons = $salons->filter(function ($item) {
    //                 return $item['distance'] >= $this->minDistance && 
    //                        $item['distance'] <= $this->maxDistanceSelected;
    //             });
    //         }
    
    //         $salons = $salons->sortBy('distance');
    //     } else {
    //         $query = User::query()->where('profile_type', 'salon');

    //     if ($this->selectedSalonCanton) {
    //         $query->where('canton', 'LIKE', '%' . $this->selectedSalonCanton . '%');
    //         $this->resetPage();
    //     }

    //     if ($this->selectedSalonVille != '') {
    //         $query->where('ville', 'LIKE', '%' . $this->selectedSalonVille . '%');
    //         $this->resetPage();
    //     }

    //     if ($this->nbFilles) {
    //         $query->where(function ($q) {
    //             foreach ($this->nbFilles as $nbFilles) {
    //                 $q->orWhere('nombre_fille_id', $nbFilles);
    //             }
    //         });
    //         $this->resetPage();
    //     }

    //     if ($this->selectedSalonCategories) {
    //         $query->where(function ($q) {
    //             foreach ($this->selectedSalonCategories as $categorie) {
    //                 $q->orWhere('categorie', 'LIKE', '%' . $categorie . '%');
    //             }
    //         });
    //         $this->resetPage();
    //     }

    //     // Obtenir tous les salons et filtrer par pays
    //     $allSalons = $query->get()->filter(function ($salon) use ($viewerCountry) {
    //         return $salon->isProfileVisibleTo($viewerCountry);
    //     });

    //     // Si aucun résultat, chercher dans les villes proches
    //     if ($allSalons->isEmpty() && !empty($this->selectedSalonVille)) {
    //         $nearbyVilles = Ville::where('canton_id', $this->selectedSalonCanton)
    //             ->where('id', '!=', $this->selectedSalonVille)
    //             ->get();

    //         foreach ($nearbyVilles as $ville) {
    //             $query = User::query()->where('profile_type', 'salon')
    //                 ->where('ville', $ville->id);

    //             if ($this->nbFilles) {
    //                 $query->where(function ($q) {
    //                     foreach ($this->nbFilles as $nbFilles) {
    //                         $q->orWhere('nombre_fille_id', $nbFilles);
    //                     }
    //                 });
    //             }

    //             if ($this->selectedSalonCategories) {
    //                 $query->where(function ($q) {
    //                     foreach ($this->selectedSalonCategories as $categorie) {
    //                         $q->orWhere('categorie', 'LIKE', '%' . $categorie . '%');
    //                     }
    //                 });
    //             }

    //             $allSalons = $query->get()->filter(function ($salon) use ($viewerCountry) {
    //                 return $salon->isProfileVisibleTo($viewerCountry);
    //             });

    //             if (!$allSalons->isEmpty()) {
    //                 break;
    //             }
    //         }
    //     }

    //     // Compter le nombre de salons trouvés
    //     $this->salonCount = $allSalons->count();

    //     // Calculer la distance maximale
    //     $this->maxDistance = 0;
    //     foreach ($allSalons as $salon) {
    //         if ($salon->lat && $salon->lon) {
    //             $distance = $this->haversineGreatCircleDistance(
    //                 $viewerLatitude,
    //                 $viewerLongitude,
    //                 $salon->lat,
    //                 $salon->lon
    //             );
    //             if ($distance > $this->maxDistance) {
    //                 $this->maxDistance = $distance;
    //             }
    //         }
    //     }
    //     $this->maxDistance = round($this->maxDistance);
    //     }

    //     // Pagination manuelle
    //     $currentPage = Paginator::resolveCurrentPage();
    //     $perPage = 10;
    //     $currentItems = $allSalons->slice(($currentPage - 1) * $perPage, $perPage)->values();
    //     $paginatedSalons = new LengthAwarePaginator(
    //         $currentItems,
    //         $allSalons->count(),
    //         $perPage,
    //         $currentPage,
    //         ['path' => request()->url(), 'query' => request()->query()]
    //     );

    //     // Hydrate les champs manuellement
    //     foreach ($paginatedSalons as $salon) {
    //         $salon['categorie'] = Categorie::find($salon->categorie);
    //         $salon['canton'] = Canton::find($salon->canton);
    //         $salon['ville'] = Ville::find($salon->ville);
    //     }

    //     return view('livewire.salon-search', [
    //         'salons' => $paginatedSalons,
    //         'maxDistance' => $this->approximite ? $this->maxAvailableDistance : $this->maxDistance,
    //         'salonCount' => $this->salonCount,
    //         'minDistance' => $this->minDistance,
    //         'maxAvailableDistance' => $this->maxAvailableDistance,
    //     ]);
    // }

    public function render()
{
    $this->cantons = Canton::all();
    $this->availableVilles = Ville::all();
    $this->categories = Categorie::where('type', 'salon')->get();
    $this->nombreFilles = NombreFille::all();

    // Récupération du pays du visiteur via IP
    $position = Location::get(request()->ip());
    $viewerCountry = $position?->countryCode ?? 'FR'; // fallback utile
    $viewerLatitude = $position?->latitude ?? 0;
    $viewerLongitude = $position?->longitude ?? 0;

    // Déclarer les variables en dehors des conditions
    $allSalons = collect();
    $salons = collect();

    if ($this->approximite) {
        // Logique de filtrage par distance
        $minDistance = PHP_FLOAT_MAX;
        $maxAvailableDistance = 0;
        $salonCount = 0;

        $salons = User::where('profile_type', 'salon')
            ->whereNotNull('lat')
            ->whereNotNull('lon')
            ->get()
            ->filter(function ($salon) use ($viewerCountry) {
                return $salon->isProfileVisibleTo($viewerCountry);
            })
            ->map(function ($salon) use ($viewerLatitude, $viewerLongitude, &$minDistance, &$maxAvailableDistance, &$salonCount) {
                $distance = $this->haversineGreatCircleDistance(
                    $viewerLatitude,
                    $viewerLongitude,
                    $salon->lat,
                    $salon->lon
                );
                
                $minDistance = min($minDistance, $distance);
                $maxAvailableDistance = max($maxAvailableDistance, $distance);
                $salonCount++;
                
                return [
                    'salon' => $salon,
                    'distance' => $distance,
                ];
            });
        

        $this->minDistance = $salonCount > 0 ? $minDistance : 0;
        $this->maxAvailableDistance = $salonCount > 0 ? ceil($maxAvailableDistance) : 0;
        $this->salonCount = $salonCount;

        if (!$this->maxDistanceSelected && $salonCount > 0) {
            $this->maxDistanceSelected = $this->maxAvailableDistance;
        }

        if ($salonCount > 0) {
            $salons = $salons->filter(function ($item) {
                return $item['distance'] <= $this->maxDistanceSelected;
            });
            $salons = $salons->sortBy('distance');
        }

        $allSalons = $salons->values();
        
    } else {
        $query = User::query()->where('profile_type', 'salon');

        if ($this->selectedSalonCanton) {
            $query->where('canton', 'LIKE', '%' . $this->selectedSalonCanton . '%');
            $this->resetPage();
        }

        if ($this->selectedSalonVille != '') {
            $query->where('ville', 'LIKE', '%' . $this->selectedSalonVille . '%');
            $this->resetPage();
        }

        if ($this->nbFilles) {
            $query->where(function ($q) {
                foreach ($this->nbFilles as $nbFilles) {
                    $q->orWhere('nombre_fille_id', $nbFilles);
                }
            });
            $this->resetPage();
        }

        if ($this->selectedSalonCategories) {
            $query->where(function ($q) {
                foreach ($this->selectedSalonCategories as $categorie) {
                    $q->orWhere('categorie', 'LIKE', '%' . $categorie . '%');
                }
            });
            $this->resetPage();
        }

        // Obtenir tous les salons et filtrer par pays
        $allSalons = $query->get()->filter(function ($salon) use ($viewerCountry) {
            return $salon->isProfileVisibleTo($viewerCountry);
        });

        // Si aucun résultat, chercher dans les villes proches
        if ($allSalons->isEmpty() && !empty($this->selectedSalonVille)) {
            $nearbyVilles = Ville::where('canton_id', $this->selectedSalonCanton)
                ->where('id', '!=', $this->selectedSalonVille)
                ->get();

            foreach ($nearbyVilles as $ville) {
                $query = User::query()->where('profile_type', 'salon')
                    ->where('ville', $ville->id);

                if ($this->nbFilles) {
                    $query->where(function ($q) {
                        foreach ($this->nbFilles as $nbFilles) {
                            $q->orWhere('nombre_fille_id', $nbFilles);
                        }
                    });
                }

                if ($this->selectedSalonCategories) {
                    $query->where(function ($q) {
                        foreach ($this->selectedSalonCategories as $categorie) {
                            $q->orWhere('categorie', 'LIKE', '%' . $categorie . '%');
                        }
                    });
                }

                $allSalons = $query->get()->filter(function ($salon) use ($viewerCountry) {
                    return $salon->isProfileVisibleTo($viewerCountry);
                });

                if (!$allSalons->isEmpty()) {
                    break;
                }
            }
        }

        // Compter le nombre de salons trouvés
        $this->salonCount = $allSalons->count();

        // Calculer la distance maximale
        $this->maxDistance = 0;
        foreach ($allSalons as $salon) {
            if ($salon->lat && $salon->lon) {
                $distance = $this->haversineGreatCircleDistance(
                    $viewerLatitude,
                    $viewerLongitude,
                    $salon->lat,
                    $salon->lon
                );
                if ($distance > $this->maxDistance) {
                    $this->maxDistance = $distance;
                }
            }
        }
        $this->maxDistance = round($this->maxDistance);
    }

    // Pagination manuelle
    $currentPage = Paginator::resolveCurrentPage();
    $perPage = 10;
    $currentItems = $allSalons->slice(($currentPage - 1) * $perPage, $perPage)->values();
    $paginatedSalons = new LengthAwarePaginator(
        $currentItems,
        $allSalons->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    // Hydrate les champs manuellement
    foreach ($paginatedSalons as $salon) {
        $salonData = is_array($salon) ? $salon['salon'] : $salon;
        $salon['categorie'] = Categorie::find($salonData->categorie);
        $salon['canton'] = Canton::find($salonData->canton);
        $salon['ville'] = Ville::find($salonData->ville);
    }

    return view('livewire.salon-search', [
        'salons' => $paginatedSalons,
        'maxDistance' => $this->approximite ? $this->maxAvailableDistance : $this->maxDistance,
        'salonCount' => $this->salonCount,
        'minDistance' => $this->minDistance,
        'maxAvailableDistance' => $this->maxAvailableDistance,
    ]);
}
}

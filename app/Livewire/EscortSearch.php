<?php

// namespace App\Livewire;

// use Livewire\Attributes\Url;
// use App\Models\Canton;
// use App\Models\Categorie;
// use App\Models\Service;
// use App\Models\User;
// use App\Models\Ville;
// use Livewire\Component;
// use Livewire\WithPagination;
// use Stevebauman\Location\Facades\Location;

// class EscortSearch extends Component
// {
//   use WithPagination;
  
//   #[Url]
//   public string $selectedCanton = '';
//   #[Url]
//   public string $selectedVille = '';
//   #[Url]
//   public string $selectedGenre = '';
//   #[Url]
//   public array $selectedCategories = [];
//   #[Url]
//   public array $selectedServices = [];

//   public array $autreFiltres = [];
//   public $categories;
//   public $cantons;
//   public $availableVilles;
//   public $villes = [];

//   private function getEscorts($escorts)
//   {
//      // Détection du pays via IP
//      $position = \Stevebauman\Location\Facades\Location::get(request()->ip());
//      $viewerCountry = $position?->countryCode ?? 'FR'; // fallback pour dev
 
//      return $escorts->filter(function ($escort) use ($viewerCountry) {
//          return $escort->isProfileVisibleTo($viewerCountry);
//      });
//   }

//   public function resetFilter()
//   {      
//     $this->selectedCanton = '';
//     $this->selectedVille = '';
//     $this->selectedGenre = '';
//     $this->selectedCategories = [];
//     $this->selectedServices = [];
//     $this->autreFiltres = [];
//     $this->resetPage();
//     $this->render();
//   }

//   public function chargeVille()
//   {
//     if(!empty($this->selectedCanton)){
//       $this->villes = Ville::where('canton_id', $this->selectedCanton)->get();
//     }else{
//       $this->villes = collect();
//     }
//   }

//   public function render()
//   {
//       $this->cantons = Canton::all();
//       $this->availableVilles = Ville::all();
//       $this->categories = Categorie::where('type', 'escort')->get();
//       $serviceQuery = Service::query();
  
//       // Détection du pays via IP
//       $position = Location::get(request()->ip());
//       $viewerCountry = $position?->countryCode ?? null; // fallback pour le dev
  
//       // Construction de la requête
//       $query = User::query()->where('profile_type', 'escorte');
  
//       if ($this->selectedCanton) {
//           $query->where('canton', $this->selectedCanton);
//       }
  
//       if ($this->selectedVille) {
//           $query->where('ville', $this->selectedVille);
//       }
  
//       if ($this->selectedGenre) {
//           $query->where('genre', $this->selectedGenre);
//       }
  
//       if ($this->selectedCategories){
//           $query->where(function ($q) {
//               foreach ($this->selectedCategories as $categorie) {
//                   $q->where('categorie', 'LIKE', '%' . $categorie . '%');
//               }
//           });
//       }
  
//       if ($this->selectedServices){
//           $query->where(function ($q) {
//               foreach ($this->selectedServices as $service) {
//                   $q->where('service', 'LIKE', '%' . $service . '%');
//               }
//           });
//       }
  
//       if ($this->autreFiltres){
//           $query->where(function ($q) {
//               foreach ($this->autreFiltres as $key => $value) {
//                   $q->where($key, 'LIKE', '%' . $value . '%');
//               }
//           });
//       }
  
//       // Récupération des escorts paginées
//       $escorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
//           return $escort->isProfileVisibleTo($viewerCountry);
//       });
  
//       // Convertir en pagination manuelle après filtrage
//       $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
//       $perPage = 10;
//       $currentItems = $escorts->slice(($currentPage - 1) * $perPage, $perPage)->values();
//       $paginatedEscorts = new \Illuminate\Pagination\LengthAwarePaginator(
//           $currentItems,
//           $escorts->count(),
//           $perPage,
//           $currentPage,
//           ['path' => request()->url(), 'query' => request()->query()]
//       );
  
//       // Hydrate relations
//       foreach ($paginatedEscorts as $escort) {
//           $escort['categorie'] = Categorie::find($escort->categorie);
//           $escort['canton'] = Canton::find($escort->canton);
//           $escort['ville'] = Ville::find($escort->ville);
//       }
  
//       return view('livewire.escort-search', [
//           'escorts' => $paginatedEscorts,
//           'services' => $serviceQuery->paginate(20),
//       ]);
//   }
  
// }



// namespace App\Livewire;

// use Livewire\Attributes\Url;
// use App\Models\Canton;
// use App\Models\Categorie;
// use App\Models\Service;
// use App\Models\User;
// use App\Models\Ville;
// use Livewire\Component;
// use Livewire\WithPagination;
// use Stevebauman\Location\Facades\Location;

// class EscortSearch extends Component
// {
//     use WithPagination;

//     #[Url]
//     public string $selectedCanton = '';
//     #[Url]
//     public string $selectedVille = '';
//     #[Url]
//     public string $selectedGenre = '';
//     #[Url]
//     public array $selectedCategories = [];
//     #[Url]
//     public array $selectedServices = [];

//     public array $autreFiltres = [];
//     public $categories;
//     public $cantons;
//     public $availableVilles;
//     public $villes = [];
//     public $maxDistance = 0;
//     public $escortCount = 0;

//     private function getEscorts($escorts)
//     {
//         // Détection du pays via IP
//         $position = \Stevebauman\Location\Facades\Location::get(request()->ip());
//         $viewerCountry = $position?->countryCode ?? 'FR'; // fallback pour dev
        
//         return $escorts->filter(function ($escort) use ($viewerCountry) {
//             return $escort->isProfileVisibleTo($viewerCountry);
//         });
//     }

//     public function resetFilter()
//     {
//         $this->selectedCanton = '';
//         $this->selectedVille = '';
//         $this->selectedGenre = '';
//         $this->selectedCategories = [];
//         $this->selectedServices = [];
//         $this->autreFiltres = [];
//         $this->resetPage();
//         $this->render();
//     }

//     public function chargeVille()
//     {
//         if (!empty($this->selectedCanton)) {
   
//             $this->villes = Ville::where('canton_id', $this->selectedCanton)->get();
//         } else {
//             $this->villes = collect();
//         }
//     }

//     private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
//     {
//         // convert from degrees to radians
//         $latFrom = deg2rad($latitudeFrom);
//         $lonFrom = deg2rad($longitudeFrom);
//         $latTo = deg2rad($latitudeTo);
//         $lonTo = deg2rad($longitudeTo);

//         $latDelta = $latTo - $latFrom;
//         $lonDelta = $lonTo - $lonFrom;

//         $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
//             cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
//         return $angle * $earthRadius;
//     }

//     public function render()
//     {
//         $this->cantons = Canton::all();
//         $this->availableVilles = Ville::all();
//         $this->categories = Categorie::where('type', 'escort')->get();
//         $serviceQuery = Service::query();

//         // Détection du pays via IP
//         $position = Location::get(request()->ip());
//         $viewerCountry = $position?->countryCode ?? null; // fallback pour le dev
//         $viewerLatitude = $position?->latitude ?? 0;
//         $viewerLongitude = $position?->longitude ?? 0;

//         // Construction de la requête
//         $query = User::query()->where('profile_type', 'escorte')
//             ->whereNotNull('lat') // Ajout de la condition pour vérifier la présence de la latitude
//             ->whereNotNull('lon'); // Ajout de la condition pour vérifier la présence de la longitude

//         if ($this->selectedCanton) {
//             $query->where('canton', $this->selectedCanton);
//         }

//         if ($this->selectedVille) {
//             $query->where('ville', $this->selectedVille);
//         }

//         if ($this->selectedGenre) {
//             $query->where('genre', $this->selectedGenre);
//         }

//         if ($this->selectedCategories) {
//             $query->where(function ($q) {
//                 foreach ($this->selectedCategories as $categorie) {
//                     $q->where('categorie', 'LIKE', '%' . $categorie . '%');
//                 }
//             });
//         }

//         if ($this->selectedServices) {
//             $query->where(function ($q) {
//                 foreach ($this->selectedServices as $service) {
//                     $q->where('service', 'LIKE', '%' . $service . '%');
//                 }
//             });
//         }

//         if ($this->autreFiltres) {
//             $query->where(function ($q) {
//                 foreach ($this->autreFiltres as $key => $value) {
//                     $q->where($key, 'LIKE', '%' . $value . '%');
//                 }
//             });
//         }

//         // Récupération des escorts paginées
//         $escorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
//             return $escort->isProfileVisibleTo($viewerCountry);
//         });

//         // Compter le nombre d'escorts trouvés
//         $this->escortCount = $escorts->count();

//         // Calculer la distance maximale
//         $this->maxDistance = 0;
//         foreach ($escorts as $escort) {
//             $distance = $this->haversineGreatCircleDistance(
//                 $viewerLatitude,
//                 $viewerLongitude,
//                 $escort->lat,
//                 $escort->lon
//             );
//             if ($distance > $this->maxDistance) {
//                 $this->maxDistance = $distance;
//             }
//         }
//         $this->maxDistance = round($this->maxDistance);

//         // Convertir en pagination manuelle après filtrage
//         $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
//         $perPage = 10;
//         $currentItems = $escorts->slice(($currentPage - 1) * $perPage, $perPage)->values();
//         $paginatedEscorts = new \Illuminate\Pagination\LengthAwarePaginator(
//             $currentItems,
//             $escorts->count(),
//             $perPage,
//             $currentPage,
//             ['path' => request()->url(), 'query' => request()->query()]
//         );

//         // Hydrate relations
//         foreach ($paginatedEscorts as $escort) {
//             $escort['categorie'] = Categorie::find($escort->categorie);
//             $escort['canton'] = Canton::find($escort->canton);
//             $escort['ville'] = Ville::find($escort->ville);
//         }

//         return view('livewire.escort-search', [
//             'escorts' => $paginatedEscorts,
//             'services' => $serviceQuery->paginate(20),
//             'maxDistance' => $this->maxDistance,
//             'escortCount' => $this->escortCount,
//         ]);
//     }
// }


namespace App\Livewire;

use Livewire\Attributes\Url;
use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\User;
use App\Models\Ville;
use Livewire\Component;
use Livewire\WithPagination;
use Stevebauman\Location\Facades\Location;

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

    public array $autreFiltres = [];
    public $categories;
    public $cantons;
    public $availableVilles;
    public $villes = [];
    public $maxDistance = 0;
    public $escortCount = 0;

    private function getEscorts($escorts)
    {
        // Détection du pays via IP
        $position = \Stevebauman\Location\Facades\Location::get(request()->ip());

        $viewerCountry = $position?->countryCode ?? 'FR'; // fallback pour dev


        return $escorts->filter(function ($escort) use ($viewerCountry) {
            return $escort->isProfileVisibleTo($viewerCountry);
        });
    }

    public function resetFilter()
    {
        $this->selectedCanton = '';
        $this->selectedVille = '';
        $this->selectedGenre = '';
        $this->selectedCategories = [];
        $this->selectedServices = [];
        $this->autreFiltres = [];
        $this->resetPage();
        $this->render();
    }

    public function chargeVille()
    {
        if (!empty($this->selectedCanton)) {
            // dd($this->selectedCanton);
            $this->villes = Ville::where('canton_id', $this->selectedCanton)->get();
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

    public function render()
    {
        $this->cantons = Canton::all();
        $this->availableVilles = Ville::all();
        $this->categories = Categorie::where('type', 'escort')->get();
        $serviceQuery = Service::query();

        // Détection du pays via IP
        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? null; // fallback pour le dev
        $viewerLatitude = $position?->latitude ?? 0;
        $viewerLongitude = $position?->longitude ?? 0;

        // Construction de la requête
        $query = User::query()->where('profile_type', 'escorte');

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
            $query->where(function ($q) {
                foreach ($this->selectedCategories as $categorie) {
                    $q->where('categorie', 'LIKE', '%' . $categorie . '%');
                }
            });
        }

        if ($this->selectedServices) {
            $query->where(function ($q) {
                foreach ($this->selectedServices as $service) {
                    $q->where('service', 'LIKE', '%' . $service . '%');
                }
            });
        }

        if ($this->autreFiltres) {
            $query->where(function ($q) {
                foreach ($this->autreFiltres as $key => $value) {
                    $q->where($key, 'LIKE', '%' . $value . '%');
                }
            });
        }

        // Récupération des escorts paginées
        $escorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
            return $escort->isProfileVisibleTo($viewerCountry);
        });

        // Si aucun résultat, chercher dans les villes proches
        if ($escorts->isEmpty() && !empty($this->selectedVille)) {
            $nearbyVilles = Ville::where('canton_id', $this->selectedCanton)
                ->where('id', '!=', $this->selectedVille)
                ->get();

            foreach ($nearbyVilles as $ville) {
                $query = User::query()->where('profile_type', 'escorte')
                    ->where('ville', $ville->id);

                if ($this->selectedGenre) {
                    $query->where('genre', $this->selectedGenre);
                }

                if ($this->selectedCategories) {
                    $query->where(function ($q) {
                        foreach ($this->selectedCategories as $categorie) {
                            $q->where('categorie', 'LIKE', '%' . $categorie . '%');
                        }
                    });
                }

                if ($this->selectedServices) {
                    $query->where(function ($q) {
                        foreach ($this->selectedServices as $service) {
                            $q->where('service', 'LIKE', '%' . $service . '%');
                        }
                    });
                }

                if ($this->autreFiltres) {
                    $query->where(function ($q) {
                        foreach ($this->autreFiltres as $key => $value) {
                            $q->where($key, 'LIKE', '%' . $value . '%');
                        }
                    });
                }

                $escorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
                    return $escort->isProfileVisibleTo($viewerCountry);
                });

                if (!$escorts->isEmpty()) {
                    break;
                }
            }
        }

        // Compter le nombre d'escorts trouvés
        $this->escortCount = $escorts->count();

        // Calculer la distance maximale
        $this->maxDistance = 0;
        foreach ($escorts as $escort) {
            if ($escort->lat && $escort->lon) {
                $distance = $this->haversineGreatCircleDistance(
                    $viewerLatitude,
                    $viewerLongitude,
                    $escort->lat,
                    $escort->lon
                );
                if ($distance > $this->maxDistance) {
                    $this->maxDistance = $distance;
                }
            }
        }
        $this->maxDistance = round($this->maxDistance);

        // Convertir en pagination manuelle après filtrage
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $escorts->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedEscorts = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $escorts->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Hydrate relations
        foreach ($paginatedEscorts as $escort) {
            $escort['categorie'] = Categorie::find($escort->categorie);
            $escort['canton'] = Canton::find($escort->canton);
            $escort['ville'] = Ville::find($escort->ville);
        }

        return view('livewire.escort-search', [
            'escorts' => $paginatedEscorts,
            'services' => $serviceQuery->paginate(20),
            'maxDistance' => $this->maxDistance,
            'escortCount' => $this->escortCount,
        ]);
    }
}

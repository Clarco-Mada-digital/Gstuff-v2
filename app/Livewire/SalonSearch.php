<?php

// namespace App\Livewire;

// use App\Models\Canton;
// use App\Models\Categorie;
// use App\Models\User;
// use App\Models\Ville;
// use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Pagination\Paginator;
// use Livewire\Attributes\Url;
// use Livewire\Component;
// use Livewire\WithPagination;
// use Stevebauman\Location\Facades\Location;

// class SalonSearch extends Component
// {
//   use WithPagination;
  
//   #[Url]
//   public $selectedSalonCanton = '';
//   #[Url]
//   public string $selectedSalonVille = '';
//   #[Url]
//   public array $selectedSalonCategories = [];
//   #[Url]
//   public $villes = [];
//   #[Url]
//   public array $nbFilles = [];
//   public $categories;
//   public $cantons;
//   public $availableVilles;

//   public function resetFilter()
//   {      
//     $this->selectedSalonCanton = '';
//     $this->selectedSalonVille = '';
//     $this->selectedSalonCategories = [];
//     $this->villes = [];
//     $this->nbFilles = [];
//     $this->render();
//   }

//   public function chargeVille()
//   {
//     if(!empty($this->selectedSalonCanton)){
//       $this->villes = Ville::where('canton_id', $this->selectedSalonCanton)->get();
//     }else{
//       $this->villes = collect();
//     }
//   }

//   public function render()
//   {
//       $this->cantons = Canton::all();
//       $this->availableVilles = Ville::all();
//       $this->categories = Categorie::where('type', 'salon')->get();
  
//       // Récupération du pays du visiteur via IP
//       $position = Location::get(request()->ip());
//       $viewerCountry = $position?->countryCode ?? null; // fallback utile
  
//       $query = User::query()->where('profile_type', 'salon');
  
//       if ($this->selectedSalonCanton) {
//           $query->where('canton', 'LIKE', '%' . $this->selectedSalonCanton . '%');
//           $this->resetPage();
//       }
  
//       if ($this->selectedSalonVille != '') {
//           $query->where('ville', 'LIKE', '%' . $this->selectedSalonVille . '%');
//           $this->resetPage();
//       }
  
//       if ($this->nbFilles) {
//           $query->where(function ($q) {
//               foreach ($this->nbFilles as $nbFilles) {
//                   $q->orWhere('nombre_filles', $nbFilles);
//               }
//           });
//           $this->resetPage();
//       }
  
//       if ($this->selectedSalonCategories) {
//           $query->where(function ($q) {
//               foreach ($this->selectedSalonCategories as $categorie) {
//                   $q->orWhere('categorie', 'LIKE', '%' . $categorie . '%');
//               }
//           });
//           $this->resetPage();
//       }
  
//       // Obtenir tous les salons et filtrer par pays
//       $allSalons = $query->get()->filter(function ($salon) use ($viewerCountry) {
//           return $salon->isProfileVisibleTo($viewerCountry);
//       });
  
//       // Pagination manuelle
//       $currentPage = Paginator::resolveCurrentPage();
//       $perPage = 10;
//       $currentItems = $allSalons->slice(($currentPage - 1) * $perPage, $perPage)->values();
//       $paginatedSalons = new LengthAwarePaginator(
//           $currentItems,
//           $allSalons->count(),
//           $perPage,
//           $currentPage,
//           ['path' => request()->url(), 'query' => request()->query()]
//       );
  
//       // Hydrate les champs manuellement
//       foreach ($paginatedSalons as $salon) {
//           $salon['categorie'] = Categorie::find($salon->categorie);
//           $salon['canton'] = Canton::find($salon->canton);
//           $salon['ville'] = Ville::find($salon->ville);
//       }
  
//       return view('livewire.salon-search', [
//           'salons' => $paginatedSalons,
//       ]);
//   }
// }


// namespace App\Livewire;

// use App\Models\Canton;
// use App\Models\Categorie;
// use App\Models\User;
// use App\Models\Ville;
// use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Pagination\Paginator;
// use Livewire\Attributes\Url;
// use Livewire\Component;
// use Livewire\WithPagination;
// use Stevebauman\Location\Facades\Location;

// class SalonSearch extends Component
// {
//     use WithPagination;

//     #[Url]
//     public $selectedSalonCanton = '';
//     #[Url]
//     public string $selectedSalonVille = '';
//     #[Url]
//     public array $selectedSalonCategories = [];
//     #[Url]
//     public $villes = [];
//     #[Url]
//     public array $nbFilles = [];
//     public $categories;
//     public $cantons;
//     public $availableVilles;

//     public function resetFilter()
//     {
//         $this->selectedSalonCanton = '';
//         $this->selectedSalonVille = '';
//         $this->selectedSalonCategories = [];
//         $this->villes = [];
//         $this->nbFilles = [];
//         $this->render();
//     }

//     public function chargeVille()
//     {
//         if (!empty($this->selectedSalonCanton)) {
//             $this->villes = Ville::where('canton_id', $this->selectedSalonCanton)->get();
//         } else {
//             $this->villes = collect();
//         }
//     }

//     public function render()
//     {
//         $this->cantons = Canton::all();
//         $this->availableVilles = Ville::all();
//         $this->categories = Categorie::where('type', 'salon')->get();

//         // Récupération du pays et des coordonnées du visiteur via IP
//         $position = Location::get(request()->ip());
//         $viewerCountry = $position?->countryCode ?? null;
//         $viewerLatitude = $position?->latitude ?? null;
//         $viewerLongitude = $position?->longitude ?? null;

//         $query = User::query()->where('profile_type', 'salon');

//         if ($this->selectedSalonCanton) {
//             $query->where('canton', 'LIKE', '%' . $this->selectedSalonCanton . '%');
//             $this->resetPage();
//         }

//         if ($this->selectedSalonVille != '') {
//             $query->where('ville', 'LIKE', '%' . $this->selectedSalonVille . '%');
//             $this->resetPage();
//         }

//         if ($this->nbFilles) {
//             $query->where(function ($q) {
//                 foreach ($this->nbFilles as $nbFilles) {
//                     $q->orWhere('nombre_filles', $nbFilles);
//                 }
//             });
//             $this->resetPage();
//         }

//         if ($this->selectedSalonCategories) {
//             $query->where(function ($q) {
//                 foreach ($this->selectedSalonCategories as $categorie) {
//                     $q->orWhere('categorie', 'LIKE', '%' . $categorie . '%');
//                 }
//             });
//             $this->resetPage();
//         }

//         // Initialisation des variables pour le rayon et le nombre de salons trouvés
//         $radius = 10; // Commencer avec un rayon de 10 km
//         $minSalons = 10; // Nombre minimum de salons à trouver
//         $foundSalons = collect();

//         // Augmenter le rayon jusqu'à ce que le nombre minimum de salons soit trouvé
//         while ($foundSalons->count() < $minSalons && $radius <= 100) { // Limiter le rayon à 100 km pour éviter des boucles infinies
//             $allSalons = $query->get()->filter(function ($salon) use ($viewerCountry, $viewerLatitude, $viewerLongitude, $radius) {
//                 if (!$salon->isProfileVisibleTo($viewerCountry)) {
//                     return false;
//                 }

//                 // Calculer la distance entre l'utilisateur et le salon
//                 if ($viewerLatitude && $viewerLongitude && $salon->latitude && $salon->longitude) {
//                     $distance = $this->calculateDistance(
//                         $viewerLatitude,
//                         $viewerLongitude,
//                         $salon->latitude,
//                         $salon->longitude
//                     );
//                     return $distance <= $radius;
//                 }

//                 return true;
//             });

//             $foundSalons = $allSalons;
//             $radius += 10; // Augmenter le rayon de 10 km à chaque itération
//         }

//         // Pagination manuelle
//         $currentPage = Paginator::resolveCurrentPage();
//         $perPage = 10;
//         $currentItems = $foundSalons->slice(($currentPage - 1) * $perPage, $perPage)->values();
//         $paginatedSalons = new LengthAwarePaginator(
//             $currentItems,
//             $foundSalons->count(),
//             $perPage,
//             $currentPage,
//             ['path' => request()->url(), 'query' => request()->query()]
//         );

//         // Hydrate les champs manuellement
//         foreach ($paginatedSalons as $salon) {
//             $salon['categorie'] = Categorie::find($salon->categorie);
//             $salon['canton'] = Canton::find($salon->canton);
//             $salon['ville'] = Ville::find($salon->ville);
//         }

//         // Retourner les salons paginés et les informations supplémentaires
//         return view('livewire.salon-search', [
//             'salons' => $paginatedSalons,
//             'totalSalons' => $foundSalons->count(),
//             'searchRadius' => $radius - 10, // Retourner le rayon utilisé pour trouver les salons
//         ]);
//     }

//     // Méthode pour calculer la distance entre deux points géographiques
//     private function calculateDistance($lat1, $lon1, $lat2, $lon2)
//     {
//         $earthRadius = 6371; // Rayon de la Terre en kilomètres

//         $dLat = deg2rad($lat2 - $lat1);
//         $dLon = deg2rad($lon2 - $lon1);

//         $a = sin($dLat / 2) * sin($dLat / 2) +
//              cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
//              sin($dLon / 2) * sin($dLon / 2);

//         $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

//         return $earthRadius * $c;
//     }
// }


// namespace App\Livewire;

// use App\Models\Canton;
// use App\Models\Categorie;
// use App\Models\User;
// use App\Models\Ville;
// use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Pagination\Paginator;
// use Livewire\Attributes\Url;
// use Livewire\Component;
// use Livewire\WithPagination;
// use Stevebauman\Location\Facades\Location;

// class SalonSearch extends Component
// {
//     use WithPagination;

//     #[Url]
//     public $selectedSalonCanton = '';
//     #[Url]
//     public string $selectedSalonVille = '';
//     #[Url]
//     public array $selectedSalonCategories = [];
//     #[Url]
//     public $villes = [];
//     #[Url]
//     public array $nbFilles = [];
//     public $categories;
//     public $cantons;
//     public $availableVilles;

//     public function resetFilter()
//     {
//         $this->selectedSalonCanton = '';
//         $this->selectedSalonVille = '';
//         $this->selectedSalonCategories = [];
//         $this->villes = [];
//         $this->nbFilles = [];
//         $this->render();
//     }

//     public function chargeVille()
//     {
//         if (!empty($this->selectedSalonCanton)) {
//             $this->villes = Ville::where('canton_id', $this->selectedSalonCanton)->get();
//         } else {
//             $this->villes = collect();
//         }
//     }

//     public function render()
//     {
//         $this->cantons = Canton::all();
//         $this->availableVilles = Ville::all();
//         $this->categories = Categorie::where('type', 'salon')->get();

//         // Récupération du pays et des coordonnées du visiteur via IP
//         $position = Location::get(request()->ip());
//         $viewerCountry = $position?->countryCode ?? null;
//         $viewerLatitude = $position?->latitude ?? null;
//         $viewerLongitude = $position?->longitude ?? null;

//         dd($position);


//         $query = User::query()->where('profile_type', 'salon');

//         if ($this->selectedSalonCanton) {
//             $query->where('canton', 'LIKE', '%' . $this->selectedSalonCanton . '%');
//             $this->resetPage();
//         }

//         if ($this->selectedSalonVille != '') {
//             $query->where('ville', 'LIKE', '%' . $this->selectedSalonVille . '%');
//             $this->resetPage();
//         }

//         if ($this->nbFilles) {
//             $query->where(function ($q) {
//                 foreach ($this->nbFilles as $nbFilles) {
//                     $q->orWhere('nombre_filles', $nbFilles);
//                 }
//             });
//             $this->resetPage();
//         }

//         if ($this->selectedSalonCategories) {
//             $query->where(function ($q) {
//                 foreach ($this->selectedSalonCategories as $categorie) {
//                     $q->orWhere('categorie', 'LIKE', '%' . $categorie . '%');
//                 }
//             });
//             $this->resetPage();
//         }

//         // Initialisation des variables pour le rayon et le nombre de salons trouvés
//         $radius = 10; // Commencer avec un rayon de 10 km
//         $minSalons = 10; // Nombre minimum de salons à trouver
//         $foundSalons = collect();

//         // Augmenter le rayon jusqu'à ce que le nombre minimum de salons soit trouvé
//         while ($foundSalons->count() < $minSalons && $radius <= 100) { // Limiter le rayon à 100 km pour éviter des boucles infinies
//             $allSalons = $query->get()->filter(function ($salon) use ($viewerCountry, $viewerLatitude, $viewerLongitude, $radius) {
//                 if (!$salon->isProfileVisibleTo($viewerCountry)) {
//                     return false;
//                 }

//                 // Calculer la distance entre l'utilisateur et le salon
//                 if ($viewerLatitude && $viewerLongitude && $salon->lat && $salon->lon) {
//                     $distance = $this->calculateDistance(
//                         $viewerLatitude,
//                         $viewerLongitude,
//                         $salon->lat,
//                         $salon->lon
//                     );
//                     return $distance <= $radius;
//                 }

//                 return true;
//             });

//             $foundSalons = $allSalons;
//             $radius += 10; // Augmenter le rayon de 10 km à chaque itération
//         }

//         // Ajouter la distance à chaque salon
//         $foundSalons = $foundSalons->map(function ($salon) use ($viewerLatitude, $viewerLongitude) {
//             if ($viewerLatitude && $viewerLongitude && $salon->lat && $salon->lon) {
//                 $salon->distance = $this->calculateDistance(
//                     $viewerLatitude,
//                     $viewerLongitude,
//                     $salon->lat,
//                     $salon->lon
//                 );
//             } else {
//                 $salon->distance = null;
//             }
//             return $salon;
//         });


//         // Pagination manuelle
//         $currentPage = Paginator::resolveCurrentPage();
//         $perPage = 10;
//         $currentItems = $foundSalons->slice(($currentPage - 1) * $perPage, $perPage)->values();
//         $paginatedSalons = new LengthAwarePaginator(
//             $currentItems,
//             $foundSalons->count(),
//             $perPage,
//             $currentPage,
//             ['path' => request()->url(), 'query' => request()->query()]
//         );

//         // Hydrate les champs manuellement
//         foreach ($paginatedSalons as $salon) {
//             $salon['categorie'] = Categorie::find($salon->categorie);
//             $salon['canton'] = Canton::find($salon->canton);
//             $salon['ville'] = Ville::find($salon->ville);
//         }

//         // Retourner les salons paginés et les informations supplémentaires
//         return view('livewire.salon-search', [
//             'salons' => $paginatedSalons,
//             'totalSalons' => $foundSalons->count(),
//             'searchRadius' => $radius - 10, // Retourner le rayon utilisé pour trouver les salons
//         ]);
//     }

//     // Méthode pour calculer la distance entre deux points géographiques
//     private function calculateDistance($lat1, $lon1, $lat2, $lon2)
//     {
//         $earthRadius = 6371; // Rayon de la Terre en kilomètres

//         $dLat = deg2rad($lat2 - $lat1);
//         $dLon = deg2rad($lon2 - $lon1);

//         $a = sin($dLat / 2) * sin($dLat / 2) +
//              cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
//              sin($dLon / 2) * sin($dLon / 2);

//         $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

//         return $earthRadius * $c;
//     }
// }



// namespace App\Livewire;

// use App\Models\Canton;
// use App\Models\Categorie;
// use App\Models\User;
// use App\Models\Ville;
// use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Pagination\Paginator;
// use Livewire\Attributes\Url;
// use Livewire\Component;
// use Livewire\WithPagination;
// use Stevebauman\Location\Facades\Location;

// class SalonSearch extends Component
// {
//     use WithPagination;

//     #[Url]
//     public $selectedSalonCanton = '';
//     #[Url]
//     public string $selectedSalonVille = '';
//     #[Url]
//     public array $selectedSalonCategories = [];
//     #[Url]
//     public $villes = [];
//     #[Url]
//     public array $nbFilles = [];
//     public $categories;
//     public $cantons;
//     public $availableVilles;

//     public function resetFilter()
//     {
//         $this->selectedSalonCanton = '';
//         $this->selectedSalonVille = '';
//         $this->selectedSalonCategories = [];
//         $this->villes = [];
//         $this->nbFilles = [];
//         $this->render();
//     }

//     public function chargeVille()
//     {
//         if (!empty($this->selectedSalonCanton)) {
//             $this->villes = Ville::where('canton_id', $this->selectedSalonCanton)->get();
//         } else {
//             $this->villes = collect();
//         }
//     }

//     public function render()
//     {
//         $this->cantons = Canton::all();
//         $this->availableVilles = Ville::all();
//         $this->categories = Categorie::where('type', 'salon')->get();

//         // Récupération du pays et des coordonnées du visiteur via IP
//         $position = Location::get(request()->ip());
        
     
//         $viewerCountry = $position?->countryCode ?? null;
//         $viewerLatitude = $position?->latitude ?? null;
//         $viewerLongitude = $position?->longitude ?? null;

//         $query = User::query()->where('profile_type', 'salon');

//         if ($this->selectedSalonCanton) {
//             $query->where('canton', 'LIKE', '%' . $this->selectedSalonCanton . '%');
//             $this->resetPage();
//         }

//         if ($this->selectedSalonVille != '') {
//             $query->where('ville', 'LIKE', '%' . $this->selectedSalonVille . '%');
//             $this->resetPage();
//         }

//         if ($this->nbFilles) {
//             $query->where(function ($q) {
//                 foreach ($this->nbFilles as $nbFilles) {
//                     $q->orWhere('nombre_filles', $nbFilles);
//                 }
//             });
//             $this->resetPage();
//         }

//         if ($this->selectedSalonCategories) {
//             $query->where(function ($q) {
//                 foreach ($this->selectedSalonCategories as $categorie) {
//                     $q->orWhere('categorie', 'LIKE', '%' . $categorie . '%');
//                 }
//             });
//             $this->resetPage();
//         }

//         // Initialisation des variables pour le rayon et le nombre de salons trouvés
//         $radius = 10; // Commencer avec un rayon de 10 km
//         $minSalons = 10; // Nombre minimum de salons à trouver
//         $foundSalons = collect();

//         // Augmenter le rayon jusqu'à ce que le nombre minimum de salons soit trouvé
//         while ($foundSalons->count() < $minSalons && $radius <= 100) { // Limiter le rayon à 100 km pour éviter des boucles infinies
//             $allSalons = $query->get()->filter(function ($salon) use ($viewerCountry, $viewerLatitude, $viewerLongitude, $radius) {
//                 if (!$salon->isProfileVisibleTo($viewerCountry)) {
//                     return false;
//                 }

//                 // Vérifier si les coordonnées sont présentes
//                 if (!$salon->lat || !$salon->lon) {
//                     return false;
//                 }

//                 // Calculer la distance entre l'utilisateur et le salon
//                 $distance = $this->calculateDistance(
//                     $viewerLatitude,
//                     $viewerLongitude,
//                     $salon->lat,
//                     $salon->lon
//                 );
//                 return $distance <= $radius;
//             });

//             $foundSalons = $allSalons;
//             $radius += 10; // Augmenter le rayon de 10 km à chaque itération
//         }

//         // Ajouter la distance à chaque salon
//         $foundSalons = $foundSalons->map(function ($salon) use ($viewerLatitude, $viewerLongitude) {
//             if ($viewerLatitude && $viewerLongitude && $salon->lat && $salon->lon) {
//                 $salon->distance = $this->calculateDistance(
//                     $viewerLatitude,
//                     $viewerLongitude,
//                     $salon->lat,
//                     $salon->lon
//                 );
//             } else {
//                 $salon->distance = null;
//             }
//             return $salon;
//         });

//         // Pagination manuelle
//         $currentPage = Paginator::resolveCurrentPage();
//         $perPage = 10;
//         $currentItems = $foundSalons->slice(($currentPage - 1) * $perPage, $perPage)->values();
//         $paginatedSalons = new LengthAwarePaginator(
//             $currentItems,
//             $foundSalons->count(),
//             $perPage,
//             $currentPage,
//             ['path' => request()->url(), 'query' => request()->query()]
//         );

//         // Hydrate les champs manuellement
//         foreach ($paginatedSalons as $salon) {
//             $salon['categorie'] = Categorie::find($salon->categorie);
//             $salon['canton'] = Canton::find($salon->canton);
//             $salon['ville'] = Ville::find($salon->ville);
//         }

//         // Retourner les salons paginés et les informations supplémentaires
//         return view('livewire.salon-search', [
//             'salons' => $paginatedSalons,
//             'totalSalons' => $foundSalons->count(),
//             'searchRadius' => $radius - 10, // Retourner le rayon utilisé pour trouver les salons
//         ]);
//     }

//     // Méthode pour calculer la distance entre deux points géographiques
//     private function calculateDistance($lat1, $lon1, $lat2, $lon2)
//     {
//         $earthRadius = 6371; // Rayon de la Terre en kilomètres

//         $dLat = deg2rad($lat2 - $lat1);
//         $dLon = deg2rad($lon2 - $lon1);

//         $a = sin($dLat / 2) * sin($dLat / 2) +
//              cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
//              sin($dLon / 2) * sin($dLon / 2);

//         $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

//         return $earthRadius * $c;
//     }
// }


// namespace App\Livewire;

// use App\Models\Canton;
// use App\Models\Categorie;
// use App\Models\User;
// use App\Models\Ville;
// use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Pagination\Paginator;
// use Livewire\Attributes\Url;
// use Livewire\Component;
// use Livewire\WithPagination;
// use Stevebauman\Location\Facades\Location;

// class SalonSearch extends Component
// {
//     use WithPagination;

//     #[Url]
//     public $selectedSalonCanton = '';
//     #[Url]
//     public string $selectedSalonVille = '';
//     #[Url]
//     public array $selectedSalonCategories = [];
//     #[Url]
//     public $villes = [];
//     #[Url]
//     public array $nbFilles = [];
//     public $categories;
//     public $cantons;
//     public $availableVilles;
//     public $userIp;
//     public $viewerCountry;
//     public $viewerLatitude;
//     public $viewerLongitude;
//     public $searchRadius;

//     protected $listeners = ['setUserIp', 'setUserLocation'];

//     public function mount()
//     {
//         $this->cantons = Canton::all();
//         $this->availableVilles = Ville::all();
//         $this->categories = Categorie::where('type', 'salon')->get();
//     }

//     public function resetFilter()
//     {
//         $this->selectedSalonCanton = '';
//         $this->selectedSalonVille = '';
//         $this->selectedSalonCategories = [];
//         $this->villes = [];
//         $this->nbFilles = [];
//         $this->render();
//     }

//     public function chargeVille()
//     {
//         if (!empty($this->selectedSalonCanton)) {
//             $this->villes = Ville::where('canton_id', $this->selectedSalonCanton)->get();
//         } else {
//             $this->villes = collect();
//         }
//     }

//     public function setUserIp($ip)
//     {
//         $this->userIp = $ip;
//         $position = Location::get($ip);

//         if (!$position) {
//             $this->emit('ipError', 'Impossible de déterminer votre localisation. Veuillez réessayer plus tard.');
//             return;
//         }

//         $this->viewerCountry = $position->countryCode ?? null;
//         $this->viewerLatitude = $position->latitude ?? null;
//         $this->viewerLongitude = $position->longitude ?? null;

//         $this->render();
//     }

//     public function setUserLocation($coords)
    
//     {
//         $this->viewerLatitude = $coords['latitude'];
//         $this->viewerLongitude = $coords['longitude'];
//         $this->render();
//     }

//     public function render()
//     {
//         $query = User::query()->where('profile_type', 'salon');

//         if ($this->selectedSalonCanton) {
//             $query->where('canton', 'LIKE', '%' . $this->selectedSalonCanton . '%');
//             $this->resetPage();
//         }

//         if ($this->selectedSalonVille != '') {
//             $query->where('ville', 'LIKE', '%' . $this->selectedSalonVille . '%');
//             $this->resetPage();
//         }

//         if ($this->nbFilles) {
//             $query->where(function ($q) {
//                 foreach ($this->nbFilles as $nbFilles) {
//                     $q->orWhere('nombre_filles', $nbFilles);
//                 }
//             });
//             $this->resetPage();
//         }

//         if ($this->selectedSalonCategories) {
//             $query->where(function ($q) {
//                 foreach ($this->selectedSalonCategories as $categorie) {
//                     $q->orWhere('categorie', 'LIKE', '%' . $categorie . '%');
//                 }
//             });
//             $this->resetPage();
//         }

//         // Initialisation des variables pour le rayon et le nombre de salons trouvés
//         $radius = 10; // Commencer avec un rayon de 10 km
//         $minSalons = 10; // Nombre minimum de salons à trouver
//         $foundSalons = collect();

//         // Augmenter le rayon jusqu'à ce que le nombre minimum de salons soit trouvé
//         while ($foundSalons->count() < $minSalons && $radius <= 100) { // Limiter le rayon à 100 km pour éviter des boucles infinies
//             $allSalons = $query->get()->filter(function ($salon) use ($radius) {
//                 if (!$salon->isProfileVisibleTo($this->viewerCountry)) {
//                     return false;
//                 }

//                 // Vérifier si les coordonnées sont présentes
//                 if (!$salon->lat || !$salon->lon) {
//                     return false;
//                 }

//                 // Calculer la distance entre l'utilisateur et le salon
//                 $distance = $this->calculateDistance(
//                     $this->viewerLatitude,
//                     $this->viewerLongitude,
//                     $salon->lat,
//                     $salon->lon
//                 );
//                 return $distance <= $radius;
//             });

//             $foundSalons = $allSalons;
//             $radius += 10; // Augmenter le rayon de 10 km à chaque itération
//         }

//         $this->searchRadius = $radius - 10; // Mettre à jour le rayon utilisé pour trouver les salons

//         // Ajouter la distance à chaque salon
//         $foundSalons = $foundSalons->map(function ($salon) {
//             if ($this->viewerLatitude && $this->viewerLongitude && $salon->lat && $salon->lon) {
//                 $salon->distance = $this->calculateDistance(
//                     $this->viewerLatitude,
//                     $this->viewerLongitude,
//                     $salon->lat,
//                     $salon->lon
//                 );
//             } else {
//                 $salon->distance = null;
//             }
//             return $salon;
//         });

//         // Pagination manuelle
//         $currentPage = Paginator::resolveCurrentPage();
//         $perPage = 10;
//         $currentItems = $foundSalons->slice(($currentPage - 1) * $perPage, $perPage)->values();
//         $paginatedSalons = new LengthAwarePaginator(
//             $currentItems,
//             $foundSalons->count(),
//             $perPage,
//             $currentPage,
//             ['path' => request()->url(), 'query' => request()->query()]
//         );

//         // Hydrate les champs manuellement
//         foreach ($paginatedSalons as $salon) {
//             $salon['categorie'] = Categorie::find($salon->categorie);
//             $salon['canton'] = Canton::find($salon->canton);
//             $salon['ville'] = Ville::find($salon->ville);
//         }

//         // Retourner les salons paginés et les informations supplémentaires
//         return view('livewire.salon-search', [
//             'salons' => $paginatedSalons,
//             'totalSalons' => $foundSalons->count(),
//             'searchRadius' => $this->searchRadius,
//         ]);
//     }

//     // Méthode pour calculer la distance entre deux points géographiques
//     private function calculateDistance($lat1, $lon1, $lat2, $lon2)
//     {
//         $earthRadius = 6371; // Rayon de la Terre en kilomètres

//         $dLat = deg2rad($lat2 - $lat1);
//         $dLon = deg2rad($lon2 - $lon1);

//         $a = sin($dLat / 2) * sin($dLat / 2) +
//              cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
//              sin($dLon / 2) * sin($dLon / 2);

//         $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

//         return $earthRadius * $c;
//     }
// }


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

    public function render()
    {
        $this->cantons = Canton::all();
        $this->availableVilles = Ville::all();
        $this->categories = Categorie::where('type', 'salon')->get();

        // Récupération du pays du visiteur via IP
        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? null; // fallback utile
        $viewerLatitude = $position?->latitude ?? 0;
        $viewerLongitude = $position?->longitude ?? 0;

        $query = User::query()->where('profile_type', 'salon')
        ->whereNotNull('lat') // Ajout de la condition pour vérifier la présence de la lat
        ->whereNotNull('lon'); // Ajout de la condition pour vérifier la présence de la longitude


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
                    $q->orWhere('nombre_filles', $nbFilles);
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

        // Compter le nombre de salons trouvés
        $this->salonCount = $allSalons->count();

        // Calculer la distance maximale
        $this->maxDistance = 0;
        foreach ($allSalons as $salon) {
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
        $this->maxDistance = round($this->maxDistance);

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
            $salon['categorie'] = Categorie::find($salon->categorie);
            $salon['canton'] = Canton::find($salon->canton);
            $salon['ville'] = Ville::find($salon->ville);
        }

        return view('livewire.salon-search', [
            'salons' => $paginatedSalons,
            'maxDistance' => $this->maxDistance,
            'salonCount' => $this->salonCount, // Passer le nombre de salons trouvés à la vue
        ]);
    }
}

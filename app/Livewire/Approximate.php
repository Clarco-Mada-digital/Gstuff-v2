<?php


// namespace App\Livewire;

// use App\Models\User;
// use App\Models\Canton;
// use App\Models\Ville;
// use App\Models\DistanceMax;
// use Livewire\Component;
// use Illuminate\Support\Facades\Auth;
// use Stevebauman\Location\Facades\Location;

// class Approximate extends Component
// {
//     public $userId;
//     public $escorts = [];
//     public $userLatitude;
//     public $userLongitude;

//     public $userCanton;
//     public $userVille;

//     public $geo;
//     public $test;

//     public $latitudeUser;
//     public $longitudeUser;
//     public $minDistance = 0;
//     public $maxAvailableDistance = 0;
//     public $selectedDistance = 0;
//     public $escortCount = 0;

//     public $userLatBase;
//     public $userLonBase;


//     public function mount($userId)
//     {
//         $this->userId = $userId;
//         $user = User::find($userId);

//         if ($user) {
//             $this->userCanton = $user->canton;
//             $this->userVille = $user->ville;
//             $this->userLatBase = $user->lat;
//             $this->userLonBase = $user->lon;
            
//             // Initialiser les propriétés de distance
//             $this->minDistance = 0;
//             $this->maxAvailableDistance = 0;
//             $this->selectedDistance = 0;
//             $this->escortCount = 0;
            
//             $this->calculateEscortsDistances();
//         }
//     }

//     // Add this method to your Approximate class
// public function useFallbackLocation()
// {
//     // This will trigger the fallback logic in calculateEscortsDistances
//     // since latitudeUser and longitudeUser will be null
//     $this->latitudeUser = null;
//     $this->longitudeUser = null;
//     $this->geo = false;
//     $this->calculateEscortsDistances();
// }

//     public function resetLocation()
//     {
//         $this->latitudeUser = null;
//         $this->longitudeUser = null;
//         $this->geo = false;
//         $this->calculateEscortsDistances();
//     }


//         // Ajoutez cette méthode publique
//     public function updateLocation($latitude, $longitude)
//     {
        
//         $this->latitudeUser = $latitude;
//         $this->longitudeUser = $longitude;
//         $this->geo = true;
//         $this->calculateEscortsDistances();
//     }

//     // Gardez cette méthode mais rendez-la privée
//     private function updatedUserLatitude()
//     {
//         if (!is_null($this->latitudeUser) && !is_null($this->longitudeUser)) {
//             $this->calculateEscortsDistances();
//         }
//     }


//     private function calculateEscortsDistances()
//     {
//         // Base query avec les relations chargées
//         $query = User::where('profile_type', 'escorte')
//                     ->where('id', '!=', $this->userId)
//                     ->whereNotNull('canton')
//                     ->whereNotNull('ville')
//                     ->whereNotNull('lat')
//                     ->whereNotNull('lon');
                  
        
//         // Réinitialisation des compteurs
//         $this->minDistance = PHP_FLOAT_MAX;
//         $this->maxAvailableDistance = 0;
//         $this->escortCount = 0;

//         // $this->latitudeUser = 0;
//         // $this->longitudeUser = 0;

//         $position = Location::get(request()->ip());
//         $viewerCountry = $position?->countryCode ?? 'FR';
//         if($this->userLatBase == null || $this->userLonBase == null || $this->userCanton == null || $this->userVille == null)
//         {
//             $this->latitudeUser = $position?->latitude ?? 0;
//             $this->longitudeUser = $position?->longitude ?? 0;
//         }
    
//         // Si on a les coordonnées de l'utilisateur, on calcule les distances
//         if (!is_null($this->latitudeUser) && !is_null($this->longitudeUser)) {
//             $escortsWithDistance = $query->clone()
//                 ->get()
//                 ->filter(function ($escort) use ($viewerCountry) {
//                     return $escort->isProfileVisibleTo($viewerCountry);
//                 })
//                 ->map(function ($escort) {
//                     if (!is_null($escort->lat) && !is_null($escort->lon)) {
//                         $distance = $this->calculateDistance(
//                             $this->latitudeUser,
//                             $this->longitudeUser,
//                             $escort->lat,
//                             $escort->lon
//                         );
    
//                         return [
//                             'canton' => $escort->cantonget, // Assurez-vous que c'est le bon accès
//                             'ville' => $escort->villeget, // Assurez-vous que c'est le bon accès
//                             'escort' => $escort,
//                             'distance' => $distance
//                         ];
//                     }
    
//                     return null;
//                 })
//                 ->sortBy('distance')
//                 ->take(9)
//                 ->values();

        
//             // Mettre à jour les propriétés
//             if ($escortsWithDistance->isNotEmpty()) {
//                 $this->minDistance = $escortsWithDistance->first()['distance'];
//                 $this->maxAvailableDistance = $escortsWithDistance->last()['distance'];
//                 $this->escortCount = $escortsWithDistance->count();
//                 $this->selectedDistance = $this->selectedDistance ?: ceil($this->maxAvailableDistance);
        
//                 $this->escorts = $escortsWithDistance
//                     ->filter(fn($escort) => is_null($escort['distance']) || $escort['distance'] <= $this->selectedDistance)
//                     ->values();
        
//                 if ($this->escorts->isNotEmpty()) {
//                     return;
//                 }
//             }
//         }
        
//         // Si pas de géolocalisation ou pas de résultats, on cherche par ville
//         if (!is_null($this->userVille)) {

//             $this->test = 'ville';
//             $escortInVilleUser = User::where('ville', $this->userVille)
//             ->where('id', '!=', $this->userId)
//             ->where('profile_type', 'escorte')
//             ->get()
//             ->filter(function ($escort) use ($viewerCountry) {
//                 return $escort->isProfileVisibleTo($viewerCountry);
//             })
//             ->take(9);
//             if ($escortInVilleUser->isNotEmpty()) {
//                 $this->escorts = $escortInVilleUser->map(function ($escort) {
//                     return [
//                         'canton' => $escort->cantonget,
//                         'ville' => $escort->villeget,
//                         'escort' => $escort,
//                         'distance' => null
//                     ];
//                 });
//                 return;
//             }

           
//         }
        
//         // Si pas de résultats dans la même ville, on cherche dans le même canton
//         if (!is_null($this->userCanton)) {
//             $this->test = 'canton';
//             $escortInCantonUser = User::where('canton', $this->userCanton)
//             ->where('id', '!=', $this->userId)
//             ->where('profile_type', 'escorte')
//             ->get()
//             ->filter(function ($escort) use ($viewerCountry) {
//                 return $escort->isProfileVisibleTo($viewerCountry);
//             })
//             ->take(9);
//             if ($escortInCantonUser->isNotEmpty()) {
//                 $this->escorts = $escortInCantonUser->map(function ($escort) {
//                     return [
//                         'canton' => $escort->cantonget,
//                         'ville' => $escort->villeget,
//                         'escort' => $escort,
//                         'distance' => null
//                     ];
//                 });
//                 return;
//             }
//         }
        
//         $this->escorts = User::where('profile_type', 'escorte')
//         ->where('id', '!=', $this->userId)
//         ->get()
//         ->filter(function ($escort) use ($viewerCountry) {
//             return $escort->isProfileVisibleTo($viewerCountry);
//         })
//         ->take(9)
//         ->map(function ($escort) {
//             return [
//                 'canton' => $escort->cantonget,
//                 'ville' => $escort->villeget,
//                 'escort' => $escort,
//                 'distance' => null
//             ];
//         });
   
            
       
//     }


//     private function calculateDistance($lat1, $lon1, $lat2, $lon2)
//     {
//         $R = 6371.0; // Rayon moyen de la Terre en kilomètres
//         $deltaLat = deg2rad($lat2 - $lat1);
//         $deltaLon = deg2rad($lon2 - $lon1);

//         $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
//              cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
//              sin($deltaLon / 2) * sin($deltaLon / 2);
//         $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

//         return $R * $c;
//     }

//     public function updateDistance($distance)
//     {
//         $this->selectedDistance = (float)$distance;
//         $this->calculateEscortsDistances();
//     }

//     public function render()
//     {
       
//         return view('livewire.approximate', [
//             'escorts' => $this->escorts->sortBy(function($escort) {
//                 // Trier par distance croissante (les null à la fin)
//                 return $escort['distance'] ?? PHP_FLOAT_MAX;
//             }),
//             'minDistance' => $this->minDistance,
//             'maxAvailableDistance' => $this->maxAvailableDistance,
//             'selectedDistance' => $this->selectedDistance,
//             'escortCount' => $this->escortCount,
//             'geo' => $this->geo
//         ]);
//     }


// }
namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Collection;
class Approximate extends Component
{
    // Propriétés publiques pour le composant Livewire
    public $userId;
    public $escorts = []; // Liste des escorts à afficher
    public $userLatitude;
    public $userLongitude;
    public $userCanton;
    public $userVille;
    public $geo;
    public $latitudeUser;
    public $longitudeUser;
    public $minDistance = 0; // Distance minimale parmi les escorts
    public $maxAvailableDistance = 0; // Distance maximale parmi les escorts
    public $selectedDistance = 0; // Distance sélectionnée par l'utilisateur
    public $escortCount = 0; // Nombre d'escorts trouvés
    public $userLatBase;
    public $userLonBase;

    /**
     * Initialisation du composant avec l'ID de l'utilisateur.
     *
     * @param int $userId
     */
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->escorts = new Collection();
        $user = User::find($userId);

        // Si l'utilisateur est trouvé, initialiser les propriétés de l'utilisateur
        if ($user) {
            $this->userCanton = $user->canton;
            $this->userVille = $user->ville;
            $this->userLatBase = $user->lat;
            $this->userLonBase = $user->lon;

            // Calculer les distances des escorts par rapport à l'utilisateur
            $this->calculateEscortsDistances();
        }
    }

    /**
     * Utiliser un emplacement de repli si la géolocalisation échoue.
     */
    public function useFallbackLocation()
    {
        $this->latitudeUser = null;
        $this->longitudeUser = null;
        $this->geo = false;
        $this->calculateEscortsDistances();
    }

    /**
     * Réinitialiser la localisation de l'utilisateur.
     */
    public function resetLocation()
    {
        $this->latitudeUser = null;
        $this->longitudeUser = null;
        $this->geo = false;
        $this->calculateEscortsDistances();
    }

    /**
     * Mettre à jour la localisation de l'utilisateur avec de nouvelles coordonnées.
     *
     * @param float $latitude
     * @param float $longitude
     */
    public function updateLocation($latitude, $longitude)
    {
        $this->latitudeUser = $latitude;
        $this->longitudeUser = $longitude;
        $this->geo = true;
        $this->calculateEscortsDistances();
    }

    /**
     * Mettre à jour les distances lorsque la latitude de l'utilisateur est modifiée.
     */
    private function updatedUserLatitude()
    {
        if (!is_null($this->latitudeUser) && !is_null($this->longitudeUser)) {
            $this->calculateEscortsDistances();
        }
    }

    /**
     * Calculer les distances entre l'utilisateur et les escorts.
     */
    private function calculateEscortsDistances()
    {
        // Requête de base pour récupérer les escorts
        $query = User::where('profile_type', 'escorte')
                    ->where('id', '!=', $this->userId)
                    ->whereNotNull(['canton', 'ville', 'lat', 'lon']);

        // Réinitialiser les valeurs de distance
        $this->minDistance = PHP_FLOAT_MAX;
        $this->maxAvailableDistance = 0;
        $this->escortCount = 0;

        // Obtenir la position de l'utilisateur à partir de son IP
        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? 'FR';

        // Si les coordonnées de base de l'utilisateur sont manquantes, utiliser celles de la position IP
        if($this->userLatBase == null || $this->userLonBase == null || $this->userCanton == null || $this->userVille == null)
        {
            $this->latitudeUser = $position?->latitude ?? 0;
            $this->longitudeUser = $position?->longitude ?? 0;
        }

        // Si les coordonnées de l'utilisateur sont disponibles, calculer les distances
        if (!is_null($this->latitudeUser) && !is_null($this->longitudeUser)) {
            $this->processEscortsByDistance($query, $viewerCountry);
        }

        // Si aucun résultat n'est trouvé par distance, essayer de trouver des escorts dans la même ville
        if ($this->escorts->isEmpty() && !is_null($this->userVille)) {
            $this->processEscortsByVille($viewerCountry);
        }

        // Si aucun résultat n'est trouvé par ville, essayer de trouver des escorts dans le même canton
        if ($this->escorts->isEmpty() && !is_null($this->userCanton)) {
            $this->processEscortsByCanton($viewerCountry);
        }

        // Si aucun résultat n'est trouvé, retourner une liste par défaut d'escorts
        if ($this->escorts->isEmpty()) {
            $this->processDefaultEscorts($viewerCountry);
        }
    }

    /**
     * Traiter les escorts en fonction de leur distance par rapport à l'utilisateur.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $viewerCountry
     */
    private function processEscortsByDistance($query, $viewerCountry)
    {
        $escortsWithDistance = $query->clone()
            ->get()
            ->filter(function ($escort) use ($viewerCountry) {
                return $escort->isProfileVisibleTo($viewerCountry);
            })
            ->map(function ($escort) {
                if (!is_null($escort->lat) && !is_null($escort->lon)) {
                    $distance = $this->calculateDistance(
                        $this->latitudeUser,
                        $this->longitudeUser,
                        $escort->lat,
                        $escort->lon
                    );

                    return [
                        'canton' => $escort->cantonget,
                        'ville' => $escort->villeget,
                        'escort' => $escort,
                        'distance' => $distance
                    ];
                }
                return null;
            })
            ->filter()
            ->sortBy('distance')
            ->take(9)
            ->values();

        if ($escortsWithDistance->isNotEmpty()) {
            $this->minDistance = $escortsWithDistance->first()['distance'];
            $this->maxAvailableDistance = $escortsWithDistance->last()['distance'];
            $this->escortCount = $escortsWithDistance->count();
            $this->selectedDistance = $this->selectedDistance ?: ceil($this->maxAvailableDistance);

            $this->escorts = $escortsWithDistance
                ->filter(fn($escort) => is_null($escort['distance']) || $escort['distance'] <= $this->selectedDistance)
                ->values();
        }
    }

    /**
     * Traiter les escorts dans la même ville que l'utilisateur.
     *
     * @param string $viewerCountry
     */
    private function processEscortsByVille($viewerCountry)
    {
        $escorts = User::where('ville', $this->userVille)
            ->where('id', '!=', $this->userId)
            ->where('profile_type', 'escorte')
            ->get()
            ->filter(function ($escort) use ($viewerCountry) {
                return $escort->isProfileVisibleTo($viewerCountry);
            })
            ->take(9);

        $this->escorts = $escorts->map(function ($escort) {
            return [
                'canton' => $escort->cantonget,
                'ville' => $escort->villeget,
                'escort' => $escort,
                'distance' => null
            ];
        });
    }

    /**
     * Traiter les escorts dans le même canton que l'utilisateur.
     *
     * @param string $viewerCountry
     */
    private function processEscortsByCanton($viewerCountry)
    {
        $escorts = User::where('canton', $this->userCanton)
            ->where('id', '!=', $this->userId)
            ->where('profile_type', 'escorte')
            ->get()
            ->filter(function ($escort) use ($viewerCountry) {
                return $escort->isProfileVisibleTo($viewerCountry);
            })
            ->take(9);

        $this->escorts = $escorts->map(function ($escort) {
            return [
                'canton' => $escort->cantonget,
                'ville' => $escort->villeget,
                'escort' => $escort,
                'distance' => null
            ];
        });
    }

    /**
     * Traiter les escorts par défaut si aucune autre méthode ne retourne de résultats.
     *
     * @param string $viewerCountry
     */
    private function processDefaultEscorts($viewerCountry)
    {
        $this->escorts = User::where('profile_type', 'escorte')
            ->where('id', '!=', $this->userId)
            ->get()
            ->filter(function ($escort) use ($viewerCountry) {
                return $escort->isProfileVisibleTo($viewerCountry);
            })
            ->take(9)
            ->map(function ($escort) {
                return [
                    'canton' => $escort->cantonget,
                    'ville' => $escort->villeget,
                    'escort' => $escort,
                    'distance' => null
                ];
            });
    }

    /**
     * Calculer la distance entre deux points géographiques.
     *
     * @param float $lat1 Latitude du premier point
     * @param float $lon1 Longitude du premier point
     * @param float $lat2 Latitude du deuxième point
     * @param float $lon2 Longitude du deuxième point
     * @return float Distance en kilomètres
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371.0; // Rayon moyen de la Terre en kilomètres
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c;
    }

    /**
     * Mettre à jour la distance sélectionnée et recalculer les distances des escorts.
     *
     * @param float $distance
     */
    public function updateDistance($distance)
    {
        $this->selectedDistance = (float)$distance;
        $this->calculateEscortsDistances();
    }

    /**
     * Rendre la vue du composant avec les données nécessaires.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.approximate', [
            'escorts' => $this->escorts->sortBy(function($escort) {
                return $escort['distance'] ?? PHP_FLOAT_MAX;
            }),
            'minDistance' => $this->minDistance,
            'maxAvailableDistance' => $this->maxAvailableDistance,
            'selectedDistance' => $this->selectedDistance,
            'escortCount' => $this->escortCount,
            'geo' => $this->geo
        ]);
    }
}

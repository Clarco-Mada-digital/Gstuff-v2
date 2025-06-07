<?php
namespace App\Livewire;

use App\Models\User;
use App\Models\Canton;
use App\Models\Ville;
use App\Models\DistanceMax;
use Livewire\Component;

class Approximate extends Component
{
    public $userId;
    public $escorts = [];
    public $userLatitude;
    public $userLongitude;

    public $userCanton;
    public $userVille;

    public $geo;

    public $latitudeUser;
    public $longitudeUser;
    public $minDistance = 0;
    public $maxAvailableDistance = 0;
    public $selectedDistance = 0;
    public $escortCount = 0;


    public function mount($userId)
    {
        $this->userId = $userId;
        $user = User::find($userId);

        if ($user) {
            $this->userCanton = $user->canton;
            $this->userVille = $user->ville;
            
            // Initialiser les propriétés de distance
            $this->minDistance = 0;
            $this->maxAvailableDistance = 0;
            $this->selectedDistance = 0;
            $this->escortCount = 0;
            
            $this->calculateEscortsDistances();
        }
    }

    // Add this method to your Approximate class
public function useFallbackLocation()
{
    // This will trigger the fallback logic in calculateEscortsDistances
    // since latitudeUser and longitudeUser will be null
    $this->latitudeUser = null;
    $this->longitudeUser = null;
    $this->calculateEscortsDistances();
}

    public function resetLocation()
    {
        $this->latitudeUser = null;
        $this->longitudeUser = null;
        $this->calculateEscortsDistances();
    }


        // Ajoutez cette méthode publique
    public function updateLocation($latitude, $longitude)
    {
        $this->latitudeUser = $latitude;
        $this->longitudeUser = $longitude;
        $this->calculateEscortsDistances();
    }

    // Gardez cette méthode mais rendez-la privée
    private function updatedUserLatitude()
    {
        if (!is_null($this->latitudeUser) && !is_null($this->longitudeUser)) {
            $this->calculateEscortsDistances();
        }
    }


    private function calculateEscortsDistances()
    {
        // Base query avec les relations chargées
        $query = User::where('profile_type', 'escorte')
                    ->with(['ville', 'canton']);
        
        // Réinitialisation des compteurs
        $this->minDistance = PHP_FLOAT_MAX;
        $this->maxAvailableDistance = 0;
        $this->escortCount = 0;
        
        // Si on a les coordonnées de l'utilisateur, on calcule les distances
        if (!is_null($this->latitudeUser) && !is_null($this->longitudeUser)) {
            // Récupérer les escortes avec leurs distances
            $escortsWithDistance = $query->clone()
                ->whereNotNull(['lat', 'lon'])
                ->get()
                ->map(function ($escort) {
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
                })
                ->sortBy('distance')
                ->take(9)
                ->values();
        
            // Mettre à jour les propriétés
            if ($escortsWithDistance->isNotEmpty()) {
                $this->minDistance = $escortsWithDistance->first()['distance'];
                $this->maxAvailableDistance = $escortsWithDistance->last()['distance'];
                $this->escortCount = $escortsWithDistance->count();
                $this->selectedDistance = $this->selectedDistance ?: ceil($this->maxAvailableDistance);
        
                $this->escorts = $escortsWithDistance
                    ->filter(fn($escort) => is_null($escort['distance']) || $escort['distance'] <= $this->selectedDistance)
                    ->values();
        
                if ($this->escorts->isNotEmpty()) {
                    return;
                }
            }
        }
        
        // Si pas de géolocalisation ou pas de résultats, on cherche par ville
        if (!is_null($this->userVille)) {

            $escortInVilleUser = User::where('ville', $this->userVille)->get();
            if ($escortInVilleUser->isNotEmpty()) {
                $this->escorts = $escortInVilleUser->map(function ($escort) {
                    return [
                        'canton' => $escort->cantonget,
                        'ville' => $escort->villeget,
                        'escort' => $escort,
                        'distance' => null
                    ];
                });
                return;
            }

           
        }
        
        // Si pas de résultats dans la même ville, on cherche dans le même canton
        if (!is_null($this->userCanton)) {
            $escortInCantonUser = User::where('canton', $this->userCanton)->get();
            if ($escortInCantonUser->isNotEmpty()) {
                $this->escorts = $escortInCantonUser->map(function ($escort) {
                    return [
                        'canton' => $escort->canton,
                        'ville' => $escort->ville,
                        'escort' => $escort,
                        'distance' => null
                    ];
                });
                return;
            }
        }
        
        // Si toujours pas de résultats, on prend toutes les escortes disponibles
        $this->escorts = $query->get()
                             ->map(function ($escort) {
                                 return [
                                     'canton' => $escort->canton,
                                     'ville' => $escort->ville,
                                     'escort' => $escort,
                                     'distance' => null
                                 ];
                             });
        $this->escorts = $this->escorts->sortBy('distance');
        $this->escorts = $this->escorts->take(9);
    }

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

    public function updateDistance($distance)
    {
        $this->selectedDistance = (float)$distance;
        $this->calculateEscortsDistances();
    }

    public function render()
    {
        return view('livewire.approximate', [
            'escorts' => $this->escorts->sortBy(function($escort) {
                // Trier par distance croissante (les null à la fin)
                return $escort['distance'] ?? PHP_FLOAT_MAX;
            }),
            'minDistance' => $this->minDistance,
            'maxAvailableDistance' => $this->maxAvailableDistance,
            'selectedDistance' => $this->selectedDistance,
            'escortCount' => $this->escortCount
        ]);
    }


}

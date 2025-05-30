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
            $allEscortsUsers = $query->clone()
                                ->whereNotNull('lat')
                                ->whereNotNull('lon')
                                ->get();

            // Calculer les distances pour chaque escorte
            $escortsWithDistance = $allEscortsUsers->map(function ($escort) {
                $distance = $this->calculateDistance(
                    $this->latitudeUser, 
                    $this->longitudeUser, 
                    $escort->lat, 
                    $escort->lon
                );

                // Mettre à jour les distances min et max
                $this->minDistance = min($this->minDistance, $distance);
                $this->maxAvailableDistance = max($this->maxAvailableDistance, $distance);
                $this->escortCount++;

                return [
                    'canton' => $escort->cantonget,
                    'ville' => $escort->villeget,
                    'escort' => $escort,
                    'distance' => $distance
                ];
            });
            
            // Si c'est le premier chargement, initialiser la distance sélectionnée
            if ($this->selectedDistance === 0 && $this->escortCount > 0) {
                $this->selectedDistance = ceil($this->maxAvailableDistance);
            }
            
            // Filtrer par distance sélectionnée
            $this->escorts = $escortsWithDistance
                ->filter(function ($escort) {
                    // Si pas de distance (cas où on n'a pas pu calculer), on garde le résultat
                    if (is_null($escort['distance'])) {
                        return true;
                    }
                    return $escort['distance'] <= $this->selectedDistance;
                })
                ->sortBy('distance')
                ->values();
            
            if (!$this->escorts->isEmpty()) {
                return;
            }
        }
        
        // Si pas de géolocalisation ou pas de résultats, on cherche par ville
        if (!is_null($this->userVille)) {
            // dd($this->userVille);
            $villesListe = Ville::where('canton_id', $this->userCanton)->get();

            $escortInVilleUser = User::where('ville', $this->userVille)->get();
            // dd("escortInVilleUser",$escortInVilleUser);
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

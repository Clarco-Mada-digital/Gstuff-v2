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
    public $maxDistance;
    public $escorts = [];

    public function mount($userId)
    {
        $this->userId = $userId;
        $user = User::find($userId);

        $distanceMaxRecord = DistanceMax::first();
        $this->maxDistance = $distanceMaxRecord->distance_max;

        if ($user && !is_null($user->lon) && !is_null($user->lat)) {
            $userLongitude = $user->lon;
            $userLatitude = $user->lat;

            $allEscortsUsers = User::where('profile_type', 'escorte')->get();

            // Calculer la distance de chaque escorte sans limite stricte
            $this->escorts = $allEscortsUsers->map(function ($escort) use ($userLatitude, $userLongitude) {
                if (!is_null($escort->lat) && !is_null($escort->lon)) {
                    $distance = $this->calculateDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon);
                    
                    return [
                        'canton' => Canton::find($escort->canton),
                        'ville' => Ville::find($escort->ville),
                        'escort' => $escort,
                        'distance' => floatval($distance)
                    ];
                }
            })->filter(); // Supprimer les valeurs nulles
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371.0;
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c;
    }

    public function render()
    {
        return view('livewire.approximate', ['escorts' => $this->escorts , 'distanceMax'=>$this->maxDistance]);
    }
}


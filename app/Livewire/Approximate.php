<?php

namespace App\Livewire;
use App\Models\User;
use App\Models\Canton;
use App\Models\Ville;

use Livewire\Component;

class Approximate extends Component
{
    public $userId;
    public $escorts = [];

    public function mount($userId)
    {
        $this->userId = $userId;

        $user = User::find($userId);

        if ($user && !is_null($user->lon) && !is_null($user->lat)) {
            $userLongitude = $user->lon;
            $userLatitude = $user->lat;

            $allEscortsUsers = User::where('profile_type', 'escorte')->get();

            $escortsWithinRadius = $allEscortsUsers->filter(function ($escort) use ($userLatitude, $userLongitude) {
                return !is_null($escort->lat) && !is_null($escort->lon) &&
                    $this->calculateDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon) <= 100;
            });

            $this->escorts = $escortsWithinRadius->map(function ($escort) {
                return [
                    'canton' => Canton::find($escort->canton),
                    'ville' => Ville::find($escort->ville),
                    'escort' => $escort,
                ];
            });
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
        return view('livewire.approximate', ['escorts' => $this->escorts]);
    }

}
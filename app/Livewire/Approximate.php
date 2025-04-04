<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Canton;
use App\Models\Ville;

use Livewire\Component;

/**
 * La classe Approximate est un composant Livewire.
 * Elle sert à trouver les utilisateurs proches d'un utilisateur spécifique
 * en fonction de leur position géographique (latitude et longitude).
 */
class Approximate extends Component
{
    /**
     * @var int $userId L'ID de l'utilisateur pour lequel les proximités sont calculées.
     */
    public $userId;

    /**
     * @var array $escorts Une liste des escortes proches dans un rayon défini (100 km).
     */
    public $escorts = [];

    /**
     * Méthode mount exécutée lors du chargement du composant Livewire.
     * Elle initialise les données basées sur l'utilisateur fourni.
     *
     * @param int $userId L'identifiant de l'utilisateur cible.
     */
    public function mount($userId)
    {
        $this->userId = $userId;

        // Récupérer l'utilisateur en fonction de son ID
        $user = User::find($userId);

        // Vérifier si l'utilisateur possède des coordonnées valides
        if ($user && !is_null($user->lon) && !is_null($user->lat)) {
            $userLongitude = $user->lon;
            $userLatitude = $user->lat;

            // Récupérer tous les utilisateurs avec un profil d'escorte
            $allEscortsUsers = User::where('profile_type', 'escorte')->get();

            // Filtrer les escortes situées dans un rayon de 100 km
            $escortsWithinRadius = $allEscortsUsers->filter(function ($escort) use ($userLatitude, $userLongitude) {
                return !is_null($escort->lat) && !is_null($escort->lon) &&
                    $this->calculateDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon) <= 100;
            });

            // Mapper les données pour inclure le canton et la ville
            $this->escorts = $escortsWithinRadius->map(function ($escort) {
                return [
                    'canton' => Canton::find($escort->canton), // Récupérer le canton correspondant
                    'ville' => Ville::find($escort->ville),   // Récupérer la ville correspondante
                    'escort' => $escort,                     // Inclure les données de l'utilisateur
                ];
            });
        }
    }

    /**
     * Calcul de la distance entre deux coordonnées géographiques.
     *
     * @param float $lat1 Latitude de la première position.
     * @param float $lon1 Longitude de la première position.
     * @param float $lat2 Latitude de la seconde position.
     * @param float $lon2 Longitude de la seconde position.
     * @return float La distance en kilomètres.
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371.0; // Rayon moyen de la Terre en kilomètres

        // Différences en radians entre les latitudes et longitudes
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);

        // Formule de Haversine
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c; // Distance en kilomètres
    }

    /**
     * Méthode render pour afficher la vue associée au composant.
     *
     * @return \Illuminate\View\View La vue du composant avec les données des escortes.
     */
    public function render()
    {
        return view('livewire.approximate', ['escorts' => $this->escorts]);
    }
}

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
                            $q->orWhere('nombre_filles', $nbFilles);
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

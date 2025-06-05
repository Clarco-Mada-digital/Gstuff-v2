<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Genre;
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
    #[Url]
    public $minDistance = 0; // Distance minimale

    #[Url]
    public $maxDistanceSelected = 0; // Distance maximale sélectionnée

    public $maxAvailableDistance = 0; // Distance maximale disponible

    public array $autreFiltres = [];
    public $categories;
    public $cantons;
    public $availableVilles;
    public $villes = [];
    public $maxDistance = 0;
    public $escortCount = 0;
    public $genres;

    public $approximite = false;
    public $latitudeUser;
    public $longitudeUser;

    #[Url]
    public $showClosestOnly = false; // Nouvelle propriété pour le filtre des plus proches

    public $showFiltreCanton = true;

    private function getEscorts($escorts)
    {
        // Détection du pays via IP
        $position = \Stevebauman\Location\Facades\Location::get(request()->ip());

        $viewerCountry = $position?->countryCode ?? 'FR'; // fallback pour dev

        $esc = [];
        foreach ($escorts as $escort) {
            if ($escort->isProfileVisibleTo($viewerCountry)) {
                $esc[] = $escort;
            }
        }
        return $esc;
    }

    public function approximiteFunc()
    {
        $this->approximite = !$this->approximite;
        if ($this->approximite) {
            $this->showClosestOnly = false;
            $this->reset('maxDistanceSelected');
        }
        $this->resetPage();
    }

    public function updateUserLatitude($latitude)
    {
        $this->latitudeUser = $latitude;
    }

    public function updateUserLongitude($longitude)
    {
        $this->longitudeUser = $longitude;
    }

    public function resetFilter()
    {
        $this->selectedCanton = '';
        $this->selectedVille = '';
        $this->selectedGenre = '';
        $this->selectedCategories = [];
        $this->selectedServices = [];
        $this->autreFiltres = [];
        $this->approximite = false;
        $this->showClosestOnly = false;
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

    public function updatedShowClosestOnly($value)
    {
        if ($value) {
            $this->approximite = false;
            $this->reset('maxDistanceSelected');
        }
        $this->resetPage();
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

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    public function render()
    {
        // Gestion des états mutuellement exclusifs
        if ($this->approximite && $this->showClosestOnly) {
            $this->showClosestOnly = false;
        }

        // Déterminer si le filtre canton doit être affiché
        $this->showFiltreCanton = !($this->approximite || $this->showClosestOnly);

        $currentLocale = app()->getLocale();
        $this->cantons = Canton::all();
        $this->availableVilles = Ville::all();
        $this->categories = Categorie::where('type', 'escort')->get();
        $serviceQuery = Service::query();
        $this->genres = Genre::all();

        // Détection du pays via IP
        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? 'FR'; // fallback pour dev
        $viewerLatitude = $position?->latitude ?? 0;
        $viewerLongitude = $position?->longitude ?? 0;

        if (!$this->approximite) {
            $query = User::query()->where('profile_type', 'escorte');

            if ($this->selectedCanton) {
                $query->where('canton', $this->selectedCanton);
            }

            if ($this->selectedVille) {
                $query->where('ville', $this->selectedVille);
            }

            if ($this->selectedGenre) {
                $query->where('genre_id', $this->selectedGenre);
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
                        if (!empty($value)) {
                            switch ($key) {
                                case 'mensuration':
                                    $q->where('mensuration_id', $value);
                                    break;
                                case 'orientation':
                                    $q->where('orientation_sexuelle_id', (int) $value);
                                    break;
                                case 'couleur_yeux':
                                    $q->where('couleur_yeux_id', (int) $value);
                                    break;
                                case 'couleur_cheveux':
                                    $q->where('couleur_cheveux_id', (int) $value);
                                    break;
                                case 'poitrine':
                                    $q->where('poitrine_id', (int) $value);
                                    break;
                                case 'langue':
                                    $q->whereJsonContains('langue', $value);
                                    break;
                                case 'pubis':
                                    $q->where('pubis_type_id', (int) $value);
                                    break;
                                case 'tatouages':
                                    $q->where('tatoo_id', (int) $value);
                                    break;
                                case 'taille_poitrine':
                                    $poitrineValues = [
                                        'petite' => ['A', 'B', 'C'],
                                        'moyenne' => ['D', 'E', 'F'],
                                        'grosse' => ['G', 'H'],
                                    ];
                                    
                                    // Vérifier si la valeur recherchée existe comme clé dans $poitrineValues
                                    if (array_key_exists($value, $poitrineValues)) {
                                        $taillesCorrespondantes = $poitrineValues[$value];
                                        
                                        $q->where(function ($q) use ($taillesCorrespondantes) {
                                            foreach ($taillesCorrespondantes as $taille) {
                                                $q->orWhere('TAILLE_POITRINE', 'LIKE', "%{$taille}%");
                                            }
                                        });
                                    }
                                    break;
                                case 'mobilite':
                                    $q->where('mobilite_id', (int) $value);
                                    break;
                                default:
                                    $q->where($key, 'LIKE', '%' . $value . '%');
                                    break;
                            }
                        }
                    }
                });
            }

            $escorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
                return $escort->isProfileVisibleTo($viewerCountry);
            });

            // Si aucun résultat, chercher dans les villes proches
            if ($escorts->isEmpty() && !empty($this->selectedVille)) {
                $nearbyVilles = Ville::where('canton_id', $this->selectedCanton)->where('id', '!=', $this->selectedVille)->get();

                foreach ($nearbyVilles as $ville) {
                    $query = User::query()->where('profile_type', 'escorte')->where('ville', $ville->id);

                    if ($this->selectedGenre) {
                        $query->where('genre_id', $this->selectedGenre);
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
                                if (!empty($value)) {
                                    switch ($key) {
                                        case 'mensuration':
                                            $q->where('mensuration_id', $value);
                                            break;
                                        case 'orientation':
                                            $q->where('orientation_sexuelle_id', (int) $value);
                                            break;
                                        case 'couleur_yeux':
                                            $q->where('couleur_yeux_id', (int) $value);
                                            break;
                                        case 'couleur_cheveux':
                                            $q->where('couleur_cheveux_id', (int) $value);
                                            break;
                                        case 'poitrine':
                                            $q->where('poitrine_id', (int) $value);
                                            break;
                                        case 'pubis':
                                            $q->where('pubis_type_id', (int) $value);
                                            break;
                                        case 'tatouages':
                                            $q->where('tatoo_id', (int) $value);
                                            break;
                                        case 'taille_poitrine':
                                            $poitrineValues = [
                                                'petite' => ['A', 'B', 'C'],
                                                'moyenne' => ['D', 'E', 'F'],
                                                'grosse' => ['G', 'H'],
                                            ];
                                            
                                            // Vérifier si la valeur recherchée existe comme clé dans $poitrineValues
                                            if (array_key_exists($value, $poitrineValues)) {
                                                $taillesCorrespondantes = $poitrineValues[$value];
                                                
                                                $q->where(function ($q) use ($taillesCorrespondantes) {
                                                    foreach ($taillesCorrespondantes as $taille) {
                                                        $q->orWhere('TAILLE_POITRINE', 'LIKE', "%{$taille}%");
                                                    }
                                                });
                                            }
                                            break;
                                        case 'mobilite':
                                            $q->where('mobilite_id', (int) $value);
                                            break;
                                        default:
                                            $q->where($key, 'LIKE', '%' . $value . '%');
                                            break;
                                    }
                                }
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
                    $distance = $this->haversineGreatCircleDistance($viewerLatitude, $viewerLongitude, $escort->lat, $escort->lon);
                    if ($distance > $this->maxDistance) {
                        $this->maxDistance = $distance;
                    }
                }
            }

            $this->maxDistance = round($this->maxDistance);

            // Convertir en pagination manuelle après filtrage
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
            $perPage = 12;
            $currentItems = $escorts->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedEscorts = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $escorts->count(), $perPage, $currentPage, ['path' => request()->url(), 'query' => request()->query()]);

            // Hydrate relations
            foreach ($paginatedEscorts as $escort) {
                $escort['categorie'] = Categorie::find($escort->categorie);
                $escort['canton'] = Canton::find($escort->canton);
                $escort['ville'] = Ville::find($escort->ville);
            }
        }

        if ($this->approximite) {
            $userLatitude = $this->latitudeUser;
            $userLongitude = $this->longitudeUser;

            if (!$userLatitude || !$userLongitude) {
                $userLatitude = $viewerLatitude;
                $userLongitude = $viewerLongitude;
            }

            // Initialiser les variables
            $minDistance = PHP_FLOAT_MAX;
            $maxAvailableDistance = 0;
            $escortCount = 0;

            $escorts = User::where('profile_type', 'escorte')
                ->whereNotNull('lat')
                ->whereNotNull('lon')
                ->get()
                ->filter(function ($escort) use ($viewerCountry) {
                    return $escort->isProfileVisibleTo($viewerCountry);
                })
                ->map(function ($escort) use ($userLatitude, $userLongitude, &$minDistance, &$maxAvailableDistance, &$escortCount) {
                    $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon);

                    // Mettre à jour les distances min et max
                    $minDistance = min($minDistance, $distance);
                    $maxAvailableDistance = max($maxAvailableDistance, $distance);

                    $escortCount++;

                    return [
                        'escort' => $escort,
                        'distance' => $distance,
                    ];
                });

            // Mettre à jour les propriétés de la classe
            $this->minDistance = $escortCount > 0 ? $minDistance : 0;
            $this->maxAvailableDistance = $escortCount > 0 ? ceil($maxAvailableDistance) : 0;
            $this->escortCount = $escortCount;

            // Si c'est le premier chargement, initialiser maxDistanceSelected
            if (!$this->maxDistanceSelected && $escortCount > 0) {
                $this->maxDistanceSelected = $this->maxAvailableDistance;
            }

            // Filtrer par plage de distance, catégories et genre si sélectionnés
            if ($escortCount > 0) {
                $escorts = $escorts->filter(function ($item) {
                    // Vérifier la distance
                    $distanceMatch = $item['distance'] >= $this->minDistance && $item['distance'] <= $this->maxDistanceSelected;

                    if (!$distanceMatch) {
                        return false;
                    }

                    // Vérifier le genre si sélectionné
                    if ($this->selectedGenre && $item['escort']->genre_id != $this->selectedGenre) {
                        return false;
                    }

                    // Vérifier les catégories si sélectionnées
                    if (!empty($this->selectedCategories)) {
                        // Convertir la catégorie de l'escort en tableau si ce n'est pas déjà le cas
                        $escortCategory = $item['escort']->categorie;
                        $escortCategories = is_array($escortCategory) ? $escortCategory : [(string) $escortCategory];

                        // Convertir les IDs en chaînes pour la comparaison
                        $escortCategories = array_map('strval', $escortCategories);
                        $selectedCategories = array_map('strval', $this->selectedCategories);

                        // Vérifier s'il y a une correspondance
                        $hasMatchingCategory = count(array_intersect($selectedCategories, $escortCategories)) > 0;
                        if (!$hasMatchingCategory) {
                            return false;
                        }
                    }

                    // Vérifier les services si sélectionnés
                    if (!empty($this->selectedServices)) {
                        $escortServices = $item['escort']->service;
                        $escortServicesArray = is_array($escortServices) ? $escortServices : explode(',', (string) $escortServices);

                        $escortServicesArray = array_map('strval', $escortServicesArray);
                        $selectedServices = array_map('strval', $this->selectedServices);

                        $hasMatchingService = count(array_intersect($selectedServices, $escortServicesArray)) > 0;
                        if (!$hasMatchingService) {
                            return false;
                        }
                    }

                    // Vérifier les autres filtres
                    if (!empty($this->autreFiltres)) {
                        dd($this->autreFiltres);
                        foreach ($this->autreFiltres as $key => $value) {
                            if (!empty($value)) {
                                $escortValue = $item['escort']->$key;

                                // Si c'est une relation, on prend l'ID
                                if (is_object($escortValue) && method_exists($escortValue, 'getKey')) {
                                    $escortValue = $escortValue->getKey();
                                }

                                // Si la valeur est numérique, on la convertit en entier pour la comparaison
                                if (is_numeric($escortValue)) {
                                    $escortValue = (int) $escortValue;
                                    $value = (int) $value;
                                }

                                // Vérifier la correspondance en fonction du type de filtre
                                switch ($key) {
                                    case 'mensuration':
                                        if ($escortValue != $value) {
                                            return false;
                                        }
                                        break;
                                    case 'orientation':
                                    case 'couleur_yeux':
                                    case 'couleur_cheveux':
                                    case 'poitrine':
                                    case 'pubis':
                                    case 'tatouages':
                                    case 'mobilite':
                                        if ($escortValue != $value) {
                                            return false;
                                        }
                                        break;
                                    case 'taille_poitrine':
                                        $poitrineValues = [
                                            'petite' => ['A', 'B', 'C'],
                                            'moyenne' => ['D', 'E', 'F'],
                                            'grosse' => ['G', 'H'],
                                        ];

                                        if (array_key_exists($value, $poitrineValues)) {
                                            $taillesCorrespondantes = $poitrineValues[$value];

                                            $escorts = $escorts->where(function ($q) use ($taillesCorrespondantes) {
                                                foreach ($taillesCorrespondantes as $taille) {
                                                    $q->orWhere('TAILLE_POITRINE', 'LIKE', "%{$taille}%");
                                                }
                                            });
                                        }
                                        break;
                                    default:
                                        // Pour les autres champs, on fait une recherche partielle
                                        if (is_string($escortValue) && stripos($escortValue, $value) === false) {
                                            return false;
                                        }
                                        break;
                                }
                            }
                        }
                    }

                    return true;
                });
            }

            // Trier par distance
            $escorts = $escorts->sortBy('distance');
            $this->escortCount = $escorts->count();

            // Convertir en pagination
            $perPage = 12;
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
            $currentItems = $escorts->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedEscorts = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $escorts->count(), $perPage, $currentPage, ['path' => request()->url(), 'query' => request()->query()]);

            // Hydrater les relations
            foreach ($paginatedEscorts as $escortData) {
                $escort = $escortData['escort'];
                $escort['categorie'] = Categorie::find($escort->categorie);
                $escort['canton'] = Canton::find($escort->canton);
                $escort['ville'] = Ville::find($escort->ville);
            }
        }

        if ($this->showClosestOnly) {
            $userLatitude = $this->latitudeUser;
            $userLongitude = $this->longitudeUser;

            
            if (!$userLatitude || !$userLongitude) {
                $userLatitude = $viewerLatitude;
                $userLongitude = $viewerLongitude;
            }

            // Initialiser les variables
            $minDistance = PHP_FLOAT_MAX;
            $maxAvailableDistance = 0;
            $escortCount = 0;

            // Récupérer toutes les escortes avec leurs coordonnées
            $escorts = User::where('profile_type', 'escorte')
                ->whereNotNull('lat')
                ->whereNotNull('lon')
                ->get()
                ->filter(function ($escort) use ($viewerCountry) {
                    return $escort->isProfileVisibleTo($viewerCountry);
                })
                ->map(function ($escort) use ($userLatitude, $userLongitude, &$minDistance, &$maxAvailableDistance, &$escortCount) {
                    $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon);

                    // Mettre à jour les distances min et max
                    $minDistance = min($minDistance, $distance);
                    $maxAvailableDistance = max($maxAvailableDistance, $distance);

                    $escortCount++;

                    return [
                        'escort' => $escort,
                        'distance' => $distance,
                    ];
                });

            if ($escortCount > 4) {
                $escorts = $escorts->sortBy('distance')->take(4);
                $maxAvailableDistance = $escorts->last()['distance'];
            }

            // Mettre à jour les propriétés de la classe
            $this->minDistance = $escortCount > 0 ? $minDistance : 0;
            $this->maxAvailableDistance = $escortCount > 0 ? ceil($maxAvailableDistance) : 0;
            $this->escortCount = $escortCount;

            // Si c'est le premier chargement, initialiser maxDistanceSelected
            if (!$this->maxDistanceSelected && $escortCount > 0) {
                $this->maxDistanceSelected = $this->maxAvailableDistance;
            }

            // Filtrer par plage de distance, catégories et genre si sélectionnés
            if ($escortCount > 0) {
                $escorts = $escorts->filter(function ($item) {
                    // Vérifier la distance
                    $distanceMatch = $item['distance'] >= $this->minDistance && $item['distance'] <= $this->maxDistanceSelected;

                    if (!$distanceMatch) {
                        return false;
                    }

                    // Vérifier le genre si sélectionné
                    if ($this->selectedGenre && $item['escort']->genre_id != $this->selectedGenre) {
                        return false;
                    }

                    // Vérifier les catégories si sélectionnées
                    if (!empty($this->selectedCategories)) {
                        $escortCategory = $item['escort']->categorie;
                        $escortCategories = is_array($escortCategory) ? $escortCategory : [(string) $escortCategory];

                        $escortCategories = array_map('strval', $escortCategories);
                        $selectedCategories = array_map('strval', $this->selectedCategories);

                        $hasMatchingCategory = count(array_intersect($selectedCategories, $escortCategories)) > 0;
                        if (!$hasMatchingCategory) {
                            return false;
                        }
                    }

                    // Vérifier les services si sélectionnés
                    if (!empty($this->selectedServices)) {
                        $escortServices = $item['escort']->service;
                        $escortServicesArray = is_array($escortServices) ? $escortServices : explode(',', (string) $escortServices);

                        $escortServicesArray = array_map('strval', $escortServicesArray);
                        $selectedServices = array_map('strval', $this->selectedServices);

                        $hasMatchingService = count(array_intersect($selectedServices, $escortServicesArray)) > 0;
                        if (!$hasMatchingService) {
                            return false;
                        }
                    }

                    // Vérifier les autres filtres
                    if (!empty($this->autreFiltres)) {
                        foreach ($this->autreFiltres as $key => $value) {
                            if (!empty($value)) {
                                $escortValue = $item['escort']->$key;

                                if (is_object($escortValue) && method_exists($escortValue, 'getKey')) {
                                    $escortValue = $escortValue->getKey();
                                }

                                if (is_numeric($escortValue)) {
                                    $escortValue = (int) $escortValue;
                                    $value = (int) $value;
                                }

                                switch ($key) {
                                    case 'mensuration':
                                        if ($escortValue != $value) {
                                            return false;
                                        }
                                        break;
                                    case 'orientation':
                                    case 'couleur_yeux':
                                    case 'couleur_cheveux':
                                    case 'poitrine':
                                    case 'pubis':
                                    case 'tatouages':
                                    case 'mobilite':
                                        if ($escortValue != $value) {
                                            return false;
                                        }
                                        break;
                                    case 'taille_poitrine':
                                        $poitrineValues = [
                                            'petite' => ['A', 'B', 'C'],
                                            'moyenne' => ['D', 'E', 'F'],
                                            'grosse' => ['G', 'H'],
                                        ];

                                        if (array_key_exists($value, $poitrineValues)) {
                                            $taillesCorrespondantes = $poitrineValues[$value];

                                            $escorts = $escorts->where(function ($q) use ($taillesCorrespondantes) {
                                                foreach ($taillesCorrespondantes as $taille) {
                                                    $q->orWhere('TAILLE_POITRINE', 'LIKE', "%{$taille}%");
                                                }
                                            });
                                        }
                                        break;
                                    default:
                                        if (is_string($escortValue) && stripos($escortValue, $value) === false) {
                                            return false;
                                        }
                                        break;
                                }
                            }
                        }
                    }

                    return true;
                });
            }

            // Trier par distance et prendre les 4 plus proches
            $escorts = $escorts->sortBy('distance')->take(4);
            $this->escortCount = $escorts->count();

            // Convertir en collection paginée
            $perPage = 12;
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
            $currentItems = $escorts->slice(0, $perPage)->values();

            $paginatedEscorts = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $escorts->count(), $perPage, $currentPage, ['path' => request()->url(), 'query' => request()->query()]);

            // Hydrater les relations
            foreach ($paginatedEscorts as $escortData) {
                $escort = $escortData['escort'];
                $escort['categorie'] = Categorie::find($escort->categorie);
                $escort['canton'] = Canton::find($escort->canton);
                $escort['ville'] = Ville::find($escort->ville);
            }
        }

        return view('livewire.escort-search', [
            'escorts' => $paginatedEscorts,
            'services' => $serviceQuery->paginate(20),
            'maxDistance' => $this->maxDistance,
            'escortCount' => $this->escortCount,
            'currentLocale' => $currentLocale,
        ]);
    }
}

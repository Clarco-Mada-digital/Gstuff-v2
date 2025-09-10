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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\CouleurCheveux;
use App\Models\CouleurYeux;
use App\Models\Mensuration;
use App\Models\Poitrine;
use App\Models\PubisType;
use App\Models\Silhouette;
use App\Models\Tattoo;
use App\Models\Mobilite;
use App\Models\NombreFille;
use App\Models\OrientationSexuelle;

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

    public $ageMin = 18;
    public $ageMax = 100;
    public $tailleMin = 90;
    public $tailleMax = 200;
    public $tarifMin = 100;
    public $tarifMax = 1000;

    public $ageInterval = [];
    public $tailleInterval = [];
    public $tarifInterval = [];

    public $approximite = false;
    public $latitudeUser;
    public $longitudeUser;

    public $autre = false;

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
        $this->villes = [];
        $this->ageInterval = [];
        $this->tailleInterval = [];
        $this->tarifInterval = [];
        $this->getValueRange();
        $this->resetPage();
        $this->render();
    }

    public function resetFilterModal()
    {
        $this->selectedCanton = '';
        $this->selectedVille = '';
        $this->selectedGenre = '';
        $this->selectedCategories = [];
        $this->selectedServices = [];
        $this->autreFiltres = [];
        $this->approximite = false;
        $this->showClosestOnly = false;
        $this->villes = [];
        $this->ageInterval = [];
        $this->tailleInterval = [];
        $this->tarifInterval = [];
        $this->getValueRange();
        $this->resetPage();
        return redirect('escortes');
    }

    public function chargeVille()
    {
        if (!empty($this->selectedCanton)) {
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
    
    public function updated($propertyName)
    {
        // Réinitialiser la pagination à 1 lors de la modification des filtres principaux
        $filterProperties = [
            'selectedCanton',
            'selectedVille',
            'selectedGenre',
            'selectedCategories',
            'selectedServices',
            'autreFiltres',
            'approximite',
            'showClosestOnly',
            'minDistance',
            'maxDistanceSelected'
        ];
        
        if (in_array($propertyName, $filterProperties)) {
            $this->resetPage();
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

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return round($angle * $earthRadius, 0);
    }

    private function getValueRange(){

        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? 'FR';
            $query = User::query()
            ->where('profile_type', 'escorte')
            ->orderBy('is_profil_pause')
            ->orderByDesc('rate_activity')
            ->orderByDesc('last_activity');
        if (Auth::user()) {
            $query->where('id', '!=', Auth::user()->id);
        }
        $baseEscorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
            return $escort->isProfileVisibleTo($viewerCountry);
        });
        $this->ageMin = $baseEscorts->min('age');
        $this->ageMax = $baseEscorts->max('age');
        foreach ($baseEscorts as $escort) {
            $min = $escort->tailles; // Assure-toi que le nom de la méthode est correct
        
            if ($min > 0 && $min < $this->tailleMin) {
                $this->tailleMin = $min;
            }
        }
        
        $this->tailleMax = $baseEscorts->max('tailles');
        $this->tarifMin = $baseEscorts->min('tarif');
        $this->tarifMax = $baseEscorts->max('tarif');
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
        $this->cantons = Cache::remember('all_cantons', 3600, function () {
            return Canton::all();
        });
        $this->availableVilles = Ville::all();
        $this->categories = Cache::remember('all_categories', 3600, function () {
            return Categorie::where('type', 'escort')->get();
        });
        $serviceQuery = Service::query();


        // $listeGenresExist = User::where('profile_type', 'escorte')->pluck('genre_id')->unique();
        // $this->genres = Genre::whereIn('id', $listeGenresExist)->get();
        $this->genres = Genre::all()->take(3);

        // Détection du pays via IP
        $position = Location::get(request()->ip());
        $viewerCountry = $position?->countryCode ?? 'FR'; // fallback pour dev
        $viewerLatitude = $position?->latitude ?? 0;
        $viewerLongitude = $position?->longitude ?? 0;

        $this->getValueRange();

        if (!$this->approximite) {
             // 1. Récupérer tous les profils de base
                $query = User::query()
                ->where('profile_type', 'escorte')
                ->orderBy('is_profil_pause')
                ->orderByDesc('rate_activity')
                ->orderByDesc('last_activity');
            if (Auth::user()) {
                $query->where('id', '!=', Auth::user()->id);
            }
            $baseEscorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
                return $escort->isProfileVisibleTo($viewerCountry);
            });
            $this->ageMin = $baseEscorts->min('age');
            $this->ageMax = $baseEscorts->max('age');
            foreach ($baseEscorts as $escort) {
                $min = $escort->tailles; // Assure-toi que le nom de la méthode est correct
            
                if ($min > 0 && $min < $this->tailleMin) {
                    $this->tailleMin = $min;
                }
            }
            
            $this->tailleMax = $baseEscorts->max('tailles');
            $this->tarifMin = $baseEscorts->min('tarif');
            $this->tarifMax = $baseEscorts->max('tarif');

            // 2. Initialiser une collection vide pour les résultats finaux
            $filteredEscorts = collect();

             // 3. Appliquer chaque filtre de manière additive
            if ($this->selectedCanton) {
                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('canton', $this->selectedCanton));
            }

            // if ($this->selectedCanton) {
            //     $query->where('canton', $this->selectedCanton);
            // }

            if ($this->selectedVille) {
                // $query->where('ville', $this->selectedVille);
                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('ville', $this->selectedVille));
            }

            if ($this->selectedGenre) {
                // $query->where('genre_id', $this->selectedGenre);
                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('genre_id', $this->selectedGenre));
            }

            // if ($this->selectedCategories) {
            //     $query->where(function ($q) {
            //         foreach ($this->selectedCategories as $categorie) {
            //             $q->where('categorie', 'LIKE', '%' . $categorie . '%');
            //         }
            //     });
            // }

            // if ($this->selectedServices) {
            //     $query->where(function ($q) {
            //         foreach ($this->selectedServices as $service) {
            //             $q->where('service', 'LIKE', '%' . $service . '%');
            //         }
            //     });
            // }

            if (!empty($this->selectedCategories)) {
                foreach ($this->selectedCategories as $categorie) {
                    $filteredEscorts = $filteredEscorts->merge(
                        $baseEscorts->filter(function ($escort) use ($categorie) {
                            return str_contains($escort->categorie, (string) $categorie);
                        })
                    );
                }
            }
        
            if (!empty($this->selectedServices)) {
                foreach ($this->selectedServices as $service) {
                    $filteredEscorts = $filteredEscorts->merge(
                        $baseEscorts->filter(function ($escort) use ($service) {
                            return str_contains($escort->service, (string) $service);
                        })
                    );
                }
            }

            // if ($this->autreFiltres) {
            //     $query->where(function ($q) {
            //         foreach ($this->autreFiltres as $key => $value) {
            //             if (!empty($value)) {
            //                 switch ($key) {
            //                     case 'mensuration':
            //                         $q->where('mensuration_id', $value);
            //                         break;
            //                     case 'orientation':
            //                         $q->where('orientation_sexuelle_id', (int) $value);
            //                         break;
            //                     case 'couleur_yeux':
            //                         $q->where('couleur_yeux_id', (int) $value);
            //                         break;
            //                     case 'couleur_cheveux':
            //                         $q->where('couleur_cheveux_id', (int) $value);
            //                         break;
            //                     case 'poitrine':
            //                         $q->where('poitrine_id', (int) $value);
            //                         break;
            //                     case 'langues':
            //                         $q->whereJsonContains('langues', $value);
            //                         break;
            //                     case 'pubis':
            //                         $q->where('pubis_type_id', (int) $value);
            //                         break;
            //                     case 'tatouages':
            //                         $q->where('tatoo_id', (int) $value);
            //                         break;
            //                     case 'taille_poitrine':
            //                         $poitrineValues = [
            //                             'petite' => ['A', 'B', 'C'],
            //                             'moyenne' => ['D', 'E', 'F'],
            //                             'grosse' => ['G', 'H'],
            //                         ];

            //                         if ($value == 'autre') {
            //                             $this->autre = true;
            //                         } else {
            //                             $this->autre = false;
            //                         }
                                    
            //                         // Vérifier si la valeur recherchée existe comme clé dans $poitrineValues
            //                         if (array_key_exists($value, $poitrineValues)) {
            //                             $taillesCorrespondantes = $poitrineValues[$value];
                                        
            //                             $q->where(function ($q) use ($taillesCorrespondantes) {
            //                                 foreach ($taillesCorrespondantes as $taille) {
            //                                     $q->orWhere('taille_poitrine', 'LIKE', "%{$taille}%");
            //                                 }
            //                             });
            //                         }
            //                         break;
            //                     case 'taille_poitrine_detail':
            //                         $q->where('taille_poitrine', 'LIKE', "%{$value}%");
            //                         break;
            //                     case 'mobilite':
            //                         $q->where('mobilite_id', (int) $value);
            //                         break;
            //                     default:
            //                         $q->where($key, 'LIKE', '%' . $value . '%');
            //                         break;
            //                 }
            //             }
            //         }
            //     });
            // }

            if ($this->autreFiltres) {
                foreach ($this->autreFiltres as $key => $value) {
                    if (!empty($value)) {
                        switch ($key) {
                            case 'mensuration':
                                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('mensuration_id', $value));
                                break;
                            case 'orientation':
                                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('orientation_sexuelle_id', (int) $value));
                                break;
                            case 'couleur_yeux':
                                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('couleur_yeux_id', (int) $value));
                                break;
                            case 'couleur_cheveux':
                                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('couleur_cheveux_id', (int) $value));
                                break;
                            case 'poitrine':
                                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('poitrine_id', (int) $value));
                                break;
                            case 'langues':
                                $filteredEscorts = $filteredEscorts->merge(
                                    $baseEscorts->filter(function ($escort) use ($value) {
                                        return in_array($value, $escort->langues ?? []);
                                    })
                                );
                                break;
                            case 'pubis':
                                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('pubis_type_id', (int) $value));
                                break;
                            case 'tatouages':
                                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('tatoo_id', (int) $value));
                                break;
                            case 'taille_poitrine':
                                $poitrineValues = [
                                    'petite' => ['A', 'B', 'C'],
                                    'moyenne' => ['D', 'E', 'F'],
                                    'grosse' => ['G', 'H'],
                                ];
                                if (array_key_exists($value, $poitrineValues)) {
                                    $taillesCorrespondantes = $poitrineValues[$value];
                                    $filteredEscorts = $filteredEscorts->merge(
                                        $baseEscorts->filter(function ($escort) use ($taillesCorrespondantes) {
                                            foreach ($taillesCorrespondantes as $taille) {
                                                if (str_contains($escort->taille_poitrine, $taille)) {
                                                    return true;
                                                }
                                            }
                                            return false;
                                        })
                                    );
                                }
                                break;
                            case 'taille_poitrine_detail':
                                $filteredEscorts = $filteredEscorts->merge(
                                    $baseEscorts->filter(function ($escort) use ($value) {
                                        return str_contains($escort->taille_poitrine, $value);
                                    })
                                );
                                break;
                            case 'mobilite':
                                $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('mobilite_id', (int) $value));
                                break;
                        
                            default:
                                $filteredEscorts = $filteredEscorts->merge(
                                    $baseEscorts->filter(function ($escort) use ($key, $value) {
                                        return str_contains(strtolower($escort->$key ?? ''), strtolower($value));
                                    })
                                );
                                break;
                        }
                    }
                }
            }

            $minAge = isset($this->ageInterval['min']) ? (int) $this->ageInterval['min'] : null;
            $maxAge = isset($this->ageInterval['max']) ? (int) $this->ageInterval['max'] : null;

            logger()->info('Age interval: ' . json_encode($this->ageInterval));
            logger()->info('Min age: ' . $minAge);
            logger()->info('Max age: ' . $maxAge);
            logger()->info('Filtred count before : ' . $filteredEscorts->count());

            if ($minAge !== null && $maxAge !== null && $minAge <= $maxAge) {
                $filteredEscorts = $filteredEscorts->merge(
                    $baseEscorts->filter(function ($escort) use ($minAge, $maxAge) {
                        return $escort->age >= $minAge && $escort->age <= $maxAge;
                    })
                );
            }

            logger()->info('Filtred count after : ' . $filteredEscorts->count());


            $minTaille = isset($this->tailleInterval['min']) ? (int) $this->tailleInterval['min'] : null;
            $maxTaille = isset($this->tailleInterval['max']) ? (int) $this->tailleInterval['max'] : null;

            logger()->info('Taille interval: ' . json_encode($this->tailleInterval));
            logger()->info('Min Taille: ' . $minTaille);
            logger()->info('Max Taille: ' . $maxTaille);
            logger()->info('Filtred count before : ' . $filteredEscorts->count());

            if ($minTaille !== null && $maxTaille !== null && $minTaille <= $maxTaille) {
                $filteredEscorts = $filteredEscorts->merge(
                    $baseEscorts->filter(function ($escort) use ($minTaille, $maxTaille) {
                        return $escort->tailles >= $minTaille && $escort->tailles <= $maxTaille;
                    })
                );
            }

            logger()->info('Filtred count after : ' . $filteredEscorts->count());

            $minTarif = isset($this->tarifInterval['min']) ? (int) $this->tarifInterval['min'] : null;
            $maxTarif = isset($this->tarifInterval['max']) ? (int) $this->tarifInterval['max'] : null;

            logger()->info('Tarif interval: ' . json_encode($this->tarifInterval));
            logger()->info('Min tarif: ' . $minTarif);
            logger()->info('Max tarif: ' . $maxTarif);
            logger()->info('Filtred count before : ' . $filteredEscorts->count());

            if ($minTarif !== null && $maxTarif !== null && $minTarif <= $maxTarif) {
                $filteredEscorts = $filteredEscorts->merge(
                    $baseEscorts->filter(function ($escort) use ($minTarif, $maxTarif) {
                        return $escort->tarif >= $minTarif && $escort->tarif <= $maxTarif;
                    })
                );
            }

            logger()->info('Filtred count after : ' . $filteredEscorts->count());

            

             // 4. Supprimer les doublons
            $filteredEscorts = $filteredEscorts->unique('id');
            logger()->info('Filtred count after unique : ' . $filteredEscorts->count());


            // $escorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
            //     return $escort->isProfileVisibleTo($viewerCountry);
            // });

            // 5. Si aucun filtre n'est sélectionné, utiliser tous les profils
            if ($filteredEscorts->isEmpty() && empty($this->selectedCanton) && empty($this->selectedVille) && empty($this->selectedGenre) && empty($this->selectedCategories) && empty($this->selectedServices) && empty($this->autreFiltres)) {
                $filteredEscorts = $baseEscorts;
            }

            $escorts = $filteredEscorts;

            // Si aucun résultat, chercher dans les villes proches
            if ($escorts->isEmpty() && !empty($this->selectedVille)) {
                $nearbyVilles = Ville::where('canton_id', $this->selectedCanton)->where('id', '!=', $this->selectedVille)->get();

                foreach ($nearbyVilles as $ville) {
                    $query = User::query()->where('profile_type', 'escorte')->where('ville', $ville->id)
                    ->orderBy('is_profil_pause')            // 1️⃣ Profil actif (0) avant pause (1)
                    ->orderByDesc('rate_activity')          // 2️⃣ Taux d'activité élevé en premier
                    ->orderByDesc('last_activity')          // 3️⃣ Activité récente ensuite
                    ;

                    if (Auth::user()) {
                        $query->where('id', '!=', Auth::user()->id);
                    }
                    $baseEscorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
                        return $escort->isProfileVisibleTo($viewerCountry);
                    });

                    if ($this->selectedGenre) {
                        // $query->where('genre_id', $this->selectedGenre);
                        $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('genre_id', $this->selectedGenre));
                    }

                    // if ($this->selectedCategories) {
                    //     $query->where(function ($q) {
                    //         foreach ($this->selectedCategories as $categorie) {
                    //             $q->where('categorie', 'LIKE', '%' . $categorie . '%');
                    //         }
                    //     });
                    // }

                    // if ($this->selectedServices) {
                    //     $query->where(function ($q) {
                    //         foreach ($this->selectedServices as $service) {
                    //             $q->where('service', 'LIKE', '%' . $service . '%');
                    //         }
                    //     });
                    // }

                    if ($this->selectedCategories) {
                        foreach ($this->selectedCategories as $categorie) {
                            $filteredEscorts = $filteredEscorts->merge(
                                $baseEscorts->filter(function ($escort) use ($categorie) {
                                    return str_contains($escort->categorie, (string) $categorie);
                                })
                            );
                        }
                    }
                
                    if ($this->selectedServices) {
                        foreach ($this->selectedServices as $service) {
                            $filteredEscorts = $filteredEscorts->merge(
                                $baseEscorts->filter(function ($escort) use ($service) {
                                    return str_contains($escort->service, (string) $service);
                                })
                            );
                        }
                    }

                    // if ($this->autreFiltres) {
                    //     $query->where(function ($q) {
                    //         foreach ($this->autreFiltres as $key => $value) {
                    //             if (!empty($value)) {
                    //                 switch ($key) {
                    //                     case 'mensuration':
                    //                         $q->where('mensuration_id', $value);
                    //                         break;
                    //                     case 'orientation':
                    //                         $q->where('orientation_sexuelle_id', (int) $value);
                    //                         break;
                    //                     case 'couleur_yeux':
                    //                         $q->where('couleur_yeux_id', (int) $value);
                    //                         break;
                    //                     case 'couleur_cheveux':
                    //                         $q->where('couleur_cheveux_id', (int) $value);
                    //                         break;
                    //                     case 'poitrine':
                    //                         $q->where('poitrine_id', (int) $value);
                    //                         break;
                    //                     case 'langues':
                    //                         $q->whereJsonContains('langues', $value);
                    //                         break;
                    //                     case 'pubis':
                    //                         $q->where('pubis_type_id', (int) $value);
                    //                         break;
                    //                     case 'tatouages':
                    //                         $q->where('tatoo_id', (int) $value);
                    //                         break;
                    //                     case 'taille_poitrine':
                    //                         $poitrineValues = [
                    //                             'petite' => ['A', 'B', 'C'],
                    //                             'moyenne' => ['D', 'E', 'F'],
                    //                             'grosse' => ['G', 'H'],
                    //                         ];
                                            
                    //                         // Vérifier si la valeur recherchée existe comme clé dans $poitrineValues
                    //                         if (array_key_exists($value, $poitrineValues)) {
                    //                             $taillesCorrespondantes = $poitrineValues[$value];
                                                
                    //                             $q->where(function ($q) use ($taillesCorrespondantes) {
                    //                                 foreach ($taillesCorrespondantes as $taille) {
                    //                                     $q->orWhere('taille_poitrine', 'LIKE', "%{$taille}%");
                    //                                 }
                    //                             });
                    //                         }
                    //                         break;
                    //                     case 'mobilite':
                    //                         $q->where('mobilite_id', (int) $value);
                    //                         break;
                    //                     default:
                    //                         $q->where($key, 'LIKE', '%' . $value . '%');
                    //                         break;
                    //                 }
                    //             }
                    //         }
                    //     });
                    // }

                    if ($this->autreFiltres) {
                        foreach ($this->autreFiltres as $key => $value) {
                            if (!empty($value)) {
                                switch ($key) {
                                    case 'mensuration':
                                        $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('mensuration_id', $value));
                                        break;
                                    case 'orientation':
                                        $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('orientation_sexuelle_id', (int) $value));
                                        break;
                                    case 'couleur_yeux':
                                        $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('couleur_yeux_id', (int) $value));
                                        break;
                                    case 'couleur_cheveux':
                                        $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('couleur_cheveux_id', (int) $value));
                                        break;
                                    case 'poitrine':
                                        $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('poitrine_id', (int) $value));
                                        break;
                                    case 'langues':
                                        $filteredEscorts = $filteredEscorts->merge(
                                            $baseEscorts->filter(function ($escort) use ($value) {
                                                return in_array($value, $escort->langues ?? []);
                                            })
                                        );
                                        break;
                                    case 'pubis':
                                        $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('pubis_type_id', (int) $value));
                                        break;
                                    case 'tatouages':
                                        $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('tatoo_id', (int) $value));
                                        break;
                                    case 'taille_poitrine':
                                        $poitrineValues = [
                                            'petite' => ['A', 'B', 'C'],
                                            'moyenne' => ['D', 'E', 'F'],
                                            'grosse' => ['G', 'H'],
                                        ];
                                        if (array_key_exists($value, $poitrineValues)) {
                                            $taillesCorrespondantes = $poitrineValues[$value];
                                            $filteredEscorts = $filteredEscorts->merge(
                                                $baseEscorts->filter(function ($escort) use ($taillesCorrespondantes) {
                                                    foreach ($taillesCorrespondantes as $taille) {
                                                        if (str_contains($escort->taille_poitrine, $taille)) {
                                                            return true;
                                                        }
                                                    }
                                                    return false;
                                                })
                                            );
                                        }
                                        break;
                                    case 'taille_poitrine_detail':
                                        $filteredEscorts = $filteredEscorts->merge(
                                            $baseEscorts->filter(function ($escort) use ($value) {
                                                return str_contains($escort->taille_poitrine, $value);
                                            })
                                        );
                                        break;
                                    case 'mobilite':
                                        $filteredEscorts = $filteredEscorts->merge($baseEscorts->where('mobilite_id', (int) $value));
                                        break;
                                    default:
                                        $filteredEscorts = $filteredEscorts->merge(
                                            $baseEscorts->filter(function ($escort) use ($key, $value) {
                                                return str_contains(strtolower($escort->$key ?? ''), strtolower($value));
                                            })
                                        );
                                        break;
                                }
                            }
                        }
                    }
                    // $escorts = $query->get()->filter(function ($escort) use ($viewerCountry) {
                    //     return $escort->isProfileVisibleTo($viewerCountry);
                    // });

                    // 4. Supprimer les doublons
                    $filteredEscorts = $filteredEscorts->unique('id');

                    if (!$filteredEscorts->isEmpty()) {
                        $escorts = $filteredEscorts;
                        break;
                    }
                }
            }

            // Compter le nombre d'escorts trouvés
            // $this->escortCount = $escorts->count();

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
                $categoriesIds = !empty($escort->categorie) ? explode(',', $escort->categorie) : [];
                $escort['categorie'] = Categorie::whereIn('id', $categoriesIds)->get();
                $escort['canton'] = Canton::find($escort->canton);
                $escort['ville'] = Ville::find($escort->ville);
            }

             // 8. Mettre à jour le nombre d'escorts
            $this->escortCount = $filteredEscorts->count();
        }

        if ($this->approximite) {
            $userLatitude = $this->latitudeUser;
            $userLongitude = $this->longitudeUser;

            if (!$userLatitude || !$userLongitude) {
                $userLatitude = $viewerLatitude;
                $userLongitude = $viewerLongitude;
            }

            // Initialiser les variables
            // $minDistance = PHP_FLOAT_MAX;
            // $maxAvailableDistance = 0;
            // $escortCount = 0;

            // if(Auth::user()){
            // $escorts = User::where('profile_type', 'escorte')
            //     ->where('id', '!=', Auth::user()->id)
            //     ->whereNotNull('lat')
            //     ->whereNotNull('lon')
            //     ->orderBy('is_profil_pause')            // 1️⃣ Profil actif (0) avant pause (1)
            //     ->orderByDesc('rate_activity')          // 2️⃣ Taux d'activité élevé en premier
            //     ->orderByDesc('last_activity')          // 3️⃣ Activité récente ensuite
            //     ->get()
            //     ->filter(function ($escort) use ($viewerCountry) {
            //         return $escort->isProfileVisibleTo($viewerCountry);
            //     })
            //     ->map(function ($escort) use ($userLatitude, $userLongitude, &$minDistance, &$maxAvailableDistance, &$escortCount) {
            //         $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon);

            //         // Mettre à jour les distances min et max
            //         $minDistance = min($minDistance, $distance);
            //         $maxAvailableDistance = max($maxAvailableDistance, $distance);

            //         $escortCount++;

            //         return [
            //             'escort' => $escort,
            //             'distance' => $distance,
            //         ];
            //     });
            // }else{
            //     $escorts = User::where('profile_type', 'escorte')
            //     ->whereNotNull('lat')
            //     ->whereNotNull('lon')
            //     ->orderBy('is_profil_pause')            // 1️⃣ Profil actif (0) avant pause (1)
            //     ->orderByDesc('rate_activity')          // 2️⃣ Taux d'activité élevé en premier
            //     ->orderByDesc('last_activity')          // 3️⃣ Activité récente ensuite
            //     ->get()
            //     ->filter(function ($escort) use ($viewerCountry) {
            //         return $escort->isProfileVisibleTo($viewerCountry);
            //     })
            //     ->map(function ($escort) use ($userLatitude, $userLongitude, &$minDistance, &$maxAvailableDistance, &$escortCount) {
            //         $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon);

            //         // Mettre à jour les distances min et max
            //         $minDistance = min($minDistance, $distance);
            //         $maxAvailableDistance = max($maxAvailableDistance, $distance);

            //         $escortCount++;

            //         return [
            //             'escort' => $escort,
            //             'distance' => $distance,
            //         ];
            //     });
            // }

            // 1. Récupérer tous les profils de base avec leurs distances
                $query = User::where('profile_type', 'escorte')
                ->whereNotNull('lat')
                ->whereNotNull('lon')
                ->orderBy('is_profil_pause')
                ->orderByDesc('rate_activity')
                ->orderByDesc('last_activity');
            if (Auth::user()) {
                $query->where('id', '!=', Auth::user()->id);
            }
            $baseEscorts = $query->get()
                ->filter(function ($escort) use ($viewerCountry) {
                    return $escort->isProfileVisibleTo($viewerCountry);
                })
                ->map(function ($escort) use ($userLatitude, $userLongitude) {
                    $distance = $this->haversineGreatCircleDistance($userLatitude, $userLongitude, $escort->lat, $escort->lon);
                    return [
                        'escort' => $escort,
                        'distance' => $distance,
                    ];
                });

            // 2. Initialiser une collection vide pour les résultats finaux
            $filteredEscorts = collect();
            $minDistance = PHP_FLOAT_MAX;
            $maxAvailableDistance = 0;
            $escortCount = 0;

            // 3. Appliquer chaque filtre de manière additive
    if ($this->selectedGenre) {
        $filteredEscorts = $filteredEscorts->merge(
            $baseEscorts->filter(function ($item) {
                return $item['escort']->genre_id == $this->selectedGenre;
            })
        );
    }

    if ($this->selectedCategories) {
        foreach ($this->selectedCategories as $categorie) {
            $filteredEscorts = $filteredEscorts->merge(
                $baseEscorts->filter(function ($item) use ($categorie) {
                    return str_contains($item['escort']->categorie, (string) $categorie);
                })
            );
        }
    }

    if ($this->selectedServices) {
        foreach ($this->selectedServices as $service) {
            $filteredEscorts = $filteredEscorts->merge(
                $baseEscorts->filter(function ($item) use ($service) {
                    return str_contains($item['escort']->service, (string) $service);
                })
            );
        }
    }

    if ($this->autreFiltres) {
        foreach ($this->autreFiltres as $key => $value) {
            if (!empty($value)) {
                switch ($key) {
                    case 'mensuration':
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($value) {
                                return $item['escort']->mensuration_id == $value;
                            })
                        );
                        break;
                    case 'orientation':
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($value) {
                                return $item['escort']->orientation_sexuelle_id == (int) $value;
                            })
                        );
                        break;
                    case 'couleur_yeux':
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($value) {
                                return $item['escort']->couleur_yeux_id == (int) $value;
                            })
                        );
                        break;
                    case 'couleur_cheveux':
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($value) {
                                return $item['escort']->couleur_cheveux_id == (int) $value;
                            })
                        );
                        break;
                    case 'poitrine':
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($value) {
                                return $item['escort']->poitrine_id == (int) $value;
                            })
                        );
                        break;
                    case 'langues':
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($value) {
                                return in_array($value, $item['escort']->langues ?? []);
                            })
                        );
                        break;
                    case 'pubis':
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($value) {
                                return $item['escort']->pubis_type_id == (int) $value;
                            })
                        );
                        break;
                    case 'tatouages':
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($value) {
                                return $item['escort']->tatoo_id == (int) $value;
                            })
                        );
                        break;
                    case 'taille_poitrine':
                        $poitrineValues = [
                            'petite' => ['A', 'B', 'C'],
                            'moyenne' => ['D', 'E', 'F'],
                            'grosse' => ['G', 'H'],
                        ];
                        if (array_key_exists($value, $poitrineValues)) {
                            $taillesCorrespondantes = $poitrineValues[$value];
                            $filteredEscorts = $filteredEscorts->merge(
                                $baseEscorts->filter(function ($item) use ($taillesCorrespondantes) {
                                    foreach ($taillesCorrespondantes as $taille) {
                                        if (str_contains($item['escort']->taille_poitrine, $taille)) {
                                            return true;
                                        }
                                    }
                                    return false;
                                })
                            );
                        }
                        break;
                    case 'taille_poitrine_detail':
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($value) {
                                return str_contains($item['escort']->taille_poitrine, $value);
                            })
                        );
                        break;
                    case 'mobilite':
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($value) {
                                return $item['escort']->mobilite_id == (int) $value;
                            })
                        );
                        break;
                    default:
                        $filteredEscorts = $filteredEscorts->merge(
                            $baseEscorts->filter(function ($item) use ($key, $value) {
                                return str_contains(strtolower($item['escort']->$key ?? ''), strtolower($value));
                            })
                        );
                        break;
                }
            }
        }
    }

    // 4. Si aucun filtre n'est sélectionné, utiliser tous les profils
    if ($filteredEscorts->isEmpty() && empty($this->selectedGenre) && empty($this->selectedCategories) && empty($this->selectedServices) && empty($this->autreFiltres)) {
        $filteredEscorts = $baseEscorts;
    }

    // 5. Supprimer les doublons
    $filteredEscorts = $filteredEscorts->unique('escort.id');

    // 6. Mettre à jour les distances min/max et le nombre d'escorts
    if ($filteredEscorts->isNotEmpty()) {
        $minDistance = $filteredEscorts->min('distance');
        $maxAvailableDistance = $filteredEscorts->max('distance');
        $escortCount = $filteredEscorts->count();
    }

    // 7. Filtrer par plage de distance
    if ($escortCount > 0) {
        $filteredEscorts = $filteredEscorts->filter(function ($item) {
            return $item['distance'] >= $this->minDistance && $item['distance'] <= $this->maxDistanceSelected;
        });
    }

    // 8. Trier par distance
    $filteredEscorts = $filteredEscorts->sortBy('distance');


            // Mettre à jour les propriétés de la classe
            $this->minDistance = $escortCount > 0 ? $minDistance : 0;
            $this->maxAvailableDistance = $escortCount > 0 ? ceil($maxAvailableDistance) : 0;
            // $this->escortCount = $escortCount;
            $this->escortCount = $filteredEscorts->count();

            // Si c'est le premier chargement, initialiser maxDistanceSelected
            if (!$this->maxDistanceSelected && $escortCount > 0) {
                $this->maxDistanceSelected = $this->maxAvailableDistance;
            }

            // Filtrer par plage de distance, catégories et genre si sélectionnés
            // if ($escortCount > 0) {
            //     $escorts = $escorts->filter(function ($item) {
            //         // Vérifier la distance
            //         $distanceMatch = $item['distance'] >= $this->minDistance && $item['distance'] <= $this->maxDistanceSelected;

            //         if (!$distanceMatch) {
            //             return false;
            //         }

            //         // Vérifier le genre si sélectionné
            //         if ($this->selectedGenre && $item['escort']->genre_id != $this->selectedGenre) {
            //             return false;
            //         }

            //         // Vérifier les catégories si sélectionnées
            //         if (!empty($this->selectedCategories)) {
            //             // Convertir la catégorie de l'escort en tableau si ce n'est pas déjà le cas
            //             $escortCategory = $item['escort']->categorie;
            //             $escortCategories = is_array($escortCategory) ? $escortCategory : [(string) $escortCategory];

            //             // Convertir les IDs en chaînes pour la comparaison
            //             $escortCategories = array_map('strval', $escortCategories);
            //             $selectedCategories = array_map('strval', $this->selectedCategories);

            //             // Vérifier s'il y a une correspondance
            //             $hasMatchingCategory = count(array_intersect($selectedCategories, $escortCategories)) > 0;
            //             if (!$hasMatchingCategory) {
            //                 return false;
            //             }
            //         }

            //         // Vérifier les services si sélectionnés
            //         if (!empty($this->selectedServices)) {
            //             $escortServices = $item['escort']->service;
            //             $escortServicesArray = is_array($escortServices) ? $escortServices : explode(',', (string) $escortServices);

            //             $escortServicesArray = array_map('strval', $escortServicesArray);
            //             $selectedServices = array_map('strval', $this->selectedServices);

            //             $hasMatchingService = count(array_intersect($selectedServices, $escortServicesArray)) > 0;
            //             if (!$hasMatchingService) {
            //                 return false;
            //             }
            //         }

            //         // Vérifier les autres filtres
            //         if (!empty($this->autreFiltres)) {
            //             foreach ($this->autreFiltres as $key => $value) {
            //                 if (!empty($value)) {
            //                     $escortValue = $item['escort']->$key;

            //                     // Si c'est une relation, on prend l'ID
            //                     if (is_object($escortValue) && method_exists($escortValue, 'getKey')) {
            //                         $escortValue = $escortValue->getKey();
            //                     }

            //                     // Si la valeur est numérique, on la convertit en entier pour la comparaison
            //                     if (is_numeric($escortValue)) {
            //                         $escortValue = (int) $escortValue;
            //                         $value = (int) $value;
            //                     }

            //                     // Vérifier la correspondance en fonction du type de filtre
            //                     switch ($key) {
            //                         case 'mensuration':
            //                             if ($escortValue != $value) {
            //                                 return false;
            //                             }
            //                             break;
            //                         case 'orientation':
            //                         case 'couleur_yeux':
            //                         case 'couleur_cheveux':
            //                         case 'poitrine':
            //                         case 'pubis':
            //                         case 'tatouages':
            //                         case 'mobilite':
            //                             if ($escortValue != $value) {
            //                                 return false;
            //                             }
            //                             break;
            //                         case 'taille_poitrine':
            //                             $poitrineValues = [
            //                                 'petite' => ['A', 'B', 'C'],
            //                                 'moyenne' => ['D', 'E', 'F'],
            //                                 'grosse' => ['G', 'H'],
            //                             ];

            //                             if (array_key_exists($value, $poitrineValues)) {
            //                                 $taillesCorrespondantes = $poitrineValues[$value];

            //                                 $escorts = $escorts->where(function ($q) use ($taillesCorrespondantes) {
            //                                     foreach ($taillesCorrespondantes as $taille) {
            //                                         $q->orWhere('taille_poitrine', 'LIKE', "%{$taille}%");
            //                                     }
            //                                 });
            //                             }
            //                             break;
            //                         default:
            //                             // Pour les autres champs, on fait une recherche partielle
            //                             if (is_string($escortValue) && stripos($escortValue, $value) === false) {
            //                                 return false;
            //                             }
            //                             break;
            //                     }
            //                 }
            //             }
            //         }

            //         return true;
            //     });
            // }

            // Trier par distance
            // $escorts = $escorts->sortBy('distance');
            // $this->escortCount = $escorts->count();

            // 7. Mettre à jour $escorts pour la suite
            $escorts = $filteredEscorts;

            // Convertir en pagination
            $perPage = 12;
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage();
            $currentItems = $escorts->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedEscorts = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $escorts->count(), $perPage, $currentPage, ['path' => request()->url(), 'query' => request()->query()]);

            // Hydrater les relations
            foreach ($paginatedEscorts as $escortData) {
                $escort = $escortData['escort'];
                $categoriesIds = !empty($escort->categorie) ? explode(',', $escort->categorie) : [];
                $escort['categorie'] = Categorie::whereIn('id', $categoriesIds)->get();
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
                if(Auth::user()){
                $escorts = User::where('profile_type', 'escorte')
                    ->where('id', '!=', Auth::user()->id)
                    ->whereNotNull('lat')
                    ->whereNotNull('lon')
                    ->orderBy('is_profil_pause')            // 1️⃣ Profil actif (0) avant pause (1)
                    ->orderByDesc('rate_activity')          // 2️⃣ Taux d'activité élevé en premier
                    ->orderByDesc('last_activity')          // 3️⃣ Activité récente ensuite
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
                }else{
                    $escorts = User::where('profile_type', 'escorte')
                    ->whereNotNull('lat')
                    ->whereNotNull('lon')
                    ->orderBy('is_profil_pause')            // 1️⃣ Profil actif (0) avant pause (1)
                    ->orderByDesc('rate_activity')          // 2️⃣ Taux d'activité élevé en premier
                    ->orderByDesc('last_activity')          // 3️⃣ Activité récente ensuite
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
                }
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
                                                        $q->orWhere('taille_poitrine', 'LIKE', "%{$taille}%");
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
                $categoriesIds = !empty($escort->categorie) ? explode(',', $escort->categorie) : [];
                $escort['categorie'] = Categorie::whereIn('id', $categoriesIds)->get();
                $escort['canton'] = Canton::find($escort->canton);
                $escort['ville'] = Ville::find($escort->ville);
            }
        }
        $selecterCantonInfo = null;
        $selecterVilleInfo = null;
        $selecterGenreInfo = null;
        $selecterCategoriesInfo = null;
        $selecterServicesInfo = null;
        $selecterAutreFiltresInfo = null;
        if($this->selectedCanton){
            $selecterCantonInfo = Canton::find($this->selectedCanton);
        }
        if($this->selectedVille){
            $selecterVilleInfo = Ville::find($this->selectedVille);
        }
        if($this->selectedGenre){
            $selecterGenreInfo = Genre::find($this->selectedGenre);
        }
        if($this->selectedCategories){
            $selecterCategoriesInfo = Categorie::whereIn('id', $this->selectedCategories)->get();
        }
        if($this->selectedServices){
            $selecterServicesInfo = Service::whereIn('id', $this->selectedServices)->get();
        }

        foreach ($this->autreFiltres as $key => $value) {
            if (!empty($value)) {
                switch ($key) {
                    case 'origine':
                        $origine = $value;
                        $selecterAutreFiltresInfo['origine'] = $origine;
                        break;
                    case 'mensuration':

                        $mensuration = Mensuration::find($value);
                        $selecterAutreFiltresInfo['mensuration'] = $mensuration;
                      
                        break;
                    case 'orientation':
                        $orientation = OrientationSexuelle::find($value);
                        $selecterAutreFiltresInfo['orientation'] = $orientation;
                        break;
                    case 'couleur_yeux':
                        $couleur_yeux = CouleurYeux::find($value);
                        $selecterAutreFiltresInfo['couleur_yeux'] = $couleur_yeux;
                        break;
                    case 'couleur_cheveux':
                        $couleur_cheveux = CouleurCheveux::find($value);
                        $selecterAutreFiltresInfo['couleur_cheveux'] = $couleur_cheveux;
                        break;
                    case 'poitrine':
                        $poitrine = Poitrine::find($value);
                        $selecterAutreFiltresInfo['poitrine'] = $poitrine;
                        break;
                    case 'langues':
                        $langue = $value;
                        $selecterAutreFiltresInfo['langue'] = $langue;
                        break;
                    case 'pubis':
                        $pubis = PubisType::find($value);
                        $selecterAutreFiltresInfo['pubis'] = $pubis;
                        break;
                    case 'tatouages':
                        $tatouages = Tattoo::find($value);
                        $selecterAutreFiltresInfo['tatouages'] = $tatouages;
                        break;
                    case 'taille_poitrine':
                        if($value == 'petite'){
                        $selecterAutreFiltresInfo['taille_poitrine'] = __('escort-search.petite');
                        }
                        if($value == 'moyenne'){
                        $selecterAutreFiltresInfo['taille_poitrine'] = __('escort-search.moyenne');
                        }
                        if($value == 'grosse'){
                        $selecterAutreFiltresInfo['taille_poitrine'] = __('escort-search.grosse');
                        }
                        break;
                    case 'taille_poitrine_detail':
                        $taille_poitrine_detail = $value;
                        $selecterAutreFiltresInfo['taille_poitrine_detail'] = $taille_poitrine_detail;
                        break;
                    case 'mobilite':
                        $mobilite = Mobilite::find($value);
                        $selecterAutreFiltresInfo['mobilite'] = $mobilite;
                        break;

                    default:
                        break;
                }
            }
        }

        $filterApplay = [
            'selectedCanton' => $selecterCantonInfo,
            'selectedVille' => $selecterVilleInfo,
            'selectedGenre' => $selecterGenreInfo,
            'selectedCategories' => $selecterCategoriesInfo,
            'selectedServices' => $selecterServicesInfo,
            'autreFiltres' => $selecterAutreFiltresInfo,
            'approximite' => $this->approximite,
            'showClosestOnly' => $this->showClosestOnly,
        ];

        return view('livewire.escort-search', [
            'escorts' => $paginatedEscorts,
           'services' => $serviceQuery->simplePaginate(20, ['*'], 'servicesPage'),
            'maxDistance' => $this->maxDistance,
            'escortCount' => $this->escortCount,
            'currentLocale' => $currentLocale,
            'filterApplay' => $filterApplay,
        ]);
    }
}

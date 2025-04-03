<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\User;
use App\Models\Ville;
use Livewire\Component;
use Livewire\WithPagination;

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

  public array $autreFiltres = [];
  public $categories;
  public $cantons;
  public $availableVilles;
  public $villes = [];

  public function resetFilter()
  {      
    $this->selectedCanton = '';
    $this->selectedVille = '';
    $this->selectedGenre = '';
    $this->selectedCategories = [];
    $this->selectedServices = [];
    $this->autreFiltres = [];
    $this->resetPage();
    $this->render();
  }

  public function chargeVille()
  {
    if(!empty($this->selectedCanton)){
      $this->villes = Ville::where('canton_id', $this->selectedCanton)->get();
    }else{
      $this->villes = collect();
    }
  }

    public function render()
    {
        $this->cantons = Canton::all();
        $this->availableVilles = Ville::all();
        $this->categories = Categorie::where('type', 'escort')->get();
        $serviceQuery = Service::query();
        // $this->escorts = User::where('profile_type', 'escorte')->get();

        $query = User::query()->where('profile_type', 'escorte');
                
        // Filtres supplémentaires
        if ($this->selectedCanton) {
            $query->where('canton', $this->selectedCanton);
        }

        if ($this->selectedVille) {
            $query->where('ville', $this->selectedVille);
        }

        if ($this->selectedGenre) {
            $query->where('genre', $this->selectedGenre);
        }

        if ($this->selectedCategories){
          $query->where(function ($q) {
            foreach($this->selectedCategories as $categorie){
              $q->where('categorie', 'LIKE', '%'.$categorie.'%');
            }
          });
        }
        if ($this->selectedServices){
          $query->where(function ($q) {
            foreach($this->selectedServices as $service){
              $q->where('service', 'LIKE', '%'.$service.'%');
            }
          });
        }
        if ($this->autreFiltres){
          $query->where(function ($q) {
            foreach($this->autreFiltres as $key => $value){
              $q->where($key, 'LIKE', '%'.$value.'%');
            }
          });
        }

        $escorts = $query->paginate(10);
        $services = $serviceQuery->paginate(20);
        foreach ($escorts as $escort) {
          $escort['categorie'] = Categorie::find($escort->categorie);
          $escort['canton'] = Canton::find($escort->canton);
          $escort['ville'] = Ville::find($escort->ville);
        }

        return view('livewire.escort-search', [
            'escorts' => $escorts,
            'services' => $services,
        ]);
    }
}

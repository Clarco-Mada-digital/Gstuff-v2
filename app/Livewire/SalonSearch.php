<?php

namespace App\Livewire;

use App\Models\Canton;
use App\Models\Categorie;
use App\Models\User;
use App\Models\Ville;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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
    if(!empty($this->selectedSalonCanton)){
      $this->villes = Ville::where('canton_id', $this->selectedSalonCanton)->get();
    }else{
      $this->villes = collect();
    }
  }

    public function render()
    {
        $this->cantons = Canton::all();
        $this->availableVilles = Ville::all();
        $this->categories = Categorie::where('type', 'salon')->get();
        // $this->escorts = User::where('profile_type', 'escorte')->get();

        $query = User::query()->where('profile_type', 'salon');
                
        // Filtres supplémentaires
        if ($this->selectedSalonCanton) {
            $query->where('canton', 'LIKE', '%'.$this->selectedSalonCanton.'%');
            $this->resetPage();
        }

        if ($this->selectedSalonVille != '') {
            $query->where('ville', 'LIKE', '%'.$this->selectedSalonVille.'%');
            $this->resetPage();
        }

        if ($this->nbFilles) {
          $query->where(function ($q) {
            foreach($this->nbFilles as $nbFilles){
              $q->orwhere('nombre_filles', $nbFilles);
            }
          });
          $this->resetPage();
        }

        if ($this->selectedSalonCategories){
          $query->where(function ($q) {
            foreach($this->selectedSalonCategories as $categorie){
              $q->orwhere('categorie', 'LIKE', '%'.$categorie.'%');
            }
          });
          $this->resetPage();
        }

        $salons = $query->paginate(10);
        foreach ($salons as $salon) {
          $salon['categorie'] = Categorie::find($salon->categorie);
          $salon['canton'] = Canton::find($salon->canton);
          $salon['ville'] = Ville::find($salon->ville);
        }
        
        return view('livewire.salon-search', [
            'salons' => $salons,
        ]);
    }
}

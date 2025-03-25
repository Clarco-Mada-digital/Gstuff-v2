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
  
  public $selectedSalonCanton = '';
  public string $selectedSalonVille = '';
  public array $selectedSalonCategories = [];
  public $categories;
  public $cantons;
  public $availableVilles;
  public $villes = [];

  public function resetFilter()
  {      
    $this->selectedSalonCanton = '';
    $this->selectedSalonVille = '';
    $this->selectedSalonCategories = [];
    $this->villes = [];
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
            $query->where('canton', $this->selectedSalonCanton);
            $this->resetPage();
        }

        if ($this->selectedSalonVille) {
            $query->where('ville', $this->selectedSalonVille);
            $this->resetPage();
        }

        if ($this->selectedSalonCategories){
          $query->where(function ($q) {
            foreach($this->selectedSalonCategories as $categorie){
              $q->orwhere('categorie', 'LIKE', $categorie);
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

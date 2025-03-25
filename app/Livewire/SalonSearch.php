<?php

namespace App\Livewire;

use App\Models\Canton;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\User;
use App\Models\Ville;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SalonSearch extends Component
{
    use WithPagination;
  
  #[Url]
  public string $selectedCanton = '';
  #[Url]
  public string $selectedVille = '';
  #[Url]
  public array $selectedCategories = [];
  public $categories;
  public $cantons;
  public $availableVilles;
  public $villes = [];

  public function resetFilter()
  {      
    $this->selectedCanton = '';
    $this->selectedVille = '';
    $this->selectedCategories = [];
    $this->villes = [];

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
        $this->categories = Categorie::where('type', 'salon')->get();
        // $this->escorts = User::where('profile_type', 'escorte')->get();

        $query = User::query()->where('profile_type', 'salon');
                
        // Filtres supplémentaires
        if ($this->selectedCanton) {
            $query->where('canton', $this->selectedCanton);
            $this->resetPage();
        }

        if ($this->selectedVille) {
            $query->where('ville', $this->selectedVille);
            $this->resetPage();
        }

        if ($this->selectedCategories){
          $query->where(function ($q) {
            foreach($this->selectedCategories as $categorie){
              $q->orwhere('categorie', 'LIKE', $categorie);
            }
          });
          $this->resetPage();
        }

        $escorts = $query->paginate(10);
        foreach ($escorts as $escort) {
          $escort['categorie'] = Categorie::find($escort->categorie);
          $escort['canton'] = Canton::find($escort->canton);
          $escort['ville'] = Ville::find($escort->ville);
        }
        
        return view('livewire.salon-search', [
            'salons' => $escorts,
        ]);
    }
}

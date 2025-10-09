<?php

namespace App\Livewire;

use Livewire\Component;

class SalonCard extends Component
{
    public string $name;
    public string $canton;
    public string $ville;
    public float $salonId;
    public $avatar;
    public string $profileVerifie;
    public bool $isPause;

    public function render()
    {
        return view('livewire.salon-card');
    }
}

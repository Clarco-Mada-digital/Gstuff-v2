<?php

namespace App\Livewire;

use Livewire\Component;

class EscortCard extends Component
{
    public string $name;
    public string $canton;
    public string $ville;
    public string $avatar;
    public string $distance;
    public float $escortId;
    public bool $isOnline = false;
    public string $profileVerifie;
    public bool $isPause = false;


    public function render()
    {
        return view('livewire.escort-card');
    }
}

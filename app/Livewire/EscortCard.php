<?php

namespace App\Livewire;

use Livewire\Component;

class EscortCard extends Component
{
    public string $name;
    public string $canton;
    public string $ville;
    public string $avatar;
    public float $escortId;

    public function render()
    {
        return view('livewire.escort-card');
    }
}

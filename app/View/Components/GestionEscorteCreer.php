<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GestionEscorteCreer extends Component
{

    public $allrelation;
    /**
     * Create a new component instance.
     */
    public function __construct($allrelation)
    {
        //
        $this->allrelation = $allrelation;
        }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.gestion-escorte-creer');
    }
}


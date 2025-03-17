<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Ramsey\Uuid\Type\Integer;

class escort_card extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
      public string $name,
      public string $canton,
      public string $ville,
      public float $escortId,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.escort_card');
    }
}

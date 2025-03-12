<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class selecte_multiple extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
      public string $selectedItem,
      public string $placeholder,
      public array $options,
      public string $selectId,
      public string $name,
      public array $value,
    )
    {
       //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.selecte_multiple');
    }
}

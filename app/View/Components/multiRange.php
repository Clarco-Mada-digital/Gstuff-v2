<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class multiRange extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $label,
        public int $min,
        public int $max,
        public int $step = 1,
        public int $minvalue = 0,
        public int $maxvalue = 0,
        public string $unit = '',
        public string $class = '',
        public string $id = '',
        public string $placeholder = '',
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.multi-range');
    }
}

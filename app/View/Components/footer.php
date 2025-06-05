<?php

namespace App\View\Components;

use App\Models\Canton;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class footer extends Component
{
    public $cantons;
    public $categories;
   
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->cantons = Canton::withCount('users')->orderBy('users_count', 'desc')->get();
        return view('components.footer', ['cantons' => $this->cantons]);
    }
}

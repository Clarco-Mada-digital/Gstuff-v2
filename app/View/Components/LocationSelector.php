<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LocationSelector extends Component
{
    public $user;

    public function __construct($user)
    {
        $this->user = User::find($user);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.location-selector');
    }
}

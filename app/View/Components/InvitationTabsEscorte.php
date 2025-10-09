<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InvitationTabsEscorte extends Component
{
    public $salonsNoInvited;
    public $listInvitationSalon;

    public function __construct($salonsNoInvited, $listInvitationSalon)
    {
        $this->salonsNoInvited = $salonsNoInvited;
        $this->listInvitationSalon = $listInvitationSalon;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.invitation-tabs-escorte');
    }
}

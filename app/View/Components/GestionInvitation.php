<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GestionInvitation extends Component
{
    public $user;
    public $invitationsRecus;
    public $listInvitationSalons;
    public $salonAssociers;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user, $invitationsRecus, $listInvitationSalons, $salonAssociers)
    {
        $this->user = $user;
        $this->invitationsRecus = $invitationsRecus;
        $this->listInvitationSalons = $listInvitationSalons;
        $this->salonAssociers = $salonAssociers;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.gestion-invitation');
    }
}

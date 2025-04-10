<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InvitationTabs extends Component
{
    public $escortsNoInvited;
    public $listInvitation;

    public function __construct($escortsNoInvited, $listInvitation)
    {
        $this->escortsNoInvited = $escortsNoInvited;
        $this->listInvitation = $listInvitation;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.invitation-tabs');
    }
}

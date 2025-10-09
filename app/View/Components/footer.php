<?php
namespace App\View\Components;

use App\Models\Canton;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $cantons;

    public function render(): View
    {
        $this->cantons = Canton::withCount([
            'users as users_count' => function($query) {
                $query->whereRaw('CAST(canton AS bigint) = cantons.id');
            }
        ])->orderBy('users_count', 'desc')->get();

        return view('components.footer', ['cantons' => $this->cantons]);
    }
}

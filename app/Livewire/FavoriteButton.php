<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FavoriteButton extends Component
{
    public $userId;
    public $isFavorite = false;
    public $placement = '';

    // protected $listeners = ['favoriteUpdated' => 'render'];

    public function mount($userId, $placement = '')
    {
        $this->userId = $userId;
        $this->placement = $placement;
        if(Auth::check()){
            $this->isFavorite = auth()->user()->favorites->contains($this->userId);
        }
    }

    public function toggleFavorite()
    {
        if (Auth::check() && $this->userId != Auth::user()->id) {
            $user = auth()->user();
            $favoriteUser = User::findOrFail($this->userId);
    
            if ($this->isFavorite) {
                $user->favorites()->detach($favoriteUser);
                $this->isFavorite = false;
                $favoriteUser->rate_activity = $favoriteUser->rate_activity - 1;
                $favoriteUser->update();
            } else {
                $user->favorites()->attach($favoriteUser);
                $this->isFavorite = true;
                $favoriteUser->rate_activity = $favoriteUser->rate_activity + 1;
                $favoriteUser->update();
            }
    
            // $this->emit('favoriteUpdated');
        }
    }

    public function render()
    {
        return view('livewire.favorite-button', [
            'placement' => $this->placement
        ]);
    }
}

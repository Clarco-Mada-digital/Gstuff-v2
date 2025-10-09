<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Story;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class StoriePublicViewer extends Component
{
    public $userViewStorie;
    public $stories = [];

    public function mount($userViewStorie)
    {
        $this->userViewStorie = $userViewStorie;
        $this->loadStories();
    }

    public function loadStories()
    {
        $this->stories = Story::where('user_id', $this->userViewStorie)
            ->where('expires_at', '>', now())
            ->orderBy('expires_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($story) {
                return [
                    'id' => $story->id,
                    'media_path' => $story->media_path,
                    'media_type' => $story->media_type,
                    'created_at' => $story->created_at,
                    'expires_at' => $story->expires_at,
                    'media_url' => Storage::url($story->media_path),
                    'is_expired' => $this->isExpired($story)
                ];
            })
            ->values()
            ->toArray();
    }

    public function isExpired($story)
    {
        if (!isset($story->expires_at)) {
            return false;
        }
        
        $expiresAt = is_string($story->expires_at) 
            ? Carbon::parse($story->expires_at)
            : $story->expires_at;
            
        return $expiresAt->isPast();
    }

    public function render()
    {
        return view('livewire.storie-public-viewer', [
            'storiesData' => $this->stories
        ]);
    }
}

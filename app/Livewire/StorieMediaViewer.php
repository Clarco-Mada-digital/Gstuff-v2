<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Story;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class StorieMediaViewer extends Component
{
    use WithFileUploads;

    public $stories;
    public $activeStory = null;
    public $currentIndex = 0;
    public $showModal = false;
    public $media;
    public $mediaUrl;
    public $isImage = true;
    

    public function mount()
    {
        $this->loadStories();
    }

    public function loadStories()
    {
        $this->stories = Story::where('user_id', auth()->user()->id)
            ->orderBy('expires_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getStoriesData()
    {
        return $this->stories->map(function($story) {
            return [
                'id' => $story->id,
                'media_url' => Storage::url($story->media_path),
                'media_type' => $story->media_type,
                'created_at' => $story->created_at,
                'expires_at' => $story->expires_at
            ];
        });
    }

    public function nextStory()
    {
        if ($this->currentIndex < count($this->stories) - 1) {
            $this->openStory($this->currentIndex + 1);
        } else {
            $this->closeModal();
        }
    }

    public function previousStory()
    {
        if ($this->currentIndex > 0) {
            $this->openStory($this->currentIndex - 1);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->activeStory = null;
        $this->mediaUrl = null;
    }

    public function deleteStory($storyId)
    {
        $story = Story::findOrFail($storyId);
        
        // Supprimer le fichier physique
        Storage::disk('public')->delete($story->media_path);
        
        // Supprimer l'entrée en base de données
        $story->delete();
        
        // Recharger la liste des stories
        $this->loadStories();
        
        // Fermer la modale si ouverte
        if ($this->showModal) {
            $this->closeModal();
        }
        
        // Afficher un message de succès
        session()->flash('message', 'Story supprimée avec succès.');
    }

    public function republishStory($storyId)
    {
        $story = Story::findOrFail($storyId);
        
        // Mettre à jour la date d'expiration (24h à partir de maintenant)
        $story->update([
            'expires_at' => now()->addDay()
        ]);
        
        // Recharger la liste des stories
        $this->loadStories();
        
        // Afficher un message de succès
        session()->flash('message', 'Story republiée avec succès pour 24h.');
    }
    
    public function isExpired($story)
    {
        if (!isset($story->expires_at)) {
            return false;
        }
        
        // Si c'est une chaîne, on la convertit en objet Carbon
        $expiresAt = is_string($story->expires_at) 
            ? \Carbon\Carbon::parse($story->expires_at)
            : $story->expires_at;
            
        return $expiresAt->isPast();
    }

    public function render()
    {
        return view('livewire.storie-media-viewer', [
            'isExpired' => \Closure::fromCallable([$this, 'isExpired'])
        ]);
    }
}

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
    public $userId;
    
    protected $listeners = ['storyAdded' => 'loadStories'];

    public function mount()
    {
        $this->loadStories();
    }

    public function loadStories()
    {
        $this->stories = Story::where('user_id', $this->userId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        $this->emit('storiesUpdated');
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

    public function openStory($index)
    {
        // Cette méthode n'est plus utilisée directement, mais conservée pour la rétrocompatibilité
        $this->currentIndex = $index;
        $this->activeStory = $this->stories[$index];
        $this->mediaUrl = Storage::url($this->activeStory->media_path);
        $this->isImage = $this->activeStory->media_type === 'image';
        $this->showModal = true;
        
        // Émettre un événement personnalisé pour le JavaScript natif
        $this->dispatchBrowserEvent('open-story', [
            'index' => $index,
            'story' => [
                'id' => $this->activeStory->id,
                'media_url' => $this->mediaUrl,
                'media_type' => $this->activeStory->media_type
            ]
        ]);
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

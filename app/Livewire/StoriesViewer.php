<?php

namespace App\Livewire;

use App\Models\Story;
use Livewire\Component;

class StoriesViewer extends Component
{
    public $stories;
    public $selectedUserStories = [];
    public $activeUser = null;
    public $currentIndex = 0;
    public $progress = 0;

    protected $listeners = ['openStory', 'closeStory'];

    public function mount()
    {
        $this->stories = Story::with('user')
            ->where('expires_at', '>', now())
            ->get()
            ->groupBy('user_id')
            ->collect();
    }

    public function openStory($userId)
    {
        $this->activeUser = $userId;
        $this->selectedUserStories = $this->stories->get($userId)->toArray();
        $this->currentIndex = 0;
        $this->resetProgress();
    }

    public function closeStory()
    {
        $this->reset(['activeUser', 'selectedUserStories', 'currentIndex', 'progress']);
    }

    public function nextStory()
    {
        if ($this->currentIndex < count($this->selectedUserStories) - 1) {
            $this->currentIndex++;
            $this->resetProgress();
        } else {
            $this->closeStory();
        }
    }

    public function previousStory()
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
            $this->resetProgress();
        }
    }

    public function resetProgress()
    {
        $this->progress = 0;
    }

    public function render()
    {
        return view('livewire.stories-viewer');
    }
}

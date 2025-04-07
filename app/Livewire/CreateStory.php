<?php

namespace App\Livewire;

use App\Models\Story;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateStory extends Component
{
    use WithFileUploads;

    public $media;
    public $mediaType = 'image';

    protected $rules = [
        'media' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:102400' // 100MB max
    ];

    public function updatedMedia()
    {
        $this->mediaType = str()->contains($this->media->getMimeType(), 'video') ? 'video' : 'image';
    }

    public function save()
    {
        $this->validate();

        $path = $this->media->store('stories', 'public');

        Story::create([
            'user_id' => auth()->id(),
            'media_path' => $path,
            'media_type' => $this->mediaType
        ]);

        $this->reset();
    }

    public function render()
    {
        return view('livewire.create-story');
    }
}

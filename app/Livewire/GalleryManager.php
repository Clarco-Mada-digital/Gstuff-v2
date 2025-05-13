<?php

namespace App\Livewire;

use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\WithFileUploads;

class GalleryManager extends Component
{
    use WithFileUploads;

    public $user;
    public $media = [];
    public $title = '';
    public $description = '';
    public $isPublic;
    public $type = 'image';
    public $selectedMedia;
    public $showModal = false;
    public $previews = [];
    public $uploadProgress;
    public $galleries;
    public $gallerieItem;

    protected $listeners = ['galleryUpdated'=>'render'];

    protected $rules = [
        'title' => 'required|max:255',
        'description' => 'nullable|string',
        'isPublic' => 'nullable|boolean',
        'media.*' => 'required|file|mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/webp,video/quicktime|max:102400' // 100MB max
    ];
    
    protected $validationAttributes = [];
    
    public function boot()
    {
        $this->validationAttributes = [
            'title' => __('gallery.title'),
            'description' => __('gallery.description'),
            'isPublic' => __('gallery.is_public'),
            'media' => __('gallery.media'),
        ];
    }
    
    protected function getMessages()
    {
        return [
            'title.required' => __('gallery.validation.title_required'),
            'title.max' => __('gallery.validation.title_max', ['max' => 255]),
            'media.required' => __('gallery.validation.media_required'),
            'media.mimetypes' => __('gallery.validation.media_mimetypes'),
            'media.max' => __('gallery.validation.media_max'),
        ];
    }

    public function updatedMedia()
    {
        $this->validate([
            'media.*' => 'required|file|mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/quicktime|max:102400'
        ]);

        $this->previews = [];
        $this->uploadProgress = [];

        foreach ($this->media as $key => $file) {
            $this->uploadProgress[$key] = 0;
            
            if (str_starts_with($file->getMimeType(), 'image/')) {
                $this->previews[$key] = [
                    'type' => 'image',
                    'url' => $file->temporaryUrl(),
                    'name' => $file->getClientOriginalName()
                ];
            } else {
                $this->previews[$key] = [
                    'type' => 'video',
                    'url' => null,
                    'name' => $file->getClientOriginalName()
                ];
            }
        }
    }

    public function removePreview($index)
    {
        array_splice($this->media, $index, 1);
        array_splice($this->previews, $index, 1);
        array_splice($this->uploadProgress, $index, 1);
        
        $this->media = array_values($this->media);
        $this->previews = array_values($this->previews);
        $this->uploadProgress = array_values($this->uploadProgress);
    }
    
    public function mount($user, $isPublic=true)
    {
        $this->user = $user;
        $this->isPublic = $isPublic;
        $this->galleries = $this->user->galleries()
            // ->when(auth()->id() !== $this->user->id, fn($q) => $q->where('is_public', $this->isPublic))
            ->where('is_public', $this->isPublic)
            ->latest()
            ->get();
    }

    public function openModal($mediaId = null)
    {
        $this->reset(['title', 'description', 'isPublic', 'media']);
        $this->selectedMedia = $mediaId ? Gallery::find($mediaId) : null;
        
        if ($this->selectedMedia) {
            $this->title = $this->selectedMedia->title;
            $this->description = $this->selectedMedia->description;
            $this->isPublic = $this->selectedMedia->is_public;
            $this->type = $this->selectedMedia->type;
        }
        
        $this->showModal = true;
    }

    public function saveMedia()
    {
        try {
            // Validation des données avant toute opération
            $this->validate();
    
            if ($this->selectedMedia) {
                // Mise à jour d'un média existant
                $this->updateMedia();
                $successMessage = __('gallery.messages.update_success');
            } else {
                // Ajout de nouveaux médias
                $this->saveNewMedia();
                $successMessage = __('gallery.messages.upload_success');
            }
    
            // Fermer le modal et notifier du succès
            $this->showModal = false;
            $this->dispatch('galleryUpdated', [
                'message' => $successMessage,
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            // Gestion des erreurs générales
            logger()->error('Erreur lors de la sauvegarde des médias : ' . $e->getMessage());
            $this->addError('general', __('gallery.messages.error'));
        }
    }
    
    private function updateMedia()
    {
        try {
            $this->selectedMedia->update([
                'title' => $this->title,
                'description' => $this->description,
                'is_public' => $this->isPublic,
            ]);
        } catch (\Exception $e) {
            logger()->error('Erreur lors de la mise à jour du média : ' . $e->getMessage());
            throw new \RuntimeException(__('gallery.messages.error'));
        }
    }
    
    private function saveNewMedia()
    {
        foreach ($this->media as $file) {
            try {
                // Validation du fichier
                if (!$file || !$file->isValid()) {
                    throw new \InvalidArgumentException(__('gallery.messages.error'));
                }
    
                // Stockage du fichier
                $path = $file->store("galleries/{$this->user->id}", 'public');
                
                // Génération de la miniature si c'est une image
                $thumbnailPath = null;
                if (str_starts_with($file->getMimeType(), 'image/')) {
                    $thumbnailPath = $this->generateThumbnail($file);
                }
    
                // Création d'une nouvelle entrée dans la galerie
                Gallery::create([
                    'user_id' => $this->user->id,
                    'title' => $this->title,
                    'description' => $this->description,
                    'type' => str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'video',
                    'path' => $path,
                    'thumbnail_path' => $thumbnailPath,
                    'is_public' => $this->isPublic,
                ]);
            } catch (\Exception $e) {
                logger()->error('Erreur lors de l\'enregistrement d\'un nouveau média : ' . $e->getMessage());
                dd($e->getMessage());
                throw new \RuntimeException(__('gallery.messages.error'));
            }
        }
    }

    protected function generateThumbnail($file)
    {
        $manager = new ImageManager(new Driver());

        $image = $manager->read($file->getRealPath())
            ->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encodeByMediaType('image/jpg');
        
        $path = "galleries/{$this->user->id}/thumbnails/".uniqid().'.jpg';
        Storage::disk('public')->put($path, $image);
        
        return $path;
    }

    public function deleteMedia($mediaId)
    {
        try {
            $media = Gallery::findOrFail($mediaId);
            
            // Supprimer les fichiers associés
            Storage::disk('public')->delete([$media->path, $media->thumbnail_path]);
            $media->delete();
            
            $this->dispatch('galleryUpdated', [
                'message' => __('gallery.messages.delete_success'),
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            logger()->error('Erreur lors de la suppression du média : ' . $e->getMessage());
            $this->dispatch('galleryUpdated', [
                'message' => __('gallery.messages.error'),
                'type' => 'error'
            ]);
        }
    }

    public function render()
    {
        $this->gallerieItem = $this->galleries->map(function ($media) {
            return [
                'id' => $media->id,
                'type' => $media->type,
                'url' => $media->url,
                'thumbnail_url' => $media->thumbnail_url,
                'title' => $media->title,
                'description' => $media->description,
                'created_at' => $media->created_at
            ];
        });

        return view('livewire.gallery-manager');
    }
}

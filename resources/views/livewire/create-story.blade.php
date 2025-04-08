<div class="relative bg-gray-100 p-4 rounded-lg">
    <input type="file" wire:model="media" class="hidden" id="storiesUpload">
    
    @if(!$media)
        <label for="storiesUpload" class="cursor-pointer bg-blue-500 text-white px-4 py-2 rounded">
            📷 Ajouter une story
        </label>
    @else
        <div class="relative">
            @if($mediaType === 'image')
                <img src="{{ $media->temporaryUrl() }}" class="max-h-96 rounded-lg">
            @else
                <video controls class="max-h-96 rounded-lg">
                    <source src="{{ $media->temporaryUrl() }}">
                </video>
            @endif
            
            <button wire:click="save" class="absolute bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded">
                Publier 🚀
            </button>
        </div>
    @endif
</div>

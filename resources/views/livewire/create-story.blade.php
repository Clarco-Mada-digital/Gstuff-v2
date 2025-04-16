@php $user = Auth()->user(); @endphp
<div class="relative p-4 rounded-lg">
    <input type="file" wire:model="media" class="hidden" id="storiesUpload">
    
    @if(!$media)
        <label for="storiesUpload">
            {{-- 📷 Ajouter une story --}}
            <div class="relative w-24 h-24 rounded-full border-2 border-green-gs cursor-pointer">
                <img  @if ($avatar = $user->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                    @else
                    src="{{ asset('images/icon_logo.png') }}" @endif
                    class="w-full h-full rounded-full object-cover" 
                    alt="Story add">
                <div class="w-full h-full absolute top-0 left-0 rounded-full bg-gray-300/50 flex items-center justify-center text-2xl text-green-gs font-bold">+</div>
            </div>
        </label>
    @else
        <div class="relative">
            @if($mediaType === 'image')
                <img src="{{ $media->temporaryUrl() }}" class="max-w-50 rounded-lg">
            @else
                <video controls class="max-w-50 rounded-lg">
                    <source src="{{ $media->temporaryUrl() }}">
                </video>
            @endif
            
            <button wire:click="save" class="absolute bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded">
                Publier 🚀
            </button>
        </div>
    @endif
</div>

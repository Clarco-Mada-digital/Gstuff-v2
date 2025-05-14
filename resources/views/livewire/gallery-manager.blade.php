<div class="w-full" x-data="{gallery() ,  logPreviews() {
        console.log('Prévisualisations côté client:', @js($previews));
    }}" x-init="initGallery()" x-cloak @keydown.left="if(fullscreen) navigateMedia(-1)" @keydown.right="if(fullscreen) navigateMedia(1)">
    <!-- Header -->
    <div class="flex justify-between items-center gap-3 mb-6 text-green-gs">
        <h2 class="font-dm-serif font-bold text-2xl">{{__('gallery_manageSection.gallery_title')}} @if ($isPublic == false) {{__('gallery_manageSection.private')}} @endif</h2>
        <div class="flex-1 h-0.5 bg-green-gs"></div>
        <div class="flex space-x-3">
            <!-- Boutons de vue -->
            <button @click="viewMode = 'grid'" :class="{ 'text-blue-600 bg-blue-50': viewMode === 'grid', 'text-gray-500': viewMode !== 'grid' }" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-th-large"></i>
            </button>
            <button @click="viewMode = 'list'" :class="{ 'text-blue-600 bg-blue-50': viewMode === 'list', 'text-gray-500': viewMode !== 'list' }" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-list"></i>
            </button>

            <!-- Bouton ajout (seulement pour le propriétaire) -->
            @if(auth()->id() === $user->id)
            <button @click="$wire.openModal()" class="btn-primary flex items-center">
                <i class="fas fa-plus mr-2"></i> {{__('gallery_manageSection.add')}}
            </button>
            @endif
        </div>
    </div>

    @if (!$isPublic && $user->id == auth()->user()->id)
    <span class="w-full text-center text-green-gs font-bold font-dm-serif">{{__('gallery_manageSection.video_limit_warning')}}</span>
    @endif

    <!-- Modal de confirmation de suppression -->
    <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="deleteModalTitle"></h3>
                    <button @click="showDeleteModal = false" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <p class="text-gray-600 mb-6">{{__('gallery_manageSection.confirm_delete')}}</p>

                <div class="flex justify-end space-x-3">
                    <button @click="showDeleteModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        {{__('gallery_manageSection.cancel')}}
                    </button>
                    <button @click="$wire.deleteMedia(mediaToDelete); showDeleteModal = false" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i> {{__('gallery_manageSection.delete')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Content -->
    <template x-if="viewMode === 'grid'">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($galleries as $media)
            <div class="relative group rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 aspect-square">
                @if($media->type === 'image')
                <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $media->title }}" class="w-full h-full object-cover cursor-pointer" @click="currentMedia = {
                        type: 'image',
                        url: '{{ $media->url }}',
                        title: '{{ $media->title }}',
                        description: '{{ $media->description }}'
                    }; fullscreen = true">
                @else
                <div class="relative w-full h-full bg-gray-800 flex items-center justify-center cursor-pointer" @click="currentMedia = {
                        type: 'video',
                        url: '{{ $media->url }}',
                        title: '{{ $media->title }}',
                        description: '{{ $media->description }}'
                     }; fullscreen = true">
                    <i class="fas fa-play text-white text-4xl"></i>
                    <img src="{{ $media->thumbnail_url ?? asset('images/icon_logo.png') }}" alt="{{ $media->title }}" class="absolute inset-0 w-full h-full object-cover opacity-70">
                </div>
                @endif

                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-3 pointer-events-none">
                    <div class="text-white">
                        <h3 class="font-medium truncate">{{ $media->title }}</h3>
                        <p class="text-xs text-gray-300 truncate">{{ $media->description }}</p>
                    </div>
                </div>

                <!-- Actions (owner only) -->
                @if(auth()->id() === $user->id)
                <div class="absolute top-2 right-2 flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button @click.stop="$wire.openModal({{ $media->id }})" class="p-1 bg-white/80 rounded-full hover:bg-white">
                        <i class="fas fa-edit text-gray-800 text-sm"></i>
                    </button>
                    <button @click.stop="mediaToDelete = {{ $media->id }}; deleteModalTitle = '{{__('gallery_manageSection.delete')}} {{ addslashes($media->title) }}'; showDeleteModal = true" class="p-1 bg-white/80 rounded-full hover:bg-white">
                        <i class="fas fa-trash text-red-600 text-sm"></i>
                    </button>
                </div>
                @endif
            </div>
            @endforeach

            @if($galleries->isEmpty())
            <div class="col-span-full text-center py-12 text-gray-500">
                <i class="fas fa-images text-4xl mb-3"></i>
                <p>{{__('gallery_manageSection.no_media')}}</p>
                @if(auth()->id() === $user->id)
                <button @click="$wire.openModal()" class="btn-primary mt-4">
                    <i class="fas fa-plus mr-2"></i> {{__('gallery_manageSection.add_first_media')}}
                </button>
                @endif
            </div>
            @endif
        </div>
    </template>

    <!-- Mode Liste -->
    <template x-if="viewMode === 'list'">
        <div class="space-y-3">
            @foreach($galleries as $media)
            <div class="flex items-center p-3 bg-white rounded-lg shadow hover:shadow-md transition-shadow duration-300 group">
                <div class="flex-shrink-0 w-16 h-16 rounded-md overflow-hidden cursor-pointer" @click="currentMedia = {
                        type: '{{ $media->type }}',
                        url: '{{ $media->url }}',
                        title: '{{ $media->title }}',
                        description: '{{ $media->description }}'
                     }; fullscreen = true">
                    @if($media->type === 'image')
                    <img src="{{ $media->thumbnail_url ?? $media->url }}" alt="{{ $media->title }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                        <i class="fas fa-play text-white text-lg"></i>
                    </div>
                    @endif
                </div>

                <div class="ml-4 flex-1 min-w-0">
                    <h3 class="text-sm font-medium text-gray-900 truncate">{{ $media->title }}</h3>

                    @php
                    $no_description = __('gallery_manageSection.no_description');
                    $image = __('gallery_manageSection.image');
                    $video = __('gallery_manageSection.video');

                    @endphp
                    <p class="text-xs text-gray-500 truncate">{{ $media->description ?: $no_description }}</p>
                    <div class="flex items-center mt-1 text-xs text-gray-400">
                        <span class="flex items-center">
                            <i class="fas fa-{{ $media->type === 'image' ? 'image' : 'video' }} mr-1"></i>
                            {{ $media->type === 'image' ? $image : $video }}
                        </span>
                        <span class="mx-2">•</span>
                        <span>{{ $media->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>

                <!-- Actions (owner only) -->
                @if(auth()->id() === $user->id)
                <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <button @click.stop="$wire.openModal({{ $media->id }})" class="p-2 text-gray-500 hover:text-blue-600">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button @click.stop="mediaToDelete = {{ $media->id }}; deleteModalTitle = '{{__('gallery_manageSection.delete')}} {{ addslashes($media->title) }}'; showDeleteModal = true" class="p-2 text-gray-500 hover:text-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                @endif
            </div>
            @endforeach

            @if($galleries->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-images text-4xl mb-3"></i>
                <p>{{__('gallery_manageSection.no_media')}}</p>
                @if(auth()->id() === $user->id)
                <button @click="$wire.openModal()" class="btn-primary mt-4">
                    <i class="fas fa-plus mr-2"></i> {{__('gallery_manageSection.add_first_media')}}
                </button>
                @endif
            </div>
            @endif
        </div>
    </template>

    <!-- Modal d'ajout/édition -->
    <x-modal wire:model="showModal" maxWidth="2xl">
        <div class="p-6">

            @php
            $edit_media = __('gallery_manageSection.edit_media');
            $add_media = __('gallery_manageSection.add_media');

            @endphp
            <h3 class="text-xl font-semibold mb-4">
                {{ $selectedMedia ? $edit_media : $add_media }}aaaaaaaaaaaaaa
            </h3>

            <form wire:submit.prevent="saveMedia">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{__('gallery_manageSection.title')}} *</label>
                        <input type="text" wire:model="title" class="w-full rounded-lg border-gray-300">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{__('gallery_manageSection.description')}}</label>
                        <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300"></textarea>
                    </div>

                    
                    <div>
    <p>Debug:</p>
    <p>Selected Media: {{ is_array($selectedMedia) ? json_encode($selectedMedia) : $selectedMedia }}</p>
    <p>Previews: {{ json_encode($previews) }}</p>
</div>

                    @if(!$selectedMedia)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{__('gallery_manageSection.media')}} *</label>
                        <div x-data="{ isUploading: false, progress: 0, isDragging: false }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress" @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="isDragging = false; $wire.uploadMultiple('media', $event.dataTransfer.files)">
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center" :class="{ 'border-blue-500 bg-blue-50': isDragging, 'border-gray-300': !isDragging }">
                                <input type="file" wire:model="media" multiple accept="image/*,video/*" class="hidden" id="galleryUpload">
                                <label for="galleryUpload" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-blue-500 mb-2"></i>
                                    <p class="text-sm text-gray-600">{{__('gallery_manageSection.drag_drop')}}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{__('gallery_manageSection.supported_formats')}}</p>
                                </label>
                            </div>

                            <template x-if="isUploading">
                                <div class="mt-2">
                                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-500" :style="`width: ${progress}%`"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1" x-text="`{{__('gallery_manageSection.uploading')}}... ${progress}%`"></p>
                                </div>
                            </template>

                            @error('media.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <!-- Remplacer le template existant par : -->
@if(count($previews) > 0)
    <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
        @foreach($previews as $index => $preview)
            <div class="relative border rounded-lg overflow-hidden group">
                @if($preview['type'] === 'image')
                    <img src="{{ $preview['url'] }}" alt="{{ $preview['name'] }}" class="w-full h-32 object-cover">
                @else
                    <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-video text-gray-400 text-2xl"></i>
                    </div>
                @endif
                <div class="absolute inset-x-0 bottom-0 bg-black/70 text-white p-2">
                    <p class="text-xs truncate">{{ $preview['name'] }}</p>
                </div>
                <button type="button" 
                        @click.prevent="
                            $wire.previews.splice({{ $index }}, 1);
                            $wire.media.splice({{ $index }}, 1);
                        " 
                        class="absolute top-2 right-2 p-1 bg-white/80 rounded-full hover:bg-white">
                    <i class="fas fa-times text-red-600 text-sm"></i>
                </button>
            </div>
        @endforeach
    </div>
@endif

                    <!-- Prévisualisations -->
                    <template x-if="$wire.previews.length > 0">
                        <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            <template x-for="(preview, index) in $wire.previews" :key="index">
                                <div class="relative border rounded-lg overflow-hidden group">
                                    <!-- Image -->
                                    <template x-if="preview.type === 'image'">
                                        <img :src="preview.url" :alt="preview.name" class="w-full h-32 object-cover">
                                    </template>

                                    <!-- Vidéo -->
                                    <template x-if="preview.type === 'video'">
                                        <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-video text-gray-400 text-2xl"></i>
                                        </div>
                                    </template>

                                    <!-- Infos -->
                                    <div class="absolute inset-x-0 bottom-0 bg-black/70 text-white p-2">
                                        <p class="text-xs truncate" x-text="preview.name"></p>
                                        <div class="h-1 mt-1 bg-gray-600 rounded-full">
                                            <div class="h-full bg-blue-500 rounded-full" :style="'width: ' + ($wire.uploadProgress[index] || 0) + '%'"></div>
                                        </div>
                                    </div>

                                    <!-- Bouton supprimer -->
                                    <button type="button" @click="$wire.removePreview(index)" class="absolute top-2 right-2 p-1 bg-white/80 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-times text-red-600 text-sm"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>
                    @endif

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="isPublic" id="isPublic" class="rounded border-gray-300 text-blue-600">
                        <label for="isPublic" class="ml-2 text-sm text-gray-700">{{__('gallery_manageSection.make_public')}}</label>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" @click="$wire.showModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        {{__('gallery_manageSection.cancel')}}
                    </button>
                    @php
                    $update = __('gallery_manageSection.update');
                    $save = __('gallery_manageSection.save');

                    @endphp
                    <button type="submit" class="btn-gs-gradient rounded">
                        {{ $selectedMedia ? $update : $save }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Modal de visualisation -->
    <div x-show="fullscreen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4" @click.away="fullscreen = false" @keydown.escape.window="fullscreen = false">

        <template x-if="currentMedia">
            <div class="max-w-6xl w-full relative">
                <!-- Bouton précédent -->
                <button @click.stop="navigateMedia(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 z-10 p-3 text-white hover:text-blue-300 transition-colors" :class="{ 'opacity-50 cursor-not-allowed': currentMediaIndex <= 0 }" :disabled="currentMediaIndex <= 0">
                    <i class="fas fa-chevron-left text-3xl"></i>
                </button>

                <!-- Bouton suivant -->
                <button @click.stop="navigateMedia(1)" class="absolute right-4 top-1/2 -translate-y-1/2 z-10 p-3 text-white hover:text-blue-300 transition-colors" :class="{ 'opacity-50 cursor-not-allowed': currentMediaIndex >= mediaCount - 1 }" :disabled="currentMediaIndex >= mediaCount - 1">
                    <i class="fas fa-chevron-right text-3xl"></i>
                </button>

                <!-- Bouton fermer -->
                <button @click="fullscreen = false" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                    <i class="fas fa-times text-2xl"></i>
                </button>

                <!-- Contenu média -->
                <div class="bg-black rounded-lg overflow-hidden relative">
                    <template x-if="currentMedia.type === 'image'">
                        <img :src="currentMedia.url" :alt="currentMedia.title" class="w-full max-h-[80vh] object-contain mx-auto">
                    </template>

                    <template x-if="currentMedia.type === 'video'">
                        <video controls autoplay class="w-full max-h-[80vh] mx-auto">
                            <source :src="currentMedia.url" type="video/mp4">
                            {{__('gallery_manageSection.video_not_supported')}}
                        </video>
                    </template>

                    <div class="p-4 bg-gray-900 text-white">
                        <h3 x-text="currentMedia.title" class="text-xl font-semibold"></h3>
                        <p x-text="currentMedia.description" class="text-gray-300 mt-1"></p>
                        <div class="mt-2 text-sm text-gray-400">
                            <span x-text="`${currentMediaIndex + 1} / ${mediaCount}`"></span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
<script>
    document.addEventListener('livewire:initialized', () => {
    Livewire.on('media-updated', () => {
        // Cette partie n'est plus nécessaire si on utilise le rendu côté serveur
        // Laissé pour référence si besoin de logique supplémentaire
        console.log('Media updated');
    });
});
</script>
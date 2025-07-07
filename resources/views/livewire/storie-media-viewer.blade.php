<div>
    <!-- Liste des miniatures des stories -->
    <div class="flex space-x-4 overflow-x-auto py-4 px-2">
        @forelse($stories as $index => $story)
            <div wire:key="story-{{ $story->id }}" class="relative flex-shrink-0">
                <div class="relative h-24 w-24 cursor-pointer overflow-hidden rounded-full border-2 border-amber-500"
                     wire:click="openStory({{ $index }})">
                    @if($story->media_type === 'image')
                        <img src="{{ Storage::url($story->media_path) }}" 
                             alt="Story" 
                             class="h-full w-full object-cover">
                    @else
                        <video class="h-full w-full object-cover" muted>
                            <source src="{{ Storage::url($story->media_path) }}" type="video/mp4">
                        </video>
                    @endif
                </div>
                <button wire:click.stop="deleteStory({{ $story->id }})" 
                        class="absolute -right-1 -top-1 rounded-full bg-red-500 p-1 text-white"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette story ?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @empty
            <div class="w-full py-8 text-center text-gray-500">
                Aucune story disponible. Ajoutez votre première story !
            </div>
        @endforelse
    </div>

    <!-- Modal de visualisation -->
    @if($showModal && $activeStory)
        <div x-data="{ show: @entangle('showModal') }" 
             x-show="show" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 p-4"
             @keydown.escape.window="$wire.closeModal()">
            
            <!-- Bouton précédent -->
            <button x-show="{{ $currentIndex > 0 }}" 
                    wire:click="previousStory"
                    class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 text-white hover:bg-black/70">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Contenu de la story -->
            <div class="relative h-full w-full max-w-2xl">
                @if($isImage)
                    <img src="{{ $mediaUrl }}" 
                         alt="Story" 
                         class="h-full w-full object-contain">
                @else
                    <video src="{{ $mediaUrl }}" 
                           class="h-full w-full object-contain" 
                           controls 
                           autoplay
                           @ended="$wire.nextStory()">
                    </video>
                @endif
                
                <!-- Bouton de fermeture -->
                <button wire:click="closeModal"
                        class="absolute right-4 top-4 rounded-full bg-black/50 p-2 text-white hover:bg-black/70">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Bouton suivant -->
            <button x-show="{{ $currentIndex < count($stories) - 1 }}" 
                    wire:click="nextStory"
                    class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 text-white hover:bg-black/70">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Message de confirmation -->
    @if(session()->has('message'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="mt-4 rounded-lg bg-green-100 p-4 text-green-700">
            {{ session('message') }}
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Navigation au clavier
    document.addEventListener('keydown', function(event) {
        if (@this.showModal) {
            if (event.key === 'ArrowLeft') {
                @this.previousStory();
            } else if (event.key === 'ArrowRight') {
                @this.nextStory();
            } else if (event.key === 'Escape') {
                @this.closeModal();
            }
        }
    });
</script>
@endpush

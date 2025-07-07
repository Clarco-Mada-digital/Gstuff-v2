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
                <div class="relative">
                    <button onclick="showDeleteModal({{ $story->id }})"
                            class="absolute -right-1 -top-1 rounded-full bg-red-500 p-1 text-white hover:bg-red-600 transition-colors z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Modale de confirmation -->
                <div id="deleteModal-{{ $story->id }}" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black bg-opacity-50 p-4">
                    <div class="w-full max-w-sm rounded-lg bg-white p-6 shadow-xl transition-all duration-200 opacity-0 scale-95" id="modalContent-{{ $story->id }}">
                        <h3 class="text-lg font-medium text-gray-900">Supprimer la story</h3>
                        <p class="mt-2 text-sm text-gray-600">Êtes-vous sûr de vouloir supprimer cette story ? Cette action est irréversible.</p>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" 
                                    onclick="hideDeleteModal({{ $story->id }})"
                                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                Annuler
                            </button>
                            <button type="button" 
                                    onclick="confirmDelete({{ $story->id }})"
                                    class="rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
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
    // Fonction pour afficher la modale de suppression
    function showDeleteModal(storyId) {
        const modal = document.getElementById(`deleteModal-${storyId}`);
        const modalContent = document.getElementById(`modalContent-${storyId}`);
        
        if (modal && modalContent) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Animation d'entrée
            setTimeout(() => {
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-100', 'scale-100');
            }, 10);
            
            // Ajouter l'écouteur d'événement pour la touche Échap
            document.addEventListener('keydown', handleEscapeKey);
        }
    }
    
    // Fonction pour masquer la modale de suppression
    function hideDeleteModal(storyId) {
        const modal = document.getElementById(`deleteModal-${storyId}`);
        const modalContent = document.getElementById(`modalContent-${storyId}`);
        
        if (modal && modalContent) {
            // Animation de sortie
            modalContent.classList.remove('opacity-100', 'scale-100');
            modalContent.classList.add('opacity-0', 'scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-0', 'scale-95');
            }, 200);
            
            // Supprimer l'écouteur d'événement pour la touche Échap
            document.removeEventListener('keydown', handleEscapeKey);
        }
    }
    
    // Fonction pour confirmer la suppression
    function confirmDelete(storyId) {
        hideDeleteModal(storyId);
        @this.deleteStory(storyId);
    }
    
    // Gestion de la touche Échap
    function handleEscapeKey(event) {
        if (event.key === 'Escape') {
            const visibleModal = document.querySelector('.flex[id^="deleteModal-"]');
            if (visibleModal) {
                const storyId = visibleModal.id.replace('deleteModal-', '');
                hideDeleteModal(storyId);
            }
        }
    }
    
    // Gestion du clic en dehors de la modale
    document.addEventListener('click', function(event) {
        const modals = document.querySelectorAll('[id^="deleteModal-"]');
        modals.forEach(modal => {
            if (event.target === modal) {
                const storyId = modal.id.replace('deleteModal-', '');
                hideDeleteModal(storyId);
            }
        });
    });
    
    // Navigation au clavier pour les stories
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

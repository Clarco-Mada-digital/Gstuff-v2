<div x-data="{ storyForm: false }">

<div class="flex items-center justify-between gap-5 py-5">
                            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('profile.stories') }}</h2>
                            <div class="bg-green-gs h-0.5 flex-1"></div>
                            <button  x-on:click="storyForm = true"
                            class="flex items-center gap-2 text-supaGirlRose hover:text-green-gs hover:bg-supaGirlRose px-5 py-2 bg-fieldBg rounded-md cursor-pointer">
                                {{ __('profile.add') }}
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                                </svg>
                            </button>
                        </div>


<div class="container mx-auto p-4" >
    <div class="flex flex-wrap items-center gap-10">

    @php $user = Auth()->user(); @endphp
    <button x-on:click="storyForm = true ; console.log('test', storyForm)" type="button"
                            class="flex h-24 w-24 items-center justify-center rounded-full border-2 border-white bg-red-500 shadow-md transition-colors hover:bg-gray-100"
                            data-tooltip-target="tooltip-add-story" data-tooltip-placement="top">
                            <div class="border-green-gs relative h-24 w-24 cursor-pointer rounded-full border-2">
                                <img @if ($avatar = $user->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                                    @else
                                    src="{{ asset('images/icon_logo.png') }}" @endif
                                    class="h-full w-full rounded-full object-cover" alt="{{ __('profile.add_story') }}">
                                <div
                                    class="text-green-gs absolute left-0 top-0 flex h-full w-full items-center justify-center rounded-full bg-gray-300/50 text-2xl font-bold">
                                    +</div>
                            </div>
                        </button>

        <!-- Liste des miniatures des stories -->
        <div id="storiesContainer" class="flex space-x-4 overflow-x-auto py-4 px-2">
            <!-- Les stories seront ajoutées ici dynamiquement -->
        </div>
        </div>

        <!-- Message de confirmation -->
        <div id="confirmationMessage" class="mt-4 rounded-lg bg-green-100 p-4 text-green-700 hidden">
            <!-- Le message de confirmation sera affiché ici -->
        </div>

        <!-- Modal de visualisation -->
        <div id="storyModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-90 p-4">
            <div class="relative flex items-center justify-center h-full w-full max-w-2xl">
                <img id="storyImage" src="" alt="Story" class="max-h-full max-w-full object-contain hidden">
                <video id="storyVideo" src="" class="max-h-full max-w-full object-contain hidden" controls autoplay></video>
            </div>
            <button onclick="closeModal()" class="absolute right-4 top-4 rounded-full bg-black/50 p-2 text-white hover:bg-black/70">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <!-- Bouton précédent -->
            <button id="previousButton" onclick="previousStory()" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 text-white hover:bg-black/70">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <!-- Bouton suivant -->
            <button id="nextButton" onclick="nextStory()" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 text-white hover:bg-black/70">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

                            <div x-cloak x-show="storyForm" x-transition.opacity.duration.300ms
                                x-trap.inert.noscroll="storyForm" x-on:keydown.esc.window="storyForm = false"
                                x-on:click.self="storyForm = false"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 backdrop-blur-sm"
                                role="dialog" aria-modal="true" aria-labelledby="profile-modal-title">

                                <!-- Modal Dialog -->
                                <div x-show="storyForm" x-data="mediaViewer('')"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="relative w-full max-w-lg rounded-xl bg-white shadow-xl">

                                <!-- Close Button -->
                                <button type="button" x-on:click="storyForm = false"
                                    class="absolute right-3 top-3 rounded-full p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <!-- Modal Content -->
                                <div class="p-6">
                                    <h3 id="story-modal-title" class="mb-6 text-center text-xl font-bold text-green-gs font-roboto-slab">
                                       {{ __('storie_media_viewer.add_story') }}
                                    </h3>
                                    <form action="{{ route('stories.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                                        @csrf
                                        <!-- Media Preview -->
                                        <div class="flex justify-center">
                                            <div class="relative h-64 w-full overflow-hidden rounded-lg border-2 border-dashed border-gray-300 bg-gray-50">
                                                <template x-if="!mediaUrl">
                                                    <div class="flex h-full flex-col items-center justify-center p-4 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="mt-2 block text-sm text-gray-600">{{ __('storie_media_viewer.media_preview') }}</span>
                                                    </div>
                                                </template>
                                                <template x-if="mediaUrl">
                                                    <div x-show="isImage" class="h-full w-full">
                                                        <img :src="mediaUrl" class="h-full w-full object-cover" alt="Media Preview">
                                                    </div>
                                                    <div x-show="!isImage" class="h-full w-full">
                                                        <video :src="mediaUrl" class="h-full w-full object-cover" controls></video>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                        <!-- File Input -->
                                        <div class="mt-4">
                                            <label class="flex cursor-pointer items-center justify-between rounded-lg border-2 border-dashed border-gray-300 bg-white p-4 transition-colors hover:border-green-gs hover:bg-green-gs/50">
                                                <div class="flex items-center">
                                                    <svg class="h-6 w-6 text-green-gs" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                    </svg>
                                                    <span class="ml-2 text-sm text-gray-700">
                                                        <span x-text="mediaUrl ? `{{ __('storie_media_viewer.change_file') }}` : `{{ __('storie_media_viewer.select_file_Title') }}`"></span>
                                                        <span class="block text-xs text-gray-500">{{ __('storie_media_viewer.select_file') }}</span>
                                                    </span>
                                                </div>
                                                <input name="media" type="file" accept="image/*,video/*" x-on:change="fileChosen($event)" class="hidden" required>
                                            </label>
                                        </div>
                                        <!-- Action Buttons -->
                                        <div class="mt-6 flex justify-end space-x-3">
                                            <button type="button" x-on:click="storyForm = false" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                                {{ __('storie_media_viewer.cancel') }}
                                            </button>
                                            <button type="submit" class="inline-flex items-center rounded-lg bg-green-gs px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-gs/90 focus:outline-none focus:ring-2 focus:ring-green-gs/50 focus:ring-offset-2">
                                                <svg x-show="!mediaUrl" class="-ml-0.5 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                <span >
                                                    {{ __('storie_media_viewer.publish') }}
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
    </div>
</div>

    <script>
        let stories = @json($stories);
        console.log("storie data : ",stories);
        let currentIndex = 0;

        // Fonction pour afficher les stories
        function displayStories() {
            const container = document.getElementById('storiesContainer');

            if (stories.length === 0) {
                container.innerHTML = '<div class="w-full py-8 text-center text-gray-500">{{ __('storie_media_viewer.no_stories') }}</div>';
                return;
            }

            container.innerHTML = stories.map((story, index) => `
                <div class="relative flex-shrink-0">
                    <div class="relative h-24 w-24 cursor-pointer overflow-hidden rounded-full border-2 border-amber-500" onclick="openStory(${index})">
                        ${story.media_type === 'image' ?
                            `<img src="${'{{ Storage::url("") }}' + story.media_path}" alt="Story" class="h-full w-full object-cover">` :
                            `<video class="h-full w-full object-cover" muted><source src="${'{{ Storage::url("") }}' + story.media_path}" type="video/mp4"></video>`}
                    </div>
                    <div class="absolute top-0 right-0">
                        <button onclick="showDeleteModal(${story.id})" class="absolute -right-1 -top-1 rounded-full bg-red-500 p-1 text-white hover:bg-red-600 transition-colors z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    ${isExpired(story) ? `
                    <div class="absolute bottom-0 right-0">
                        <button onclick="republishStory(${story.id})"  class="absolute -right-1 -bottom-1 rounded-full bg-green-500 p-1 text-white hover:bg-green-600 transition-colors z-10" title="Republier cette story">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>` : ''}
                    <!-- Modale de confirmation -->
                    <div id="deleteModal-${story.id}" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4 backdrop-blur-sm">
                        <div class="w-full max-w-sm rounded-lg bg-white p-6 shadow-xl transition-all duration-200 opacity-0 scale-95" id="modalContent-${story.id}">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('storie_media_viewer.delete_confirm_title') }}</h3>
                            <p class="mt-2 text-sm text-gray-600">{{ __('storie_media_viewer.delete_confirm_message') }}</p>
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="hideDeleteModal(${story.id})" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    {{ __('storie_media_viewer.delete_confirm_cancel') }}
                                </button>
                                <button type="button" onclick="confirmDelete(${story.id})" class="rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    {{ __('storie_media_viewer.delete_confirm_confirm') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Fonction pour vérifier si une story est expirée
        function isExpired(story) {
            if (!story.expires_at) {
                return false;
            }
            const expiresAt = new Date(story.expires_at);
            return expiresAt < new Date();
        }

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
            // Logique pour supprimer la story

            axios.delete(`/stories/${storyId}`)
            .then(response => {
                console.log(response.data);
                // Actualiser la liste des stories
                stories = stories.filter(story => story.id !== storyId);
                displayStories();
                showConfirmationMessage(response.data.message);
                console.log(`Story ${storyId} supprimée`);
            })
            .catch(error => {
                console.error(error);
                showConfirmationMessage('Une erreur est survenue lors de la suppression de la story.');
            });
        }

        // Fonction pour republier une story
        function republishStory(storyId) {
            // Logique pour republier la story
            console.log(`Republishing story ${storyId}`);
            
            axios.post(`/stories/${storyId}/status`)
            .then(response => {
                if (response.data.success) {
                    // Mettre à jour la story dans le tableau local
                    const storyIndex = stories.findIndex(s => s.id == storyId);
                    if (storyIndex !== -1) {
                        stories[storyIndex] = response.data.story;
                    }
                    
                    // Trier les stories par expires_at (décroissant) puis par created_at (décroissant)
                    stories.sort((a, b) => {
                        const dateA = new Date(a.expires_at);
                        const dateB = new Date(b.expires_at);
                        if (dateA > dateB) return -1;
                        if (dateA < dateB) return 1;
                        
                        // Si les dates d'expiration sont égales, trier par created_at
                        const createdA = new Date(a.created_at);
                        const createdB = new Date(b.created_at);
                        return createdB - createdA;
                    });
                    
                    // Rafraîchir l'affichage
                    displayStories();
                    showConfirmationMessage(response.data.message);
                    console.log(`Story ${storyId} republiée avec succès`);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la republication:', error);
                showConfirmationMessage('Une erreur est survenue lors de la republication de la story.');
            });
        }

        // Fonction pour afficher un message de confirmation
        function showConfirmationMessage(message) {
            const confirmationMessage = document.getElementById('confirmationMessage');
            confirmationMessage.textContent = message;
            confirmationMessage.classList.remove('hidden');
            setTimeout(() => {
                confirmationMessage.classList.add('hidden');
            }, 3000);
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

        // Fonction pour ouvrir une story
        function openStory(index) {
            currentIndex = index;
            const story = stories[currentIndex];
            const modal = document.getElementById('storyModal');
            const storyImage = document.getElementById('storyImage');
            const storyVideo = document.getElementById('storyVideo');
            const previousButton = document.getElementById('previousButton');
            const nextButton = document.getElementById('nextButton');

            if (story.media_type === 'image') {
                storyImage.src = '{{ Storage::url("") }}' + story.media_path;
                storyImage.classList.remove('hidden');
                storyVideo.classList.add('hidden');
            } else {
                storyVideo.src = '{{ Storage::url("") }}' + story.media_path;
                storyVideo.classList.remove('hidden');
                storyImage.classList.add('hidden');
            }

            modal.classList.remove('hidden');

            // Afficher ou masquer les boutons précédent et suivant en fonction de l'index actuel
            previousButton.style.display = currentIndex > 0 ? 'block' : 'none';
            nextButton.style.display = currentIndex < stories.length - 1 ? 'block' : 'none';
        }

        // Fonction pour fermer le modal
        function closeModal() {
            const modal = document.getElementById('storyModal');
            modal.classList.add('hidden');
        }

        // Fonction pour afficher la story suivante
        function nextStory() {
            if (currentIndex < stories.length - 1) {
                openStory(currentIndex + 1);
            } else {
                closeModal();
            }
        }

        // Fonction pour afficher la story précédente
        function previousStory() {
            if (currentIndex > 0) {
                openStory(currentIndex - 1);
            }
        }

        // Navigation au clavier pour les stories
        document.addEventListener('keydown', function(event) {
            const modal = document.getElementById('storyModal');
            if (!modal.classList.contains('hidden')) {
                if (event.key === 'ArrowLeft') {
                    previousStory();
                } else if (event.key === 'ArrowRight') {
                    nextStory();
                } else if (event.key === 'Escape') {
                    closeModal();
                }
            }
        });

        // Fonction pour uploader une story
        function mediaViewer(src = '') {
            return {
                mediaUrl: src,
                isImage: true,
                fileChosen(event) {
                    this.fileToDataUrl(event, (result) => {
                        this.mediaUrl = result;
                        this.isImage = event.target.files[0].type.startsWith('image/');
                    });
                },
                fileToDataUrl(event, callback) {
                    if (!event.target.files.length) return;
                    let file = event.target.files[0];
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = e => callback(e.target.result);
                }
            }
        }

        // Afficher les stories au chargement de la page
        displayStories();
    </script>
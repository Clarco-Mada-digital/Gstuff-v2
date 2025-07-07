<div class="container mx-auto p-4">
        <!-- Liste des miniatures des stories -->
        <div id="storiesContainer" class="flex space-x-4 overflow-x-auto py-4 px-2">
            <!-- Les stories seront ajoutées ici dynamiquement -->
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
    </div>

    <script>
        let stories = @json($stories);
        let currentIndex = 0;

        // Fonction pour afficher les stories
        function displayStories() {
            const container = document.getElementById('storiesContainer');

            if (stories.length === 0) {
                container.innerHTML = '<div class="w-full py-8 text-center text-gray-500">Aucune story disponible. Ajoutez votre première story !</div>';
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
                        <button onclick="republishStory(${story.id})" class="absolute -right-1 -bottom-1 rounded-full bg-green-500 p-1 text-white hover:bg-green-600 transition-colors z-10" title="Republier cette story">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>` : ''}
                    <!-- Modale de confirmation -->
                    <div id="deleteModal-${story.id}" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black bg-opacity-50 p-4">
                        <div class="w-full max-w-sm rounded-lg bg-white p-6 shadow-xl transition-all duration-200 opacity-0 scale-95" id="modalContent-${story.id}">
                            <h3 class="text-lg font-medium text-gray-900">Supprimer la story</h3>
                            <p class="mt-2 text-sm text-gray-600">Êtes-vous sûr de vouloir supprimer cette story ? Cette action est irréversible.</p>
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="hideDeleteModal(${story.id})" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    Annuler
                                </button>
                                <button type="button" onclick="confirmDelete(${story.id})" class="rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    Supprimer
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
            console.log(`Story ${storyId} supprimée`);
            // Actualiser la liste des stories
            stories = stories.filter(story => story.id !== storyId);
            displayStories();
            showConfirmationMessage('Story supprimée avec succès.');
        }

        // Fonction pour republier une story
        function republishStory(storyId) {
            // Logique pour republier la story
            console.log(`Story ${storyId} republiée`);
            showConfirmationMessage('Story republiée avec succès pour 24h.');
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

        // Afficher les stories au chargement de la page
        displayStories();
    </script>
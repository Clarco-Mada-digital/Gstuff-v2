<div>
    @if(count($storiesData) > 0)



        <div class="flex items-center justify-between gap-5 py-5">

        <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('escort_profile.stories') }}</h2>
        <div class="bg-green-gs h-0.5 flex-1"></div>

        </div>
        <div class="flex flex-wrap items-center gap-4 mb-5">
            @if(count($storiesData) > 0)
                @foreach($storiesData as $index => $story)
                    <div class="relative h-24 w-24">
                        <div class="relative h-24 w-24 cursor-pointer overflow-hidden rounded-full border-2 border-green-gs" 
                            onclick="openStory({{ $index }})">
                            @if($story['media_type'] === 'image')
                                <img src="{{ $story['media_url'] }}" 
                                    alt="Story" 
                                    class="h-full w-full object-cover"
                                    loading="lazy">
                            @else
                                <video class="h-full w-full object-cover" 
                                    muted
                                    loop
                                    playsinline>
                                    <source src="{{ $story['media_url'] }}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center text-gray-500 py-4">
                    {{ __('Aucune story disponible pour le moment') }}
                </div>
            @endif
        </div>

    <!-- Modal de visualisation -->
        <div id="storyModal" class="fixed inset-0 z-50 hidden flex-col items-center justify-center bg-black bg-opacity-90 p-4">
            <!-- Barre de progression -->
            <div class="w-full max-w-2xl mb-4">
                <div class="flex gap-1">
                    @foreach($storiesData as $index => $story)
                        <div class="h-1 flex-1 bg-gray-600 rounded-full overflow-hidden">
                            <div id="progress-{{ $index }}" class="h-full bg-green-gs" style="width: 0%; transition: width 15s linear;"></div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Contenu de la story -->
            <div class="relative flex items-center justify-center h-[80vh] w-full max-w-2xl">
                <img id="storyImage" src="" alt="Story" class="max-h-full max-w-full object-contain hidden cursor-pointer" onclick="togglePause()">
                <video id="storyVideo" src="" class="max-h-full max-w-full object-contain hidden cursor-pointer" autoplay playsinline onended="videoEnded()" onclick="togglePause()"></video>
            </div>
            <button onclick="closeModal()" class="absolute right-4 top-4 rounded-full bg-supaGirlRose p-2 text-white hover:bg-green-gs">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <!-- Bouton précédent -->
            <button id="previousButton" onclick="previousStory()" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-green-gs p-2 text-white hover:bg-supaGirlRose">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <!-- Bouton suivant -->
            <button id="nextButton" onclick="nextStory()" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-green-gs p-2 text-white hover:bg-supaGirlRose">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

    @endif

    </div>

<script>
    let stories = @json($storiesData);
    let currentIndex = 0;
    let progressInterval;
    let startTime;
    let isPaused = false;
    let remainingTime = 0;
    const STORY_DURATION = 10000; // 10 secondes

    function startProgressBar() {
        // Si on est en pause, on ne fait rien
        if (isPaused) return;
        
        // S'assurer que la barre de progression actuelle est à 0% avant de démarrer
        const currentProgress = document.getElementById(`progress-${currentIndex}`);
        if (currentProgress) {
            currentProgress.style.width = '0%';
            currentProgress.style.transition = 'none';
            void currentProgress.offsetWidth; // Force le recalcul du style
            
            // Démarrer l'animation après un court délai
            setTimeout(() => {
                const duration = remainingTime > 0 ? remainingTime : STORY_DURATION;
                currentProgress.style.transition = `width ${duration}ms linear`;
                currentProgress.style.width = '100%';
            }, 10);
        }

        // Démarrer le minuteur pour la prochaine story
        clearInterval(progressInterval);
        startTime = Date.now() - (STORY_DURATION - (remainingTime > 0 ? remainingTime : STORY_DURATION));
        progressInterval = setInterval(updateProgress, 100);
        
        // Réinitialiser le temps restant
        remainingTime = 0;
    }

    function updateProgress() {
        const elapsed = Date.now() - startTime;
        const progress = (elapsed / STORY_DURATION) * 100;
        
        if (progress >= 100) {
            nextStory();
        }
    }

    function resetAllProgressBars() {
        // Réinitialiser toutes les barres de progression
        document.querySelectorAll('[id^="progress-"]').forEach(progress => {
            progress.style.width = '0%';
            progress.style.transition = 'none';
            // Forcer le recalcul du style
            void progress.offsetWidth;
        });
    }

    function openStory(index) {
        // Réactiver le défilement automatique lors de l'ouverture d'une nouvelle story
        isPaused = false;
        remainingTime = 0;
        
        // Arrêter la vidéo en cours si elle existe
        const currentVideo = document.getElementById('storyVideo');
        if (currentVideo) {
            currentVideo.pause();
            currentVideo.currentTime = 0;
            // Supprimer l'ancien gestionnaire d'événement pour éviter les doublons
            currentVideo.onloadeddata = null;
        }
        
        // Arrêter tout intervalle en cours
        clearInterval(progressInterval);
        
        currentIndex = index;
        const story = stories[currentIndex];
        const modal = document.getElementById('storyModal');
        const storyImage = document.getElementById('storyImage');
        const storyVideo = document.getElementById('storyVideo');
        const previousButton = document.getElementById('previousButton');
        const nextButton = document.getElementById('nextButton');

        // Réinitialiser toutes les barres de progression
        resetAllProgressBars();

        // Afficher la modal avant de charger le média
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        if (story.media_type === 'image') {
            storyImage.src = story.media_url;
            storyImage.classList.remove('hidden');
            storyVideo.classList.add('hidden');
            // Démarrer la barre de progression pour les images après un court délai
            // pour s'assurer que la transition CSS est réinitialisée
            setTimeout(() => startProgressBar(), 50);
        } else {
            storyVideo.src = story.media_url;
            storyVideo.classList.remove('hidden');
            storyImage.classList.add('hidden');
            
            // Pour les vidéos, démarrer la barre de progression après le chargement
            storyVideo.onloadeddata = function() {
                // Réinitialiser à nouveau pour être sûr
                resetAllProgressBars();
                // Démarrer la barre de progression
                startProgressBar();
                // Lancer la lecture de la vidéo
                storyVideo.play().catch(e => console.error('Erreur de lecture vidéo:', e));
            };
            
            // Gérer la fin de la vidéo
            storyVideo.onended = videoEnded;
        }

        // Gérer la visibilité des boutons de navigation
        previousButton.style.display = currentIndex > 0 ? 'block' : 'none';
        nextButton.style.display = currentIndex < stories.length - 1 ? 'block' : 'none';
    }

    function closeModal() {
        const modal = document.getElementById('storyModal');
        const storyVideo = document.getElementById('storyVideo');
        
        // Arrêter la vidéo en cours et le minuteur
        if (storyVideo) {
            storyVideo.pause();
            storyVideo.currentTime = 0;
        }
        
        clearInterval(progressInterval);
        isPaused = false;
        remainingTime = 0;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        
        // Réinitialiser les barres de progression
        document.querySelectorAll('[id^="progress-"]').forEach(progress => {
            progress.style.width = '0%';
            progress.style.transition = 'none';
        });
    }

    function videoEnded() {
        // Appelé quand une vidéo se termine
        nextStory();
    }

    function togglePause() {
        const currentProgress = document.getElementById(`progress-${currentIndex}`);
        const storyVideo = document.getElementById('storyVideo');
        
        if (isPaused) {
            // Reprendre la lecture
            isPaused = false;
            if (storyVideo && storyVideo.paused) {
                storyVideo.play().catch(e => console.error('Erreur de lecture vidéo:', e));
            }
            startProgressBar();
        } else {
            // Mettre en pause
            isPaused = true;
            clearInterval(progressInterval);
            if (storyVideo && !storyVideo.paused) {
                storyVideo.pause();
            }
            
            // Calculer le temps restant
            if (currentProgress) {
                const computedStyle = window.getComputedStyle(currentProgress);
                const width = parseFloat(computedStyle.width);
                const totalWidth = currentProgress.parentElement.offsetWidth;
                const progressPercent = (width / totalWidth) * 100;
                remainingTime = STORY_DURATION * (1 - (progressPercent / 100));
                
                // Mettre en pause l'animation CSS
                currentProgress.style.transition = 'none';
                currentProgress.style.width = `${progressPercent}%`;
                void currentProgress.offsetWidth; // Force le recalcul du style
            }
        }
    }

    function nextStory() {
        isPaused = false; // Réactiver le défilement automatique
        remainingTime = 0; // Réinitialiser le temps restant
        clearInterval(progressInterval);
        if (currentIndex < stories.length - 1) {
            openStory(currentIndex + 1);
        } else {
            closeModal();
        }
    }

    function previousStory() {
        isPaused = false; // Réactiver le défilement automatique
        remainingTime = 0; // Réinitialiser le temps restant
        clearInterval(progressInterval);
        if (currentIndex > 0) {
            openStory(currentIndex - 1);
        }
    }

    // Navigation au clavier
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
</script>

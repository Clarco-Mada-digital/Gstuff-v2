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
        <div id="storyModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-90 p-4">
            <div class="relative flex items-center justify-center h-full w-full max-w-2xl">
                <img id="storyImage" src="" alt="Story" class="max-h-full max-w-full object-contain hidden">
                <video id="storyVideo" src="" class="max-h-full max-w-full object-contain hidden" controls autoplay></video>
            </div>
            <button onclick="closeModal()" class="absolute right-4 top-4 rounded-full bg-supaGirlRose p-2 text-white hover:bg-green-gs">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

    function openStory(index) {
        currentIndex = index;
        const story = stories[currentIndex];
        const modal = document.getElementById('storyModal');
        const storyImage = document.getElementById('storyImage');
        const storyVideo = document.getElementById('storyVideo');
        const previousButton = document.getElementById('previousButton');
        const nextButton = document.getElementById('nextButton');

        if (story.media_type === 'image') {
            storyImage.src = story.media_url;
            storyImage.classList.remove('hidden');
            storyVideo.classList.add('hidden');
        } else {
            storyVideo.src = story.media_url;
            storyVideo.classList.remove('hidden');
            storyImage.classList.add('hidden');
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Gérer la visibilité des boutons de navigation
        previousButton.style.display = currentIndex > 0 ? 'block' : 'none';
        nextButton.style.display = currentIndex < stories.length - 1 ? 'block' : 'none';
    }

    function closeModal() {
        const modal = document.getElementById('storyModal');
        const storyVideo = document.getElementById('storyVideo');
        
        // Arrêter la vidéo en cours
        if (storyVideo) {
            storyVideo.pause();
            storyVideo.currentTime = 0;
        }
        
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function nextStory() {
        if (currentIndex < stories.length - 1) {
            openStory(currentIndex + 1);
        } else {
            closeModal();
        }
    }

    function previousStory() {
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

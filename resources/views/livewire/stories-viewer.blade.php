<div x-data="{
    openViewStorie: false,
    touchStartX: 0,
    touchEndX: 0,
    handleTouchStart(e) {
        this.touchStartX = e.touches[0].clientX;
    },
    handleTouchEnd(e) {
        this.touchEndX = e.changedTouches[0].clientX;
        const diff = this.touchStartX - this.touchEndX;

        if (Math.abs(diff) > 50) {
            if (diff > 0) {
                @this.nextStory();
            } else {
                @this.previousStory();
            }
        }
    }
}">
    <div x-data="storyPlayer()" x-init="init()">
        <!-- Liste des stories -->
        <div class="flex space-x-4 overflow-x-auto p-4">
            @php
                $hasStories = false;
            @endphp

            @foreach ($stories as $userId => $userStories)
                @if ($userStories->isNotEmpty() && $userId == $userViewStorie)
                    @php $hasStories = true; @endphp
                    <div class="relative h-24 w-24 cursor-pointer rounded-full border-2 border-blue-500"
                        @click="$wire.openStory({{ $userId }}); openViewStorie=true">

                        @if ($userStories->first()->media_type === 'image')
                            <img src="{{ asset('storage/' . $userStories->first()->media_path) }}"
                                class="h-full w-full rounded-full object-cover" alt="Story image">
                        @elseif($userStories->first()->media_type === 'video')
                            <video class="h-full w-full rounded-full object-cover" muted playsinline>
                                <source src="{{ asset('storage/' . $userStories->first()->media_path) }}">
                            </video>
                        @endif
                    </div>
                @endif
            @endforeach

            @if (!$hasStories)
                <div class="flex w-full items-center justify-center text-center text-gray-500">
                    {{ __('profile.no_stories_available') }}
                </div>
            @endif
        </div>

        <!-- Modal de visualisation -->
        @if ($activeUser)
            <div x-show='openViewStorie' class="fixed inset-0 z-50 bg-black bg-opacity-90" x-show="isModalOpen">
                <div class="relative flex h-screen items-center justify-center">
                    <!-- Contenu de la story -->
                    <div x-data="{ 'muted': true }" @touchstart="handleTouchStart" @touchend="handleTouchEnd"
                        class="relative h-5/6 w-full max-w-2xl">

                        <!-- Media -->
                        @if ($selectedUserStories[$currentIndex]['media_type'] != 'image')
                            <video class="h-full w-full rounded-lg object-contain" controls autoplay
                                onended="window.Livewire.dispatch('nextStory')">
                                <source
                                    src="{{ asset('storage/' . $selectedUserStories[$currentIndex]['media_path']) }}">
                            </video>
                        @else
                            <!-- Barre de progression -->
                            <div class="absolute left-4 right-4 top-4 flex space-x-1">
                                @foreach ($selectedUserStories as $index => $story)
                                    <div class="h-1 flex-1 rounded bg-gray-600">
                                        <div class="{{ $index == $currentIndex ? 'animate-progress' : '' }} h-full bg-white transition-all duration-500"
                                            :style="`width: ${$index < $currentIndex ? '100%' : ($index == $currentIndex ? progress + '%' : '0%')}`">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <img src="{{ asset('storage/' . $selectedUserStories[$currentIndex]['media_path']) }}"
                                class="h-full w-full rounded-lg object-contain">
                        @endif

                        <!-- Contrôles -->
                        <div class="absolute inset-0 flex justify-between">
                            <div class="h-full w-1/2 cursor-pointer" @click="$wire.previousStory"></div>
                            <div class="h-full w-1/2 cursor-pointer" @click="$wire.nextStory"></div>
                        </div>

                        <!-- Bouton de fermeture -->
                        <button class="absolute right-4 top-4 text-4xl text-white" @click="$wire.closeStory">
                            &times;
                        </button>
                    </div>

                    {{-- Like button --}}
                    @auth
                        <div x-data="{ likeCount: {{ $selectedUserStories[$currentIndex]['likes_count'] }} }">
                            <div class="absolute bottom-4 left-4 flex items-center justify-end space-x-2 text-4xl">
                                <button
                                    @if ($userViewStorie != Auth()->user()->id) @click="
                                likeCount += 1;
                                @this.call('likeStory', {{ $selectedUserStories[$currentIndex]['id'] }});
                            " @endif
                                    class="transition-colors duration-200">
                                    ❤️
                                </button>
                                <span x-text="likeCount" class="text-white"></span>
                            </div>
                        </div>
                    @endauth

                </div>
            </div>
        @endif

    </div>
</div>

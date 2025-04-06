<div x-data="{
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
    <div class="flex space-x-4 p-4 overflow-x-auto">
        @if ($stories->isEmpty())
            <div class="text-gray-500">Aucune story disponible</div>            
        @else
        @foreach($stories as $userId => $userStories)
            <div 
                class="relative w-24 h-24 rounded-full border-2 border-blue-500 cursor-pointer"
                @click="$wire.openStory({{ $userId }})">
                
                @if($userStories->first()->media_type === 'image')
                <img 
                     src="{{ asset('storage/' . $userStories->first()->media_path) }}"
                    class="w-full h-full rounded-full object-cover" />
                @elseif($userStories->first()->media_type === 'video') 
                <video 
                    class="w-full h-full rounded-full object-cover"
                    muted
                    pause=true
                    >
                    <source src="{{ asset('storage/' . $userStories->first()->media_path) }}">
                </video>
                @endif
            </div>
        @endforeach
        @endif
    </div>

    <!-- Modal de visualisation -->
    @if($activeUser)    
        <div class="fixed inset-0 bg-black bg-opacity-90 z-50" x-show="isModalOpen">
            <div class="relative h-screen flex items-center justify-center">
                <!-- Contenu de la story -->
                <div @touchstart="handleTouchStart" @touchend="handleTouchEnd" class="relative w-full max-w-2xl h-5/6">
                    
                    <!-- Media -->
                    @if($selectedUserStories[$currentIndex]['media_type'] === 'image')
                        <!-- Barre de progression -->
                        <div class="absolute top-4 left-4 right-4 flex space-x-1">
                            @foreach($selectedUserStories as $index => $story)
                                <div class="h-1 bg-gray-600 flex-1 rounded">
                                    <div 
                                        class="h-full bg-white transition-all duration-500 {{ $index == $currentIndex ? 'animate-progress' : '' }}"
                                        :style="`width: ${$index < $currentIndex ? '100%' : ($index == $currentIndex ? progress + '%' : '0%')}`">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <img 
                            src="{{ asset('storage/' . $selectedUserStories[$currentIndex]['media_path']) }}" 
                            class="w-full h-full object-contain rounded-lg">
                    @else
                        <video
                            class="w-full h-full object-contain rounded-lg" 
                            controls
                            autoplay
                            muted
                            onended="window.Livewire.dispatch('nextStory')">
                            <source src="{{ asset('storage/' . $selectedUserStories[$currentIndex]['media_path']) }}">
                        </video>
                    @endif

                    <!-- Contrôles -->
                    <div class="absolute inset-0 flex justify-between">
                        <div 
                            class="w-1/2 h-full cursor-pointer"
                            @click="$wire.previousStory"></div>
                        <div 
                            class="w-1/2 h-full cursor-pointer"
                            @click="$wire.nextStory"></div>
                    </div>                    

                    <!-- Bouton de fermeture -->
                    <button 
                        class="absolute top-4 right-4 text-white text-4xl"
                        @click="$wire.closeStory">
                        &times;
                    </button>
                </div>

                {{-- Like button --}}
                <div x-data="{ isLiked: false, likeCount: 0 }">
                    <div class="absolute bottom-4 text-4xl left-4 flex items-center justify-end space-x-2">
                        <button 
                            @click="
                                isLiked = !isLiked;
                                likeCount += isLiked ? 1 : -1;
                                @this.call('likeStory', {{ $selectedUserStories[$currentIndex]['id'] }});
                            "
                            :class="isLiked ? 'text-red-500' : 'text-white'"
                            class="transition-colors duration-200">
                            ❤️
                        </button>
                        <span x-text="likeCount" class="text-white"></span>
                    </div>
                </div>
                
            </div>
        </div>
    @endif

    <style>
        @keyframes progress {
            from { width: 0%; }
            to { width: 100%; }
        }
        .animate-progress {
            animation: progress 24s linear forwards;
        }
    </style>
</div>
</div>


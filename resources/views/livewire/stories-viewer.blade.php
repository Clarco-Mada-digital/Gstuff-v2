<div x-data="{
    openViewStorie:false,
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
        @php
            $hasStories = false;
        @endphp

        @foreach($stories as $userId => $userStories)
            @if($userStories->isNotEmpty() && $userId == $userViewStorie)
                @php $hasStories = true; @endphp
                <div class="relative w-24 h-24 rounded-full border-2 border-blue-500 cursor-pointer"
                    @click="$wire.openStory({{ $userId }}); openViewStorie=true">
                     
                    @if($userStories->first()->media_type === 'image')
                        <img src="{{ asset('storage/' . $userStories->first()->media_path) }}"
                            class="w-full h-full rounded-full object-cover" 
                            alt="Story image">
                    @elseif($userStories->first()->media_type === 'video')
                        <video class="w-full h-full rounded-full object-cover"
                            muted 
                            playsinline>
                            <source src="{{ asset('storage/' . $userStories->first()->media_path) }}">
                        </video>
                    @endif
                </div>
            @endif
        @endforeach

        @if(!$hasStories)
            <div class="text-gray-500 text-center flex items-center justify-center w-full">
                Aucun story disponible
            </div>
        @endif
    </div>

    <!-- Modal de visualisation -->
    @if($activeUser)    
        <div x-show='openViewStorie' class="fixed inset-0 bg-black bg-opacity-90 z-50" x-show="isModalOpen">
            <div class="relative h-screen flex items-center justify-center">
                <!-- Contenu de la story -->
                <div x-data="{'muted':true}" @touchstart="handleTouchStart" @touchend="handleTouchEnd" class="relative w-full max-w-2xl h-5/6">
                    
                    <!-- Media -->
                    @if($selectedUserStories[$currentIndex]['media_type'] != 'image')                       
                        <video
                            class="w-full h-full object-contain rounded-lg" 
                            controls
                            autoplay
                            onended="window.Livewire.dispatch('nextStory')">
                            <source src="{{ asset('storage/' . $selectedUserStories[$currentIndex]['media_path']) }}">
                        </video>
                    @else
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
                @auth
                <div x-data="{ likeCount: {{$selectedUserStories[$currentIndex]['likes_count']}} }">
                    <div class="absolute bottom-4 text-4xl left-4 flex items-center justify-end space-x-2">
                        <button
                            @if ($userViewStorie != Auth()->user()->id)
                            @click="
                                likeCount += 1;
                                @this.call('likeStory', {{ $selectedUserStories[$currentIndex]['id'] }});
                            "                                
                            @endif
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


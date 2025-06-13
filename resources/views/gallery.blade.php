@extends('layouts.base')

@section('pageTitle', __('gallery.gallery'))

@section('content')
    <section class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-br from-pink-500 via-purple-600 to-indigo-600 text-white shadow-xl">
        <!-- Votre en-tête existant reste inchangé -->
        <div class="mx-auto max-w-7xl px-6 py-20 text-center sm:py-24 lg:px-8">
            <h1 class="mb-4 text-4xl font-extrabold sm:text-5xl">{{ __('gallery.explore_share_feel') }}</h1>
            <p class="mx-auto max-w-2xl text-lg font-light sm:text-xl" x-html="{{ json_encode(__('gallery.header_subtitle')) }}"></p>
        </div>

        <!-- Illustration décorative -->
        <div class="pointer-events-none absolute bottom-0 right-0 opacity-20">
            <svg viewBox="0 0 200 200" class="h-64 w-64 translate-x-12 translate-y-12 transform">
                <path fill="white"
                    d="M40.6,-71.1C51.1,-66.2,58.8,-51.5,64.3,-37.1C69.7,-22.6,73,-8.3,73.5,6.2C73.9,20.7,71.4,35.3,63.8,47.8C56.2,60.3,43.5,70.7,29.3,73.6C15.2,76.5,-0.5,71.8,-16.4,66.6C-32.3,61.3,-48.5,55.4,-59.6,44.1C-70.7,32.8,-76.8,16.4,-76.3,0.3C-75.8,-15.9,-68.6,-31.8,-58.3,-44.3C-48.1,-56.8,-34.8,-65.9,-20.2,-69.8C-5.6,-73.7,10.2,-72.3,24.6,-71.2C39,-70.1,52.1,-69.9,40.6,-71.1Z"
                    transform="translate(100 100)" />
            </svg>
        </div>
    </section>

    <div class="mx-auto min-h-[50vh] max-w-7xl px-4 py-10 sm:px-6 lg:px-8" 
         x-data="galleryApp()">
        <div x-data="{ selectedTab: $persist('stories') }" class="flex flex-col gap-8 md:flex-row">
            <!-- MENU LATERAL -->
            <aside class="space-y-2 md:w-1/5">
                <!-- MOBILE TOGGLE -->
                <div class="mb-4 md:hidden">
                    <button @click="openMenu = !openMenu"
                        class="flex w-full items-center justify-between rounded-lg bg-gray-100 px-4 py-2 text-gray-800">
                        <span>📁 {{ __('gallery.sections') }}</span>
                        <svg :class="{ 'rotate-180': openMenu }" class="h-4 w-4 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <div :class="{ 'block': openMenu, 'hidden': !openMenu }" class="space-y-2 md:block">
                    <!-- Tab Stories -->
                    <button @click="selectedTab = 'stories'; openMenu = false"
                        :class="selectedTab === 'stories' ? 'bg-pink-600 text-white' : 'bg-gray-100 text-gray-700'"
                        class="flex w-full items-center justify-between rounded-lg px-4 py-2 text-left font-medium transition hover:bg-pink-100">
                        📸 Stories
                        <span class="rounded-full bg-white/30 px-2 py-1 text-xs"
                            x-text="{{ count($usersWithStories) }}"></span>
                    </button>

                    <!-- Tab Galerie publique -->
                    <button @click="selectedTab = 'public'; openMenu = false"
                        :class="selectedTab === 'public' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                        class="flex w-full items-center justify-between rounded-lg px-4 py-2 text-left font-medium transition hover:bg-blue-100">
                        🌍 {{ __('gallery.public_gallery') }}
                        <span class="rounded-full bg-white/30 px-2 py-1 text-xs"
                            x-text="{{ count($publicGallery) }}"></span>
                    </button>

                    <!-- Tab Galerie privée -->
                    <button @click="selectedTab = 'private'; openMenu = false"
                        :class="selectedTab === 'private' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700'"
                        class="flex w-full items-center justify-between rounded-lg px-4 py-2 text-left font-medium transition hover:bg-gray-200">
                        🔐 {{ __('gallery.private_gallery') }}
                        <span class="rounded-full bg-white/30 px-2 py-1 text-xs"
                            x-text="{{ count($privateGallery) }}"></span>
                    </button>
                </div>
            </aside>

            <!-- CONTENU PRINCIPAL -->
            <div class="flex-1 space-y-10">
                <!-- Stories -->
                <section x-show="selectedTab === 'stories'" x-data="{
                    openViewer: false,
                    currentUser: null,
                    currentStoryIndex: 0,
                    progress: 0,
                    interval: null,
                    
                    openStory(user) {
                        this.currentUser = user;
                        this.currentStoryIndex = 0;
                        this.openViewer = true;
                        this.startProgress();
                    },
                    
                    nextStory() {
                        if (this.currentStoryIndex < this.currentUser.stories.length - 1) {
                            this.currentStoryIndex++;
                            this.progress = 0;
                            this.startProgress();
                        } else {
                            this.closeViewer();
                        }
                    },
                    
                    previousStory() {
                        if (this.currentStoryIndex > 0) {
                            this.currentStoryIndex--;
                            this.progress = 0;
                            this.startProgress();
                        }
                    },
                    
                    startProgress() {
                        clearInterval(this.interval);
                        this.progress = 0;
                        const duration = 5000; // 5 seconds per story
                        const steps = 100;
                        const stepTime = duration / steps;
                        
                        this.interval = setInterval(() => {
                            this.progress += (100 / steps);
                            if (this.progress >= 100) {
                                clearInterval(this.interval);
                                this.nextStory();
                            }
                        }, stepTime);
                    },
                    
                    closeViewer() {
                        clearInterval(this.interval);
                        this.openViewer = false;
                        this.currentUser = null;
                    }
                }" x-init="$watch('openViewer', value => {
                    if (value) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = 'auto';
                    }
                })" x-transition>
                    <h2 class="mb-6 text-xl sm:text-3xl font-semibold text-gray-800">📸 {{ __('gallery.user_stories') }}</h2>
                    @if(count($usersWithStories) > 0)
                        <div class="flex space-x-6 overflow-x-auto pb-4 px-2">
                            @foreach ($usersWithStories as $user)
                                <div class="flex-shrink-0 text-center relative group cursor-pointer" 
                                     @click="openStory({{ json_encode($user) }});">
                                    <div class="relative">
                                        <div class="mx-auto h-24 w-24 overflow-hidden rounded-full border-4 border-pink-500 shadow-lg group-hover:border-pink-600 transition-all duration-300">
                                            <img src="{{ $user['avatar'] }}" 
                                                alt="{{ $user['name'] }}"
                                                class="h-full w-full object-cover"
                                                loading="lazy">
                                            @if($user['stories_count'] > 0)
                                                <div class="absolute -top-2 -right-2 bg-pink-500 text-white rounded-full h-8 w-8 flex items-center justify-center text-xs font-bold shadow-md">
                                                    {{ $user['stories_count'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="mt-2 block text-sm font-medium text-gray-700 truncate max-w-[6rem]">
                                        {{ $user['name'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Story Viewer -->
                        <div x-show="openViewer && currentUser" class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center" 
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             @keydown.escape.window="closeViewer">
                            
                            <div class="relative w-full max-w-md h-full max-h-[90vh] flex items-center">
                                <!-- Close button -->
                                <button @click="closeViewer" class="absolute top-4 right-4 text-white text-2xl z-10">
                                    &times;
                                </button>
                                
                                <!-- Navigation buttons -->
                                <button x-show="currentStoryIndex > 0" 
                                        @click="previousStory" 
                                        class="absolute left-4 text-white text-2xl z-10">
                                    &larr;
                                </button>
                                
                                <button x-show="currentStoryIndex < currentUser.stories.length - 1" 
                                        @click="nextStory" 
                                        class="absolute right-4 text-white text-2xl z-10">
                                    &rarr;
                                </button>
                                
                                <!-- Progress bar -->
                                <div class="absolute top-4 left-4 right-4 flex space-x-1 z-10">
                                    <template x-for="(story, index) in currentUser.stories" :key="index">
                                        <div class="h-1 flex-1 bg-gray-600 rounded-full">
                                            <div class="h-full bg-white rounded-full transition-all duration-100" 
                                                 :class="{'w-full': index < currentStoryIndex, 'w-0': index > currentStoryIndex}"
                                                 :style="index === currentStoryIndex ? 'width: ' + progress + '%' : ''">
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                
                                <!-- Story content -->
                                <div class="w-full h-full flex items-center justify-center">
                                    <template x-if="currentUser.stories[currentStoryIndex].media_type === 'image'">
                                        <img :src="currentUser.stories[currentStoryIndex].media_path" 
                                             class="max-h-full max-w-full object-contain" 
                                             alt="Story">
                                    </template>
                                    
                                    <template x-if="currentUser.stories[currentStoryIndex].media_type === 'video'">
                                        <video :src="currentUser.stories[currentStoryIndex].media_path" 
                                              class="max-h-full max-w-full" 
                                              autoplay
                                              @ended="nextStory">
                                        </video>
                                    </template>
                                </div>
                                
                                <!-- User info -->
                                <div class="absolute bottom-4 left-4 right-4 text-white text-left z-10">
                                    <div class="flex items-center space-x-2">
                                        <img :src="currentUser.avatar" 
                                             class="h-10 w-10 rounded-full border-2 border-white">
                                        <span x-text="currentUser.name" class="font-semibold"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">
                                {{ __('gallery.no_stories_available') }}
                            </p>
                        </div>
                    @endif
                </section>

                <!-- Galerie Publique -->
                <section x-show="selectedTab === 'public'" x-transition>
                    <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <h2 class="text-xl sm:text-3xl font-semibold text-gray-800">🌍 {{ __('gallery.public_gallery_title') }}</h2>
                        
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4 text-sm">
                            <!-- Filtre utilisateur amélioré -->
                            <div class="relative w-full md:w-64">
                                <div class="relative">
                                    <div @click="userFilter.open = !userFilter.open"
                                         class="flex items-center justify-between p-2 border border-gray-300 rounded-md cursor-pointer bg-white">
                                        <div class="flex flex-wrap gap-1 items-center">
                                            <template x-if="userFilter.selectedUsers.length === 0">
                                                <span class="text-gray-400">{{ __('gallery.all_users') }}</span>
                                            </template>
                                            <template x-for="userId in userFilter.selectedUsers" :key="userId">
                                                <span class="flex items-center bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                    <span x-text="userFilter.getUserName(userId)"></span>
                                                    <button @click.stop="userFilter.removeUser(userId)"
                                                            class="ml-1 text-blue-500 hover:text-blue-700">
                                                        ×
                                                    </button>
                                                </span>
                                            </template>
                                        </div>
                                        <svg class="h-5 w-5 text-gray-400 transition-transform duration-200" 
                                             :class="{ 'rotate-180': userFilter.open }" 
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>

                                    <div x-show="userFilter.open" @click.away="userFilter.open = false"
                                         class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md py-1 border max-h-60 overflow-auto">
                                        <div class="sticky top-0 bg-white border-b p-2">
                                            <input x-model="userFilter.search" @input="userFilter.filterUsers()"
                                                   @click.stop placeholder="{{ __('gallery.search') }}"
                                                   class="w-full p-1 border rounded text-sm">
                                        </div>
                                        <div @click="userFilter.toggleAllUsers()"
                                             class="px-3 py-2 hover:bg-gray-100 cursor-pointer flex items-center"
                                             :class="{ 'bg-blue-50 font-medium': userFilter.selectedUsers.length === 0 }">
                                            <input type="checkbox" class="mr-2" 
                                                   :checked="userFilter.selectedUsers.length === 0" readonly>
                                            <span>{{ __('gallery.all_users') }}</span>
                                        </div>
                                        <template x-for="user in userFilter.filteredUsers" :key="user.id">
                                            <div @click="userFilter.toggleUser(user.id)"
                                                 class="px-3 py-2 hover:bg-gray-100 cursor-pointer flex items-center"
                                                 :class="{ 'bg-blue-50 font-medium': userFilter.selectedUsers.includes(user.id) }">
                                                <input type="checkbox" class="mr-2" 
                                                       :checked="userFilter.selectedUsers.includes(user.id)" readonly>
                                                <span x-text="user.prenom"></span>
                                            </div>
                                        </template>
                                        <div x-show="userFilter.search && userFilter.filteredUsers.length === 0"
                                             class="px-3 py-2 text-gray-500 text-sm">
                                            {{ __('gallery.no_users_found') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtre par type de média -->
                            <select x-model="mediaTypeFilter" class="rounded-md border border-gray-300 p-2 w-full md:w-64">
                                <option value="">{{ __('gallery.all_types') }}</option>
                                <option value="image">{{ __('gallery.images') }}</option>
                                <option value="video">{{ __('gallery.videos') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                        @foreach ($publicGallery as $media)
                            <div x-show="shouldShowMedia('{{ $media->user_id }}', '{{ $media->type }}')"
                                class="cursor-pointer overflow-hidden rounded-xl shadow transition duration-300 hover:shadow-xl">
                                @if ($media->type === 'image')
                                    <img @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'image')" 
                                        src="{{ asset('storage/' . $media->path) }}" 
                                        class="h-60 w-full object-cover" alt="media">
                                @elseif($media->type === 'video')
                                    <div class="relative">
                                        <video @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'video')" 
                                            muted autoplay loop
                                            class="pointer-events-none h-60 w-full object-cover brightness-75">
                                            <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                        </video>
                                        <div class="absolute inset-0 flex items-center justify-center text-4xl font-bold text-white">
                                            ▶
                                        </div>
                                    </div>
                                @endif
                                <div class="flex items-center justify-between px-3">
                                    <span class="my-2">{{ $media->user->prenom }}</span>
                                    <a href="{{ route('show_escort', $media->user->id) }}"
                                    class="my-2 ms-3" title="{{ __('gallery.view_profile') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $publicGallery->links() }}
                    </div>
                </section>

                <!-- Galerie Privée -->
                <section x-show="selectedTab === 'private'" x-transition>
                    <h2 class="mb-4 text-xl sm:text-3xl font-semibold text-gray-800">🔐 {{ __('gallery.private_gallery_title') }}</h2>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                        @foreach ($privateGallery as $media)
                            @auth
                                <div class="cursor-pointer overflow-hidden rounded-xl shadow transition duration-300 hover:shadow-xl">
                                    @if ($media->type === 'image')
                                        <img @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'image')" 
                                             src="{{ asset('storage/' . $media->path) }}" 
                                             class="h-60 w-full object-cover" alt="media">
                                    @elseif($media->type === 'video')
                                        <div class="relative">
                                            <video @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'video')" 
                                                   muted class="pointer-events-none h-60 w-full object-cover brightness-75">
                                                <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                            </video>
                                            <div class="absolute inset-0 flex items-center justify-center text-4xl font-bold text-white">
                                                ▶
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endauth
                            @guest
                                <div class="relative overflow-hidden rounded-xl shadow transition hover:shadow-lg">
                                    @if ($media->type === 'image')
                                        <img class="blur-md grayscale brightness-75 h-60 w-full object-cover transition duration-300"
                                            src="{{ asset('storage/' . $media->path) }}" alt="Privé">
                                    @elseif ($media->type === 'video')
                                        <div class="blur-md grayscale brightness-75">
                                            <video class="h-60 w-full object-cover transition duration-300">
                                                <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                                Votre navigateur ne supporte pas la vidéo.
                                            </video>
                                        </div>
                                    @endif

                                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" 
                                            type="button" class="absolute inset-0 flex items-center justify-center bg-black/50 px-2 text-center text-sm font-semibold text-white">
                                        {{ __('gallery.login_to_view') }}
                                    </button>
                                </div>
                            @endguest
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('extraScripts')
<script>
    function galleryApp() {
        return {
            loggedIn: @json(auth()->check()),        
            openMenu: false,
            mediaTypeFilter: '',
            
            userFilter: {
                allUsers: @json($usersWithMedia->map(function($user) {
                    return ['id' => $user->id, 'prenom' => $user->prenom];
                })),
                filteredUsers: [],
                selectedUsers: [],
                search: '',
                open: false,
                
                init() {
                    this.$watch('currentPage', () => this.loadPage());
                    this.$watch(['selectedUsers', 'selectedType', 'searchQuery'], 
                        () => this.applyFilters());
                },
                
                filterUsers() {
                    if (!this.search) {
                        this.filteredUsers = [...this.allUsers];
                        return;
                    }
                    
                    const searchTerm = this.search.toLowerCase().trim();
                    this.filteredUsers = this.allUsers.filter(user => 
                        user.prenom.toLowerCase().includes(searchTerm)
                    );
                },
                
                toggleUser(userId) {
                    if (this.selectedUsers.includes(userId)) {
                        this.selectedUsers = this.selectedUsers.filter(id => id !== userId);
                    } else {
                        this.selectedUsers = [...this.selectedUsers, userId];
                    }
                },
                
                removeUser(userId) {
                    this.selectedUsers = this.selectedUsers.filter(id => id !== userId);
                },
                
                toggleAllUsers() {
                    this.selectedUsers = [];
                },
                
                getUserName(userId) {
                    const user = this.allUsers.find(u => u.id === userId);
                    return user ? user.prenom : '';
                }
            },
            
            shouldShowMedia(userId, mediaType) {
                // Conversion robuste des IDs en strings
                const selectedUsersStrings = this.userFilter.selectedUsers.map(String);
                const userIdString = String(userId);

                const userMatch = selectedUsersStrings.length === 0 || 
                                selectedUsersStrings.includes(userIdString);
                
                const typeMatch = !this.mediaTypeFilter || this.mediaTypeFilter === mediaType;

                return userMatch && typeMatch;
            },
            
            openMedia(src, type) {
                this.$dispatch('media-open', { src, type });
            },
        }
    }
</script>
@endsection
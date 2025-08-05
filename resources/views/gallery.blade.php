@extends('layouts.base')

@section('pageTitle', __('gallery.gallery'))

@section('content')
    <section class="relative mb-10 overflow-hidden bg-supaGirlRosePastel shadow-xl font-roboto-slab text-green-gs">
        <!-- Votre en-tête existant reste inchangé -->
        <div class="mx-auto max-w-7xl px-6 py-20 text-center sm:py-24 lg:px-8">
            <h1 class="mb-4 text-4xl font-extrabold sm:text-5xl">{{ __('gallery.explore_share_feel') }}</h1>
            <p class="mx-auto max-w-2xl text-lg font-light sm:text-xl" x-html="{{ json_encode(__('gallery.header_subtitle')) }}"></p>
        </div>

        <!-- Illustration décorative -->
        {{-- <div class="pointer-events-none absolute bottom-0 right-0 opacity-20">
            <svg viewBox="0 0 200 200" class="h-64 w-64 translate-x-12 translate-y-12 transform">
                <path fill="white"
                    d="M40.6,-71.1C51.1,-66.2,58.8,-51.5,64.3,-37.1C69.7,-22.6,73,-8.3,73.5,6.2C73.9,20.7,71.4,35.3,63.8,47.8C56.2,60.3,43.5,70.7,29.3,73.6C15.2,76.5,-0.5,71.8,-16.4,66.6C-32.3,61.3,-48.5,55.4,-59.6,44.1C-70.7,32.8,-76.8,16.4,-76.3,0.3C-75.8,-15.9,-68.6,-31.8,-58.3,-44.3C-48.1,-56.8,-34.8,-65.9,-20.2,-69.8C-5.6,-73.7,10.2,-72.3,24.6,-71.2C39,-70.1,52.1,-69.9,40.6,-71.1Z"
                    transform="translate(100 100)" />
            </svg>
        </div> --}}
    </section>

    <div x-data="galleryApp()"
     x-init="
        haveStories = @json(count($usersWithStories) > 0);
        havePublicGallery = @json(count($publicGallery) > 0);
        havePrivateGallery = @json(count($privateGallery) > 0);
     "
     class="mx-auto min-h-[50vh] max-w-7xl px-4 py-10 sm:px-6 lg:px-8 font-roboto-slab">
    <div x-data="{
        selectedTab: $persist(
            haveStories ? 'stories' : havePublicGallery ? 'public' : havePrivateGallery ? 'private' : 'stories'
        )
    }" class="flex flex-col gap-8 font-roboto-slab">
 <!-- MENU LATERAL -->
            <aside class="space-y-2 w-full flex justify-center items-center ">
                <!-- MOBILE TOGGLE -->
                <!-- <div class="mb-4 md:hidden">
                    <button @click="openMenu = !openMenu"
                        class="flex w-full items-center justify-between rounded-lg bg-fieldBg px-4 py-2 text-green-gs">
                        <span>📁 {{ __('gallery.sections') }}</span>
                        <svg :class="{ 'rotate-180': openMenu }" class="h-4 w-4 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div> -->

                <div  class="flex flex-col sm:flex-row gap-0 items-center justify-center w-full">
                    <!-- Tab Stories -->
                    @if(count($usersWithStories) > 0)
                    <button @click="selectedTab = 'stories'; openMenu = false"
                        :class="selectedTab === 'stories' ? 'bg-supaGirlRose' : 'bg-fieldBg'"
                        class="text-green-gs flex w-[60%] sm:w-1/3 md:w-[20%] lg:w-[20%] xl:w-[20%] 2xl:w-[20%] 3xl:w-[20%] 4xl:w-[20%] h-[40px] items-center justify-between border-b-2 border-supaGirlRose px-4 py-2 text-left font-medium transition hover:bg-supaGirlRose">
                        <span class="flex items-center"> 
                        <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="19" height="20" rx="9.5" fill="#FED5E9"/>
                            <path d="M6.52099 15V5H12.479V15H6.52099ZM4 13.5714V6.42857H4.74475V13.5714H4ZM14.2552 13.5714V6.42857H15V13.5714H14.2552ZM7.26574 14.2857H11.7343V5.71429H7.26574V14.2857Z" fill="black"/>
                        </svg>
                            <span class="ml-2">{{ __('gallery.stories') }}</span>
                        </span>
                        <span class="rounded-full bg-white/30 px-2 py-1 text-xs"
                            x-text="{{ count($usersWithStories) }}"></span>
                    </button>
                    @endif

                    <!-- Tab Galerie publique -->
                    @if(count($publicGallery) > 0)
                    <button @click="selectedTab = 'public'; openMenu = false"
                        :class="selectedTab === 'public' ? 'bg-supaGirlRose' : 'bg-fieldBg'"
                        class="text-green-gs flex w-[60%] sm:w-1/3 md:w-[20%] lg:w-[20%] xl:w-[20%] 2xl:w-[20%] 3xl:w-[20%] 4xl:w-[20%] h-[40px] items-center justify-between border-b-2 border-supaGirlRose px-4 py-2 text-left font-medium transition hover:bg-supaGirlRose">
                        <span class="flex items-center">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect x="0.5" y="0.5" width="19" height="19" rx="9.5" fill="#FED5E9"/>
<path d="M10 15C12.7614 15 15 12.7614 15 10C15 7.23858 12.7614 5 10 5C7.23858 5 5 7.23858 5 10C5 12.7614 7.23858 15 10 15Z" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M9.99999 9.46395C10.7463 9.46395 11.3514 8.85891 11.3514 8.11256C11.3514 7.3662 10.7463 6.76116 9.99999 6.76116C9.25364 6.76116 8.6486 7.3662 8.6486 8.11256C8.6486 8.85891 9.25364 9.46395 9.99999 9.46395Z" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M10 8.65304C10.2985 8.65304 10.5405 8.41106 10.5405 8.11257C10.5405 7.81408 10.2985 7.57211 10 7.57211C9.70152 7.57211 9.45954 7.81408 9.45954 8.11257C9.45954 8.41106 9.70152 8.65304 10 8.65304Z" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M7.83791 12.6823C7.83791 12.6823 9.05279 10.2498 10 10.2498C10.9472 10.2498 12.1621 12.6823 12.1621 12.6823" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M8.91885 12.6823C8.91885 12.6823 9.52768 11.3312 10 11.3312C10.4723 11.3312 11.0812 12.6823 11.0812 12.6823M7.83791 12.6823C7.63512 13.0335 8.31094 13.7358 8.91885 12.6823ZM12.1621 12.6823C12.3649 13.0335 11.6891 13.7358 11.0812 12.6823Z" stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                            <span class="ml-2">{{ __('gallery.public_gallery') }}</span>
                        </span>
                        <span class="rounded-full bg-white/30 px-2 py-1 text-xs"
                            x-text="{{ count($publicGallery) }}"></span>
                    </button>
                    @endif

                    <!-- Tab Galerie privée -->
                    @if(count($privateGallery) > 0)
                    <button @click="selectedTab = 'private'; openMenu = false"
                        :class="selectedTab === 'private' ? 'bg-supaGirlRose' : 'bg-fieldBg'"
                        class="text-green-gs flex w-[60%] sm:w-1/3 md:w-[20%] lg:w-[20%] xl:w-[20%] 2xl:w-[20%] 3xl:w-[20%] 4xl:w-[20%] h-[40px] items-center justify-between border-b-2 border-supaGirlRose px-4 py-2 text-left font-medium transition hover:bg-supaGirlRose">
                        <span class="flex items-center"> 
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" width="19" height="20" rx="9.5" fill="#FED5E9"/>
                        <path d="M6.53886 15C6.25086 15 6.00571 14.9126 5.80343 14.7378C5.60114 14.563 5.5 14.3513 5.5 14.1028V9.23056C5.5 8.98241 5.60114 8.77074 5.80343 8.59556C6.00571 8.42074 6.25086 8.33333 6.53886 8.33333H7.42857V7.22222C7.42857 6.60333 7.67821 6.07833 8.1775 5.64722C8.67636 5.21574 9.28386 5 10 5C10.7161 5 11.3239 5.21574 11.8231 5.64722C12.3224 6.0787 12.5719 6.6037 12.5714 7.22222V8.33333H13.4618C13.7489 8.33333 13.9939 8.42074 14.1966 8.59556C14.3989 8.77037 14.5 8.98222 14.5 9.23111V14.1028C14.5 14.3509 14.3989 14.5626 14.1966 14.7378C13.9943 14.9126 13.7494 15 13.4618 15H6.53886ZM6.53886 14.4444H13.4618C13.5771 14.4444 13.6718 14.4124 13.7459 14.3483C13.8201 14.2843 13.8571 14.2024 13.8571 14.1028V9.23056C13.8571 9.13093 13.8201 9.04907 13.7459 8.985C13.6718 8.92093 13.5771 8.88889 13.4618 8.88889H6.53821C6.42293 8.88889 6.32821 8.92093 6.25407 8.985C6.17993 9.04907 6.14286 9.13111 6.14286 9.23111V14.1028C6.14286 14.2024 6.17993 14.2843 6.25407 14.3483C6.32821 14.4124 6.42314 14.4444 6.53886 14.4444ZM10 12.5C10.2713 12.5 10.4997 12.4196 10.6853 12.2589C10.8713 12.0985 10.9643 11.9011 10.9643 11.6667C10.9643 11.4322 10.8713 11.2348 10.6853 11.0744C10.4993 10.9141 10.2709 10.8337 10 10.8333C9.72914 10.833 9.50071 10.9133 9.31471 11.0744C9.12871 11.2348 9.03571 11.4322 9.03571 11.6667C9.03571 11.9011 9.12871 12.0985 9.31471 12.2589C9.50029 12.4196 9.72871 12.5 10 12.5ZM8.07143 8.33333H11.9286V7.22222C11.9286 6.75926 11.7411 6.36574 11.3661 6.04167C10.9911 5.71759 10.5357 5.55556 10 5.55556C9.46429 5.55556 9.00893 5.71759 8.63393 6.04167C8.25893 6.36574 8.07143 6.75926 8.07143 7.22222V8.33333Z" fill="black"/>
                        </svg>
                            <span class="ml-2">{{ __('gallery.private_gallery') }}</span>
                        </span>
                        <span class="rounded-full bg-white/30 px-2 py-1 text-xs"
                            x-text="{{ count($privateGallery) }}"></span>
                    </button>
                    @endif
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
                        const duration = 10000; // 10 secondes par story
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
                })" x-transition x-cloak>
                    <h2 class="mb-6 text-xl sm:text-3xl font-semibold text-green-gs flex items-center justify-center"> {{ __('gallery.user_stories') }}</h2>
                    @if(count($usersWithStories) > 0)
                        <div class="flex space-x-6 overflow-x-auto pb-4 px-2">
                            @foreach ($usersWithStories as $user)
                                <div class="relative flex flex-col items-center w-60 h-96 rounded-xl overflow-hidden cursor-pointer"
                                    @click.stop="openStory({{ json_encode($user) }});">
                                    <div class="relative w-full h-full overflow-hidden shadow-lg group-hover:border-green-gs transition-all duration-300">
                                        <img src="{{ $user['stories'][0]['media_path'] }}"
                                            alt="{{ $user['name'] }}"
                                            class="h-full w-full object-cover"
                                            loading="lazy">
                                        @if (str_contains($user['stories'][0]['media_type'], 'video'))
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197.661a.5.5 0 01-.784-.394L9 7.616V6.868a.5.5 0 01.5-.5h.697a.5.5 0 01.5.5v.737l.257.434a.5.5 0 01-.212.662l-3.498 2.799a.5.5 0 01-.784-.394z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <a href="{{ route('show_escort', $user['id']) }}" class="absolute bottom-0 left-0 right-0 flex items-center p-2">
                                            <div class="relative h-10 w-10 rounded-full border-2 border-green-gs shadow-lg group-hover:border-green-gs transition-all duration-300">
                                                <img src="{{ $user['avatar'] }}"
                                                    alt="{{ $user['name'] }}"
                                                    class="h-full w-full object-cover rounded-full"
                                                    loading="lazy">
                                                <span class="absolute bottom-0 -right-2 rounded-full bg-pink-500 w-4 h-4 flex items-center justify-center text-xs text-white">
                                                    {{ count($user['stories']) }}
                                                </span>
                                            </div>
                                            <span class="text-white text-sm font-medium ml-2 truncate max-w-[8rem]">
                                                {{ $user['name'] }}
                                            </span>
                                        </a>
                                    </div>
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
                            
                            <div class="relative w-full h-full max-h-[90vh] flex items-center">
                                <!-- Close button -->
                                <button @click="closeViewer" class="absolute right-4 top-2 rounded-full bg-supaGirlRose p-2 text-white hover:bg-green-gs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                
                                
                                <!-- Navigation buttons -->
                                <button x-show="currentStoryIndex > 0" 
                                @click="previousStory"  class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-green-gs p-2 text-white hover:bg-supaGirlRose">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                          

                                <button x-show="currentStoryIndex < currentUser.stories.length - 1" 
                                @click="nextStory"  class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-green-gs p-2 text-white hover:bg-supaGirlRose">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                
                                <!-- Progress bar -->
                                <div class="absolute top-2 left-4 right-4 flex space-x-1 z-10 max-w-md mx-auto">
                                    <template x-for="(story, index) in currentUser.stories" :key="index">
                                        <div class="h-1 flex-1 bg-gray-600 rounded-full">
                                            <div class="h-full bg-green-gs rounded-full transition-all duration-100" 
                                                 :class="{'w-full': index < currentStoryIndex, 'w-0': index > currentStoryIndex}"
                                                 :style="index === currentStoryIndex ? 'width: ' + progress + '%' : ''">
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                
                                <!-- Story content -->
                                <div class="w-full max-w-2xl mx-auto h-[80vh] flex items-center justify-center">
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
                                <!-- <div class="absolute bottom-2 mx-auto text-white text-left z-10">
                                    <div class="flex items-center space-x-2">
                                        <img :src="currentUser.avatar" 
                                             class="h-10 w-10 rounded-full border-2 border-white">
                                        <span x-text="currentUser.name" class="font-semibold"></span>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">
                                {{ __('profile.no_stories_available') }}
                            </p>
                        </div>
                    @endif
                </section>

                <!-- Galerie Publique -->
                <section x-show="selectedTab === 'public'" x-transition>
                    <div class="mb-4 flex flex-row items-center justify-between gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <h2 class="text-xl sm:text-3xl font-semibold text-green-gs flex items-center">
                             {{ __('gallery.public_gallery_title') }}</h2>
                        
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4 text-sm">
                            <!-- Filtre utilisateur amélioré -->
                            <!-- <div class="relative w-full md:w-64">
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
                            </div> -->

                            <!-- Filtre par type de média -->
                            {{-- <select x-model="mediaTypeFilter" class="rounded-md border border-gray-300 p-2 w-full md:w-64">
                                <option value="">{{ __('gallery.all_types') }}</option>
                                <option value="image">{{ __('gallery.images') }}</option>
                                <option value="video">{{ __('gallery.videos') }}</option>
                            </select> --}}
                            
                            <!-- Filtre par genre -->
                            <select x-model="genreTypeFilter" class="rounded-md border border-supaGirlRose text-green-gs p-2 w-full md:w-64">
                                <option value="">{{ __('gallery.all') }}</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->name['fr'] ?? $genre->slug }}">
                                        {{ $genre->getTranslation('name', app()->getLocale()) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-center    w-full">
                    <div class="grid grid-cols-1 items-center sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4  gap-4">
                        @foreach ($publicGallery as $media)
                            @php
                                $userGenre = $media->user->genre->name['fr'] ?? null;
                            @endphp
                            <div x-show="shouldShowMedia('{{ $media->user_id }}', '{{ $media->type }}', '{{ $userGenre }}')"
                                class="relative cursor-pointer overflow-hidden rounded-xl shadow transition duration-300 hover:shadow-xl flex flex-col   min-w-[200px] max-w-[280px] min-h-[348px]  ">
                                @if ($media->type === 'image')
                                    <div class="flex-1 overflow-hidden h-[348px] min-h-[348px]">
                                        <img @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'image')" 
                                            src="{{ asset('storage/' . $media->path) }}" 
                                            class="h-[348px] min-h-[348px] w-full object-cover object-center" 
                                            alt="media">
                                    </div>
                                @elseif($media->type === 'video')
                                    <div class="relative flex-1 h-full w-full">
                                        <video @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'video')" 
                                            muted autoplay loop
                                            class="h-[348px] w-full object-cover object-center brightness-75">
                                            <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                        </video>
                                        <div class="absolute inset-0 flex items-center justify-center text-4xl font-bold text-white">
                                            ▶
                                        </div>
                                    </div>
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 flex items-center justify-between px-3 py-2 bg-gradient-to-t from-black/80 to-transparent text-white font-bold font-roboto-slab">
                                    <span class="truncate">{{ $media->user->prenom }}</span>
                                    <a href="{{ route('show_escort', $media->user->id) }}"
                                    class="ml-2 flex-shrink-0" title="{{ __('gallery.view_profile') }}">
                                        <img src="{{ asset('images/icons/galery_show_icon.svg') }}" alt="Show Profile" class="w-5 h-5">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    </div>
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $publicGallery->links() }}
                    </div>
                </section>

                <!-- Galerie Privée -->
                <section x-show="selectedTab === 'private'" x-transition>
                    <h2 class="mb-4 text-xl sm:text-3xl font-semibold text-green-gs flex items-center justify-center"> {{ __('gallery.private_gallery_title') }}</h2>
                    <div class="flex items-center justify-center    w-full">
                   <div class="grid grid-cols-1 items-center gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @foreach ($privateGallery as $media)
                            @auth
                                <div class="relative cursor-pointer overflow-hidden rounded-xl shadow transition duration-300 hover:shadow-xl min-w-[200px] max-w-[280px] min-h-[348px] ">
                                    @if ($media->type === 'image')
                                        <div class="flex-1 overflow-hidden h-[348px] ">
                                        <img @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'image')" 
                                            src="{{ asset('storage/' . $media->path) }}" 
                                            class="h-[348px] w-full object-cover object-center" 
                                            alt="media">
                                    </div>
                                    @elseif($media->type === 'video')
                                        <div class="relative">
                                            <video @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'video')" 
                                                   muted class="pointer-events-none h-[348px] w-full object-cover brightness-75">
                                                <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                            </video>
                                            <div class="absolute inset-0 flex items-center justify-center text-4xl font-bold text-white">
                                                ▶
                                            </div>
                                        </div>
                                    @endif
                                    <div class="absolute bottom-0 left-0 flex items-center justify-between px-3 text-white font-bold font-roboto-slab">
                                        <span class="my-2">{{ $media->user->prenom }}</span>
                                        <a href="{{ route('show_escort', $media->user->id) }}"
                                        class="my-2 ms-3" title="{{ __('gallery.view_profile') }}">
                                            <img src="{{ asset('images/icons/galery_show_icon.svg') }}" alt="Show Profile" class="w-5 h-5">
                                        </a>
                                    </div>
                                </div>
                            @endauth
                            @guest
                                <div class="relative overflow-hidden rounded-xl shadow transition hover:shadow-lg min-w-[200px] max-w-[280px] min-h-[348px] ">
                                    @if ($media->type === 'image')
                                    <div class="flex-1 overflow-hidden h-[348px] ">
                                        <img class="blur-md grayscale brightness-75 h-[348px] w-full object-cover transition duration-300"
                                            src="{{ asset('storage/' . $media->path) }}" alt="Privé">
                                    </div>
                                    @elseif ($media->type === 'video')
                                        <div class="blur-md grayscale brightness-75">
                                            <video class="h-[348px] w-full object-cover transition duration-300">
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
            genreTypeFilter: '',
            
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
            
            shouldShowMedia(userId, mediaType, genreType) {
                // Conversion robuste des IDs en strings
                const selectedUsersStrings = this.userFilter.selectedUsers.map(String);
                const userIdString = String(userId);

                // Trouver l'utilisateur correspondant
                const user = @json($publicGallery->items()).find(item => item.user.id == userId);
                
                const userMatch = selectedUsersStrings.length === 0 || 
                                selectedUsersStrings.includes(userIdString);
                
                const typeMatch = !this.mediaTypeFilter || this.mediaTypeFilter === mediaType;
                
                // Vérifier le genre de l'utilisateur
                let genreMatch = true;
                if (this.genreTypeFilter && user && user.user.genre) {
                    // Vérifier si le nom du genre correspond au filtre (en minuscules pour la casse)
                    const genreName = user.user.genre.name?.fr?.toLowerCase() || '';
                    genreMatch = genreName === this.genreTypeFilter.toLowerCase();
                }

                return userMatch && typeMatch && genreMatch;
            },
            
            openMedia(src, type) {
                // Créer un tableau de tous les médias visibles
                const mediaElements = Array.from(document.querySelectorAll('[x-show*="shouldShowMedia"]'));
                const mediaList = mediaElements
                    .filter(el => el.offsetParent !== null) // Seulement les éléments visibles
                    .map(el => {
                        const img = el.querySelector('img, video source');
                        return {
                            src: img ? (img.src || img.parentElement.src) : '',
                            type: img ? (img.tagName === 'IMG' ? 'image' : 'video') : ''
                        };
                    });
                
                // Trouver l'index du média actuel
                const currentIndex = mediaList.findIndex(media => media.src.includes(src.split('/').pop()));
                
                this.$dispatch('media-open', { 
                    src, 
                    type,
                    mediaList,
                    index: currentIndex !== -1 ? currentIndex : 0
                });
            },
        }
    }
</script>
@endsection
@extends('layouts.base')

@section('pageTitle', __('gallery.gallery'))

@section('content')


@php
    $grid = 0;
    if(count($usersWithStories) > 0){
        $grid ++;
    }
    if(count($publicGallery) > 0){
        $grid ++;
    }
    if(count($privateGallery) > 0){
        $grid ++;
    }
@endphp
    <section class="bg-supaGirlRosePastel font-roboto-slab text-green-gs relative mb-2 sm:mb-4 md:mb-6 lg:mb-8 xl:mb-10 overflow-hidden shadow-xl">
        <!-- Votre en-tête existant reste inchangé -->
        <div class="mx-auto max-w-7xl px-6 py-10 md:py-10 xl:py-15 text-center sm:py-24 lg:px-8">
            <h1 class="mb-4 font-extrabold  
            
            text-sm sm:text-md md:text-lg lg:text-xl xl:text-3xl 2xl:text-4xl">{{ __('gallery.explore_share_feel') }}</h1>
            <p class="mx-auto max-w-2xl text-lg font-light sm:text-xl"
                x-html="{{ json_encode(__('gallery.header_subtitle')) }}"></p>
        </div>
    </section>

    <div x-data="galleryApp()" x-init="haveStories = @json(count($usersWithStories) > 0);
    havePublicGallery = @json(count($publicGallery) > 0);
    havePrivateGallery = @json(count($privateGallery) > 0);"
        class="font-roboto-slab mx-auto min-h-[50vh] max-w-7xl px-2 md:px-4  py-4 ">
        <div x-data="{
            selectedTab: $persist(
                haveStories ? 'stories' : havePublicGallery ? 'public' : havePrivateGallery ? 'private' : 'stories'
            )
        }" class="font-roboto-slab flex flex-col gap-4">
            <!-- MENU LATERAL -->
            <aside class="flex w-full  items-center justify-center space-y-2">
               

                <div class="grid grid-cols-{{ $grid }} w-full items-center justify-center gap-0  2xl:w-[40%]  xl:w-[40%] lg:w-[40%] md:w-[50%] sm:w-[70%]">
                    <!-- Tab Stories -->
                    @if (count($usersWithStories) > 0)
                    <button @click="selectedTab = 'stories'; openMenu = false"
                            :class="selectedTab === 'stories' ? 'bg-supaGirlRose' : 'bg-fieldBg'"
                            class="text-green-gs 
                            
                            
                            
                             h-[40px] w-full

                         
                            px-2 py-1 sm:px-4 sm:py-2

                            border-supaGirlRose hover:bg-supaGirlRose flex
                            items-center justify-between border-b-2  text-left font-medium transition 
                            
                            ">
                            <span class="flex items-center">
                                <svg width="19" height="20" viewBox="0 0 19 20" fill="none" class="hidden sm:block"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="19" height="20" rx="9.5" fill="#FED5E9" />
                                    <path
                                        d="M6.52099 15V5H12.479V15H6.52099ZM4 13.5714V6.42857H4.74475V13.5714H4ZM14.2552 13.5714V6.42857H15V13.5714H14.2552ZM7.26574 14.2857H11.7343V5.71429H7.26574V14.2857Z"
                                        fill="black" />
                                </svg>
                                <span class="ml-2 text-xs md:text-sm">{{ __('gallery.stories') }}</span>
                            </span>
                            <span class="rounded-full bg-white/30 px-2 py-1 text-xs"
                                x-text="{{ count($usersWithStories) }}"></span>
                        </button>
                   
                    @endif
                   

                    <!-- Tab Galerie publique -->
                    @if (count($publicGallery) > 0)
                        <button @click="selectedTab = 'public'; openMenu = false"
                            :class="selectedTab === 'public' ? 'bg-supaGirlRose' : 'bg-fieldBg'"
                            class="text-green-gs 
                            h-[40px] w-full
                            md:px-4 md:py-2 px-2 py-2

                           

                            border-supaGirlRose hover:bg-supaGirlRose flex  items-center justify-between border-b-2  text-left font-medium transition ">
                            <span class="flex items-center">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="hidden sm:block"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" y="0.5" width="19" height="19" rx="9.5" fill="#FED5E9" />
                                    <path
                                        d="M10 15C12.7614 15 15 12.7614 15 10C15 7.23858 12.7614 5 10 5C7.23858 5 5 7.23858 5 10C5 12.7614 7.23858 15 10 15Z"
                                        stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M9.99999 9.46395C10.7463 9.46395 11.3514 8.85891 11.3514 8.11256C11.3514 7.3662 10.7463 6.76116 9.99999 6.76116C9.25364 6.76116 8.6486 7.3662 8.6486 8.11256C8.6486 8.85891 9.25364 9.46395 9.99999 9.46395Z"
                                        stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M10 8.65304C10.2985 8.65304 10.5405 8.41106 10.5405 8.11257C10.5405 7.81408 10.2985 7.57211 10 7.57211C9.70152 7.57211 9.45954 7.81408 9.45954 8.11257C9.45954 8.41106 9.70152 8.65304 10 8.65304Z"
                                        stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M7.83791 12.6823C7.83791 12.6823 9.05279 10.2498 10 10.2498C10.9472 10.2498 12.1621 12.6823 12.1621 12.6823"
                                        stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M8.91885 12.6823C8.91885 12.6823 9.52768 11.3312 10 11.3312C10.4723 11.3312 11.0812 12.6823 11.0812 12.6823M7.83791 12.6823C7.63512 13.0335 8.31094 13.7358 8.91885 12.6823ZM12.1621 12.6823C12.3649 13.0335 11.6891 13.7358 11.0812 12.6823Z"
                                        stroke="black" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="ml-2 text-xs md:text-sm">{{ __('gallery.public_gallery') }}</span>
                            </span>
                            <span class="rounded-full bg-white/30 px-2 py-1 text-xs"
                                x-text="{{ count($publicGallery) }}"></span>
                        </button>
                    @endif

                    <!-- Tab Galerie privée -->
                    @if (count($privateGallery) > 0)
                        <button @click="selectedTab = 'private'; openMenu = false"
                            :class="selectedTab === 'private' ? 'bg-supaGirlRose' : 'bg-fieldBg'"
                            class="text-green-gs 
                           
                            
                            border-supaGirlRose hover:bg-supaGirlRose flex
                            
                            h-[40px] w-full
                            
                            items-center justify-between border-b-2 md:px-4 md:py-2 px-2 py-1 text-left font-medium transition 
                            
                          ">
                            <span class="flex items-center">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" width="19" height="20" rx="9.5" fill="#FED5E9" />
                                    <path
                                        d="M6.53886 15C6.25086 15 6.00571 14.9126 5.80343 14.7378C5.60114 14.563 5.5 14.3513 5.5 14.1028V9.23056C5.5 8.98241 5.60114 8.77074 5.80343 8.59556C6.00571 8.42074 6.25086 8.33333 6.53886 8.33333H7.42857V7.22222C7.42857 6.60333 7.67821 6.07833 8.1775 5.64722C8.67636 5.21574 9.28386 5 10 5C10.7161 5 11.3239 5.21574 11.8231 5.64722C12.3224 6.0787 12.5719 6.6037 12.5714 7.22222V8.33333H13.4618C13.7489 8.33333 13.9939 8.42074 14.1966 8.59556C14.3989 8.77037 14.5 8.98222 14.5 9.23111V14.1028C14.5 14.3509 14.3989 14.5626 14.1966 14.7378C13.9943 14.9126 13.7494 15 13.4618 15H6.53886ZM6.53886 14.4444H13.4618C13.5771 14.4444 13.6718 14.4124 13.7459 14.3483C13.8201 14.2843 13.8571 14.2024 13.8571 14.1028V9.23056C13.8571 9.13093 13.8201 9.04907 13.7459 8.985C13.6718 8.92093 13.5771 8.88889 13.4618 8.88889H6.53821C6.42293 8.88889 6.32821 8.92093 6.25407 8.985C6.17993 9.04907 6.14286 9.13111 6.14286 9.23111V14.1028C6.14286 14.2024 6.17993 14.2843 6.25407 14.3483C6.32821 14.4124 6.42314 14.4444 6.53886 14.4444ZM10 12.5C10.2713 12.5 10.4997 12.4196 10.6853 12.2589C10.8713 12.0985 10.9643 11.9011 10.9643 11.6667C10.9643 11.4322 10.8713 11.2348 10.6853 11.0744C10.4993 10.9141 10.2709 10.8337 10 10.8333C9.72914 10.833 9.50071 10.9133 9.31471 11.0744C9.12871 11.2348 9.03571 11.4322 9.03571 11.6667C9.03571 11.9011 9.12871 12.0985 9.31471 12.2589C9.50029 12.4196 9.72871 12.5 10 12.5ZM8.07143 8.33333H11.9286V7.22222C11.9286 6.75926 11.7411 6.36574 11.3661 6.04167C10.9911 5.71759 10.5357 5.55556 10 5.55556C9.46429 5.55556 9.00893 5.71759 8.63393 6.04167C8.25893 6.36574 8.07143 6.75926 8.07143 7.22222V8.33333Z"
                                        fill="black" />
                                </svg>
                                <span class="ml-2 text-xs md:text-sm">{{ __('gallery.private_gallery') }}</span>
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
                })" x-transition
                    x-cloak>
                    <h2 class="text-green-gs mb-6 flex items-center justify-center text-xs font-semibold sm:text-md md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">
                        {{ __('gallery.user_stories') }}</h2>
                    @if (count($usersWithStories) > 0)
                        <div class="flex space-x-6 overflow-x-auto px-2 pb-4">
                            @foreach ($usersWithStories as $user)
                                <div class="relative flex h-96 w-60 cursor-pointer flex-col items-center overflow-hidden rounded-xl"
                                    @click.stop="openStory({{ json_encode($user) }});">
                                    <div
                                        class="group-hover:border-green-gs relative h-full w-full overflow-hidden shadow-lg transition-all duration-300">
                                        <img src="{{ $user['stories'][0]['media_path'] }}" alt="{{ $user['name'] }}"
                                            class="h-full w-full object-cover" loading="lazy">
                                        @if (str_contains($user['stories'][0]['media_type'], 'video'))
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14.752 11.168l-3.197.661a.5.5 0 01-.784-.394L9 7.616V6.868a.5.5 0 01.5-.5h.697a.5.5 0 01.5.5v.737l.257.434a.5.5 0 01-.212.662l-3.498 2.799a.5.5 0 01-.784-.394z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <a href="{{ route('show_escort', $user['id']) }}"
                                            class="absolute bottom-0 left-0 right-0 flex items-center p-2">
                                            <div
                                                class="border-green-gs group-hover:border-green-gs relative h-10 w-10 rounded-full border-2 shadow-lg transition-all duration-300">
                                                <img src="{{ $user['avatar'] }}" alt="{{ $user['name'] }}"
                                                    class="h-full w-full rounded-full object-cover" loading="lazy">
                                                <span
                                                    class="absolute -right-2 bottom-0 flex h-4 w-4 items-center justify-center rounded-full bg-pink-500 text-xs text-white">
                                                    {{ count($user['stories']) }}
                                                </span>
                                            </div>
                                            <span class="ml-2 max-w-[8rem] truncate text-xs md:text-sm font-medium text-white">
                                                {{ ucfirst(strtolower($user['name'])) }}
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Story Viewer -->
                        <div x-show="openViewer && currentUser"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90"
                            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            @keydown.escape.window="closeViewer">

                            <div class="relative flex h-full max-h-[90vh] w-full items-center">
                                <!-- Close button -->
                                <button @click="closeViewer"
                                    class="bg-supaGirlRose hover:bg-green-gs absolute right-4 top-2 rounded-full p-2 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>



                                <!-- Navigation buttons -->
                                <button x-show="currentStoryIndex > 0" @click="previousStory"
                                    class="bg-green-gs hover:bg-supaGirlRose absolute left-4 top-1/2 -translate-y-1/2 rounded-full p-2 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>


                                <button x-show="currentStoryIndex < currentUser.stories.length - 1" @click="nextStory"
                                    class="bg-green-gs hover:bg-supaGirlRose absolute right-4 top-1/2 -translate-y-1/2 rounded-full p-2 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>

                                <!-- Progress bar -->
                                <div class="absolute left-4 right-4 top-2 z-10 mx-auto flex max-w-md space-x-1">
                                    <template x-for="(story, index) in currentUser.stories" :key="index">
                                        <div class="h-1 flex-1 rounded-full bg-gray-600">
                                            <div class="bg-green-gs h-full rounded-full transition-all duration-100"
                                                :class="{ 'w-full': index < currentStoryIndex, 'w-0': index >
                                                    currentStoryIndex }"
                                                :style="index === currentStoryIndex ? 'width: ' + progress + '%' : ''">
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Story content -->
                                <div class="mx-auto flex h-[80vh] w-full max-w-2xl items-center justify-center">
                                    <template x-if="currentUser.stories[currentStoryIndex].media_type === 'image'">
                                        <img :src="currentUser.stories[currentStoryIndex].media_path"
                                            class="max-h-full max-w-full object-contain" alt="Story">
                                    </template>

                                    <template x-if="currentUser.stories[currentStoryIndex].media_type === 'video'">
                                        <video :src="currentUser.stories[currentStoryIndex].media_path"
                                            class="max-h-full max-w-full" autoplay @ended="nextStory">
                                        </video>
                                    </template>
                                </div>

                               
                            </div>
                        </div>
                    @else
                        <div class="rounded-lg bg-gray-50 py-8 text-center">
                            <p class="text-gray-500">
                                {{ __('profile.no_stories_available') }}
                            </p>
                        </div>
                    @endif
                </section>

                <!-- Galerie Publique -->
                <section x-show="selectedTab === 'public'" x-transition>
                    <div
                        class="mb-4 flex flex-row items-center justify-between gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <h2 class="text-green-gs flex items-center text-sm font-semibold sm:text-md md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">
                            {{ __('gallery.public_gallery_title') }}</h2>

                        <div class="flex flex-col gap-2 text-sm sm:flex-row sm:items-center sm:gap-4">
                            <!-- Filtre par genre -->
                            <select x-model="genreTypeFilter"
                                class="border-supaGirlRose text-green-gs w-full rounded-md border p-2 md:w-64 text-xs sm:text-md ">
                                <option value="">{{ __('gallery.all') }}</option>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->name['fr'] ?? $genre->slug }}">
                                        {{ $genre->getTranslation('name', app()->getLocale()) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex w-full items-center justify-center">
                        <div class="grid grid-cols-2 items-center gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 ">
                            @foreach ($publicGallery as $media)
                                @php
                                    $userGenre = $media->user->genre->name['fr'] ?? null;
                                @endphp
                                <div x-show="shouldShowMedia('{{ $media->user_id }}', '{{ $media->type }}', '{{ $userGenre }}')"
                                    class="relative flex aspect-[2/3] cursor-pointer flex-col overflow-hidden rounded-xl shadow transition duration-300 hover:shadow-xl">
                                    @if ($media->type === 'image')
                                        <div class=" flex-1 overflow-hidden h-full">
                                            <img @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'image')"
                                                src="{{ asset('storage/' . $media->path) }}"
                                                class=" w-full h-full object-cover object-center"
                                                alt="media">
                                        </div>
                                    @elseif($media->type === 'video')
                                        <div class="relative h-full w-full flex-1">
                                            <video
                                                @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'video')"
                                                muted autoplay loop
                                                class="h-full w-full object-cover object-center brightness-75">
                                                <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                            </video>
                                            <div
                                                class="absolute inset-0 flex items-center justify-center text-4xl font-bold text-white">
                                                ▶
                                            </div>
                                        </div>
                                    @endif
                                    <div
                                        class="font-roboto-slab absolute bottom-0 left-0 right-0 flex items-center justify-between bg-gradient-to-t from-black/80 to-transparent px-3 py-2 font-bold text-white">
                                        <span class="truncate text-xs md:text-sm">
                                            {{ ucfirst(strtolower($media->user->prenom)) }}
                                        </span>

                                        <a href="{{ route('show_escort', $media->user->id) }}" class="ml-2 flex-shrink-0"
                                            title="{{ __('gallery.view_profile') }}">
                                            <img src="{{ asset('images/icons/galery_show_icon.svg') }}"
                                                alt="Show Profile" class="h-5 w-5">
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
                    <h2 class="text-green-gs mb-4 flex items-center justify-center text-xs font-semibold sm:text-md md:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl">
                        {{ __('gallery.private_gallery_title') }}</h2>
                    <div class="flex w-full items-center justify-center">
                    <div class="grid grid-cols-2 items-center gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                            @foreach ($privateGallery as $media)
                                @auth
                                    <div
                                        class="relative flex aspect-[2/3] cursor-pointer overflow-hidden rounded-xl shadow transition duration-300 hover:shadow-xl">
                                        @if ($media->type === 'image')
                                            <div class=" flex-1 overflow-hidden h-full">
                                                <img @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'image')"
                                                    src="{{ asset('storage/' . $media->path) }}"
                                                    class="w-full h-full object-cover object-center" alt="media">
                                            </div>
                                        @elseif($media->type === 'video')
                                            <div class="relative">
                                                <video
                                                    @click.stop="openMedia('{{ asset('storage/' . $media->path) }}', 'video')"
                                                    muted
                                                    class="pointer-events-none h-full w-full object-cover brightness-75">
                                                    <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                                </video>
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center text-4xl font-bold text-white">
                                                    ▶
                                                </div>
                                            </div>
                                        @endif
                                        <div
                                            class="font-roboto-slab absolute bottom-0  left-0 flex items-center justify-between px-3 font-bold text-white">
                                            <span class="my-2">{{ $media->user->prenom }}</span>
                                            <a href="{{ route('show_escort', $media->user->id) }}" class="my-2 ms-3"
                                                title="{{ __('gallery.view_profile') }}">
                                                <img src="{{ asset('images/icons/galery_show_icon.svg') }}"
                                                    alt="Show Profile" class="h-5 w-5">
                                            </a>
                                        </div>
                                    </div>
                                @endauth
                                @guest
                                    <div
                                        class="relative aspect-[2/3] overflow-hidden rounded-xl shadow transition hover:shadow-lg">
                                        @if ($media->type === 'image')
                                            <div class=" flex-1 overflow-hidden h-full">
                                                <img class="h-full w-full object-cover blur-md brightness-75 grayscale transition duration-300"
                                                    src="{{ asset('storage/' . $media->path) }}" alt="Privé">
                                            </div>
                                        @elseif ($media->type === 'video')
                                            <div class="blur-md brightness-75 grayscale">
                                                <video class="h-full w-full object-cover transition duration-300">
                                                    <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                                    Votre navigateur ne supporte pas la vidéo.
                                                </video>
                                            </div>
                                        @endif

                                        <button data-modal-target="authentication-modal"
                                            data-modal-toggle="authentication-modal" type="button"
                                            class="absolute inset-0 flex w-full h-full items-center justify-center bg-black/50 px-2 text-center text-xs md:text-sm font-semibold text-white">
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
                    allUsers: @json(
                        $usersWithMedia->map(function ($user) {
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

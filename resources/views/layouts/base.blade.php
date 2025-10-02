<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Supagirl - @yield('pageTitle')">
    <meta name="keywords" content="Supagirl, @yield('pageTitle')">
    <meta name="author" content="Supagirl">
    <link rel="shortcut icon" href="{{ url('logo-icon.webp') }}" type="image/x-icon">

    <title>Supagirl - @yield('pageTitle')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">

    {{-- js import --}}
    <!-- Alpine Plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js" defer></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs-focus/3.14.9/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs-intersect/3.14.9/cdn.min.js" defer></script>
    <!-- Alpine Core -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}

    <!-- flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js" defer></script>

    {{-- leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
    <!-- Inclure dans votre fichier HTML ou layout principal -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- @vite('resources/css/app.css', 'resources/js/app.js') --}}
    {{ Vite::useBuildDirectory('build')->withEntryPoints(['resources/js/app.js', 'resources/css/app.css']) }}

    @livewireStyles
    @livewireScripts

    <style>
        .lettre {
            animation: flash 1.2s linear infinite;
        }

        .lettre:nth-child(1) {
            animation-delay: 0.1s;
        }

        .lettre:nth-child(2) {
            animation-delay: 0.2s;
        }

        .lettre:nth-child(3) {
            animation-delay: 0.3s;
        }

        .lettre:nth-child(4) {
            animation-delay: 0.4s;
        }

        .lettre:nth-child(5) {
            animation-delay: 0.5s;
        }

        .lettre:nth-child(6) {
            animation-delay: 0.6s;
        }

        .fondu-out {
            opacity: 0;
            transition: opacity 0.4s ease-out;
        }

        @keyframes flash {
            0% {
                color: var(--color-supaGirlRose);
                text-shadow: 0 0 7px var(--color-supaGirlRosePastel);
            }

            50% {
                color: var(--color-complementaryColorViolet);
                text-shadow: 0 0 10px rgba(127, 85, 177, 0.7);
            }

            100% {
                color: var(--color-supaGirlRose);
                text-shadow: 0 0 7px var(--color-supaGirlRosePastel);
            }
        }
    </style>
    @yield('extraStyle')

</head>

<body 
    class="font-roboto-slab relative min-h-[100vh] w-full overflow-x-hidden text-sm font-normal antialiased transition-all md:text-base">
    @if (session('success'))
        <div id="sessionAlert"
            class="absolute top-3 mb-4 flex items-center rounded-lg bg-green-50 p-4 text-green-800 ring-2 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            <svg class="h-4 w-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                {{ session('success') }}
            </div>
            <button type="button"
                class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-green-50 p-1.5 text-green-500 hover:bg-green-200 focus:ring-2 focus:ring-green-400 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                data-dismiss-target="#sessionAlert" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif
    
    @if(app()->environment('local'))
    <!-- Indicateur de taille d'écran (sans JavaScript) -->
    <div class="fixed bottom-4 right-4 z-50 flex flex-col gap-2">
        <!-- Inferieur sm (mobile) -->
        <div class="block sm:hidden bg-blue-500 text-white p-2 rounded-lg text-xs font-bold">
            Inferieur sm (< 640px)
        </div>

        <!-- sm -->
        <div class="hidden sm:block md:hidden bg-red-500 text-white p-2 rounded-lg text-xs font-bold">
            sm (640px - 767px)
        </div>

        <!-- md -->
        <div class="hidden md:block lg:hidden bg-yellow-500 text-black p-2 rounded-lg text-xs font-bold">
            md (768px - 1023px)
        </div>

        <!-- lg -->
        <div class="hidden lg:block xl:hidden bg-green-500 text-white p-2 rounded-lg text-xs font-bold">
            lg (1024px - 1279px)
        </div>

        <!-- xl -->
        <div class="hidden xl:block 2xl:hidden bg-purple-500 text-white p-2 rounded-lg text-xs font-bold">
            xl (1280px - 1535px)
        </div>

        <!-- 2xl ou plus -->
        <div class="hidden 2xl:block bg-pink-500 text-white p-2 rounded-lg text-xs font-bold">
            2xl ou plus (≥ 1536px)
        </div>
    </div>
    @endif


    {{-- Loader section --}}
    <div id="loader" class="absolute left-0 top-0 z-50 h-full w-full bg-white">
        <div
            class="fixed left-[50%] top-[50%] flex h-screen w-full -translate-x-[50%] -translate-y-[50%] items-center justify-center gap-4 text-xl sm:text-2xl md:text-5xl xl:text-6xl">
            <span class=" font-roboto-slab text-green-gs lettre">S</span>
            <span class="font-roboto-slab lettre text-[#484848]">U</span>
            <span class="font-roboto-slab lettre text-[#484848]">P</span>
            <span class="font-roboto-slab lettre text-[#484848]">A</span>
            <span class="font-roboto-slab lettre text-[#484848]">G</span>
            <span class="font-roboto-slab lettre text-[#484848]">I</span>
            <span class="font-roboto-slab lettre text-[#484848]">R</span>
            <span class="font-roboto-slab lettre text-[#484848]">L</span>
        </div>
    </div>

    <!-- Vérification d'âge -->
    <div id="age-verification"
        class="bg-textColor fixed inset-0 z-[9999] flex hidden items-center justify-center bg-opacity-90">
        <div class="mx-4 w-full max-w-md rounded-lg bg-white p-8 text-center">
            <h2 class="font-roboto-slab text-textColor mb-6 text-sm md:text-xl font-bold">Avez-vous plus de 18 ans ?</h2>
            <div class="grid grid-cols-2  gap-2 justify-center ">
                <button id="confirm-age"
                    class="text-xs sm:text-sm font-roboto-slab bg-supaGirlRose hover:bg-supaGirlRose/80 text-complementaryColorViolet rounded px-6 py-2 font-bold hover:text-white">
                    Oui
                </button>
                <button id="deny-age"
                    class="text-xs sm:text-sm font-roboto-slab border-green-gs hover:bg-green-gs text-complementaryColorViolet rounded border bg-white px-6 py-2 font-bold hover:text-white">
                    Non
                </button>
            </div>
        </div>
    </div>


    <div x-data="{ imgModal: false, imgModalSrc: '', imgModalDesc: '' }">
        <template
            @img-modal.window="imgModal = true; imgModalSrc = $event.detail.imgModalSrc; imgModalDesc = $event.detail.imgModalDesc;"
            x-if="imgModal">
            <div x-on:click.stop="imgModal = false" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90"
                class="fixed inset-0 z-50 flex h-full w-full items-center justify-center overflow-hidden bg-black/90 p-2">
                <div @click.stop class="flex max-h-[90vh] w-full max-w-[90vw] flex-col overflow-auto">
                    <div class="z-50">
                        <button @click="imgModal = false"
                            class="bg-supaGirlRose hover:bg-green-gs absolute right-4 top-4 rounded-full p-2 text-white">
                            <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18"
                                height="18" viewBox="0 0 18 18">
                                <path
                                    d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                                </path>
                            </svg>
                        </button>

                    </div>
                    <div class="flex w-full items-center justify-center p-2">
                        <img class="max-h-[80vh] w-full max-w-[75vw] object-contain object-center"
                            :src="imgModalSrc">
                        <p x-text="imgModalDesc" class="text-center text-white"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- MODAL LIGHTBOX MEDIA -->
    <div x-data="{
        open: false,
        src: '',
        type: '',
        currentIndex: 0,
        mediaList: [],
        init() {
            // Créer une référence liée pour le contexte this
            this.handleKeyDown = this.handleKeyDown.bind(this);
        },
        show(src, type, mediaList = [], index = 0) {
            this.mediaList = mediaList;
            this.currentIndex = index;
            this.src = src;
            this.type = type;
            this.open = true;
    
            // Désactiver le défilement de la page
            document.body.style.overflow = 'hidden';
    
            // Ajouter l'écouteur d'événement avec la référence liée
            window.addEventListener('keydown', this.handleKeyDown);
        },
        close() {
            this.open = false;
            this.src = '';
            this.type = '';
            this.mediaList = [];
            this.currentIndex = 0;
    
            // Réactiver le défilement de la page
            document.body.style.overflow = 'auto';
    
            // Supprimer l'écouteur d'événement
            window.removeEventListener('keydown', this.handleKeyDown);
        },
        nextMedia() {
            if (this.mediaList.length > 0 && this.currentIndex < this.mediaList.length - 1) {
                this.currentIndex++;
                this.updateMedia();
            } else if (this.mediaList.length > 0) {
                // Revenir au premier média si on est à la fin
                this.currentIndex = 0;
                this.updateMedia();
            }
        },
        prevMedia() {
            if (this.mediaList.length > 0 && this.currentIndex > 0) {
                this.currentIndex--;
                this.updateMedia();
            } else if (this.mediaList.length > 0) {
                // Aller au dernier média si on est au début
                this.currentIndex = this.mediaList.length - 1;
                this.updateMedia();
            }
        },
        updateMedia() {
            const media = this.mediaList[this.currentIndex];
            if (media) {
                this.src = media.src;
                this.type = media.type;
    
                // Mettre en pause la vidéo précédente si nécessaire
                const prevVideo = document.querySelector('video');
                if (prevVideo) {
                    prevVideo.pause();
                }
            }
        },
        handleKeyDown(e) {
            // Ignorer si on est dans un champ de formulaire
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.isContentEditable) {
                return;
            }
    
            switch (e.key) {
                case 'ArrowRight':
                case 'd':
                case 'D':
                    e.preventDefault();
                    this.nextMedia();
                    break;
                case 'ArrowLeft':
                case 'q':
                case 'Q':
                    e.preventDefault();
                    this.prevMedia();
                    break;
                case 'Escape':
                    e.preventDefault();
                    this.close();
                    break;
                case ' ':
                case 'Spacebar':
                    // Mettre en pause/lecture la vidéo si c'est une vidéo
                    const video = document.querySelector('video');
                    if (video) {
                        e.preventDefault();
                        if (video.paused) {
                            video.play();
                        } else {
                            video.pause();
                        }
                    }
                    break;
            }
        }
    }" x-ref="lightbox"
        x-on:media-open.window="show($event.detail.src, $event.detail.type, $event.detail.mediaList, $event.detail.index)"
        x-show="open" x-transition.opacity x-cloak @keydown.escape.window="close()" @click.self="close()"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4">
        <button @click="close"
            class="bg-supaGirlRose hover:bg-green-gs absolute right-4 top-4 rounded-full p-2 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="relative w-full">
            <div class="relative w-auto max-w-full overflow-hidden rounded-xl bg-transparent shadow-xl">
                <!-- Contenu média -->
                <div class="relative flex w-full items-center justify-center">
                    <template x-if="type === 'image'">
                        <img :src="src" alt="media"
                            class="max-h-[90vh] w-auto max-w-full object-cover">
                    </template>
                    <template x-if="type === 'video'">
                        <video controls autoplay class="max-h-[90vh] w-auto max-w-full bg-black">
                            <source :src="src" type="video/mp4">
                        </video>
                    </template>
                </div>

                <!-- Bouton précédent -->
                <button x-show="mediaList.length > 1 && currentIndex > 0" @click.stop="prevMedia()"
                    class="bg-green-gs hover:bg-supaGirlRose absolute left-4 top-1/2 -translate-y-1/2 rounded-full p-2 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <!-- Bouton suivant -->
                <button x-show="mediaList.length > 1 && currentIndex < mediaList.length - 1" @click.stop="nextMedia()"
                    class="bg-green-gs hover:bg-supaGirlRose absolute right-4 top-1/2 -translate-y-1/2 rounded-full p-2 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Bouton de fermeture -->



            </div>
        </div>
    </div>


    {{-- header --}}
    @livewire('header')

    {{-- Content --}}
    @yield('content')

    <!-- Modal toggle -->
    {{-- <button  class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
      Toggle modal
    </button> --}}

    <!-- Connexion modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-[95%] p-4 sm:w-[70%] md:w-[60%] lg:w-[50%] xl:w-[40%] 2xl:w-[30%]">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow-sm dark:bg-gray-700">

                <!-- Modal header -->
                <div
                    class="flex items-center justify-between rounded-t border-b border-gray-200 p-1 md:p4 md:p-5 dark:border-gray-600">
                    <h3 class="flex w-full items-center justify-center">
                        <img class="" src="{{ asset('images/logoSupa.png') }}" alt="Logo SupaGirl" />
                    </h3>
                    <button type="button"
                        class="text-green-gs end-2.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm hover:bg-gray-200  "
                        data-modal-hide="authentication-modal">
                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body formulaire -->
                @guest
                    <div x-data="loginForm" class="relative p-4 md:p-5">

                        {{-- Message du formulaire --}}
                        <div x-show="message"
                            class="mb-4 flex items-center rounded-lg border p-4 text-sm dark:bg-gray-800"
                            :class="status ?
                                'text-green-800 border-green-300 bg-green-50 dark:text-green-400 dark:border-green-800' :
                                'text-red-800 bg-red-50 border-red-300 dark:border-red-800 dark:text-red-400'"
                            role="alert">
                            <svg class="me-3 inline h-4 w-4 shrink-0" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Info</span>
                            <div x-text="message">
                            </div>
                        </div>




                        {{-- Content formulaire --}}
                        <form x-show="showloginForm" x-on:submit.prevent="submitForm()" id="loginForm" class="space-y-4"
                            action="{{ route('login') }}" method="POST">
                            @csrf
                            <div>
                                <label for="email"
                                    class="text-green-gs font-roboto-slab mb-2 block text-xs md:text-sm font-medium">{{ __('login_form.email') }}
                                    *</label>
                                <input x-model="email" type="email" name="email" id="email"
                                    class="@error('email') border-red-300 @enderror block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-xs md:text-sm text-gray-900 focus:border-amber-300 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    placeholder="name@company.com" required autocomplete="email" autofocus />
                            </div>
                            <div class="relative" x-data="{ 'pwdShow': true }">
                                <label for="conex_pass"
                                    class="text-green-gs font-roboto-slab mb-2 block text-xs md:text-sm font-medium">{{ __('login_form.password') }}
                                    *</label>
                                <input x-model="password" :type="pwdShow ? 'password' : 'text'" name="pass"
                                    id="conex_pass" placeholder="••••••••"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-xs md:text-sm text-gray-900 focus:border-amber-300 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    required />
                                <div class="absolute bottom-3 right-0 flex items-center pr-3 text-sm leading-5">
                                    <svg class="h-4 text-gray-700" fill="none" @click="pwdShow = !pwdShow"
                                        :class="{ 'hidden': !pwdShow, 'block': pwdShow }"
                                        xmlns="http://www.w3.org/2000/svg" viewbox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                        </path>
                                    </svg>
                                    <svg class="h-4 text-gray-700" fill="none" @click="pwdShow = !pwdShow"
                                        :class="{ 'block': !pwdShow, 'hidden': pwdShow }"
                                        xmlns="http://www.w3.org/2000/svg" viewbox="0 0 640 512">
                                        <path fill="currentColor"
                                            d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <div class="flex items-start">
                                    <div class="flex h-5 items-center">
                                        <input x-model="remember" id="remember" type="checkbox" name="remember"
                                            class="focus:ring-3 h-4 w-4 rounded-sm border border-gray-300 bg-gray-50 focus:ring-amber-300 dark:border-gray-500 dark:bg-gray-600 dark:ring-offset-gray-800 dark:focus:ring-amber-300 dark:focus:ring-offset-gray-800"
                                            {{ old('remember') ? 'checked' : '' }} />
                                    </div>
                                    <label for="remember"
                                        class="ms-2 text-xs md:text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('login_form.remember_me') }}</label>
                                </div>
                                <a href="#" x-on:click="showloginForm = false"
                                    class="text-green-gs dark:text-green-gs font-roboto-slab hover:text-green-gs/80 text-xs md:text-sm hover:underline">{{ __('login_form.forgot_password') }}</a>
                            </div>
                            <button type="submit"
    class="bg-green-gs focus:ring-green-gs/50 group relative flex w-full transform cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg px-5 py-2.5 text-center text-xs md:text-sm font-medium text-white transition-all duration-300 hover:scale-[1.02] hover:bg-green-gs/30 hover:text-green-gs hover:shadow-lg focus:outline-none focus:ring-4">
    
    <span class="relative z-10 flex items-center gap-2 whitespace-nowrap">
        <svg x-show="loadingRequest" aria-hidden="true"
            class="inline h-4 w-4 animate-spin fill-green-500 text-gray-200 dark:text-gray-600"
            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                fill="currentColor" />
            <path
                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                fill="currentFill" />
        </svg>

        <span class="relative">
            {{ __('login_form.login') }}
            <span class="absolute -bottom-0.5 left-0 h-0.5 w-0 bg-white transition-all duration-300 group-hover:w-full"></span>
        </span>
    </span>

    <span class="pointer-events-none absolute inset-0 flex items-center justify-center">
        <span class="absolute h-0 w-0 rounded-full bg-white opacity-0 transition-all duration-1000 group-hover:h-32 group-hover:w-full group-hover:opacity-10"></span>
    </span>

    <span class="absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
        <span class="absolute inset-0 rounded-lg border-2 border-white/80 transition-all duration-300"></span>
    </span>
</button>

                            <div class="flex w-full justify-center text-center">
                                <h1 class="text-xs md:text-sm text-gray-500">
                                    Vous n'avez pas de compte ?
                                    <a href="{{ route('nextStep') }}"
                                        class="text-supaGirlRose text-xs md:text-sm font-roboto-slab">S'inscrire</a>
                                </h1>
                            </div>

                            <!-- <div class="flex items-center justify-center">
                                    <div class="bg-green-gs h-1 flex-1"></div>
                                    <span class="font-roboto-slab text-green-gs p-2 text-xl">{{ __('login_form.or') }}</span>
                                    <div class="bg-green-gs h-1 flex-1"></div>
                                </div>
                                <div
                                    class="flex w-full flex-col items-center justify-center gap-2 py-5 text-sm transition-all lg:text-base">
                                    <a href="{{ route('registerForm') }}"
                                        class="hover:text-green-gs border-green-gs font-roboto-slab hover:bg-supaGirlRosePastel hover:text-green-gs w-full border p-3 text-center">{{ __('login_form.register_free') }}</a>
                                    <a href="{{ route('escort_register') }}"
                                        class="hover:text-green-gs border-green-gs font-roboto-slab hover:bg-supaGirlRosePastel hover:text-green-gs w-full border p-3 text-center">{{ __('login_form.register_escort') }}</a>
                                    <a href="{{ route('salon_register') }}"
                                        class="hover:text-green-gs border-green-gs font-roboto-slab hover:bg-supaGirlRosePastel hover:text-green-gs w-full border p-3 text-center">{{ __('login_form.register_professional') }}</a>
                                </div> -->
                        </form>


                        {{-- Formulaire de reset pwd --}}
                        <form x-show="!showloginForm" x-on:submit.prevent="submitForm(true)" id="resetPwdForm"
                            class="space-y-4" action="{{ route('reset_password') }}" method="POST">
                            @csrf
                            <div>
                                <label for="emailReset"
                                    class="text-green-gs font-roboto-slab mb-2 block text-xs md:text-sm font-medium">{{ __('login_form.email') }}
                                    *</label>
                                <input x-model="emailReset" type="email" name="emailReset" id="emailReset"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-xs md:text-sm text-gray-900 focus:border-amber-300 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400"
                                    placeholder=" " required autofocus />
                            </div>
                            <a href="#" x-on:click="showloginForm = true"
                                class="font-roboto-slab text-green-gs hover:text-supaGirlRosePastel text-xs md:text-sm hover:underline">{{ __('login_form.back_to_login') }}</a>
                            <button type="submit"
                                class="bg-green-gs font-roboto-slab hover:text-green-gs hover:bg-green-gs/30 w-full rounded-lg px-5 py-2.5 text-center text-xs md:text-sm font-medium text-white hover:bg-amber-300 focus:outline-none">
                                <svg x-show="loadingRequest" aria-hidden="true"
                                    class="inline h-4 w-4 animate-spin fill-green-500 text-gray-200 dark:text-gray-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                {{ __('login_form.reset_password') }}
                            </button>
                        </form>


                    </div>
                @endguest

                {{-- Modal body deja connecter --}}
                @auth
                    <div class="relative p-4 text-center md:p-5">
                        Vous êtes déjà connecté en tant que
                        {{ Auth::user()->user_name ?? (Auth::user()->name ?? Auth::user()->nom_salon) }}.
                    </div>
                @endauth
            </div>
        </div>
    </div>






    {{-- Footer --}}
    <x-footer />

    {{-- <div class="relative w-full min-h-[375px] bg-green-gs transition-all mt-10 z-30">
      <div class="flex flex-col items-center lg:flex-row justify-center lg:items-start gap-10 lg:gap-40 container mx-auto py-24 text-white text-sm xl:text-base">
        <div class="flex flex-col items-center justify-center w-full lg:w-auto lg:items-start gap-3">
          <a href="{{ route('home') }}" class="w-full">
            <img class="mx-auto lg:m-0 w-60" src="{{ url('images/Logo_lg.png') }}" alt="Logo gstuff" />
          </a>
          <p class="w-96 lg:text-start text-center">Votre portail suisse des rencontres érotique sécurisées et inclusives.</p>
        </div>

        <div class="flex flex-col items-center lg:items-start gap-2">
          <h3 class="font-dm-serif text-4xl font-bold mb-3">Liens rapides</h3>
          @foreach ($cantons->slice(0, 5) as $canton)
          <a href="{{route('escortes').'?selectedCanton='.$canton->id}}">Escort girl {{ $canton->nom }}</a>
          @endforeach
        </div>

        <div class="flex flex-col items-center lg:items-start gap-2">
          <h3 class="font-dm-serif text-4xl font-bold mb-3">Liens rapides</h3>
          <a href="{{ route('glossaires.index') }}">Glossaire</a>
          <a href="{{ route('faq') }}">FAQ</a>
          <a href="{{ route('about')}}">Qui sommes-nous ?</a>
          <a href="{{ route('cgv') }}">Conditions générales de vente (GGV)</a>
          <a href="{{ route('contact') }}">Contact</a>
        </div>

      </div>
    </div>
    <div class="relative flex items-center justify-center bg-black text-white text-xs lg:text-base py-7 transition-all z-30">
      Copyright 2025 - <a href="{{ route('home') }}" class="text-yellow-500 mx-2"> Gstuff </a> - <a href="{{ route('pdc') }}" class="text-yellow-500 mx-2"> Politique de confidentialité </a>
    </div> --}}

    @auth
        <div x-data="{
            async loadChat(userId) {
                $dispatch('loadForSender', [userId]);
                await axios.post('/messenger/make-seen', { id: userId });
            }
        }" id="chatshow" class="hidden">
            @livewire('chat')
        </div>
    @endauth
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-3"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Vérifie si l'utilisateur a déjà confirmé son âge
            const hasConfirmedAge = localStorage.getItem('ageConfirmed');
            const ageVerification = document.getElementById('age-verification');

            if (!hasConfirmedAge) {
                // Affiche la modale après le chargement complet de la page
                window.addEventListener('load', function() {
                    document.getElementById('loader').classList.add('hidden');
                    ageVerification.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
            } else {
                // Cache le loader si l'âge est déjà confirmé
                window.addEventListener('load', function() {
                    document.getElementById('loader').classList.add('hidden');
                });
            }

            // Gestion des boutons
            document.getElementById('confirm-age').addEventListener('click', function() {
                localStorage.setItem('ageConfirmed', 'true');
                ageVerification.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });

            document.getElementById('deny-age').addEventListener('click', function() {
                window.location.href = 'https://www.youtube.com/watch?v=t0Q2otsqC4I';
            });
        });

        const mega_menu_link = document.getElementById('mega-menu-full-dropdown-button');
        const mega_menu_item = document.getElementById('mega-menu-full-dropdown');
        const loader = document.getElementById('loader');
        const chatshow = document.getElementById('chatshow');


        // function scrollByPercentage(element, ltr = true, percentageX = 0, percentageY = 0) {
        //     // Si aucun élément n'est fourni, on utilise la fenêtre
        //     const target = element || document.documentElement;

        //     // Nombre d'element dans le container
        //     let containerChild = parseInt(element.children.length);
        //     itemPercent = Math.ceil(100 / containerChild);

        //     if (percentageX == 0) {
        //         percentageX = itemPercent + 1;
        //     }

        //     // Calcul des distances de défilement
        //     const scrollX = ltr ? (target.scrollWidth - target.clientWidth) * (percentageX / 100) : -(target.scrollWidth -
        //         target.clientWidth) * (percentageX / 100);
        //     // const scrollY = (target.scrollHeight - target.clientHeight) * (percentageY / 100);

        //     // Défilement vers la position calculée
        //     target.scrollBy({
        //         left: scrollX,
        //         top: scrollY,
        //         behavior: 'smooth' // Optionnel : pour un défilement fluide
        //     });
        // }

        function scrollByPercentage(element, ltr = true, percentageX = 0) {
            const target = element || document.documentElement;

            const maxScrollLeft = 3409 - target.clientWidth;
            const currentScrollLeft = target.scrollLeft;


            const scrollAmount = maxScrollLeft * (percentageX / 100);

            // Empêche le scroll si on est déjà au bout
            if (ltr && currentScrollLeft + scrollAmount >= maxScrollLeft) {
                target.scrollTo({
                    left: maxScrollLeft,
                    behavior: 'smooth'
                });
                return;
            }

            if (!ltr && currentScrollLeft - scrollAmount <= 0) {
                target.scrollTo({
                    left: 0,
                    behavior: 'smooth'
                });
                return;
            }

            target.scrollBy({
                left: ltr ? scrollAmount : -scrollAmount,
                behavior: 'smooth'
            });
        }



        function loginForm() {

            return {
                email: '',
                emailReset: '',
                password: '',
                remember: false,
                message: '',
                showloginForm: true,
                loadingRequest: false,
                status: true,
                init() {},
                async submitForm(reset = false) {
                    this.loadingRequest = true;
                    this.message = "";
                    if (reset) {
                        Resetform = document.getElementById('resetPwdForm');

                        try {
                            const response = await fetch(Resetform.action, {
                                method: Resetform.method,
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify({
                                    email: this.emailReset,
                                })
                            });

                            if (response.ok) {
                                const data = await response.json();
                                this.loadingRequest = false;
                                this.message = data.message;
                                this.status = data.success;
                                // Redirige l'utilisateur ou effectue une autre action
                                // window.location.href = '{{ route('profile.index') }}';
                            } else {
                                const error = await response.json();
                                this.loadingRequest = false;
                                this.message = error.message;
                                this.status = error.success;
                            }
                        } catch (error) {
                            this.message = 'Une erreur est survenue. Veuillez réessayer.';
                            this.loadingRequest = false;
                            this.status = false;
                        }
                    } else {
                        form = document.getElementById('loginForm');
                        try {
                            const response = await fetch(form.action, {
                                method: form.method,
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify({
                                    email: this.email,
                                    password: this.password,
                                    remember: this.remember
                                })
                            });

                            if (response.ok) {
                                const data = await response.json();
                                this.loadingRequest = false;
                                this.message = data.message;
                                this.status = data.success;
                                // Redirige l'utilisateur ou effectue une autre action
                                window.location.href = '{{ route('profile.index') }}';
                            } else {
                                const error = await response.json();
                                this.loadingRequest = false;
                                this.message = error.message;
                                this.status = error.success;
                            }
                        } catch (error) {
                            this.message = 'Une erreur est survenue. Veuillez réessayer.';
                            this.loadingRequest = false;
                            this.status = false;
                        }
                    }
                }

                //   async resetPwdForm(){
                //     this.loadingRequest = true;

                // };
            }
        }

        // Script for multi-object-Select
        function multiObjectSelect(options, value) {

            return {
                options: options,
                selectedOptions: value != "" ? value : [],
                search: '',
                filteredOptions: [],
                isOpen: false,

                init() {
                    this.filteredOptions = this.options;
                },

                filterOptions() {
                    this.filteredOptions = this.options.filter(option =>
                        option.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                selectOption(option) {
                    if (!this.selectedOptions.includes(option)) {
                        this.selectedOptions.push(option);
                    }
                    this.search = '';
                    //this.filterOptions();
                    this.isOpen = false;
                },

                removeOption(index) {
                    this.selectedOptions.splice(index, 1);
                },

                closeDropdown() {
                    setTimeout(() => {
                        this.isOpen = false;
                    }, 200);
                },
                selectedValues() {
                    let val = [];
                    this.selectedOptions.map((option) => {
                        val.push(option['id']);
                    })
                    return val;
                }
            };
        }

        // Script for multi-select
        function multiSelect(options, value) {

            return {
                options: options,
                selectedOptions: value != "" ? value : [],
                search: '',
                filteredOptions: [],
                isOpen: false,

                init() {
                    this.filteredOptions = this.options;
                },

                filterOptions() {
                    this.filteredOptions = this.options.filter(option =>
                        option.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                selectOption(option) {
                    if (!this.selectedOptions.includes(option)) {
                        this.selectedOptions.push(option);
                    }
                    this.search = '';
                    this.filterOptions();
                    this.isOpen = false;
                },

                removeOption(index) {
                    this.selectedOptions.splice(index, 1);
                },

                closeDropdown() {
                    setTimeout(() => {
                        this.isOpen = false;
                    }, 200);
                },
                selectedValues() {
                    let val = [];
                    this.selectedOptions.map((option) => {
                        val.push(option);
                    })
                    return val;
                }
            };
        }

        // Pour le gallerie
        function gallery() {
            return {
                viewMode: Alpine.$persist('grid'),
                fullscreen: false,
                currentMedia: null,
                showDeleteModal: false,
                mediaToDelete: null,
                deleteModalTitle: '',
                currentMediaIndex: 0,

                get mediaCount() {
                    return this.$wire.gallerieItem.length;
                },

                navigateMedia(direction) {
                    let newIndex = this.currentMediaIndex + direction;

                    if (newIndex < 0) {
                        newIndex = this.mediaCount - 1; // Retour à la dernière image
                    } else if (newIndex >= this.mediaCount) {
                        newIndex = 0; // Retour à la première image
                    }

                    this.currentMediaIndex = newIndex;
                    this.updateCurrentMedia();
                },
                updateCurrentMedia() {
                    let media = this.$wire.gallerieItem[this.currentMediaIndex];
                    this.currentMedia = {
                        type: media.type,
                        url: media.url,
                        title: media.title,
                        description: media.description
                    };
                },

                async deleteFunc() {

                    try {
                        const response = await fetch(`/profile/media/${this.mediaToDelete}`, {
                            method: 'DELETE',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: {}
                        });

                        if (response.redirected) {
                            window.location.reload();
                        } else if (response.ok) {
                            window.location.reload();
                        }
                    } catch (error) {
                        alert('Une erreur est survenue lors de la suppression du média.');
                    }


                },


                // Modifier les clics initiaux pour mettre à jour l'index
                initGallery() {
                    this.$watch('fullscreen', (value) => {
                        if (value) {
                            // Trouver l'index du média actuel
                            this.currentMediaIndex = this.$wire.gallerieItem.findIndex(
                                m => m.url === this.currentMedia.url
                            );
                        }
                    });
                }
            }
        }

        window.addEventListener('load', () => {
            loader.classList.add('fondu-out');
            setTimeout(() => {
                loader.classList.add('hidden');
                chatshow.classList.remove('hidden');
            }, 500);
        })

        // Gestion des toasts
        window.addEventListener('show-toast', (event) => {
            const {
                type,
                message
            } = event.detail;
            showToast(type, message);
        });

        function showToast(type, message) {

            if (!message || message.trim() === '') {
                return;
            }
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };

            const toast = document.createElement('div');
            toast.className =
                `${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg flex items-center justify-between max-w-xs animate-fade-in-up`;
            toast.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-4">
                    &times;
                </button>
            `;

            const container = document.getElementById('toast-container');
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('animate-fade-out');
                setTimeout(() => toast.remove(), 50000);
            }, 5000);
        }

        window.addEventListener('fetch', (event) => {
            if (event.request.method === 'GET' && event.request.url.endsWith('/livewire/update')) {
                event.respondWith(new Response(null, {
                    status: 204
                })); // Répond avec un statut 204 No Content pour bloquer la requête
                event.preventDefault(); // Empêche la propagation de l'événement

            }
        });

        // Pour les formulaires qui pourraient utiliser GET
        document.addEventListener('submit', (event) => {
            if (event.target.method === 'get' && event.target.action.endsWith('/livewire/update')) {
                event.preventDefault(); // Empêche la soumission du formulaire

            }
        });

        // Pour les changements de localisation (liens <a>)
        document.addEventListener('click', (event) => {
            if (event.target.tagName === 'A' && event.target.href.endsWith('/livewire/update')) {
                event.preventDefault(); // Empêche la navigation

            }
        });
    </script>
    @yield('extraScripts')
    @yield('specialScripts')
    @stack('scripts')

</body>

</html>

@extends('layouts.base')

@section('pageTitle', 'Galerie')

@section('content')
    <section
        class="relative mb-10 overflow-hidden rounded-xl bg-gradient-to-br from-pink-500 via-purple-600 to-indigo-600 text-white shadow-xl">
        <div class="mx-auto max-w-7xl px-6 py-20 text-center sm:py-24 lg:px-8">
            <h1 class="mb-4 text-4xl font-extrabold sm:text-5xl">Explorez. Partagez. Ressentez 📸</h1>
            <p class="mx-auto max-w-2xl text-lg font-light sm:text-xl">
                Vos moments les plus précieux prennent vie ici – entre <strong>stories instantanées</strong> et
                <strong>galeries captivantes</strong>. Plongez dans l’univers des émotions partagées.
            </p>
        </div>

        <!-- Illustration décorative (optionnelle) -->
        <div class="pointer-events-none absolute bottom-0 right-0 opacity-20">
            <svg viewBox="0 0 200 200" class="h-64 w-64 translate-x-12 translate-y-12 transform">
                <path fill="white"
                    d="M40.6,-71.1C51.1,-66.2,58.8,-51.5,64.3,-37.1C69.7,-22.6,73,-8.3,73.5,6.2C73.9,20.7,71.4,35.3,63.8,47.8C56.2,60.3,43.5,70.7,29.3,73.6C15.2,76.5,-0.5,71.8,-16.4,66.6C-32.3,61.3,-48.5,55.4,-59.6,44.1C-70.7,32.8,-76.8,16.4,-76.3,0.3C-75.8,-15.9,-68.6,-31.8,-58.3,-44.3C-48.1,-56.8,-34.8,-65.9,-20.2,-69.8C-5.6,-73.7,10.2,-72.3,24.6,-71.2C39,-70.1,52.1,-69.9,40.6,-71.1Z"
                    transform="translate(100 100)" />
            </svg>
        </div>
    </section>

    <div class="mx-auto min-h-[50vh] max-w-7xl px-4 py-10 sm:px-6 lg:px-8" x-data="{
        loggedIn: @json(auth()->check()),
        selectedTab: 'stories',
        selectedUser: '',
        selectedType: '',
        openMenu: false
    }">
        <div class="flex flex-col gap-8 md:flex-row">

            <!-- MENU LATERAL -->
            <aside class="space-y-2 md:w-1/5">

                <!-- MOBILE TOGGLE -->
                <div class="mb-4 md:hidden">
                    <button @click="openMenu = !openMenu"
                        class="flex w-full items-center justify-between rounded-lg bg-gray-100 px-4 py-2 text-gray-800">
                        <span>📁 Sections</span>
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
                        🌍 Publique
                        <span class="rounded-full bg-white/30 px-2 py-1 text-xs"
                            x-text="{{ count($publicGallery) }}"></span>
                    </button>

                    <!-- Tab Galerie privée -->
                    <button @click="selectedTab = 'private'; openMenu = false"
                        :class="selectedTab === 'private' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700'"
                        class="flex w-full items-center justify-between rounded-lg px-4 py-2 text-left font-medium transition hover:bg-gray-200">
                        🔐 Privée
                        <span class="rounded-full bg-white/30 px-2 py-1 text-xs"
                            x-text="{{ count($privateGallery) }}"></span>
                    </button>
                </div>
            </aside>

            <!-- CONTENU PRINCIPAL -->
            <div class="flex-1 space-y-10">

                <!-- Stories -->
                <section x-show="selectedTab === 'stories'" x-transition>
                    <h2 class="mb-6 text-3xl font-semibold text-gray-800">📸 Stories des utilisateurs</h2>
                    <div class="flex space-x-4 overflow-x-auto pb-2">
                        @foreach ($usersWithStories as $user)
                            <div class="flex-shrink-0 text-center">
                                <div
                                    class="mx-auto h-20 w-20 overflow-hidden rounded-full border-4 border-pink-500 shadow-md">
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                        class="h-full w-full object-cover">
                                </div>
                                <span class="mt-2 block truncate text-sm text-gray-700">{{ $user->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Galerie Publique -->
                <section x-show="selectedTab === 'public'" x-transition>
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-3xl font-semibold text-gray-800">🌍 Galerie Publique</h2>
                        <div class="flex items-center gap-4 text-sm">
                            <select x-model="selectedUser" class="rounded-md border border-gray-300 p-1">
                                <option value="">Tous les utilisateurs</option>
                                @foreach ($usersWithMedia as $user)
                                    <option value="{{ $user->id }}">{{ $user->prenom }}</option>
                                @endforeach
                            </select>
                            <select x-model="selectedType" class="rounded-md border border-gray-300 p-1">
                                <option value="">Tous types</option>
                                <option value="image">Images</option>
                                <option value="video">Vidéos</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                        @foreach ($publicGallery as $media)
                            <template
                                x-if="(!selectedUser || selectedUser == '{{ $media->user_id }}') && (!selectedType || selectedType == '{{ $media->type }}')">
                                <div @click="$dispatch('media-open', { src: '{{ asset('storage/' . $media->path) }}', type: '{{ $media->type }}' })"
                                    class="cursor-pointer overflow-hidden rounded-xl shadow transition duration-300 hover:shadow-xl">
                                    @if ($media->type === 'image')
                                        <img src="{{ asset('storage/' . $media->path) }}" class="h-48 w-full object-cover"
                                            alt="media">
                                    @elseif($media->type === 'video')
                                        <div class="relative">
                                            <video muted autoplay loop
                                                class="pointer-events-none h-48 w-full object-cover brightness-75">
                                                <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                            </video>
                                            <div
                                                class="absolute inset-0 flex items-center justify-center text-4xl font-bold text-white">
                                                ▶</div>
                                        </div>
                                    @endif
                                    <span class="my-2 ms-3"> {{ $media->user->prenom }} </span>
                                </div>
                            </template>
                        @endforeach
                    </div>
                </section>

                <!-- Galerie Privée -->
                <section x-show="selectedTab === 'private'" x-transition>
                    <h2 class="mb-4 text-3xl font-semibold text-gray-800">🔐 Galerie Privée</h2>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                        @foreach ($privateGallery as $media)
                            @auth
                                <div @click="$dispatch('media-open', { src: '{{ asset('storage/' . $media->path) }}', type: '{{ $media->type }}' })"
                                    class="cursor-pointer overflow-hidden rounded-xl shadow transition duration-300 hover:shadow-xl">
                                    @if ($media->type === 'image')
                                        <img src="{{ asset('storage/' . $media->path) }}" class="h-48 w-full object-cover"
                                            alt="media">
                                    @elseif($media->type === 'video')
                                        <div class="relative">
                                            <video muted class="pointer-events-none h-48 w-full object-cover brightness-75">
                                                <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                            </video>
                                            <div
                                                class="absolute inset-0 flex items-center justify-center text-4xl font-bold text-white">
                                                ▶</div>
                                        </div>
                                    @endif
                                </div>
                            @endauth
                            @guest
                                <div class="relative overflow-hidden rounded-xl shadow transition hover:shadow-lg">
                                    @if ($media->type === 'image')
                                        <img :class="!loggedIn ? 'blur-md grayscale brightness-75' : ''"
                                            src="{{ asset('storage/' . $media->path) }}" alt="Privé"
                                            class="h-48 w-full object-cover transition duration-300">
                                    @elseif ($media->type === 'video')
                                        <video :class="!loggedIn ? 'blur-md grayscale brightness-75' : ''"
                                            class="h-48 w-full object-cover transition duration-300">
                                            <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                            Votre navigateur ne supporte pas la vidéo.
                                        </video>
                                    @endif

                                    <div x-show="!loggedIn"
                                        class="absolute inset-0 flex items-center justify-center bg-black/50 px-2 text-center text-sm font-semibold text-white">
                                        Connectez-vous pour voir ce contenu
                                    </div>
                                </div>
                            @endguest
                        @endforeach
                    </div>
                </section>

            </div>
        </div>
    </div>


@stop

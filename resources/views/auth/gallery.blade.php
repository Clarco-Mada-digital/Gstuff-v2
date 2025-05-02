@extends('layouts.base')

@section('pageTitle', 'Galerie')

@section('content')
<section class="relative bg-gradient-to-br from-pink-500 via-purple-600 to-indigo-600 text-white rounded-xl overflow-hidden shadow-xl mb-10">
    <div class="max-w-7xl mx-auto px-6 py-20 sm:py-24 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-4">Explorez. Partagez. Ressentez 📸</h1>
        <p class="text-lg sm:text-xl font-light max-w-2xl mx-auto">
            Vos moments les plus précieux prennent vie ici – entre <strong>stories instantanées</strong> et <strong>galeries captivantes</strong>. Plongez dans l’univers des émotions partagées.
        </p>
    </div>

    <!-- Illustration décorative (optionnelle) -->
    <div class="absolute bottom-0 right-0 opacity-20 pointer-events-none">
        <svg viewBox="0 0 200 200" class="w-64 h-64 transform translate-x-12 translate-y-12">
            <path fill="white" d="M40.6,-71.1C51.1,-66.2,58.8,-51.5,64.3,-37.1C69.7,-22.6,73,-8.3,73.5,6.2C73.9,20.7,71.4,35.3,63.8,47.8C56.2,60.3,43.5,70.7,29.3,73.6C15.2,76.5,-0.5,71.8,-16.4,66.6C-32.3,61.3,-48.5,55.4,-59.6,44.1C-70.7,32.8,-76.8,16.4,-76.3,0.3C-75.8,-15.9,-68.6,-31.8,-58.3,-44.3C-48.1,-56.8,-34.8,-65.9,-20.2,-69.8C-5.6,-73.7,10.2,-72.3,24.6,-71.2C39,-70.1,52.1,-69.9,40.6,-71.1Z" transform="translate(100 100)" />
        </svg>
    </div>
</section>

<div class="max-w-7xl min-h-[50vh] mx-auto py-10 px-4 sm:px-6 lg:px-8"
     x-data="{
        loggedIn: @json(auth()->check()),
        selectedTab: 'stories',
        selectedUser: '',
        selectedType: '',
        openMenu: false
     }"
>
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- MENU LATERAL -->
        <aside class="md:w-1/5 space-y-2">

            <!-- MOBILE TOGGLE -->
            <div class="md:hidden mb-4">
                <button @click="openMenu = !openMenu" 
                        class="w-full px-4 py-2 bg-gray-100 text-gray-800 rounded-lg flex items-center justify-between">
                    <span>📁 Sections</span>
                    <svg :class="{ 'rotate-180': openMenu }" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>

            <div :class="{'block': openMenu, 'hidden': !openMenu }" class="md:block space-y-2">
                <!-- Tab Stories -->
                <button @click="selectedTab = 'stories'; openMenu = false"
                        :class="selectedTab === 'stories' ? 'bg-pink-600 text-white' : 'bg-gray-100 text-gray-700'"
                        class="w-full py-2 px-4 rounded-lg text-left font-medium hover:bg-pink-100 transition flex justify-between items-center">
                    📸 Stories
                    <span class="bg-white/30 text-xs px-2 py-1 rounded-full" x-text="{{ count($usersWithStories) }}"></span>
                </button>

                <!-- Tab Galerie publique -->
                <button @click="selectedTab = 'public'; openMenu = false"
                        :class="selectedTab === 'public' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                        class="w-full py-2 px-4 rounded-lg text-left font-medium hover:bg-blue-100 transition flex justify-between items-center">
                    🌍 Publique
                    <span class="bg-white/30 text-xs px-2 py-1 rounded-full" x-text="{{ count($publicGallery) }}"></span>
                </button>

                <!-- Tab Galerie privée -->
                <button @click="selectedTab = 'private'; openMenu = false"
                        :class="selectedTab === 'private' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700'"
                        class="w-full py-2 px-4 rounded-lg text-left font-medium hover:bg-gray-200 transition flex justify-between items-center">
                    🔐 Privée
                    <span class="bg-white/30 text-xs px-2 py-1 rounded-full" x-text="{{ count($privateGallery) }}"></span>
                </button>
            </div>
        </aside>

        <!-- CONTENU PRINCIPAL -->
        <div class="flex-1 space-y-10">

            <!-- Stories -->
            <section x-show="selectedTab === 'stories'" x-transition>
                <h2 class="text-3xl font-semibold text-gray-800 mb-6">📸 Stories des utilisateurs</h2>
                <div class="flex space-x-4 overflow-x-auto pb-2">
                    @foreach($usersWithStories as $user)
                        <div class="flex-shrink-0 text-center">
                            <div class="w-20 h-20 rounded-full border-4 border-pink-500 shadow-md overflow-hidden mx-auto">
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            </div>
                            <span class="text-sm mt-2 block text-gray-700 truncate">{{ $user->name }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Galerie Publique -->
            <section x-show="selectedTab === 'public'" x-transition>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-3xl font-semibold text-gray-800">🌍 Galerie Publique</h2>
                    <div class="flex gap-4 items-center text-sm">
                        <select x-model="selectedUser" class="border border-gray-300 rounded-md p-1">
                            <option value="">Tous les utilisateurs</option>
                            @foreach($usersWithMedia as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <select x-model="selectedType" class="border border-gray-300 rounded-md p-1">
                            <option value="">Tous types</option>
                            <option value="image">Images</option>
                            <option value="video">Vidéos</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($publicGallery as $media)
                    <template x-if="(!selectedUser || selectedUser == '{{ $media->user_id }}') && (!selectedType || selectedType == '{{ $media->type }}')">
                        <div 
                            @click="$dispatch('media-open', { src: '{{ asset('storage/' . $media->path) }}', type: '{{ $media->type }}' })"
                            class="cursor-pointer overflow-hidden rounded-xl shadow hover:shadow-xl transition duration-300"
                        >
                            @if($media->type === 'image')
                                <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-48 object-cover" alt="media">
                            @elseif($media->type === 'video')
                                <div class="relative">
                                    <video muted autoplay loop class="w-full h-48 object-cover pointer-events-none brightness-75">
                                        <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                    </video>
                                    <div class="absolute inset-0 flex items-center justify-center text-white text-4xl font-bold">▶</div>
                                </div>
                            @endif
                        </div>
                    </template>
                    
                    @endforeach
                </div>
            </section>

            <!-- Galerie Privée -->
            <section x-show="selectedTab === 'private'" x-transition>
                <h2 class="text-3xl font-semibold text-gray-800 mb-4">🔐 Galerie Privée</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($privateGallery as $media)
                    @auth
                        <div 
                            @click="$dispatch('media-open', { src: '{{ asset('storage/' . $media->path) }}', type: '{{ $media->type }}' })"
                            class="cursor-pointer overflow-hidden rounded-xl shadow hover:shadow-xl transition duration-300"
                        >
                            @if($media->type === 'image')
                                <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-48 object-cover" alt="media">
                            @elseif($media->type === 'video')
                                <div class="relative">
                                    <video muted class="w-full h-48 object-cover pointer-events-none brightness-75">
                                        <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                    </video>
                                    <div class="absolute inset-0 flex items-center justify-center text-white text-4xl font-bold">▶</div>
                                </div>
                            @endif                        
                        </div>
                    @endauth
                    @guest
                        <div class="relative overflow-hidden rounded-xl shadow hover:shadow-lg transition">
                            @if ($media->type === 'image')
                                <img 
                                    :class="!loggedIn ? 'blur-md grayscale brightness-75' : ''"
                                    src="{{ asset('storage/' . $media->path) }}" 
                                    alt="Privé" 
                                    class="w-full h-48 object-cover transition duration-300"
                                >
                            @elseif ($media->type === 'video')
                                <video 
                                    :class="!loggedIn ? 'blur-md grayscale brightness-75' : ''"
                                    class="w-full h-48 object-cover transition duration-300" >
                                    <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                    Votre navigateur ne supporte pas la vidéo.
                                </video>
                            @endif

                            <div x-show="!loggedIn" class="absolute inset-0 flex items-center justify-center bg-black/50 text-white font-semibold text-center text-sm px-2">
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

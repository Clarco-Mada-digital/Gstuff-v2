@extends('layouts.base')

@section('pageTitle', 'Galerie')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-16" x-data="{ loggedIn: @json(auth()->check()), selectedUser: '', selectedType: '' }">

    <!-- Stories Section -->
    <section>
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

    <!-- Public Gallery -->
    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-semibold text-gray-800">🌍 Galerie Publique</h2>
            <!-- Filters -->
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
                    <div class="overflow-hidden rounded-xl shadow hover:shadow-xl transition duration-300">
                        @if($media->type === 'image')
                            <img src="{{ asset('storage/' . $media->path) }}" class="w-full h-48 object-cover" alt="media">
                        @elseif($media->type === 'video')
                            <video controls class="w-full h-48 object-cover">
                                <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                Votre navigateur ne supporte pas la vidéo.
                            </video>
                        @endif
                    </div>
                </template>
            @endforeach
        </div>
    </section>

    <!-- Private Gallery -->
    <section>
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">🔐 Galerie Privée</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($privateGallery as $media)
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
            @endforeach
        </div>
    </section>
</div>
@endsection

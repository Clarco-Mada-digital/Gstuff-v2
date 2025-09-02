@php
    $user = App\Models\User::find($escortId);
@endphp

<div class="relative mx-auto mb-4 flex h-full min-h-[405px] w-full min-w-[270px] max-w-[330px] flex-col rounded-xl border border-gray-200 bg-white shadow-md dark:border-gray-700 dark:bg-gray-900 transition-all duration-300 hover:shadow-lg"
    style="scroll-snap-align: center">

    {{-- Bouton favori stylisé --}}
    <div class="absolute right-3 top-3 z-10">
        <div class="rounded-full bg-white shadow-md border border-gray-200 transition-all duration-300 hover:scale-105">
            <livewire:favorite-button :userId="$escortId" wire:key="{{ $escortId }}" />
        </div>
    </div>

    {{-- Image de profil --}}
    <a class="block aspect-[3/4] w-full overflow-hidden rounded-t-xl"
        @if ($user->profile_type == 'escorte') href="{{ route('show_escort', $escortId) }}" @else href="{{ route('show_salon', $escortId) }}" @endif>
        <div class="relative h-full w-full group overflow-hidden ">
    <!-- Image avec effet zoom au survol -->
    <img 
        class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
        @if ($avatar) src="{{ asset('storage/avatars/' . $avatar) }}" 
        @else src="{{ asset('images/icon_logo.png') }}" 
        @endif
        alt="image profile"
    />

    @if($isPause)

    <!-- Dégradé rose toujours visible -->
    <div class="absolute inset-0 bg-gradient-to-br from-transparent to-pink-500 opacity-60 mix-blend-multiply pointer-events-none"></div>

    <!-- Texte au survol -->
    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <span class="text-white text-sm font-semibold bg-black/40 px-3 py-1 rounded-full">
        {{ __('gestionPause.badgePause') }}
        </span>
    </div>
    @endif
</div>

    </a>

    {{-- Informations principales --}}
    <div class="px-4 py-2 flex flex-col gap-2">

        {{-- Nom + badges + statut --}}
        <div class="flex items-center gap-2">
            <a class="flex items-center gap-2"
                @if ($user->profile_type == 'escorte') href="{{ route('show_escort', $escortId) }}" @else href="{{ route('show_salon', $escortId) }}" @endif>
                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ ucfirst(html_entity_decode($name)) }}
                </h5>
            </a>

            {{-- Badge vérifié --}}
            @if ($profileVerifie === 'verifier')
                <div class="relative group">
                    <svg fill="#000000" width="22px" height="22px" viewBox="0 0 24 24" class="text-green-600">
                        <circle cx="12" cy="12" r="10" fill="#f9cdf3" />
                        <polyline points="8 12 11 15 16 10" fill="none" stroke="#146c33" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                        {{ __('profile.profile_verifie') }}
                    </div>
                </div>
            @endif


            {{-- Badge pause 
            @if ($isPause)
                <x-badgePause />
            @endif--}}

            {{-- Statut en ligne avec tooltip --}}
            <div class="relative group">
                <div class="{{ $isOnline ? 'bg-green-500' : 'bg-gray-400' }} h-2 w-2 rounded-full"></div>
                <div class="absolute bottom-full mb-1 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                    {{ $isOnline ? 'En ligne' : 'Hors ligne' }}
                </div>
            </div>
        </div>

        {{-- Localisation --}}
        @if (!empty($canton) || !empty($ville))
            <p class="text-sm text-gray-700 dark:text-gray-400">
                @if (!empty($canton)) {{ $canton }} @endif
                @if (!empty($canton) && !empty($ville)) | @endif
                @if (!empty($ville)) {{ $ville }} @endif
            </p>
        @else
        <p class="text-sm text-gray-700 dark:text-gray-400">&nbsp;</p>
        @endif

        {{-- Distance --}}
        @if ($distance > 0)
            <div class="absolute left-3 top-3 z-10 bg-white text-green-600 px-2 py-1 text-xs font-bold rounded shadow-md">
                @if ($distance < 1)
                    {{ round($distance * 1000) }} m
                @else
                    {{ round($distance) }} km
                @endif
            </div>
        @endif
    </div>
</div>

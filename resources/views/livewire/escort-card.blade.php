@php
    $user = App\Models\User::find($escortId);
@endphp

@props([
    'size' => '',
])
@if ($size === 'small')
<div class="relative mx-auto mb-4 flex min-h-[200px] min-w-[130px] flex-col rounded-xl border border-gray-200 bg-white shadow-md transition-all duration-300 hover:shadow-lg dark:border-gray-700 dark:bg-gray-900"
    style="scroll-snap-align: center">

    {{-- Bouton favori stylisé --}}
    <div class="absolute right-2 top-2 z-10">
        <div class="rounded-full border border-gray-200 bg-white shadow-md transition-all duration-300 hover:scale-105">
            <livewire:favorite-button :userId="$escortId" wire:key="{{ $escortId }}" size="small" />
        </div>
    </div>

    {{-- Image de profil --}}
    <a class="block aspect-[3/4] w-full overflow-hidden rounded-t-xl"
        @if ($user->profile_type == 'escorte') href="{{ route('show_escort', $escortId) }}" @else href="{{ route('show_salon', $escortId) }}" @endif>
        <div class="group relative h-full w-full overflow-hidden">
            <!-- Image avec effet zoom au survol -->
            <img class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
                @if ($avatar) src="{{ asset('storage/avatars/' . $avatar) }}" 
        @else src="{{ asset('images/icon_logo.png') }}" @endif
                alt="image profile" />

            @if ($isPause)
                <!-- Dégradé rose toujours visible -->
                <div
                    class="pointer-events-none absolute inset-0 bg-gradient-to-br from-transparent to-pink-500 opacity-60 mix-blend-multiply">
                </div>

                <!-- Texte au survol -->
                <div
                    class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <span class="rounded-full bg-black/40 px-3 py-1 text-sm font-semibold text-white">
                        {{ __('gestionPause.badgePause') }}
                    </span>
                </div>
            @endif
        </div>

    </a>

    {{-- Informations principales --}}
    <div class="flex flex-col gap-2 px-4 py-2">

        {{-- Nom + badges + statut --}}
        <div class="flex items-center gap-1">
            <a class="flex items-center "
                @if ($user->profile_type == 'escorte') href="{{ route('show_escort', $escortId) }}" @else href="{{ route('show_salon', $escortId) }}" @endif>
                <h5 class="text-xs font-semibold text-gray-900 dark:text-white">{{ ucfirst(html_entity_decode($name)) }}
                </h5>
            </a>

            {{-- Badge vérifié --}}
            @if ($profileVerifie === 'verifier')
                <div class="group relative">
                    <svg fill="#000000" width="12px" height="12px" viewBox="0 0 24 24" class="text-green-600">
                        <circle cx="12" cy="12" r="10" fill="#f9cdf3" />
                        <polyline points="8 12 11 15 16 10" fill="none" stroke="#146c33" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <div
                        class="absolute bottom-full left-1/2 z-10 mb-1 -translate-x-1/2 transform whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        {{ __('profile.profile_verifie') }}
                    </div>
                </div>
            @endif


            {{-- Badge pause 
            @if ($isPause)
                <x-badgePause />
            @endif --}}

            {{-- Statut en ligne avec tooltip --}}
            <div class="group relative">
                <div class="{{ $isOnline ? 'bg-green-500' : 'bg-gray-400' }} h-2 w-2 rounded-full"></div>
                <div
                    class="absolute bottom-full mb-1 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    {{ $isOnline ? 'En ligne' : 'Hors ligne' }}
                </div>
            </div>
        </div>

        {{-- Localisation --}}
        @if (!empty($canton) || !empty($ville))
            <p class="text-xs text-gray-700 whitespace-nowrap">
                @if (!empty($canton))
                    {{ $canton }}
                @endif
                @if (!empty($canton) && !empty($ville))
                    |
                @endif
                @if (!empty($ville))
                    {{ $ville }}
                @endif
            </p>
        @else
            <p class="text-xs text-gray-700 dark:text-gray-400">&nbsp;</p>
        @endif

        {{-- Distance --}}
        @if ($distance > 0)
            <div
                class="absolute left-3 top-3 text-xs z-10 rounded bg-white px-1 py-1 text-xs font-bold text-green-600 shadow-md">
                @if ($distance < 1)
                    {{ round($distance * 1000) }} m
                @else
                    {{ round($distance) }} km
                @endif
            </div>
        @endif
    </div>
</div>
@else
<div class="relative mx-auto mb-4 flex h-full min-h-[405px] w-full min-w-[270px] max-w-[330px] flex-col rounded-xl border border-gray-200 bg-white shadow-md transition-all duration-300 hover:shadow-lg dark:border-gray-700 dark:bg-gray-900"
    style="scroll-snap-align: center">

    {{-- Bouton favori stylisé --}}
    <div class="absolute right-3 top-3 z-10">
        <div class="rounded-full border border-gray-200 bg-white shadow-md transition-all duration-300 hover:scale-105">
            <livewire:favorite-button :userId="$escortId" wire:key="{{ $escortId }}" />
        </div>
    </div>

    {{-- Image de profil --}}
    <a class="block aspect-[3/4] w-full overflow-hidden rounded-t-xl"
        @if ($user->profile_type == 'escorte') href="{{ route('show_escort', $escortId) }}" @else href="{{ route('show_salon', $escortId) }}" @endif>
        <div class="group relative h-full w-full overflow-hidden">
            <!-- Image avec effet zoom au survol -->
            <img class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
                @if ($avatar) src="{{ asset('storage/avatars/' . $avatar) }}" 
        @else src="{{ asset('images/icon_logo.png') }}" @endif
                alt="image profile" />

            @if ($isPause)
                <!-- Dégradé rose toujours visible -->
                <div
                    class="pointer-events-none absolute inset-0 bg-gradient-to-br from-transparent to-pink-500 opacity-60 mix-blend-multiply">
                </div>

                <!-- Texte au survol -->
                <div
                    class="absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <span class="rounded-full bg-black/40 px-3 py-1 text-sm font-semibold text-white">
                        {{ __('gestionPause.badgePause') }}
                    </span>
                </div>
            @endif
        </div>

    </a>

    {{-- Informations principales --}}
    <div class="flex flex-col gap-2 px-4 py-2">

        {{-- Nom + badges + statut --}}
        <div class="flex items-center gap-2">
            <a class="flex items-center gap-2"
                @if ($user->profile_type == 'escorte') href="{{ route('show_escort', $escortId) }}" @else href="{{ route('show_salon', $escortId) }}" @endif>
                <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ ucfirst(html_entity_decode($name)) }}
                </h5>
            </a>

            {{-- Badge vérifié --}}
            @if ($profileVerifie === 'verifier')
                <div class="group relative">
                    <svg fill="#000000" width="22px" height="22px" viewBox="0 0 24 24" class="text-green-600">
                        <circle cx="12" cy="12" r="10" fill="#f9cdf3" />
                        <polyline points="8 12 11 15 16 10" fill="none" stroke="#146c33" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <div
                        class="absolute bottom-full left-1/2 z-10 mb-1 -translate-x-1/2 transform whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        {{ __('profile.profile_verifie') }}
                    </div>
                </div>
            @endif


            {{-- Badge pause 
            @if ($isPause)
                <x-badgePause />
            @endif --}}

            {{-- Statut en ligne avec tooltip --}}
            <div class="group relative">
                <div class="{{ $isOnline ? 'bg-green-500' : 'bg-gray-400' }} h-2 w-2 rounded-full"></div>
                <div
                    class="absolute bottom-full mb-1 whitespace-nowrap rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    {{ $isOnline ? 'En ligne' : 'Hors ligne' }}
                </div>
            </div>
        </div>

        {{-- Localisation --}}
        @if (!empty($canton) || !empty($ville))
            <p class="text-sm text-gray-700 dark:text-gray-400">
                @if (!empty($canton))
                    {{ $canton }}
                @endif
                @if (!empty($canton) && !empty($ville))
                    |
                @endif
                @if (!empty($ville))
                    {{ $ville }}
                @endif
            </p>
        @else
            <p class="text-sm text-gray-700 dark:text-gray-400">&nbsp;</p>
        @endif

        {{-- Distance --}}
        @if ($distance > 0)
            <div
                class="absolute left-3 top-3 z-10 rounded bg-white px-2 py-1 text-xs font-bold text-green-600 shadow-md">
                @if ($distance < 1)
                    {{ round($distance * 1000) }} m
                @else
                    {{ round($distance) }} km
                @endif
            </div>
        @endif
    </div>
</div>
@endif

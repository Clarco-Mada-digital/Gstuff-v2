<div class="relative flex 
       min-h-[200px] min-w-[45%] sm:min-w-[40%] md:min-w-[30%] lg:min-w-[25%] xl:min-w-[20%]  aspect-[2/3]
    
    
    
    
    flex-col rounded-xl border border-gray-200 bg-white shadow-md transition-all duration-300 hover:shadow-lg 
    dark:border-gray-700 dark:bg-gray-900"
        style="scroll-snap-align: center">

    {{-- Bouton favori stylisé --}}
    <div class="absolute right-3 top-3 z-10">
        <div class="rounded-full border border-gray-200 bg-white shadow-md transition-all duration-300 hover:scale-105">
            <livewire:favorite-button :userId="$salonId" wire:key="{{ $salonId }}" />
        </div>
    </div>

    {{-- Image de profil --}}
    <a class="block aspect-[3/4] w-full overflow-hidden rounded-t-xl" href="{{ route('show_salon', $salonId) }}">
        <div class="group relative h-full w-full overflow-hidden">
            <!-- Image avec effet zoom au survol -->
            <img class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
                @if ($avatar) src="{{ asset('storage/avatars/' . $avatar) }}" 
        @else src="{{ asset('images/icon_logo.png') }}" @endif
                alt="image profile" />

            @if ($isPause)
                <!-- Dégradé rose toujours visible -->
                <div
                    class="pointer-events-none absolute inset-0 bg-gradient-to-br from-transparent to-pink-500 opacity-90 mix-blend-multiply">
                </div>

                <!-- Texte “Profil en pause” visible au survol -->
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

        {{-- Nom + badges --}}
        <div class="flex items-center gap-2">
            <a class="flex items-center gap-2" href="{{ route('show_salon', $salonId) }}">
                <h5 class="text-xs sm:text-sm  font-semibold text-gray-900 dark:text-white">{{ ucfirst(html_entity_decode($name)) }}
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
                        class="absolute bottom-full mb-1 rounded bg-gray-800 px-2 py-1 text-xs text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        {{ __('profile.profile_verifie') }}
                    </div>
                </div>
            @endif

            {{-- Badge pause
            @if ($isPause)
                <x-badgePause />
            @endif --}}
        </div>

        {{-- Localisation --}}
        @if (!empty($canton) || !empty($ville))
        <p class="text-xs text-gray-700 whitespace-nowrap truncate">
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


    </div>
</div>

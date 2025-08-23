<div x-data="{
    isActive: false,
    watchId: null,
    errorMessage: '',
    showError: false,
    options: {
        enableHighAccuracy: true,
        timeout: 50000,
        maximumAge: 0
    },

    init() {
        this.toggleGeolocation(true);

        Livewire.on('destroy', () => {
            if (this.watchId !== null) {
                navigator.geolocation.clearWatch(this.watchId);
            }
        });
    },

    updateLocation(position) {
        const coords = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
            timestamp: Date.now()
        };

        // Stocker dans localStorage
        localStorage.setItem('lastLocation', JSON.stringify(coords));

        // Envoyer à Livewire
        @this.call('updateLocation', coords.lat, coords.lng);
        this.showError = false;
    },

    handleError(error) {
        let message = '{{ __("proximity.location_error") }}';
        console.log('Erreur de localisation', error);

        switch(error.code) {
            case error.PERMISSION_DENIED:
                message = '{{ __("proximity.permission_denied") }}';
                break;
            case error.POSITION_UNAVAILABLE:
                message = '{{ __("proximity.position_unavailable") }}';
                break;
            case error.TIMEOUT:
                message = '{{ __("proximity.timeout_error") }}';
                break;
        }

        this.errorMessage = message;
        this.showError = true;
        this.isActive = false;

        // Utiliser la dernière position connue si disponible
        const saved = localStorage.getItem('lastLocation');
        if (saved) {
            const coords = JSON.parse(saved);
            const age = Date.now() - coords.timestamp;
            if (age < 1000 * 60 * 10) { // moins de 10 minutes
                console.log('Utilisation de la dernière position connue', coords);
                @this.call('updateLocation', coords.lat, coords.lng);
                return;
            }
        }

        // Sinon fallback
        @this.call('useFallbackLocation');
    },

    toggleGeolocation(force = false) {
        if (!force) this.isActive = !this.isActive;
        else this.isActive = true;

        if (this.isActive) {
            if (!navigator.geolocation) {
                this.errorMessage = '{{ __("proximity.geolocation_unsupported") }}';
                this.showError = true;
                this.isActive = false;
                @this.call('useFallbackLocation');
                return;
            }

            // Nettoyer ancien watch
            if (this.watchId !== null) {
                navigator.geolocation.clearWatch(this.watchId);
                this.watchId = null;
            }

            // Localisation initiale
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    this.updateLocation(position);

                    // Suivi en temps réel
                    this.watchId = navigator.geolocation.watchPosition(
                        (pos) => this.updateLocation(pos),
                        (err) => this.handleError(err),
                        this.options
                    );
                },
                (error) => {
                    this.handleError(error);
                    this.isActive = false;
                },
                this.options
            );
        } else {
            if (this.watchId !== null) {
                navigator.geolocation.clearWatch(this.watchId);
                this.watchId = null;
            }
            @this.call('resetLocation');
        }
    }
}" x-init="init">
    <!-- En-tête avec titre et bouton de géolocalisation -->
    <div class="flex flex-col space-y-4 py-5 sm:flex-row sm:items-center sm:justify-between md:flex-row md:items-center md:justify-between md:space-y-0">
       <div class="flex items-center justify-center">
   

        <h2 class="font-roboto-slab text-green-gs text-center text-xl sm:text-2xl font-bold sm:text-left">{{ __('proximity.nearby_girls') }}</h2>
       </div>
        
        @if($geo)
        <div class="relative">
            <!-- Pulsing effect when active -->
            <style>
                @keyframes ping-once {
                    0% {
                        transform: scale(0.8);
                        opacity: 0.8;
                    }
                    75%, 100% {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
                .animate-ping-once {
                    animation: ping-once 1.5s cubic-bezier(0, 0, 0.2, 1) 1;
                }
            </style>
            <div x-show="isActive" 
                 x-transition:enter="transition-opacity ease-out duration-300"
                 x-transition:leave="transition-opacity ease-in duration-200"
                 x-data="{ showPing: true }"
                 x-init="setTimeout(() => showPing = false, 3000)"
                 x-show="showPing"
                 class="absolute inset-0 rounded-full bg-green-gs opacity-75"
                 :class="{ 'animate-ping-once': showPing }"
                 style="width: 3rem; height: 3rem; --tw-bg-opacity: 0.7;">
            </div>
            
            <button @click="toggleGeolocation"
                    class="relative flex items-center justify-center w-12 h-12 transition-all duration-300 ease-in-out transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-green-gs focus:ring-opacity-50 rounded-full shadow-lg"
                    :class="isActive ? 'bg-gradient-to-br from-supraGirlRosePastel/50 to-supraGirlRosePastel/100 hover:from-supraGirlRosePastel/150 hover:to-supraGirlRosePastel/200' : 'bg-gradient-to-br from-green-gs-300 to-green-gs-400 hover:from-green-gs-400 hover:to-green-gs-500'"
                    :title="isActive ? 'Localisation active' : 'Activer la localisation'"
                    x-tooltip.placement.top="isActive ? 'Désactiver la localisation' : 'Activer la localisation'">
                
                <!-- Active state (location icon) -->
                <svg x-show="isActive" 
                     class="w-6 h-6 text-white transition-all duration-300 transform"
                     fill="currentColor" 
                     viewBox="0 0 24 24" 
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                
                <!-- Inactive state (location off icon) -->
                <svg x-show="!isActive"
                     class="w-6 h-6 text-gray-700 transition-all duration-300 transform"
                     fill="currentColor" 
                     viewBox="0 0 24 24" 
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 16.55c-2.0-2.69-5-7.05-5-9.55 0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.49-3 6.86-5 9.55z M12 6c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                </svg>
                
                <!-- Animated checkmark when active -->
                <div x-show="isActive" 
                     class="absolute inset-0 flex items-center justify-center">
                    <div class="w-3 h-3 bg-green-gs rounded-full animate-ping"></div>
                </div>
            </button>
            
            <!-- Tooltip text for better UX -->
            <div x-show="!isActive" class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-2 py-1 bg-supraGirlRose text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                {{ __('proximity.activate_location') }}
            </div>
        </div>
        @endif
    </div>

    @if($maxAvailableDistance > 0)
    <div class="mb-6 px-4 py-3 h-[10vh] bg-white rounded-lg shadow-sm border border-green-gs" x-show="isActive">
        <div class="flex items-center justify-between mb-2">
            <label for="distance" class="block text-sm font-medium text-textColorParagraph font-roboto-slab">{{ __('proximity.max_distance') }}</label>
            <div class="flex items-center">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-gs text-white font-roboto-slab mr-2">
                    <span x-text="$wire.selectedDistance.toFixed(1)"></span> km
                </span>
                <div wire:loading wire:target="selectedDistance" class="flex items-center">
                    <svg class="h-4 w-4 animate-spin text-green-gs" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="relative">
            <input 
                type="range" 
                id="distance" 
                min="{{ $minDistance }}" 
                max="{{ $maxAvailableDistance }}" 
                step="0.01"
                wire:model.live="selectedDistance"
                wire:change="updateDistance(parseFloat($event.target.value))"
                class="w-full h-2 bg-textColorParagraph rounded-lg appearance-none cursor-pointer accent-green-gs-500"
            />
            <div class="absolute left-0 right-0 -bottom-5 flex justify-between text-xs text-textColor font-roboto-slab">
                <span>{{ number_format($minDistance, 1) }} km</span>
                <span class="text-textColor">|</span>
                <span class="font-medium">{{ __('proximity.distance_label') }}</span>
                <span class="text-textColor">|</span>
                <span>{{ number_format($maxAvailableDistance, 1) }} km</span>
            </div>
        </div>
    </div>
    @endif
    <div id="escortsContainer">
       
        @if ($escorts && $escorts->count() > 0)
     
            <div class="mb-4 grid w-full grid-cols-1 items-center gap-4 md:grid-cols-2 2xl:grid-cols-3">
                @foreach ($escorts as $escort)
                    <div class="escort-card" data-distance="{{ $escort['distance'] ?? '' }}">
                        <livewire:escort-card 
                            wire:key="escort-{{ $escort['escort']['id'] }}"
                            name="{{ $escort['escort']['prenom'] ?? '' }}"
                            canton="{{ $escort['canton']->nom ?? '' }}" 
                            ville="{{ $escort['ville']->nom ?? '' }}"
                            avatar="{{ $escort['escort']['avatar'] ?? '' }}"
                            escortId="{{ $escort['escort']['id'] ?? '' }}"
                            distance="{{ $escort['distance'] ?? '' }}" 
                            isPause="{{ $escort['escort']['is_profil_pause'] ?? '' }}"
                        />
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center py-10">
                <p class="text-lg text-textColorParagraph font-roboto-slab">{{ __('proximity.no_results_found') }}</p>
            </div>
        @endif
    </div>

    <!-- Message d'erreur de géolocalisation -->
    <div x-show="showError" class="mt-4 rounded-lg bg-red-50 p-4 text-red-700">
        <div class="flex items-center">
            <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <span x-text="errorMessage"></span>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Le code a été déplacé directement dans le template avec x-data
</script>
@endpush
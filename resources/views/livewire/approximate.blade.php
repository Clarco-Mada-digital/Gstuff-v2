<div x-data="{
    isActive: false,
    watchId: null,
    errorMessage: '',
    showError: false,
    options: {
        enableHighAccuracy: true,
        timeout: 10000,
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
        @this.call('updateLocation', 
            position.coords.latitude, 
            position.coords.longitude
        );
        this.showError = false;
    },
    
    handleError(error) {
        let message = 'Erreur de géolocalisation';
        
        switch(error.code) {
            case error.PERMISSION_DENIED:
                message = 'Accès à la localisation refusé';
                break;
            case error.POSITION_UNAVAILABLE:
                message = 'Position indisponible';
                break;
            case error.TIMEOUT:
                message = 'Délai de localisation dépassé';
                break;
        }
        
        this.errorMessage = message;
        this.showError = true;
        this.isActive = false;
        @this.call('useFallbackLocation');
    },
    
    toggleGeolocation() {
        this.isActive = !this.isActive;
        
        if (this.isActive) {
            if (navigator.geolocation) {
                if (this.watchId !== null) {
                    navigator.geolocation.clearWatch(this.watchId);
                    this.watchId = null;
                }
                
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        this.watchId = navigator.geolocation.watchPosition(
                            (pos) => this.updateLocation(pos),
                            (err) => this.handleError(err),
                            this.options
                        );
                        this.updateLocation(position);
                    },
                    (error) => {
                        this.handleError(error);
                        this.isActive = false;
                    },
                    this.options
                );
            } else {
                this.errorMessage = '{{ __("proximity.geolocation_unsupported") }}';
                this.showError = true;
                this.isActive = false;
                @this.call('useFallbackLocation');
            }
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
        <h2 class="font-dm-serif text-center text-xl sm:text-2xl font-bold sm:text-left">{{ __('proximity.nearby_girls') }}</h2>
       </div>
        
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
                 class="absolute inset-0 rounded-full bg-yellow-400 opacity-75"
                 :class="{ 'animate-ping-once': showPing }"
                 style="width: 3rem; height: 3rem; --tw-bg-opacity: 0.7;">
            </div>
            
            <button @click="toggleGeolocation"
                    class="relative flex items-center justify-center w-12 h-12 transition-all duration-300 ease-in-out transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-yellow-300 focus:ring-opacity-50 rounded-full shadow-lg"
                    :class="isActive ? 'bg-gradient-to-br from-yellow-500 to-yellow-600 hover:from-yellow-400 hover:to-yellow-500' : 'bg-gradient-to-br from-green-gs-300 to-green-gs-400 hover:from-green-gs-400 hover:to-green-gs-500'"
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
                    <div class="w-3 h-3 bg-yellow-100 rounded-full animate-ping"></div>
                </div>
            </button>
            
            <!-- Tooltip text for better UX -->
            <div x-show="!isActive" class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-2 py-1 bg-gray-800 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                {{ __('proximity.activate_location') }}
            </div>
        </div>
    </div>

    @if($maxAvailableDistance > 0)
    <div class="mb-6 px-4 py-3 h-[10vh] bg-white rounded-lg shadow-sm border border-gray-200" x-show="isActive">
        <div class="flex items-center justify-between mb-2">
            <label for="distance" class="block text-sm font-medium text-gray-700">{{ __('proximity.max_distance') }}</label>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                <span x-text="$wire.selectedDistance.toFixed(1)"></span> km
            </span>
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
                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-yellow-500"
            />
            <div class="absolute left-0 right-0 -bottom-5 flex justify-between text-xs text-gray-500">
                <span>{{ number_format($minDistance, 1) }} km</span>
                <span class="text-gray-400">|</span>
                <span class="font-medium">{{ __('proximity.distance_label') }}</span>
                <span class="text-gray-400">|</span>
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
                        />
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center py-10">
                <p class="text-lg text-gray-500">{{ __('proximity.no_results_found') }}</p>
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
<div>

    @if ($deviceType === 'phone')
        <script>
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    console.log(Livewire);

                    Livewire.trigger('updateUserLatitude', position.coords.latitude);
                    Livewire.trigger('updateUserLongitude', position.coords.longitude);
                });
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        </script>
    @endif

    <div class="flex flex-col items-center justify-between py-5 md:flex-row">
        <h2 class="font-dm-serif text-center text-2xl font-bold md:text-left">{{ __('proximity.nearby_girls') }}</h2>
        <div class="mt-4 flex items-center md:mt-0">
            <h2 class="px-4 font-semibold">
                <span id="distanceValue"
                    class="mr-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $distanceMax }}</span>{{ __('proximity.km') }}
            </h2>
            <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay" data-dropdown-delay="500"
                data-dropdown-trigger="hover"
                class="bg-green-gs inline-flex items-center rounded-lg px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                {{ __('proximity.distance_label') }}
                <svg class="ms-3 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Dropdown menu -->
    <div id="dropdownDelay"
        class="z-10 flex hidden w-full max-w-md flex-col items-center justify-center divide-y divide-gray-100 rounded-lg bg-white p-5 shadow-sm md:max-w-lg lg:max-w-xl dark:bg-gray-700">
        <!-- Ajout de la jauge pour varier la distance -->
        <div class="flex w-full flex-col items-center justify-center">
            <label for="distanceRange" class="mb-2 text-lg font-medium text-gray-900 dark:text-white">
                {{ __('proximity.distance_label') }} ({{ __('proximity.km') }}) :
                <span id="distanceValue2"
                    class="mt-2 text-lg font-medium text-gray-900 dark:text-white">{{ $distanceMax }}</span>
            </label>
            <input type="range" id="distanceRange" min="0" max="{{ $distanceMax }}"
                value="{{ $distanceMax / 2 }}"
                class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 dark:bg-gray-700">
        </div>
    </div>

    <div id="escortsContainer">
        @if ($escorts)
            <div class="mb-4 grid w-full grid-cols-1 items-center gap-4 md:grid-cols-2 2xl:grid-cols-3">
                @foreach ($escorts as $escort)
                    <div class="escort-card" data-distance="{{ $escort['distance'] }}">
                        <livewire:escort-card name="{{ $escort['escort']['prenom'] ?? '' }}"
                            canton="{{ $escort['canton']['nom'] ?? '' }}" ville="{{ $escort['ville']['nom'] ?? '' }}"
                            avatar="{{ $escort['escort']['avatar'] ?? '' }}"
                            escortId="{{ $escort['escort']['id'] ?? '' }}"
                            distance="{{ $escort['distance'] ?? '' }}" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center py-10">
                <p class="text-lg text-gray-500">{{ __('proximity.no_results_found') }}</p>
            </div>
        @endif
    </div>

    <!-- Message pour indiquer qu'aucun résultat n'a été trouvé -->
    <div id="noResultsMessage" class="flex items-center justify-center py-10" style="display: none;">
        <p class="text-lg text-gray-500">{{ __('proximity.no_results_for_distance') }}</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const distanceRange = document.getElementById('distanceRange');
        const distanceValue = document.getElementById('distanceValue');
        const distanceValue2 = document.getElementById('distanceValue2');
        const escortCards = document.querySelectorAll('.escort-card');
        const noResultsMessage = document.getElementById('noResultsMessage');

        // Récupérer la valeur de distance depuis le localStorage
        const savedDistance = localStorage.getItem('selectedDistance');
        if (savedDistance !== null) {
            distanceRange.value = savedDistance;
            distanceValue.textContent = savedDistance;
            distanceValue2.textContent = savedDistance;
        }

        function filterEscorts() {
            const selectedDistance = parseFloat(distanceRange.value);
            distanceValue.textContent = selectedDistance;
            distanceValue2.textContent = selectedDistance;

            // Stocker la valeur de distance dans le localStorage
            localStorage.setItem('selectedDistance', selectedDistance);

            let visibleCards = 0;

            escortCards.forEach(card => {
                const escortDistance = parseFloat(card.getAttribute('data-distance'));
                if (escortDistance <= selectedDistance) {
                    card.style.display = 'block';
                    visibleCards++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Afficher ou masquer le message "Aucun résultat trouvé"
            if (visibleCards === 0) {
                noResultsMessage.style.display = 'flex';
            } else {
                noResultsMessage.style.display = 'none';
            }
        }

        distanceRange.addEventListener('input', filterEscorts);

        // Appel initial pour afficher les escortes en fonction de la distance par défaut
        filterEscorts();
    });
</script>

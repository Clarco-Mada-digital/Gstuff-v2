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

    <div class="flex flex-col md:flex-row items-center justify-between py-5">
        <h2 class="font-dm-serif font-bold text-2xl text-center md:text-left">Les filles hot près de chez toi</h2>
        <div class="flex items-center mt-4 md:mt-0">
            <h2 class="px-4 font-semibold">
                <span id="distanceValue" class="mr-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $distanceMax }}</span>km
            </h2>
            <button id="dropdownDelayButton"
                data-dropdown-toggle="dropdownDelay"
                data-dropdown-delay="500"
                data-dropdown-trigger="hover"
                class="text-white bg-green-gs hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                Distance
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Dropdown menu -->
    <div id="dropdownDelay" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-full max-w-md md:max-w-lg lg:max-w-xl dark:bg-gray-700 flex flex-col items-center justify-center p-5">
        <!-- Ajout de la jauge pour varier la distance -->
        <div class="flex flex-col items-center justify-center w-full">
            <label for="distanceRange" class="mb-2 text-lg font-medium text-gray-900 dark:text-white">
                Distance (km) :
                <span id="distanceValue2" class="mt-2 text-lg font-medium text-gray-900 dark:text-white">{{ $distanceMax }}</span>
            </label>
            <input type="range" id="distanceRange" min="0" max="{{ $distanceMax }}" value="{{ $distanceMax/2 }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
        </div>
    </div>

    <div id="escortsContainer">
        @if ($escorts)
        <div class="w-full grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 items-center mb-4 gap-4">
            @foreach ($escorts as $escort)
            <div class="escort-card" data-distance="{{ $escort['distance'] }}">
                <livewire:escort-card name="{{ $escort['escort']['prenom'] }}" canton="{{ $escort['canton']['nom'] }}" ville="{{ $escort['ville']['nom'] }}" avatar="{{ $escort['escort']['avatar'] }}" escortId="{{ $escort['escort']['id'] }}" distance="{{ $escort['distance'] }}" />
            </div>
            @endforeach
        </div>
        @else
        <div class="flex items-center justify-center py-10">
            <p class="text-gray-500 text-lg">Aucun résultat trouvé.</p>
        </div>
        @endif
    </div>

    <!-- Message pour indiquer qu'aucun résultat n'a été trouvé -->
    <div id="noResultsMessage" class="flex items-center justify-center py-10" style="display: none;">
        <p class="text-gray-500 text-lg">Aucun résultat trouvé pour cette distance.</p>
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

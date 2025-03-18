<div class="mb-4 relative">
    <label class="block text-sm font-medium text-gray-700">Localisation</label>
    <input type="text" id="location-search" name="localisation"
           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
           placeholder="Rechercher une ville...">
    <input type="hidden" name="lat" id="latitude" value="">
    <input type="hidden" name="lon" id="longitude" value="">
    <div id="suggestions" class="mt-2 p-2 absolute z-50">
        
    </div>
</div>

<div class="h-[300px] z-1" id="map">
    <img src="{{ asset('images/map_placeholder.png') }}" alt="map image"
         class="w-full h-full object-cover object-center">
</div>

<script>
    
    var map;
    var marker;

    // Ajouter l'écouteur d'événements pour la recherche
    document.getElementById('location-search').addEventListener('input', function() {
       
        var query = this.value;
        if (query.length < 3) return;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
            .then(response => response.json())
            .then(data => {

                var suggestions = document.getElementById('suggestions');
                suggestions.innerHTML = '';
                data.forEach(place => {
                    var option = document.createElement('div');
                    option.className = 'suggestion-item text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white';
                    option.innerHTML = `
                        <button type="button" class="relative mb-2 inline-flex items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                            ${place.display_name}
                        </button>
                    `;
                    option.addEventListener('click', function() {
                        document.getElementById('location-search').value = place.display_name;
                        document.getElementById('longitude').value = place.lon;
                        document.getElementById('latitude').value = place.lat;
                        suggestions.innerHTML = '';
                        // Initialiser la carte avec la localisation sélectionnée
                        initializeMap(place.lat, place.lon, place.display_name);
                    });
                    suggestions.appendChild(option);
                });
            });
    });

    function initializeMap(lat, lon, cityName) {
        if (map) {
            map.remove();
        }
        map = L.map('map').setView([lat, lon], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker([lat, lon]).addTo(map)
            .bindPopup(cityName)
            .openPopup();
    }
</script>

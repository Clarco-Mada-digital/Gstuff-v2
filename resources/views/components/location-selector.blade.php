
<div class="mb-4 relative">
    <label class="block text-sm font-medium text-gray-700">Localisation</label>
    <div class="relative">
        <input type="text" id="location-search" name="localisation"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-10"
            placeholder="Rechercher une ville..." value="{{ $user->localisation ?? '' }}">
        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="performSearch()">
            <i class="fas fa-search text-gray-400 hover:text-gray-600"></i>
        </div>
    </div>
    <input type="hidden" name="lat" id="latitude" value="{{ $user->lat ?? '' }}">
    <input type="hidden" name="lon" id="longitude" value="{{ $user->lon ?? '' }}">
    <div id="suggestions" class="mt-2 absolute z-50 bg-white w-full rounded-lg shadow-lg max-h-[200px] overflow-y-scroll">
    </div>
    
</div>

<div class="relative">
    <div class="absolute right-0 bg-gray-200 flex items-center justify-center w-10 h-10 z-2 rounded-full m-2 hover:bg-gray-300 cursor-pointer"
        onclick="reloadAction()">
        <i class="fas fa-sync-alt text-gray-600 hover:text-gray-800"></i>
    </div>
    <div class="absolute right-12 bg-gray-200 flex items-center justify-center w-10 h-10 z-2 rounded-full m-2 hover:bg-gray-300 cursor-pointer"
        onclick="openMapModal()">
        <i class="fas fa-expand text-gray-600 hover:text-gray-800"></i>
    </div>
    @if($user->lat)
    <div class="h-[300px] z-1" id="map">
    </div>
    @else
    <div class="h-[300px] z-1">
        <img src="{{ asset('images/map_placeholder.png') }}" alt="map image"
            class="w-full h-full object-cover object-center">
    </div>
    @endif
</div>

<!-- Modal Structure -->
<div id="mapModal" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-4 rounded-lg relative w-full h-full max-w-[95%] max-h-[95%] m-2.5  relative">
        <div class="absolute right-0 mr-5 bg-gray-200 flex items-center justify-center w-10 h-10 z-10 rounded-full m-2 hover:bg-gray-300 cursor-pointer"
            onclick="closeMapModal(event)">
            <i class="fas fa-times text-gray-600 hover:text-gray-800"></i>
        </div>
        <div id="modalMap" class="h-full z-1"></div>
    </div>
</div>

<script>
    var user = @json($user);
    console.log('user ee', user);
    var map;
    var marker;
    var modalMap;
    var modalMarker;

    function initializeMap(lat, lon, cityName) {
        if (map) {
            map.remove();
        }
        map = L.map('map').setView([lat, lon], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        if (marker) {
            console.log('ici');
            
            map.removeLayer(marker);
        }
        marker = L.marker([lat, lon]).addTo(map)
            .bindPopup(cityName)
            .openPopup();
    }

    window.onload = function () {
        var lat = document.getElementById('latitude').value;
        var lon = document.getElementById('longitude').value;
        var name = document.getElementById('location-search').value;

        if (lat && lon && name) {
            initializeMap(lat, lon, name);
        }
    };

    function reloadAction() {
        console.log('User data (reload):', user);

        if (user.lat && user.lon && user.localisation) {
            initializeMap(user.lat, user.lon, user.localisation);
            console.log('Carte réinitialisée avec succès !');
        } else {
            console.error('Coordonnées utilisateur manquantes !');
        }
    }

    var mapElement = document.getElementById('map');
    mapElement.addEventListener('mouseenter', function handleMouseEnter() {
        reloadAction();
        mapElement.removeEventListener('mouseenter', handleMouseEnter);
    });
    var mapModalElement = document.getElementById('mapModal');
    mapModalElement.addEventListener('mouseenter', function handleMouseEnter() {
        console.log('lllllllllll');
        
        reloadActionMapModal();

        
    });

    function performSearch() {
        console.log('composant recher');

        var query = document.getElementById('location-search').value;
        if (query.length < 3) return;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
            .then((response) => response.json())
            .then((data) => {
                console.log('data comp', data);

                var suggestions = document.getElementById('suggestions');
                suggestions.innerHTML = '';
                data.forEach((place) => {
                    var option = document.createElement('div');
                    option.className = 'suggestion-item my-1 text-gray-900 bg-white border-b border-gray-200 rounded-lg hover:bg-gray-200 cursor-pointer';

                    option.innerHTML = `
                        <button type="button" class="relative inline-flex items-center w-full px-4 py-2 text-sm ">
                            ${place.display_name}
                        </button>
                    `;
                    option.addEventListener('click', function () {
                        document.getElementById('location-search').value = place.display_name;
                        document.getElementById('longitude').value = place.lon;
                        document.getElementById('latitude').value = place.lat;
                        suggestions.innerHTML = '';
                        initializeMap(place.lat, place.lon, place.display_name);
                    });
                    suggestions.appendChild(option);
                });
            });
    }

    function openMapModal() {
        var lat = document.getElementById('latitude').value;
        var lon = document.getElementById('longitude').value;
        var name = document.getElementById('location-search').value;
        console.log('lat', lat);

        if (lat && lon && name) {
            initializeModalMap(lat, lon, name);
            document.getElementById('mapModal').classList.remove('hidden');
        }
    }

    function closeMapModal(e) {
        e.preventDefault();
        document.getElementById('mapModal').classList.add('hidden');
    }

    function reloadActionMapModal() {
        console.log('User data (reload):', user);
        var lat = document.getElementById('latitude').value;
        var lon = document.getElementById('longitude').value;
        var name = document.getElementById('location-search').value;


        if (lat && lon && name) {
            initializeModalMap(lat, lon, name);
            console.log('Carte réinitialisée avec succès !');
        } else {
            console.error('Coordonnées utilisateur manquantes !');
        }
    }

    function initializeModalMap(lat, lon, cityName) {
        console.log('Initializing modal map with:', lat, lon, cityName);
        if (modalMap) {
            modalMap.remove();
        }
        modalMap = L.map('modalMap').setView([lat, lon], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(modalMap);

        if (modalMarker) {
            modalMap.removeLayer(modalMarker);
        }
        modalMarker = L.marker([lat, lon]).addTo(modalMap).bindPopup(cityName).openPopup();
    }
</script>
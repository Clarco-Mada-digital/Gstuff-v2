@props([
    'villes' => [],
    'selectedVille' => null,
    'class' => '',
    'id' => 'ville-search',
    'label' => null,
])

<div class="{{ $class }} relative">
    @if ($label)
        <label for="{{ $id }}" class="text-green-gs font-roboto-slab mb-2 block text-xs md:text-sm font-medium">
            {{ $label }}
        </label>
    @endif
    <div class="relative">
        <div class="custom-ville-select-wrapper">
            <select wire:model.live="selectedVille" id="{{ $id }}" class="hidden">
                <option value="" class="text-green-gs hover:bg-supaGirlRose/10 text-xs md:text-sm">
                    @if (count($villes) > 0)
                        {{ __('salon-search.villes') }}
                    @else
                        {{ __('salon-search.select_canton') }}
                    @endif
                </option>
                @foreach ($villes as $ville)
                    <option value="{{ $ville->id }}" class="text-green-gs hover:bg-supaGirlRose/10 text-xs md:text-sm">
                        {{ $ville->nom }}
                    </option>
                @endforeach
            </select>
            <div
                class="custom-ville-select border-supaGirlRose font-roboto-slab cursor-pointer rounded-sm md:rounded-lg border border-2 bg-white px-2 py-1 md:px-4 md:py-2">
                <div class="flex items-center justify-between">
                    <div class="selected-ville-option text-xs md:text-sm" id="{{ $id }}-selected-option">
                        @if ($selectedVille)
                            {{ collect($villes)->firstWhere('id', $selectedVille)['nom'] ?? __('salon-search.villes') }}
                        @elseif(count($villes) > 0)
                            {{ __('salon-search.villes') }}
                        @else
                            {{ __('salon-search.select_canton') }}
                        @endif
                    </div>
                    <i class="fas fa-chevron-down ville-arrow-icon text-green-gs font-roboto-slab text-xs md:text-sm"></i>
                </div>
                @if (count($villes) > 0)
                    <div class="custom-ville-options">
                        <div class="search-ville-container">
                            <input type="text" id="{{ $id }}-search"
                                class="search-ville-input border-supaGirlRose text-green-gs font-roboto-slab focus:ring-supaGirlRose/50 w-full rounded-sm md:rounded-lg border-b bg-white px-2 py-1 md:px-4 md:py-2 text-xs md:text-sm transition-all duration-200 focus:border-transparent focus:outline-none focus:ring-2"
                                placeholder="{{ __('user-search.search') }}">
                        </div>
                        <div class="options-ville-list">
                            @foreach ($villes as $ville)
                                <div class="custom-ville-option text-xs md:text-sm" data-value="{{ $ville->id }}">{{ $ville->nom }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .custom-ville-select-wrapper {
        position: relative;
    }

    .custom-ville-select {
        position: relative;
        width: 100%;
    }

    .selected-ville-option {
        color: #7F55B1;
    }

    .custom-ville-options {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 300px;
        overflow-y: auto;
        background: white;
        border: 2px solid #FED5E9;
        border-radius: 0.5rem;
        z-index: 1000;
        margin-top: 0.5rem;
    }

    .custom-ville-options.show {
        display: block;
    }

    .search-ville-container {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1001;
        padding: 0.5rem;
    }

    .options-ville-list {
        max-height: 250px;
    }

    .custom-ville-option {
        padding: 0.5rem 1rem;
        color: #7F55B1;
        cursor: pointer;
    }

    .custom-ville-option:hover {
        background-color: #FED5E9;
    }

    .custom-ville-option.selected {
        background-color: #FED5E9;
    }

    .search-ville-input {
        width: 100%;
        padding: 0.5rem;
        border: none;
        outline: none;
    }
</style>

<script>
    let isInitialized = false; // Drapeau pour vérifier si l'initialisation a déjà été effectuée

    function initVilleSelect() {
        if (isInitialized) {

            return;
        }


        const select = document.getElementById('ville-search');
        if (!select) {

            return;
        }


        const customSelect = document.querySelector('.custom-ville-select');
        const selectedOption = document.getElementById('ville-search-selected-option');
        const searchInput = document.getElementById('ville-search-search');
        const customOptions = document.querySelector('.custom-ville-options');
        const arrowIcon = document.querySelector('.ville-arrow-icon');




        if (!customOptions || !searchInput) {

            return;
        }

        function attachOptionEvents() {
            const options = document.querySelectorAll('.custom-ville-option');
            options.forEach(option => {
                option.addEventListener('click', function(event) {
                    event.stopPropagation(); // Empêcher la propagation de l'événement

                    const value = this.getAttribute('data-value');
                    const text = this.textContent;
                    select.value = value;
                    selectedOption.textContent = text;
                    searchInput.value = '';
                    customOptions.classList.remove('show');
                    if (arrowIcon) {
                        arrowIcon.classList.remove('fa-chevron-up');
                        arrowIcon.classList.add('fa-chevron-down');
                    }
                    const eventChange = new Event('change', {
                        bubbles: true
                    });
                    select.dispatchEvent(eventChange);
                });
            });
        }

        attachOptionEvents();

        let isCustomSelectClicked = false;

        customSelect.addEventListener('click', function(event) {
            if (isCustomSelectClicked) {
                return;
            }

            isCustomSelectClicked = true;


            event.stopPropagation(); // Empêcher la propagation de l'événement

            const isShowing = customOptions.classList.toggle('show');


            searchInput.focus();

            if (arrowIcon) {
                if (isShowing) {
                    arrowIcon.classList.remove('fa-chevron-down');
                    arrowIcon.classList.add('fa-chevron-up');
                } else {
                    arrowIcon.classList.remove('fa-chevron-up');
                    arrowIcon.classList.add('fa-chevron-down');
                }
            }

            setTimeout(() => {
                isCustomSelectClicked = false;
            }, 200);
        });

        searchInput.addEventListener('click', function(event) {

            event.stopPropagation(); // Empêcher la propagation de l'événement
        });

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const options = document.querySelectorAll('.custom-ville-option');
            options.forEach(option => {
                const optionText = option.textContent.toLowerCase();
                option.style.display = optionText.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // Fonction pour fermer tous les menus déroulants
        function closeAllDropdowns(exceptElement = null) {
            document.querySelectorAll('.custom-ville-options').forEach(dropdown => {
                if (!exceptElement || !dropdown.contains(exceptElement)) {
                    dropdown.classList.remove('show');
                }
            });

            document.querySelectorAll('.ville-arrow-icon').forEach(icon => {
                if (!exceptElement || !icon.closest('.custom-ville-select')?.contains(exceptElement)) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        }

        // Gestionnaire de clic global
        function handleDocumentClick(event) {
            const clickedElement = event.target;
            const isVilleSelect = clickedElement.closest('.custom-ville-select');
            const isVilleOptions = clickedElement.closest('.custom-ville-options');
            const isSearchInput = clickedElement.classList.contains('search-ville-input');

            // Si on clique en dehors d'un sélecteur de ville
            if (!isVilleSelect && !isVilleOptions) {
                closeAllDropdowns();
                return;
            }

            // Si on clique sur un sélecteur de ville différent
            if (isVilleSelect && !isSearchInput) {
                const currentSelect = clickedElement.closest('.custom-ville-select');
                const currentOptions = currentSelect?.querySelector('.custom-ville-options');

                // Si le menu est déjà ouvert, on le ferme
                if (currentOptions?.classList.contains('show')) {
                    closeAllDropdowns();
                    return;
                }

                // Sinon, on ferme tous les autres menus d'abord
                closeAllDropdowns(currentSelect);
            }
        }

        // Ajout de l'écouteur d'événements avec capture pour une meilleure détection
        document.addEventListener('click', handleDocumentClick, true);

        isInitialized = true; // Marquer l'initialisation comme effectuée

        // Nettoyage lors de la suppression du composant
        document.addEventListener('livewire:before-update', () => {
            if (typeof handleDocumentClick === 'function') {
                document.removeEventListener('click', handleDocumentClick, true);
            }
        });
    }

    // Gestionnaire d'événements pour les mises à jour Livewire
    function handleLivewireUpdate() {
        setTimeout(initVilleSelect, 300);
    }

    // Initialisation au chargement du DOM
    document.addEventListener('DOMContentLoaded', function() {

        initVilleSelect();
    });

    // Gestion des événements Livewire
    if (window.Livewire) {


        // Au chargement initial de Livewire
        document.addEventListener('livewire:load', function() {
            initVilleSelect();
        });

        // Après chaque mise à jour du DOM par Livewire
        Livewire.hook('morph.updated', () => {
            handleLivewireUpdate();
        });

        // Après chaque message traité par Livewire
        Livewire.hook('message.processed', (message, component) => {

            handleLivewireUpdate();
        });
    }
</script>

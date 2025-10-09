@props([
    'villes' => [],
    'selectedVille' => null,
    'model' => 'selectedSalonVille',
    'id' => 'salon-ville-select',
    'class' => '',
    'placeholder' => 'salon-search.villes',
    'disabledPlaceholder' => 'salon-search.select_canton',
    'label' => null,
])

<div class="{{ $class }} relative">
    @if ($label)
        <label for="{{ $id }}" class="text-green-gs font-roboto-slab mb-2 block text-xs md:text-sm font-medium">
            {{ $label }}
        </label>
    @endif
    <div class="relative">
        <div class="salon-custom-ville-select-wrapper">
            @php
                $villes = is_array($villes) || $villes instanceof Countable ? $villes : [];
                $hasVilles = count($villes) > 0;
            @endphp
            <select wire:model.live="{{ $model }}" id="{{ $id }}" class="hidden"
                @if (!$hasVilles) disabled @endif>
                <option value="" class="text-green-gs hover:bg-supaGirlRose/10">
                    @if ($hasVilles)
                        {{ __($placeholder) }}
                    @else
                        {{ __($disabledPlaceholder) }}
                    @endif
                </option>
                @foreach ($villes as $ville)
                    <option value="{{ $ville->id }}" class="text-green-gs hover:bg-supaGirlRose/10">
                        {{ $ville->nom }}
                    </option>
                @endforeach
            </select>
            <div
                class="salon-custom-ville-select border-supaGirlRose font-roboto-slab cursor-pointer rounded-lg border-2 bg-white px-2 py-1 md:px-4 md:py-2">
                <div class="flex items-center justify-between">
                    <div class="salon-selected-ville-option text-xs md:text-sm" id="{{ $id }}-selected-option">
                        @if ($selectedVille)
                            @php
                                $selected = collect($villes)->firstWhere('id', $selectedVille);
                            @endphp
                            {{ $selected->nom ?? __($placeholder) }}
                        @elseif($hasVilles)
                            {{ __($placeholder) }}
                        @else
                            {{ __($disabledPlaceholder) }}
                        @endif
                    </div>
                    <i class="fas fa-chevron-down salon-ville-arrow-icon text-green-gs font-roboto-slab text-xs md:text-sm"></i>
                </div>
                @if ($hasVilles)
                    <div class="salon-custom-ville-options">
                        <div class="salon-search-ville-container">
                            <input type="text" id="{{ $id }}-search"
                                class="salon-search-ville-input border-supaGirlRose text-green-gs font-roboto-slab focus:ring-supaGirlRose/50 w-full rounded-lg border-b bg-white px-2 py-1 md:px-4 md:py-2 text-xs md:text-sm transition-all duration-200 focus:border-transparent focus:outline-none focus:ring-2"
                                placeholder="{{ __('user-search.search') }}">
                        </div>
                        <div class="salon-options-ville-list">
                            @foreach ($villes as $ville)
                                <div class="salon-custom-ville-option text-xs md:text-sm" data-value="{{ $ville->id }}">
                                    {{ $ville->nom }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .salon-custom-ville-select-wrapper {
        position: relative;
    }

    .salon-custom-ville-select {
        position: relative;
        width: 100%;
    }

    .salon-selected-ville-option {
        color: #7F55B1;
    }

    .salon-custom-ville-options {
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

    .salon-custom-ville-options.show {
        display: block;
    }

    .salon-search-ville-container {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1001;
        padding: 0.5rem;
    }

    .salon-options-ville-list {
        max-height: 250px;
    }

    .salon-custom-ville-option {
        padding: 0.5rem 1rem;
        color: #7F55B1;
        cursor: pointer;
    }

    .salon-custom-ville-option:hover {
        background-color: #FED5E9;
    }

    .salon-custom-ville-option.selected {
        background-color: #FED5E9;
    }

    .salon-search-ville-input {
        width: 100%;
        padding: 0.5rem;
        border: none;
        outline: none;
    }
</style>

<script>
    console.log('=== Script salon-ville-select chargé ===');
    console.log('Livewire disponible:', typeof window.Livewire !== 'undefined');

    let isInitialized = false;

    function initVilleSelect() {
        if (isInitialized) {
            console.log('Initialisation déjà effectuée');
            return;
        }

        console.log('=== Initialisation du sélecteur de villes salon ===');
        const select = document.getElementById('{{ $id }}');
        if (!select) {
            console.error('Élément select non trouvé avec l\'ID: {{ $id }}');
            return;
        }
        console.log('Élément select trouvé:', select);

        const customSelect = document.querySelector('.salon-custom-ville-select');
        const selectedOption = document.getElementById('{{ $id }}-selected-option');
        const searchInput = document.getElementById('{{ $id }}-search');
        const customOptions = document.querySelector('.salon-custom-ville-options');
        const arrowIcon = document.querySelector('.salon-ville-arrow-icon');

        console.log('Éléments trouvés:', {
            customSelect: !!customSelect,
            selectedOption: !!selectedOption,
            searchInput: !!searchInput,
            customOptions: !!customOptions,
            arrowIcon: !!arrowIcon
        });

        if (!customOptions || !searchInput) {
            console.error('Éléments manquants:', {
                customOptions: !customOptions,
                searchInput: !searchInput
            });
            return;
        }

        function attachOptionEvents() {
            const options = document.querySelectorAll('.salon-custom-ville-option');
            options.forEach(option => {
                option.addEventListener('click', function(event) {
                    event.stopPropagation();
                    console.log('Option cliquée:', this.textContent);
                    const value = this.getAttribute('data-value');
                    const text = this.textContent;
                    select.value = value;
                    if (selectedOption) {
                        selectedOption.textContent = text;
                    }
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

        if (customSelect) {
            customSelect.addEventListener('click', function(event) {
                if (isCustomSelectClicked) {
                    return;
                }

                isCustomSelectClicked = true;
                console.log('Sélecteur personnalisé cliqué');
                event.stopPropagation();

                const isShowing = customOptions.classList.toggle('show');
                console.log('Classe "show" ajoutée:', isShowing);

                if (searchInput) {
                    searchInput.focus();
                }

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
        }

        if (searchInput) {
            searchInput.addEventListener('click', function(event) {
                console.log('Input de recherche cliqué');
                event.stopPropagation();
            });

            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                const options = document.querySelectorAll('.salon-custom-ville-option');
                options.forEach(option => {
                    const optionText = option.textContent.toLowerCase();
                    option.style.display = optionText.includes(searchTerm) ? 'block' : 'none';
                });
            });
        }

        // Fonction pour fermer tous les menus déroulants
        function closeAllDropdowns(exceptElement = null) {
            document.querySelectorAll('.salon-custom-ville-options').forEach(dropdown => {
                if (!exceptElement || !dropdown.contains(exceptElement)) {
                    dropdown.classList.remove('show');
                }
            });

            document.querySelectorAll('.salon-ville-arrow-icon').forEach(icon => {
                if (!exceptElement || !icon.closest('.salon-custom-ville-select')?.contains(exceptElement)) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        }

        // Gestionnaire de clic global
        function handleDocumentClick(event) {
            const clickedElement = event.target;
            const isVilleSelect = clickedElement.closest('.salon-custom-ville-select');
            const isVilleOptions = clickedElement.closest('.salon-custom-ville-options');
            const isSearchInput = clickedElement.classList.contains('salon-search-ville-input');

            // Si on clique en dehors d'un sélecteur de ville
            if (!isVilleSelect && !isVilleOptions) {
                closeAllDropdowns();
                return;
            }

            // Si on clique sur un sélecteur de ville différent
            if (isVilleSelect && !isSearchInput) {
                const currentSelect = clickedElement.closest('.salon-custom-ville-select');
                const currentOptions = currentSelect?.querySelector('.salon-custom-ville-options');

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

        isInitialized = true;

        // Nettoyage lors de la suppression du composant
        document.addEventListener('livewire:before-update', () => {
            if (typeof handleDocumentClick === 'function') {
                document.removeEventListener('click', handleDocumentClick, true);
            }
        });
    }

    // Gestionnaire d'événements pour les mises à jour Livewire
    function handleLivewireUpdate() {
        console.log('=== Mise à jour Livewire détectée ===');
        setTimeout(initVilleSelect, 300);
    }

    // Initialisation au chargement du DOM
    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== DOM chargé ===');
        initVilleSelect();
    });

    // Gestion des événements Livewire
    if (window.Livewire) {
        console.log('Livewire détecté, configuration des hooks...');

        // Au chargement initial de Livewire
        document.addEventListener('livewire:load', function() {
            console.log('=== Livewire chargé ===');
            initVilleSelect();
        });

        // Après chaque mise à jour du DOM par Livewire
        Livewire.hook('morph.updated', () => {
            console.log('=== Mise à jour du DOM par Livewire ===');
            handleLivewireUpdate();
        });

        // Après chaque message traité par Livewire
        Livewire.hook('message.processed', (message, component) => {
            console.log('=== Message Livewire traité ===', {
                message: message,
                component: component
            });
            handleLivewireUpdate();
        });
    } else {
        console.warn('Livewire non détecté, certaines fonctionnalités pourraient ne pas fonctionner');
    }
</script>

@props([
    'villes' => [],
    'selectedVille' => null,
    'class' => '',
    'id' => 'ville-search',
    'label' => null,
    'disabled' => false,
])

@php
    $villes = is_array($villes) || $villes instanceof Countable ? $villes : [];
    $hasVilles = count($villes) > 0;
    $selectId = $id . '-select';
@endphp

<div class="{{ $class }} relative">
    @if ($label)
        <label for="{{ $selectId }}" class="text-green-gs mb-1 block text-xs md:text-sm font-medium">
            {{ $label }}
        </label>
    @endif
    <div class="relative">
        <div class="user-ville-select-wrapper">
            <select wire:model.live="selectedVille" id="{{ $selectId }}" class="hidden"
                {{ $disabled || !$hasVilles ? 'disabled' : '' }}>
                <option value="" class="text-green-gs hover:bg-supaGirlRose/10">
                    {{ $hasVilles ? __('user-search.cities') : __('user-search.choose_canton') }}
                </option>
                @foreach ($villes as $ville)
                    <option value="{{ $ville->id }}" class="text-green-gs hover:bg-supaGirlRose/10">
                        {{ $ville->nom }}
                    </option>
                @endforeach
            </select>
            <div
                class="user-ville-select border-supaGirlRose font-roboto-slab cursor-pointer rounded-sm md:rounded-lg border-2 bg-white md:px-3 md:py-2.5 px-2 py-1">
                <div class="flex items-center justify-between">
                    <div class="user-selected-ville-option text-xs md:text-sm" id="{{ $selectId }}-selected-option">
                        @if ($selectedVille && $hasVilles)
                            @php
                                $selected = collect($villes)->firstWhere('id', $selectedVille);
                            @endphp
                            {{ $selected->nom ?? __('user-search.cities') }}
                        @else
                            {{ $hasVilles ? __('user-search.cities') : __('user-search.choose_canton') }}
                        @endif
                    </div>
                    <i class="fas fa-chevron-down user-ville-arrow-icon text-green-gs font-roboto-slab text-xs md:text-sm"></i>
                </div>
                @if ($hasVilles && !$disabled)
                    <div class="user-ville-options">
                        <div class="user-search-ville-container">
                            <input type="text" id="{{ $selectId }}-search"
                                class="user-search-ville-input border-supaGirlRose text-green-gs font-roboto-slab focus:ring-supaGirlRose/50 w-full rounded-sm md:rounded-lg border-b bg-white px-4 py-2 text-xs md:text-sm transition-all duration-200 focus:border-transparent focus:outline-none focus:ring-2"
                                placeholder="{{ __('user-search.search') }}">
                        </div>
                        <div class="user-options-ville-list">
                            @foreach ($villes as $ville)
                                <div class="user-ville-option text-xs md:text-sm" data-value="{{ $ville->id }}">{{ $ville->nom }}
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
    .user-ville-select-wrapper {
        position: relative;
    }

    .user-ville-select {
        position: relative;
        width: 100%;
    }

    .user-selected-ville-option {
        color: #7F55B1;
    }

    .user-ville-options {
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

    .user-ville-options.show {
        display: block;
    }

    .user-search-ville-container {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1001;
        padding: 0.5rem;
    }

    .user-options-ville-list {
        max-height: 250px;
        overflow-y: auto;
    }

    .user-ville-option {
        padding: 0.5rem 1rem;
        color: #7F55B1;
        cursor: pointer;
    }

    .user-ville-option:hover {
        background-color: #FED5E9;
    }

    .user-ville-option.selected {
        background-color: #FED5E9;
    }

    .user-search-ville-input {
        width: 100%;
        padding: 0.5rem;
        border: none;
        outline: none;
    }
</style>

<script>
    console.log('=== Script user-ville-select chargé ===');
    console.log('Livewire disponible:', typeof window.Livewire !== 'undefined');

    let isInitialized = false;
    const selectId = '{{ $selectId }}';

    function initVilleSelect() {
        if (isInitialized) {
            console.log('Initialisation déjà effectuée');
            return;
        }

        console.log('=== Initialisation du sélecteur de villes user ===', selectId);
        const select = document.getElementById(selectId);
        if (!select) {
            console.error('Élément select non trouvé avec l\'ID:', selectId);
            return;
        }

        const customSelect = document.querySelector('.user-ville-select');
        const selectedOption = document.getElementById(selectId + '-selected-option');
        const searchInput = document.getElementById(selectId + '-search');
        const customOptions = document.querySelector('.user-ville-options');
        const arrowIcon = document.querySelector('.user-ville-arrow-icon');

        if (!customOptions || !searchInput) {
            console.error('Éléments manquants pour l\'initialisation');
            return;
        }

        function attachOptionEvents() {
            const options = document.querySelectorAll('.user-ville-option');
            options.forEach(option => {
                option.addEventListener('click', function(event) {
                    event.stopPropagation();
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
                if (isCustomSelectClicked || select.disabled) {
                    return;
                }

                isCustomSelectClicked = true;
                event.stopPropagation();

                const isShowing = customOptions.classList.toggle('show');
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
                event.stopPropagation();
            });

            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                const options = document.querySelectorAll('.user-ville-option');
                options.forEach(option => {
                    const optionText = option.textContent.toLowerCase();
                    option.style.display = optionText.includes(searchTerm) ? 'block' : 'none';
                });
            });
        }

        // Fonction pour fermer tous les menus déroulants
        function closeAllDropdowns(exceptElement = null) {
            document.querySelectorAll('.user-ville-options').forEach(dropdown => {
                if (!exceptElement || !dropdown.contains(exceptElement)) {
                    dropdown.classList.remove('show');
                }
            });

            document.querySelectorAll('.user-ville-arrow-icon').forEach(icon => {
                if (!exceptElement || !icon.closest('.user-ville-select')?.contains(exceptElement)) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        }

        // Gestionnaire de clic global
        function handleDocumentClick(event) {
            const clickedElement = event.target;
            const isVilleSelect = clickedElement.closest('.user-ville-select');
            const isVilleOptions = clickedElement.closest('.user-ville-options');
            const isSearchInput = clickedElement.classList.contains('user-search-ville-input');

            // Si on clique en dehors d'un sélecteur de ville
            if (!isVilleSelect && !isVilleOptions) {
                closeAllDropdowns();
                return;
            }

            // Si on clique sur un sélecteur de ville différent
            if (isVilleSelect && !isSearchInput) {
                const currentSelect = clickedElement.closest('.user-ville-select');
                const currentOptions = currentSelect?.querySelector('.user-ville-options');

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
    }

    // Nettoyage lors de la suppression du composant
    document.addEventListener('livewire:before-update', () => {
        document.removeEventListener('click', handleDocumentClick, true);
    });

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
        Livewire.hook('message.processed', () => {
            handleLivewireUpdate();
        });
    }
</script>

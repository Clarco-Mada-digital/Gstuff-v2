@props([
    'cantons' => [],
    'selectedCanton' => null,
    'onChange' => 'chargeVille',
    'model' => 'selectedSalonCanton',
    'id' => 'salon-canton-select',
    'class' => '',
    'placeholder' => 'salon-search.cantons',
])

<div class="{{ $class }} relative">
    <div class="relative">
        <div class="custom-select-wrapper">
            <select wire:model.live="{{ $model }}" wire:change="{{ $onChange }}" id="{{ $id }}"
                class="hidden">
                <option value="" class="text-green-gs text-xs md:text-sm hover:bg-supaGirlRose/10">{{ __($placeholder) }}</option>
                @foreach ($cantons as $canton)
                    <option value="{{ $canton->id }}" class="text-green-gs text-xs md:text-sm hover:bg-supaGirlRose/10">
                        {{ $canton->nom }}
                    </option>
                @endforeach
            </select>
            <div
                class="custom-select border-supaGirlRose font-roboto-slab cursor-pointer rounded-sm md:rounded-lg border-2 bg-white px-2 py-1 md:px-4 md:py-2">
                <div class="flex items-center justify-between">
                    <div class="selected-option text-xs md:text-sm" id="{{ $id }}-selected-option">
                        {{ $selectedCanton && $cantons->firstWhere('id', $selectedCanton) ? $cantons->firstWhere('id', $selectedCanton)->nom : __('user-search.cantons') }}
                    </div>
                    <i class="fas fa-chevron-down arrow-icon text-green-gs font-roboto-slab text-xs md:text-sm"></i>
                </div>
                <div class="custom-options">
                    <div class="search-container">
                        <input type="text" id="{{ $id }}-search"
                            class="border-b-1 border-supaGirlRose text-green-gs font-roboto-slab focus:ring-supaGirlRose/50 w-full rounded-sm md:rounded-lg bg-white px-2 py-1 md:px-4 md:py-2 text-xs md:text-sm transition-all duration-200 focus:border-transparent focus:outline-none focus:ring-2"
                            placeholder="{{ __('user-search.search') }}">
                    </div>
                    <div class="options-list">
                        @foreach ($cantons as $canton)
                            <div class="custom-option text-xs md:text-sm" data-value="{{ $canton->id }}">{{ $canton->nom }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-select-wrapper {
        position: relative;
    }

    .custom-select {
        position: relative;
        width: 100%;
    }

    .selected-option {
        color: #7F55B1;
    }

    .custom-options {
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

    .custom-options.show {
        display: block;
    }

    .search-container {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1001;
        padding: 0.5rem;
    }

    .options-list {
        max-height: 250px;
    }

    .custom-option {
        padding: 0.5rem 1rem;
        color: #7F55B1;
        cursor: pointer;
    }

    .custom-option:hover {
        background-color: #FED5E9;
    }

    .custom-option.selected {
        background-color: #FED5E9;
    }

    #{{ $id }}-search {
        width: 100%;
        padding: 0.5rem;
        border: none;
        outline: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('{{ $id }}');
        const customSelect = document.querySelector('.custom-select');
        const selectedOption = document.getElementById('{{ $id }}-selected-option');
        const searchInput = document.getElementById('{{ $id }}-search');
        const customOptions = document.querySelector('.custom-options');
        const options = document.querySelectorAll('.custom-option');
        const arrowIcon = document.querySelector('.arrow-icon');

        // Afficher/Masquer les options personnalisées
        customSelect.addEventListener('click', function(event) {
            event.stopPropagation();
            customOptions.classList.toggle('show');
            searchInput.focus();

            // Changer l'icône de la flèche
            if (customOptions.classList.contains('show')) {
                arrowIcon.classList.remove('fa-chevron-down');
                arrowIcon.classList.add('fa-chevron-up');
            } else {
                arrowIcon.classList.remove('fa-chevron-up');
                arrowIcon.classList.add('fa-chevron-down');
            }
        });

        // Empêcher la fermeture du champ de recherche lors du clic
        searchInput.addEventListener('click', function(event) {
            event.stopPropagation();
        });

        // Filtrer les options en fonction de la recherche
        searchInput.addEventListener('input', function(event) {
            event.stopPropagation();
            const searchTerm = searchInput.value.toLowerCase();
            options.forEach(option => {
                const optionText = option.textContent.toLowerCase();
                if (optionText.includes(searchTerm)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        // Sélectionner une option
        options.forEach(option => {
            option.addEventListener('click', function(event) {
                event.stopPropagation();
                const value = option.getAttribute('data-value');
                const text = option.textContent;
                select.value = value;
                selectedOption.textContent = text;
                searchInput.value = ''; // Réinitialiser le champ de recherche
                customOptions.classList.remove('show'); // Fermer les options

                // Réinitialiser l'icône de la flèche
                arrowIcon.classList.remove('fa-chevron-up');
                arrowIcon.classList.add('fa-chevron-down');

                // Déclencher l'événement de changement pour Livewire
                select.dispatchEvent(new Event('change'));
            });
        });

        // Fonction pour fermer tous les menus déroulants
        function closeAllDropdowns(exceptElement = null) {
            document.querySelectorAll('.custom-options').forEach(dropdown => {
                if (!exceptElement || !dropdown.contains(exceptElement)) {
                    dropdown.classList.remove('show');
                }
            });

            document.querySelectorAll('.arrow-icon').forEach(icon => {
                if (!exceptElement || !icon.closest('.custom-select')?.contains(exceptElement)) {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        }

        // Gestionnaire de clic global
        function handleDocumentClick(event) {
            const clickedElement = event.target;
            const isCantonSelect = clickedElement.closest('.custom-select');
            const isCantonOptions = clickedElement.closest('.custom-options');
            const isSearchInput = clickedElement.id && clickedElement.id.endsWith('-search');

            // Si on clique en dehors d'un sélecteur de canton
            if (!isCantonSelect && !isCantonOptions) {
                closeAllDropdowns();
                return;
            }

            // Si on clique sur un sélecteur de canton différent
            if (isCantonSelect && !isSearchInput) {
                const currentSelect = clickedElement.closest('.custom-select');
                const currentOptions = currentSelect?.querySelector('.custom-options');

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
    });

    // Nettoyage lors de la suppression du composant
    document.addEventListener('livewire:before-update', () => {
        if (typeof handleDocumentClick === 'function') {
            document.removeEventListener('click', handleDocumentClick, true);
        }
    });
</script>

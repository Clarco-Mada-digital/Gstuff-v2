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

<div class="relative {{ $class }}">
    @if($label)
        <label for="{{ $selectId }}" class="block text-sm font-medium text-green-gs mb-1">
            {{ $label }}
        </label>
    @endif
    <div class="relative">
        <div class="user-ville-select-wrapper">
            <select 
                wire:model.live="selectedVille" 
                id="{{ $selectId }}" 
                class="hidden"
                {{ $disabled || !$hasVilles ? 'disabled' : '' }}
            >
                <option value="" class="text-green-gs hover:bg-supaGirlRose/10">
                    {{ $hasVilles ? __('user-search.cities') : __('user-search.choose_canton') }}
                </option>
                @foreach($villes as $ville)
                    <option value="{{ $ville->id }}" class="text-green-gs hover:bg-supaGirlRose/10">
                        {{ $ville->nom }}
                    </option>
                @endforeach
            </select>
            <div class="user-ville-select rounded-lg cursor-pointer bg-white px-3 py-2.5 border-2 border-supaGirlRose font-roboto-slab">
                <div class="flex justify-between items-center">
                    <div class="user-selected-ville-option" id="{{ $selectId }}-selected-option">
                        @if($selectedVille && $hasVilles)
                            @php
                                $selected = collect($villes)->firstWhere('id', $selectedVille);
                            @endphp
                            {{ $selected->nom ?? __('user-search.cities') }}
                        @else
                            {{ $hasVilles ? __('user-search.cities') : __('user-search.choose_canton') }}
                        @endif
                    </div>
                    <i class="fas fa-chevron-down user-ville-arrow-icon text-green-gs font-roboto-slab"></i>
                </div>
                @if($hasVilles && !$disabled)
                <div class="user-ville-options">
                    <div class="user-search-ville-container">
                        <input type="text" id="{{ $selectId }}-search" class="user-search-ville-input w-full bg-white rounded-lg border-b border-supaGirlRose py-2 px-4 text-sm text-green-gs font-roboto-slab focus:outline-none focus:ring-2 focus:ring-supaGirlRose/50 focus:border-transparent transition-all duration-200" placeholder="{{ __('user-search.search') }}">
                    </div>
                    <div class="user-options-ville-list">
                        @foreach($villes as $ville)
                            <div class="user-ville-option" data-value="{{ $ville->id }}">{{ $ville->nom }}</div>
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
                    const eventChange = new Event('change', { bubbles: true });
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

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.user-ville-select') && !event.target.closest('.user-ville-options')) {
                customOptions.classList.remove('show');
                if (arrowIcon) {
                    arrowIcon.classList.remove('fa-chevron-up');
                    arrowIcon.classList.add('fa-chevron-down');
                }
            }
        });

        isInitialized = true;
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
        Livewire.hook('message.processed', () => {
            handleLivewireUpdate();
        });
    }
</script>

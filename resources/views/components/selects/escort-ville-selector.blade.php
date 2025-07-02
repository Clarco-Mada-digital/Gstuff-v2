@props([
    'villes' => [],
    'selectedVille' => null,
    'class' => '',
    'id' => 'escort-ville-selector',
    'label' => null,
])

<div class="relative {{ $class }}">
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-green-gs mb-2 font-roboto-slab">
            {{ $label }}
        </label>
    @endif
    <div class="relative">
        <select 
            wire:model.live="selectedVille"
            id="{{ $id }}" 
            class="appearance-none w-full bg-white border-2 border-supaGirlRose rounded-lg py-2.5 px-4 text-green-gs font-roboto-slab focus:outline-none focus:ring-2 focus:ring-supaGirlRose/50 focus:border-transparent transition-all duration-200 pr-10 cursor-pointer"
            @if(!$villes || $villes->isEmpty()) disabled @endif
        >
            <option value="" class="text-green-gs hover:bg-supaGirlRose/10">
                @if($villes && $villes->isNotEmpty())
                    {{ __('salon-search.villes') }}
                @else
                    {{ __('salon-search.select_canton') }}
                @endif
            </option>
            @if(is_iterable($villes))
                @foreach($villes as $ville)
                    <option value="{{ $ville->id }}" class="text-green-gs hover:bg-supaGirlRose/10">
                        {{ $ville->nom }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<style>
    /* Style de base pour le select */
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    /* Style pour les options du select */
    select option {
        background: white;
        color: #7F55B1;
        padding: 8px 12px;
        cursor: pointer;
    }
    
    /* Style pour l'option au survol */
    select option:hover {
        background-color: #FED5E9 !important;
        color: #7F55B1 !important;
    }
    
    /* Style pour l'option sélectionnée */
    select option:checked {
        background-color: #FED5E9 !important;
        color: #7F55B1 !important;
    }
    
    /* Style pour le placeholder */
    select:invalid {
        color: #7F55B1 !important;
        opacity: 0.7;
    }
    
    /* Style pour la liste déroulante (s'applique à certains navigateurs) */
    select option:not(:checked) {
        background-color: white;
    }
    
    /* Style pour le select désactivé */
    select:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        background-color: #f3f4f6;
    }
</style>

<script>
    // Script pour améliorer le style des options au survol
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('{{ $id }}');
        
        if (select) {
            // Gestionnaire pour le survol sur mobile/tactile
            select.addEventListener('mousemove', function(e) {
                if (e.target.tagName === 'OPTION') {
                    e.target.style.backgroundColor = '#FED5E9';
                }
            });
            
            // Réinitialiser les styles quand on quitte le select
            select.addEventListener('mouseleave', function() {
                const options = select.querySelectorAll('option');
                options.forEach(option => {
                    if (!option.selected) {
                        option.style.backgroundColor = 'white';
                    }
                });
            });
        }
    });
</script>

@props([
    'cantons' => [],
    'villes' => [],
    'selectedCanton' => null,
    'selectedVille' => null,
    'onCantonChange' => 'chargeVille',
    'cantonModel' => 'selectedSalonCanton',
    'villeModel' => 'selectedSalonVille',
    'class' => '',
    'cantonId' => 'canton-select',
    'villeId' => 'ville-select'
])

<div class="flex w-full flex-col items-center justify-center space-y-4 px-4 text-sm sm:flex-row sm:space-x-4 sm:space-y-0 {{ $class }} ">
    <!-- Canton Selector -->
    <div class="w-full min-w-[200px] max-w-xs">
       
        <div class="relative">
            <select 
                wire:model.live="{{ $cantonModel }}" 
                wire:change="{{ $onCantonChange }}"
                id="{{ $cantonId }}" 
                class="appearance-none w-full bg-white border-2 border-supaGirlRose rounded-lg py-2.5 px-4 text-green-gs font-roboto-slab focus:outline-none focus:ring-2 focus:ring-supaGirlRose/50 focus:border-transparent transition-all duration-200 pr-10 cursor-pointer"
            >
                <option value="" class="text-green-gs hover:bg-supaGirlRose/10">{{ __('salon-search.cantons') }}</option>
                @foreach ($cantons as $canton)
                    <option value="{{ $canton->id }}" class="text-green-gs hover:bg-supaGirlRose/10">
                        {{ $canton->nom }}
                    </option>
                @endforeach
            </select>
            
        </div>
    </div>

    <!-- City Selector -->
    <div class="w-full min-w-[200px] max-w-xs">
        <div class="relative">
            <select 
                wire:model.live="{{ $villeModel }}"
                id="{{ $villeId }}"
                class="appearance-none w-full bg-white border-2 border-supaGirlRose rounded-lg py-2.5 px-4 text-green-gs font-roboto-slab focus:outline-none focus:ring-2 focus:ring-supaGirlRose/50 focus:border-transparent transition-all duration-200 pr-10 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                @if (!$villes) disabled @endif
            >
                <option value="" class="text-green-gs hover:bg-supaGirlRose/10">
                    {{ $villes ? __('salon-search.villes') : __('salon-search.select_canton') }}
                </option>
                @if (is_iterable($villes))
                    @foreach ($villes as $ville)
                        <option value="{{ $ville->id }}" class="text-green-gs hover:bg-supaGirlRose/10">
                            {{ $ville->nom }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<style>
    /* Style de base pour les selects */
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    /* Style pour les options des selects */
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
</style>

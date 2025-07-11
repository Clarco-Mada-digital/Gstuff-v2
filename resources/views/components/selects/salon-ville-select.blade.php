@props([
    'villes' => [],
    'model' => 'selectedSalonVille',
    'id' => 'salon-ville-select',
    'class' => '',
    'placeholder' => 'salon-search.villes',
    'disabledPlaceholder' => 'salon-search.select_canton'
])

<div class="w-full min-w-[200px] max-w-xs {{ $class }}">
    <div class="relative">
        <select 
            wire:model.live="{{ $model }}"
            id="{{ $id }}"
            class="appearance-none w-full bg-white border-2 border-supaGirlRose rounded-lg py-2.5 px-4 text-green-gs font-roboto-slab focus:outline-none focus:ring-2 focus:ring-supaGirlRose/50 focus:border-transparent transition-all duration-200 pr-10 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
            @if (!$villes || count($villes) === 0) disabled @endif
        >
            <option value="" class="text-green-gs hover:bg-supaGirlRose/10">
                {{ $villes && count($villes) > 0 ? __($placeholder) : __($disabledPlaceholder) }}
            </option>
            @if (is_iterable($villes) && count($villes) > 0)
                @foreach ($villes as $ville)
                    <option value="{{ $ville->id }}" class="text-green-gs hover:bg-supaGirlRose/10">
                        {{ $ville->nom }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<style>
    #{{ $id }} {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    #{{ $id }} option {
        background: white;
        color: #7F55B1;
        padding: 8px 12px;
        cursor: pointer;
    }
    
    #{{ $id }} option:hover {
        background-color: #FED5E9 !important;
        color: #7F55B1 !important;
    }
    
    #{{ $id }} option:checked {
        background-color: #FED5E9 !important;
        color: #7F55B1 !important;
    }
    
    #{{ $id }}:invalid {
        color: #7F55B1 !important;
        opacity: 0.7;
    }
</style>

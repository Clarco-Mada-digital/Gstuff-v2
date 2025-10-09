@props([
    'cantons' => [],
    'villes' => [],
    'genres' => [],
    'selectedCanton' => null,
    'selectedVille' => null,
    'selectedGenre' => null,
    'class' => '',
])
<div class="{{ $class }} grid grid-cols-3 sm:grid-cols-3 
    w-full 
    sm:w-[80%] sm:m-auto 
    md:w-[60%] md:m-auto  
    lg:w-[50%] lg:m-auto 
    xl:w-[50%] xl:m-auto 

    items-center gap-2 px-1 md:px-4 text-sm">
    <!-- Canton Selector -->
    <div class="w-full ">
        <x-selects.canton-select :cantons="$cantons" :selectedCanton="$selectedCanton" :chargeVille="'chargeVille'" class="w-full" />
    </div>
    <!-- City Selector -->
    <div class="w-full">
        <x-selects.escort-ville-selector :villes="$villes" :selectedVille="$selectedVille" class="w-full" :disabled="!$selectedCanton" />
    </div>
    <!-- Gender Selector -->
    @if ($genres)
        <div class="w-full">
            <x-selects.genre-select :genres="$genres" :selectedGenre="$selectedGenre" class="w-full" />
        </div>
    @endif
</div>


@props([
    'cantons' => [],
    'villes' => [],
    'genres' => [],
    'selectedCanton' => null,
    'selectedVille' => null,
    'selectedGenre' => null,
    'class' => ''
])

<div class="flex w-full flex-col items-center justify-center space-y-4 px-4 text-sm sm:flex-row sm:space-x-4 sm:space-y-0 {{ $class }}">
    <!-- Canton Selector -->
    <div class="w-full min-w-[200px] max-w-xs">
        <x-selects.canton-select 
            :cantons="$cantons"
            :selectedCanton="$selectedCanton"
            :chargeVille="'chargeVille'"
            class="w-full"
        />
    </div>

    <!-- City Selector -->
    <div class="w-full min-w-[200px] max-w-xs">
        <x-selects.escort-ville-selector 
            :villes="$villes"
            :selectedVille="$selectedVille"
            class="w-full"
            :disabled="!$selectedCanton"
        />
    </div>

    <!-- Gender Selector -->
    @if ($genres)
        <div class="w-full min-w-[200px] max-w-xs">
            <x-selects.genre-select 
                :genres="$genres"
                :selectedGenre="$selectedGenre"
                class="w-full"
            />
        </div>
    @endif
</div>

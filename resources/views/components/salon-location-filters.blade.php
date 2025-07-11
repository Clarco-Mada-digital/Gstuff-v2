@props([
    'cantons' => [],
    'villes' => [],
    'selectedCanton' => null,
    'selectedVille' => null,
    'onCantonChange' => 'chargeVille',
    'cantonModel' => 'selectedSalonCanton',
    'villeModel' => 'selectedSalonVille',
    'class' => '',
    'cantonId' => 'salon-canton-select',
    'villeId' => 'salon-ville-select'
])

<div class="flex w-full flex-col items-center justify-center space-y-4 px-4 text-sm sm:flex-row sm:space-x-4 sm:space-y-0 {{ $class }}">
    <!-- Canton Selector Component -->
    <div class="w-full min-w-[200px] max-w-xs">
    <x-selects.salon-canton-select
        :cantons="$cantons"
        :model="$cantonModel"
        :onChange="$onCantonChange"
        :id="$cantonId"
        :selectedCanton="$selectedCanton"
        class="w-full"
    />
    </div>

    <!-- City Selector Component -->
    <div class="w-full min-w-[200px] max-w-xs">
        <x-selects.salon-ville-select
            :villes="$villes"
            :model="$villeModel"
            :id="$villeId"
            :selectedVille="$selectedVille"
            class="w-full"
        />
    </div>
</div>

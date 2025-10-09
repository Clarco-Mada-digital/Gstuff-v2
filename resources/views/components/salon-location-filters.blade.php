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
    'villeId' => 'salon-ville-select',
])

<div
    class="{{ $class }} 
    grid grid-cols-2 sm:grid-cols-2 m-auto
    w-[80%]
    sm:w-[60%] sm:m-auto 
    md:w-[50%] md:m-auto  
    lg:w-[50%] lg:m-auto 
    xl:w-[30%] xl:m-auto 

    items-center gap-2 px-1 md:px-4 text-sm">
    <!-- Canton Selector Component -->
    <div class="w-full ">
        <x-selects.salon-canton-select :cantons="$cantons" :model="$cantonModel" :onChange="$onCantonChange" :id="$cantonId"
            :selectedCanton="$selectedCanton" class="w-full" />
    </div>

    <!-- City Selector Component -->
    <div class="w-full ">
        <x-selects.salon-ville-select :villes="$villes" :model="$villeModel" :id="$villeId" :selectedVille="$selectedVille"
            class="w-full" />
    </div>
</div>

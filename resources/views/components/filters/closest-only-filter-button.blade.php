@props([
    'model' => 'showClosestOnly',
    'loadingTarget' => 'showClosestOnly',
    'label' => 'escort-search.filter_by_closest_only',
    'icon' => 'images/icons/nearHot.png',
    'class' => '',
])

<div class="min-w-[120px] flex-1 sm:min-w-[140px] sm:flex-none {{ $class }}">
    <input 
        wire:model.live="{{ $model }}" 
        class="peer hidden" 
        type="checkbox" 
        id="filterByClosestOnly"
        name="filter_by_closest_only"
    >
    <label 
        for="filterByClosestOnly"
        class="border-2 hover:bg-green-gs peer-checked:bg-green-gs group flex w-full cursor-pointer items-center 
        justify-center gap-2 rounded-lg border-supaGirlRose bg-white py-2 px-3 text-center text-xs transition-all 
        duration-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-gs focus:ring-offset-2 
        peer-checked:text-white sm:text-sm text-green-gs font-roboto-slab"
    >
        <div wire:loading.remove wire:target="{{ $loadingTarget }}" class="flex-shrink-0">
            <img 
                src="{{ url($icon) }}" 
                class="w-6 h-6"
                alt="icon {{ __($label) }}" 
            />
        </div>
        <div wire:loading wire:target="{{ $loadingTarget }}" class="flex-shrink-0">
            <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
        <span>{{ __($label) }}</span>
    </label>
</div>

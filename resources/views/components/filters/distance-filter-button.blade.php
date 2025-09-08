@props([
    'model' => 'approximite',
    'loadingTarget' => 'approximite',
    'label' => 'escort-search.filter_by_distance',
    'icon' => 'images/icons/locationByDistance.png',
    'class' => '',
])

<div class="{{ $class }} min-w-[100px] flex-1 sm:min-w-[140px] sm:flex-none">
    <input wire:model.live="{{ $model }}" class="peer hidden" type="checkbox" id="filterByDistance"
        name="filter_by_distance">
    <label for="filterByDistance"
        class="font-roboto-slab hover:bg-green-gs peer-checked:bg-green-gs border-supaGirlRose focus:ring-green-gs text-green-gs group flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border-2 bg-white sm:px-3 px-0 sm:py-2 py-1 text-center text-xs transition-all duration-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 peer-checked:text-white text-xs sm:text-xs md:text-sm">
        <div wire:loading.remove wire:target="{{ $loadingTarget }}" class="flex-shrink-0">
            <img src="{{ url($icon) }}" class="h-6 w-6" alt="icon {{ __($label) }}" />
        </div>
        <div wire:loading wire:target="{{ $loadingTarget }}" class="flex-shrink-0">
            <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
        <span>{{ __($label) }}</span>
    </label>
</div>

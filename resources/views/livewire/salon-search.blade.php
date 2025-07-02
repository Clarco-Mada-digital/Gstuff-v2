<div>
    <div class="py-15 flex min-h-72 w-full flex-col items-center justify-center  bg-supaGirlRosePastel px-4">
        <h1 class="font-roboto-slab text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
            {{ __('salon-search.title') }}</h1>


        @if ($showFiltreCanton)
            <x-salon-location-filters
                :cantons="$cantons"
                :villes="$villes"
                :selectedCanton="$selectedSalonCanton"
                :selectedVille="$selectedSalonVille"
                onCantonChange="chargeVille"
                cantonModel="selectedSalonCanton"
                villeModel="selectedSalonVille"
            />
        @endif



        @if ($approximite || $showClosestOnly)
            <div class="mx-auto mb-4 mt-1 w-full max-w-2xl rounded-lg bg-white p-4 shadow font-roboto-slab">
                <div class="mb-4">
                    <div class="space-y-6">
                        <div>
                            <div class="mb-2 mt-4 flex items-center justify-between">
                                <label
                                    class="block text-sm font-roboto-slab font-medium text-gray-700">{{ __('escort-search.distance_km') }}
                                    {{ number_format($maxDistanceSelected, 0) }}</label>
                                <div wire:loading wire:target="maxDistanceSelected" class="flex items-center">
                                    <svg class="-ml-1 mr-2 h-4 w-4 animate-spin text-green-gs"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="relative pt-1">

                                <div class="w-full">
                                    <div class="mb-2 flex items-center justify-between text-xs text-gray-600 sm:hidden">
                                        <span
                                            class="whitespace-nowrap rounded-full bg-gray-100 px-2 py-1">{{ str_replace(',', ' ', number_format($minDistance, 0)) }}
                                            km</span>
                                        <span
                                            class="whitespace-nowrap rounded-full bg-gray-100 px-2 py-1">{{ str_replace(',', ' ', number_format($maxAvailableDistance, 0)) }}
                                            km</span>
                                    </div>
                                    <input type="range" wire:model.live="maxDistanceSelected"
                                        min="{{ $minDistance }}" max="{{ $maxAvailableDistance }}" step="1"
                                        class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 sm:hidden">

                                </div>

                                <div
                                    class="mb-2 flex hidden w-full items-center justify-between gap-2 text-xs text-gray-600 sm:block sm:flex sm:gap-3 md:gap-4">
                                    <span
                                        class="shrink-0 rounded-full bg-gray-100 px-2 py-1 text-xs sm:px-3 sm:py-1.5 sm:text-sm">
                                        {{ str_replace(',', ' ', number_format($minDistance, 0)) }} km
                                    </span>
                                    <input type="range" wire:model.live="maxDistanceSelected"
                                        min="{{ $minDistance }}" max="{{ $maxAvailableDistance }}" step="0.01"
                                        class="h-1.5 w-full cursor-pointer appearance-none rounded-full bg-gray-300 transition-colors hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-green-gs focus:ring-opacity-50 sm:h-2">
                                    <span
                                        class="shrink-0 rounded-full bg-gray-100 px-2 py-1 text-xs sm:px-3 sm:py-1.5 sm:text-sm">
                                        {{ str_replace(',', ' ', number_format($maxAvailableDistance, 0)) }} km
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <div class="my-2 flex flex-wrap items-center justify-center gap-2 text-sm font-bold xl:text-base">
         
            <x-category-checkbox 
                    :categories="$categories"
                    :selected-values="$selectedSalonCategories"
                    model="selectedSalonCategories"
                    prefixId="salon"
                />











        </div>

        <div class="my-2 flex flex-wrap items-center justify-center gap-2 text-sm font-bold text-green-gs">

            @foreach ($nombreFilles as $nombreFille)
                <div>
                    <input wire:model.live='nbFilles' class="peer hidden" name="{{ $nombreFille->id }}" type="checkbox"
                        id="nbfille{{ $nombreFille->id }}" value="{{ $nombreFille->id }}" />
                    <label for="nbfille{{ $nombreFille->id }}"
                        class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-2 border-supaGirlRose bg-white 
                        py-2 px-3 text-center text-green-gs hover:text-white peer-checked:text-white transition-all duration-200">{{ $nombreFille->getTranslation('name', app()->getLocale()) }}</label>
                </div>
            @endforeach

        </div>









       <div class="my-2 flex items-center justify-center gap-2 flex-wrap">
       
        <x-filters.closest-only-filter-button 
                wire:model.live="showClosestOnly"
                :loading-target="'showClosestOnly'"
                :label="'salon-search.filter_by_closest_only'"
                :icon="'images/icons/nearHot.png'"
                class="flex-1"
            />
        
        <x-filters.distance-filter-button 
                wire:model.live="approximite"
                :loading-target="'approximite'"
                :label="'escort-search.filter_by_distance'"
                :icon="'images/icons/locationByDistance.png'"
                class="flex-1"
            />





       </div>


        
        <x-buttons.reset-button 
                wire:click="resetFilter" 
                class="w-56 m-auto p-2"
                :loading-target="'resetFilter'"
                translation="escort-search.reset_filters"
                loading-translation="escort-search.resetting"
            />

    </div>

    <div class="container mx-auto px-4 py-10 sm:py-20">
        <div class="font-roboto-slab text-green-gs mb-3 text-2xl font-bold sm:text-3xl">
            {{ $salonCount }}

            @if (!$showFiltreCanton)
                @if ($salonCount > 1)
                    @if ($maxDistanceSelected > 0)
                        {{ __('salon-search.results_around') }}
                        {{ str_replace(',', ' ', number_format($maxDistanceSelected, 0)) }} km
                    @else
                        {{ __('salon-search.results_no_aroud') }}
                    @endif
                @else
                    {{ __('salon-search.result') }}
                @endif
            @else
                {{ __('salon-search.result') }}
            @endif
        </div>
        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-4">
            @foreach ($salons as $salonData)
                @php
                    $salon = is_array($salonData) ? (object) $salonData['salon'] : $salonData;
                    $distance = is_array($salonData) ? round($salonData['distance'] ?? 0, 1) . ' km' : 'N/A';
                @endphp
                <livewire:salon_card wire:key='{{ $salon->id }}' name="{{ $salon->nom_salon }}"
                    canton="{{ $salon->canton?->nom ?? $salon->cantonget?->nom }}"
                    ville="{{ $salon->ville?->nom ?? $salon->villeget?->nom }}" avatar='{{ $salon->avatar }}'
                    salonId="{{ $salon->id }}" />
            @endforeach
        </div>
        <div class="mt-10">{{ $salons->links('pagination::simple-tailwind') }}</div>
    </div>
</div>

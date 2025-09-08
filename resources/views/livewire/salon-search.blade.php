<div>
    <div class="xl:py-10 py-5 bg-supaGirlRosePastel flex min-h-64 w-full flex-col items-center justify-center">
    <h1 class="font-roboto-slab text-green-gs mb-4 text-center text-sm sm:text-lg md:text-3xl font-bold">
            {{ __('salon-search.title') }}</h1>


        <div class="@if ($showFiltreCanton) block @else hidden @endif w-full">
            <x-salon-location-filters :cantons="$cantons" :villes="$villes" :selectedCanton="$selectedSalonCanton" :selectedVille="$selectedSalonVille"
                onCantonChange="chargeVille" cantonModel="selectedSalonCanton" villeModel="selectedSalonVille" />
        </div>



        @if ($approximite || $showClosestOnly)
            <div class="mx-auto mb-4 mt-1 w-full max-w-2xl rounded-lg bg-white p-4 shadow">
                <div class="">
                    <div class="space-y-2">
                        <div>
                            <div class="font-roboto-slab flex items-center justify-between">
                                <label
                                    class="font-roboto-slab text-green-gs block text-sm font-medium">{{ __('escort-search.distance_km') }}
                                    {{ number_format($maxDistanceSelected, 0) }}</label>
                                <div wire:loading wire:target="maxDistanceSelected" class="flex items-center">
                                    <svg class="text-green-gs -ml-1 mr-2 h-4 w-4 animate-spin"
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
                                    <div
                                        class="font-roboto-slab mb-2 flex items-center justify-between text-xs text-gray-600 sm:hidden">
                                        <span
                                            class="font-roboto-slab text-green-gs whitespace-nowrap rounded-full px-2 py-1 text-xs">{{ str_replace(',', ' ', number_format($minDistance, 0)) }}
                                            km</span>
                                        <span
                                            class="font-roboto-slab text-green-gs whitespace-nowrap rounded-full px-2 py-1 text-xs">{{ str_replace(',', ' ', number_format($maxAvailableDistance, 0)) }}
                                            km</span>
                                    </div>
                                    <input type="range" wire:model.live="maxDistanceSelected"
                                        min="{{ $minDistance }}" max="{{ $maxAvailableDistance }}" step="0.01"
                                        class="[&::-webkit-slider-thumb]:bg-supaGirlRose [&::-webkit-slider-thumb]:focus:ring-supaGirlRose/50 h-2 w-full cursor-pointer appearance-none rounded-full bg-gray-200 outline-none transition-all duration-200 sm:hidden [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:shadow-lg [&::-webkit-slider-thumb]:transition-all [&::-webkit-slider-thumb]:hover:scale-110 [&::-webkit-slider-thumb]:focus:ring-2"
                                        style="background: linear-gradient(to right, #FDA5D6 0%, #FED5E9 {{ ($maxDistanceSelected / $maxAvailableDistance) * 100 }}%, #E5E7EB {{ ($maxDistanceSelected / $maxAvailableDistance) * 100 }}%, #E5E7EB 100%)">
                                </div>

                                <div
                                    class="flex hidden w-full items-center justify-between gap-2 text-xs text-gray-600 sm:block sm:flex sm:gap-3 md:gap-4">
                                    <span
                                        class="font-roboto-slab text-green-gs shrink-0 rounded-full px-2 py-1 text-xs">
                                        {{ str_replace(',', ' ', number_format($minDistance, 0)) }} km
                                    </span>
                                    <input type="range" wire:model.live="maxDistanceSelected"
                                        min="{{ $minDistance }}" max="{{ $maxAvailableDistance }}" step="1"
                                        class="[&::-webkit-slider-thumb]:bg-supaGirlRose [&::-webkit-slider-thumb]:focus:ring-supaGirlRose/50 h-2 w-full cursor-pointer appearance-none rounded-full bg-gray-200 outline-none transition-all duration-200 [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:shadow-lg [&::-webkit-slider-thumb]:transition-all [&::-webkit-slider-thumb]:hover:scale-110 [&::-webkit-slider-thumb]:focus:ring-2"
                                        style="background: linear-gradient(to right, #FDA5D6 0%, #FED5E9 {{ ($maxDistanceSelected / $maxAvailableDistance) * 100 }}%, #E5E7EB {{ ($maxDistanceSelected / $maxAvailableDistance) * 100 }}%, #E5E7EB 100%)">
                                    <span
                                        class="font-roboto-slab text-green-gs shrink-0 rounded-full px-2 py-1 text-xs">
                                        {{ str_replace(',', ' ', number_format($maxAvailableDistance, 0)) }} km
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <div class="md:my-2 my-0 flex flex-wrap   items-center justify-center gap-2 text-sm font-bold xl:text-base">

            <x-category-checkbox :categories="$categories" :selected-values="$selectedSalonCategories" model="selectedSalonCategories" prefixId="salon" />
        </div>

        <div class="text-green-gs my-2 flex flex-wrap items-center justify-center gap-2 text-sm font-bold">
            @foreach ($nombreFilles as $nombreFille)
                <div>
                    <input wire:model.live='nbFilles' class="peer hidden" name="nbFilles" type="radio"
                        id="nbfille{{ $nombreFille->id }}" value="{{ $nombreFille->id }}" />
                    <label for="nbfille{{ $nombreFille->id }}"
                        class="hover:bg-green-gs peer-checked:bg-green-gs border-supaGirlRose text-green-gs text-xs md:text-sm rounded-sm md:rounded-lg border border-2 bg-white md:px-3 md:py-2 px-2 py-1 text-center transition-all duration-200 hover:text-white peer-checked:text-white">
                        {{ $nombreFille->getTranslation('name', app()->getLocale()) }}
                    </label>
                </div>
            @endforeach
        </div>










        <div class="my-2 flex flex-wrap items-center justify-center gap-2 w-[90%] m-auto ">

            <x-filters.closest-only-filter-button wire:model.live="showClosestOnly" :loading-target="'showClosestOnly'" :label="'salon-search.filter_by_closest_only'"
                :icon="'images/icons/nearHot.png'" class="flex-1" />

            <x-filters.distance-filter-button wire:model.live="approximite" :loading-target="'approximite'" :label="'escort-search.filter_by_distance'"
                :icon="'images/icons/locationByDistance.png'" class="flex-1" />

        </div>

        @if (
            $showClosestOnly ||
                $approximite ||
                !empty($selectedSalonCanton) ||
                !empty($selectedSalonVille) ||
                !empty($selectedSalonCategories) ||
                !empty($selectedServices) ||
                !empty($nbFilles))
            <x-buttons.reset-button wire:click="resetFilter" class="m-auto w-56 p-2" :loading-target="'resetFilter'"
                translation="escort-search.reset_filters" loading-translation="escort-search.resetting" />
        @endif

    </div>

    <div class=" md:w-[95%]  mx-auto px-1 sm:px-4 py-2 lg:py-5">
    <div class="font-roboto-slab text-green-gs mb-3 text-xs sm:text-sm md:text-base lg:text-xl font-bold xl:text-2xl">
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
        <div class="grid grid-cols-2 gap-2
        sm:grid-cols-3
        md:grid-cols-4
        lg:grid-cols-5
        xl:grid-cols-5
        2xl:grid-cols-6
        
        ">
            @foreach ($salons as $salonData)
                @php
                    $salon = is_array($salonData) ? (object) $salonData['salon'] : $salonData;
                    $distance = is_array($salonData) ? round($salonData['distance'] ?? 0, 1) . ' km' : 'N/A';
                @endphp
                <livewire:salon_card wire:key='{{ $salon->id }}' name="{{ $salon->nom_salon }}"
                    canton="{{ $salon->canton?->nom ?? $salon->cantonget?->nom }}"
                    ville="{{ $salon->ville?->nom ?? $salon->villeget?->nom }}" avatar='{{ $salon->avatar }}'
                    isPause="{{ $salon->is_profil_pause }}" salonId="{{ $salon->id }}" />
            @endforeach
        </div>
        <div class="mt-10">{{ $salons->links('pagination::simple-tailwind') }}</div>

        @if ($salonCount == 0)
            <div class="flex flex-col items-center justify-center px-4 py-10">
                <p class="mb-4 text-xl font-semibold text-gray-800">
                    {{ __('escort-search.filtreApply') }}
                </p>

                <div class="w-full space-y-6 rounded-lg bg-white p-6 shadow-md">
                    {{-- Canton, Ville, Genre en ligne --}}
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        @if (isset($filterApplay['selectedCanton']) && $filterApplay['selectedCanton'])
                            <div class="flex flex-wrap items-center justify-center gap-2">
                                <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.canton') }} :
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm text-green-800">
                                        {{ $filterApplay['selectedCanton']['nom'] }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if (isset($filterApplay['selectedVille']) && $filterApplay['selectedVille'])
                            <div class="flex flex-wrap items-center justify-center gap-2">
                                <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.ville') }} :</p>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm text-blue-800">
                                        {{ $filterApplay['selectedVille']['nom'] }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Catégories --}}
                    @if (isset($filterApplay['selectedCategories']) && $filterApplay['selectedCategories'])
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.categories') }} :
                            </p>
                            <div class="flex flex-wrap gap-2">

                                <span
                                    class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">{{ $filterApplay['selectedCategories']['nom'] }}</span>

                            </div>
                        </div>
                    @endif



                    {{-- NbFille --}}
                    @if (isset($filterApplay['nbFilles']) && $filterApplay['nbFilles'])
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.nbFille') }} :</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($filterApplay['nbFilles'] as $nbFille)
                                    <span
                                        class="rounded-full bg-indigo-100 px-3 py-1 text-sm text-indigo-800">{{ $nbFille['name'] }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        @endif

    </div>
</div>

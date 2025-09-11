<?php
$nb_escorts = is_array($escorts) ? count($escorts) : $escorts->count();
?>
<div x-data="{
    'dropdownData': '',
    'currentLocale': '{{ app()->getLocale() }}',
    approximite: false,
    getTranslatedName(nameObj) {
        if (!nameObj) return '';
        const locale = this.currentLocale;
        return nameObj[locale] || nameObj['en'] || Object.values(nameObj)[0] || '';
    },
    approximiteFunc() {

        this.approximite = !this.approximite;
    },
    async fetchDropdownData() {
        try {
            const response = await fetch('{{ route('dropdown.data') }}');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            this.dropdownData = data;

        } catch (error) {
            console.error('Error loading dropdown data:', error);
            // You might want to show an error message to the user here
        }
    }
}" x-init="fetchDropdownData()">


    <div class="xl:py-10 py-5 bg-supaGirlRosePastel flex min-h-64 w-full flex-col items-center justify-center">
        <h1 class="font-roboto-slab text-green-gs mb-4 text-center text-sm sm:text-lg md:text-3xl font-bold">
            {{ __('escort-search.discover_escorts') }}
        </h1>
        <div class="@if ($showFiltreCanton) block @else hidden @endif w-full">
            <x-escort-filters :cantons="$cantons" :villes="$villes" :genres="$genres" :selectedCanton="$selectedCanton" :selectedVille="$selectedVille"
                :selectedGenre="$selectedGenre" class="mb-3" />
        </div>



        @if ($approximite || $showClosestOnly)
           <div class="flex flex-col items-center justify-between w-full  sm:flex-row md:w-[90%] lg:w-[70%] xl:w-[60%] 2xl:w-[50%] ">
           <div class="mx-auto mb-2 mt-1 w-[80%] max-w-2xl rounded-lg bg-white p-4 shadow">
                <div class="">
                    <div class="space-y-2">
                        <div>
                            <div class="font-roboto-slab flex items-center justify-between">
                               {{--  <label
                                    class="font-roboto-slab text-green-gs block text-sm font-medium">{{ __('escort-search.distance_km') }}
                                    {{ number_format($maxDistanceSelected, 0) }}</label> --}}
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

            <div class="min-w-[100px] md:w-[100px] max-w-xs">
                <x-selects.genre-select :genres="$genres" :selectedGenre="$selectedGenre" class="w-full" />
            </div>
           </div>
        @endif

        <x-category-select-escort :categories="$categories" :selectedCategories="$selectedCategories ?? []" class="mx-2 my-2 sm:my-3 md:my-4 
        " />

        <div class="flex flex-wrap items-center justify-center gap-2 px-2 sm:px-4 sm:gap-3 md:gap-4">


            <x-filters.closest-only-filter-button wire:model.live="showClosestOnly" :loading-target="'showClosestOnly'"
                :label="'escort-search.filter_by_closest_only'" :icon="'images/icons/nearHot.png'" class="flex-1" />


            <x-filters.distance-filter-button wire:model.live="approximite" :loading-target="'approximite'" :label="'escort-search.filter_by_distance'"
                :icon="'images/icons/locationByDistance.png'" class="flex-1" />

            <button data-modal-target="search-escorte-modal" data-modal-toggle="search-escorte-modal"
                class="font-roboto-slab hover:bg-green-gs border-supaGirlRose text-green-gs focus:ring-green-gs group flex w-full items-center justify-center gap-2 rounded-lg border border-2 bg-white px-2.5 py-2 text-sm transition-all duration-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                w-[100px] sm:w-auto sm:px-4
                text-xs sm:text-xs md:text-sm">

                <img src="{{ url('images/icons/moreFilter.png') }}" class="sm:h-6 sm:w-6 h-4 w-4"
                    alt="icon {{ __('escort-search.more_filters') }}" />
                {{ __('escort-search.more_filters') }}


            </button>

        </div>


        @if (
            $approximite ||
                $showClosestOnly ||
                !empty($selectedCanton) ||
                !empty($selectedVille) ||
                !empty($selectedGenre) ||
                !empty($selectedCategories) ||
                !empty($selectedServices) ||
                !empty($autreFiltres))
            <div class=" mt-2 sm:mt-3 md:mt-4 lg:mt-5 xl:mt-5 flex justify-center">
                <x-buttons.reset-button wire:click="resetFilter" class="m-auto w-56 p-2" :loading-target="'resetFilter'"
                    translation="escort-search.reset_filters" loading-translation="escort-search.resetting" />
            </div>
        @endif


    </div>




    {{-- Resultats --}}
    <div class=" md:w-[95%]  mx-auto px-1 sm:px-4 py-2 lg:py-5">
        <div class="font-roboto-slab text-green-gs mb-3 text-xs sm:text-sm md:text-base lg:text-xl font-bold xl:text-2xl">
            {{ $escortCount }}
            @if (!$showFiltreCanton)
                @if ($escorts->count() > 1)
                    @if ($maxDistance > 0)
                        {{ __('escort-search.results_around', ['distance' => str_replace(',', ' ', number_format($maxDistanceSelected, 0))]) }}
                    @else
                        {{ __('escort-search.results_no_aroud') }}
                    @endif
                @else
                    {{ __('escort-search.result') }}
                @endif
            @else
                {{ __('escort-search.result') }}
            @endif
        </div>
        <div class="grid grid-cols-2 gap-2
        sm:grid-cols-3
        md:grid-cols-4
        lg:grid-cols-5
        xl:grid-cols-5
        2xl:grid-cols-6
        
        ">
            @foreach ($escorts as $escortData)
                @php
                    $escort = is_array($escortData) ? (object) $escortData['escort'] : $escortData;
                @endphp
                <livewire:escort_card  name="{{ $escort->prenom }}" canton="{{ $escort->canton['nom'] ?? '' }}"
                    ville="{{ $escort->ville['nom'] ?? '' }}" avatar='{{ $escort->avatar }}'
                    escortId="{{ $escort->id }}" isOnline='{{ $escort->isOnline() }}'
                    profileVerifie="{{ $escort->profile_verifie }}" isPause="{{ $escort->is_profil_pause }}"
                    wire:key='{{ $escort->id }}' />
            @endforeach
        </div>



        <div class="mt-10">{{ $escorts->links('pagination::simple-tailwind') }}</div>

        @if ($escortCount == 0)
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

                        @if (isset($filterApplay['selectedGenre']) && $filterApplay['selectedGenre'])
                            <div class="flex flex-wrap items-center justify-center gap-2">
                                <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.genre') }} :</p>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="inline-flex items-center rounded-full bg-pink-100 px-3 py-1 text-sm text-pink-800">
                                        {{ $filterApplay['selectedGenre']['name'] }}
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
                                @foreach ($filterApplay['selectedCategories'] as $category)
                                    <span
                                        class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">{{ $category['nom'] }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Services --}}
                    @if (isset($filterApplay['selectedServices']) && $filterApplay['selectedServices'])
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.services') }} :</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($filterApplay['selectedServices'] as $service)
                                    <span
                                        class="rounded-full bg-indigo-100 px-3 py-1 text-sm text-indigo-800">{{ $service['nom'] }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif


                    @if (isset($filterApplay['ageInterval']) && $filterApplay['ageInterval'])
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.age') }} :</p>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">
                                    {{ $filterApplay['ageInterval']['min'] ?? '—' }} ans - {{ $filterApplay['ageInterval']['max'] ?? '—' }} ans
                                </span>
                            </div>
                        </div>
                    @endif
                    @if (isset($filterApplay['tarifInterval']) && $filterApplay['tarifInterval'])
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.tarif') }} :</p>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">
                                    {{ $filterApplay['tarifInterval']['min'] ?? '—' }} CHF - {{ $filterApplay['tarifInterval']['max'] ?? '—' }} CHF
                                </span>
                            </div>
                        </div>
                    @endif
                    @if (isset($filterApplay['tailleInterval']) && is_array($filterApplay['tailleInterval']))
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.height') }} :</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">
                                    {{ number_format(($filterApplay['tailleInterval']['min'] ?? 0) / 100, 2) }}m -
                                    {{ number_format(($filterApplay['tailleInterval']['max'] ?? 0) / 100, 2) }}m
                                </span>
                            </div>
                        </div>
                    @endif

                    {{-- Autres filtres --}}
                    @if (isset($filterApplay['autreFiltres']) && $filterApplay['autreFiltres'])
                        <div class="flex flex-wrap items-center justify-center gap-2">

                            <div class="flex flex-wrap items-center justify-center gap-2">
                                <p class="mb-1 text-sm font-medium text-gray-700">
                                    {{ __('escort-search.autre_filtres') }} :</p>
                                @foreach ($filterApplay['autreFiltres'] as $subKey => $subValue)
                                    @php
                                        $labels = [
                                            'origine' => __('escort-search.origin'),
                                            'mensuration' => __('escort-search.Silhouette'),
                                            'orientation' => __('escort-search.sexual_orientation'),
                                            'couleur_yeux' => __('escort-search.eyes'),
                                            'couleur_cheveux' => __('escort-search.hair'),
                                            'poitrine' => __('escort-search.breast_state'),
                                            'langues' => __('escort-search.language'),
                                            'pubis' => __('escort-search.pubis'),
                                            'tatouages' => __('escort-search.tattoo'),
                                            'mobilite' => __('escort-search.escort_mobility'),
                                            'taille_poitrine' => __('escort-search.breast_size'),
                                            'taille_poitrine_detail' => __('escort-search.breast_size'),
                                        ];
                                    @endphp

                                    @if (array_key_exists($subKey, $labels))
                                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm text-yellow-800">
                                            {{ $labels[$subKey] }} :
                                            {{ is_object($subValue) ? $subValue->name : $subValue }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif



    </div>

    {{-- Recherche modal --}}
    <div id="search-escorte-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 m-auto hidden h-[calc(100%-1rem)] w-full max-w-lg items-center justify-center md:inset-0"
        wire:ignore.self>
        <div class="relative max-h-full w-full">
            {{-- Modal content --}}
            <div class="relative m-2 rounded-lg bg-white shadow-sm">

                {{-- Modal header --}}
                <div class="flex justify-between rounded-t border-b border-gray-200 p-4 md:p-5">
                    <div>
                        <h3
                            class="font-roboto-slab text-green-gs text-md flex w-full items-center justify-center font-bold md:text-3xl">
                            {{ __('escort-search.more_filters') }}</h3>
                    </div>
                    <button type="button"
                        class="text-green-gs end-2.5 ms-auto inline-flex h-4 w-4 items-center justify-center rounded-lg bg-transparent text-sm hover:bg-gray-200 hover:text-amber-400 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="search-escorte-modal">
                        <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">{{ __('escort-search.close') }}</span>
                    </button>
                </div>

                {{-- Modal body --}}
                <div class="relative flex flex-col gap-3 p-2 md:p-5">
                    <div class="grid w-full grid-cols-2 items-center justify-between gap-3">
                        <template x-if="dropdownData['origines'] && dropdownData['origines'].length > 0">
                            <select wire:model.live="autreFiltres.origine" id="origine" name="origine"
                                class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900">
                                <option selected value="">{{ __('escort-search.origin') }}</option>
                                <template x-for="origine in dropdownData['origines']">
                                    <option :value="origine" x-text="origine"></option>
                                </template>
                            </select>
                        </template>

                        <select wire:model.live="autreFiltres.mensuration" id="mensuration" name="mensuration"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900">
                            <option selected value=""> {{ __('escort-search.Silhouette') }} </option>
                            <template x-for="mensuration in dropdownData['mensurations']">
                                <option :value="mensuration.id" x-text="mensuration.name[currentLocale]"></option>
                            </template>
                        </select>


                        <select wire:model.live="autreFiltres.langues" id="langue" name="langues"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs dark:focus:border-green-gs dark:focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                            <option selected value=""> {{ __('escort-search.language') }} </option>
                            <template x-for="langue in dropdownData['langues']">
                                <option :value="langue" x-text="langue"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.couleur_cheveux" id="cheveux" name="cheveux"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs dark:focus:border-green-gs dark:focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                            <option selected value=""> {{ __('escort-search.hair') }} </option>
                            <template x-for="cheveux in dropdownData['couleursCheveux']">
                                <option :value="cheveux.id" x-text="cheveux.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.couleur_yeux" id="yeux" name="yeux"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs dark:focus:border-green-gs dark:focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                            <option selected value=""> {{ __('escort-search.eyes') }} </option>
                            <template x-for="yeux in dropdownData['couleursYeux']">
                                <option :value="yeux.id" x-text="yeux.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.poitrine" id="poitrine" name="poitrine"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs dark:focus:border-green-gs dark:focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                            <option selected value=""> {{ __('escort-search.breast_state') }} </option>
                            <template x-for="poitrine in dropdownData['poitrines']">
                                <option :value="poitrine.id" x-text="poitrine.name[currentLocale]"></option>
                            </template>
                        </select>




                        <select wire:model.live="autreFiltres.pubis" id="pubis" name="pubus"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs dark:focus:border-green-gs dark:focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                            <option selected value=""> {{ __('escort-search.pubic_hair') }} </option>
                            <template x-for="pubis in dropdownData['pubis']">
                                <option :value="pubis.id" x-text="pubis.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.tatouages" id="tatouages" name="tatouages"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs dark:focus:border-green-gs dark:focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                            <option selected value=""> {{ __('escort-search.tattoo') }} </option>
                            <template x-for="tatous in dropdownData['tatouages']">
                                <option :value="tatous.id" x-text="tatous.name[currentLocale]"></option>
                            </template>
                        </select>


                        <select wire:model.live="autreFiltres.taille_poitrine" id="poitrine" name="poitrine"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs dark:focus:border-green-gs dark:focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                            <option selected value=""> {{ __('escort-search.breast_size') }} </option>
                            <option value="petite">{{ __('escort-search.petite') }}</option>
                            <option value="moyenne">{{ __('escort-search.moyenne') }}</option>
                            <option value="grosse">{{ __('escort-search.grosse') }}</option>
                            <option value="autre">{{ __('escort-search.other') }}</option>
                            {{-- <template x-for="poitrine in dropdownData['taillesPoitrine']">
                                <option value="poitrine" x-text="poitrine"></option>
                            </template> --}}
                        </select>
                        @if ($autre)
                            <select wire:model.live="autreFiltres.taille_poitrine_detail" id="poitrine"
                                name="poitrine_detail"
                                class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs dark:focus:border-green-gs dark:focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                                <option :selected="autreFiltres.taille_poitrine === 'autre'" value="">
                                    {{ __('escort-search.breast_size') }}</option>
                                <template x-for="poitrine in dropdownData['taillesPoitrine']">
                                    <option :value="poitrine" x-text="poitrine"></option>
                                </template>
                            </select>
                        @endif

                        <select wire:model.live="autreFiltres.mobilite" id="mobilite" name="mobilite"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs dark:focus:border-green-gs dark:focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                            <option selected value=""> {{ __('escort-search.escort_mobility') }} </option>
                            <template x-for="mobilite in dropdownData['mobilites']">
                                <option :value="mobilite.id" x-text="mobilite.name[currentLocale]"></option>
                            </template>
                        </select>
                        <div></div>

                    </div>
                    <div>
                  


                

                    <x-multi-range wireModel="ageInterval" :value="[$ageMin, $ageMax]" :min="$ageMin" :max="$ageMax"
                        :minvalue="$ageMin" :maxvalue="$ageMax" step="1" name='ageInterval'
                        label="{{ __('escort-search.age') }}" id="ageInterval" />
                    <x-multi-range wireModel="tarifInterval" :value="[$tarifMin, $tarifMax]" :min="$tarifMin" :max="$tarifMax"
                        :minvalue="$tarifMin" :maxvalue="$tarifMax" step="50" name='tarifInterval'
                        label="{{ __('escort-search.tarif') }} (CHF)" id="tarifInterval" />
                    <x-multi-range wireModel="tailleInterval" :value="[$tailleMin, $tailleMax]" :min="$tailleMin" :max="$tailleMax"
                        :minvalue="$tailleMin" :maxvalue="$tailleMax" step="1" name='tailleInterval'
                        label="{{ __('escort-search.height') }} (m)" id="tailleInterval" type="taille" />
                </div>

                {{-- Modal footer --}}
                <div
                    class="mt-2 flex items-center justify-between space-x-4 rounded-t border-t border-gray-200 p-4 md:p-5">
                    <button
                        class="font-roboto-slab text-green-gs flex items-center justify-center rounded-sm bg-gray-200 p-2 text-sm hover:bg-gray-300"
                        wire:click="resetFilterModal" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="resetFilterModal">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                <path fill="currentColor"
                                    d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z" />
                            </svg>
                        </span>
                        <span wire:loading wire:target="resetFilterModal">
                            <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                        <span class="ml-2">Réinitialiser</span>
                    </button>
                    <button
                        class="font-roboto-slab text-green-gs hover:text-supaGirlRosePastel bg-supaGirlRosePastel hover:bg-green-gs flex items-center justify-center rounded-sm p-2 text-sm"
                        data-modal-hide="search-escorte-modal">

                        <span class="">Rechercher ( {{ $escortCount }})</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        console.log("Escortes data", @json($escorts));

        navigator.geolocation.getCurrentPosition(function(position) {
            @this.set('latitudeUser', position.coords.latitude, true);
            @this.set('longitudeUser', position.coords.longitude, true);

        });

        console.log("Escortes data", @json($escorts));


        console.log("minAge", @json($ageMin));
        console.log("maxAge", @json($ageMax));
        console.log("minTaille", @json($tailleMin));
        console.log("maxTaille", @json($tailleMax));
        



        // Mise à jour des valeurs min/max lorsque les curseurs sont déplacés
        Livewire.on('updatedMinDistance', value => {
            document.getElementById('minDistanceValue').textContent = value;
        });

        Livewire.on('updatedMaxDistanceSelected', value => {
            document.getElementById('maxDistanceValue').textContent = value;
        });
    });
</script>
<!-- <script>
    window.addEventListener('reload-page', () => {
        location.reload();
    });
</script> -->

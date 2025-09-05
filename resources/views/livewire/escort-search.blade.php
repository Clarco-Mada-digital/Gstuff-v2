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


    <div class="py-15 flex min-h-72 w-full flex-col items-center justify-center bg-supaGirlRosePastel">
        <h1 class="font-roboto-slab text-green-gs mb-4 text-center text-3xl font-bold">
        {{ __('escort-search.discover_escorts') }}
        </h1>
   <div class=" w-full @if($showFiltreCanton) block @else hidden @endif">
   <x-escort-filters 
                :cantons="$cantons"
                :villes="$villes"
                :genres="$genres"
                :selectedCanton="$selectedCanton"
                :selectedVille="$selectedVille"
                :selectedGenre="$selectedGenre"
                class="mb-3"
            />
   </div>

           
     
        @if ($approximite || $showClosestOnly)
            <div class="mx-auto mb-4 mt-1 w-full max-w-2xl rounded-lg bg-white p-4 shadow">
                <div class="">
                    <div class="space-y-2">
                        <div>
                            <div class="font-roboto-slab flex items-center justify-between">
                                <label
                                    class="font-roboto-slab block text-sm font-medium text-green-gs">{{ __('escort-search.distance_km') }}
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
                                    <div class=" font-roboto-slab mb-2 flex items-center justify-between text-xs text-gray-600 sm:hidden">
                                        <span
                                            class="font-roboto-slab whitespace-nowrap rounded-full text-green-gs text-xs px-2 py-1">{{ str_replace(',', ' ', number_format($minDistance, 0)) }}
                                            km</span>
                                        <span
                                            class="font-roboto-slab whitespace-nowrap rounded-full text-green-gs text-xs px-2 py-1">{{ str_replace(',', ' ', number_format($maxAvailableDistance, 0)) }}
                                            km</span>
                                    </div>
                                        <input 
                                            type="range" 
                                            wire:model.live="maxDistanceSelected"
                                            min="{{ $minDistance }}" 
                                            max="{{ $maxAvailableDistance }}" 
                                            step="0.01"
                                            class="sm:hidden h-2 w-full cursor-pointer appearance-none rounded-full bg-gray-200 outline-none transition-all duration-200 [&::-webkit-slider-thumb]:h-5 
                                            [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-supaGirlRose [&::-webkit-slider-thumb]:shadow-lg [&::-webkit-slider-thumb]:transition-all [&::-webkit-slider-thumb]:hover:scale-110 [&::-webkit-slider-thumb]:focus:ring-2 [&::-webkit-slider-thumb]:focus:ring-supaGirlRose/50"
                                            style="background: linear-gradient(to right, #FDA5D6 0%, #FED5E9 {{ ($maxDistanceSelected / $maxAvailableDistance) * 100 }}%, #E5E7EB {{ ($maxDistanceSelected / $maxAvailableDistance) * 100 }}%, #E5E7EB 100%)"
                                        >

                                </div>

                                <div
                                    class="flex hidden w-full items-center justify-between gap-2 text-xs text-gray-600 sm:block sm:flex sm:gap-3 md:gap-4">
                                    <span
                                        class="font-roboto-slab shrink-0 rounded-full  px-2 py-1 text-xs text-green-gs">
                                        {{ str_replace(',', ' ', number_format($minDistance, 0)) }} km
                                    </span>
                                    <input 
                                            type="range" 
                                            wire:model.live="maxDistanceSelected"
                                            min="{{ $minDistance }}" 
                                            max="{{ $maxAvailableDistance }}" 
                                            step="1"
                                            class="h-2 w-full cursor-pointer appearance-none rounded-full bg-gray-200 outline-none transition-all duration-200 [&::-webkit-slider-thumb]:h-5 
                                            [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-supaGirlRose [&::-webkit-slider-thumb]:shadow-lg [&::-webkit-slider-thumb]:transition-all [&::-webkit-slider-thumb]:hover:scale-110 [&::-webkit-slider-thumb]:focus:ring-2 [&::-webkit-slider-thumb]:focus:ring-supaGirlRose/50"
                                            style="background: linear-gradient(to right, #FDA5D6 0%, #FED5E9 {{ ($maxDistanceSelected / $maxAvailableDistance) * 100 }}%, #E5E7EB {{ ($maxDistanceSelected / $maxAvailableDistance) * 100 }}%, #E5E7EB 100%)"
                                        >
                                    <span
                                        class="font-roboto-slab shrink-0 rounded-full  px-2 py-1 text-xs text-green-gs">
                                        {{ str_replace(',', ' ', number_format($maxAvailableDistance, 0)) }} km
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full min-w-[200px] max-w-xs">
            <x-selects.genre-select 
                :genres="$genres"
                :selectedGenre="$selectedGenre"
                class="w-full"
            />
        </div>
        @endif

        <x-category-select-escort 
            :categories="$categories" 
            :selectedCategories="$selectedCategories ?? []"
            class="mx-4 my-3 md:my-4"
        />

        <div class="mt-5 flex flex-wrap items-center justify-center gap-3 px-4 sm:gap-4">


            <x-filters.closest-only-filter-button 
                wire:model.live="showClosestOnly"
                :loading-target="'showClosestOnly'"
                :label="'escort-search.filter_by_closest_only'"
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

            <button data-modal-target="search-escorte-modal" data-modal-toggle="search-escorte-modal"
                class="font-roboto-slab hover:bg-green-gs group flex w-full items-center justify-center gap-2 rounded-lg border border-2 border-supaGirlRose bg-white px-2.5 py-2 text-sm text-green-gs
                 transition-all duration-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-green-gs focus:ring-offset-2 sm:w-auto sm:px-4 ">
                 
                <img src="{{ url('images/icons/moreFilter.png') }}" class="w-6 h-6"
                alt="icon {{ __('escort-search.more_filters') }}" />
                {{ __('escort-search.more_filters') }}
               

            </button>
    
        </div>

        
        @if(
           $approximite ||
           $showClosestOnly ||
           !empty($selectedCanton) ||
           !empty($selectedVille) ||
           !empty($selectedGenre) ||
           !empty($selectedCategories) ||
           !empty($selectedServices)||
           !empty($autreFiltres)
       )

        <div class="flex justify-center mt-5    ">
            <x-buttons.reset-button 
                wire:click="resetFilter" 
                class="w-56 m-auto p-2"
                :loading-target="'resetFilter'"
                translation="escort-search.reset_filters"
                loading-translation="escort-search.resetting"
            />
        </div>

      @endif

       
    </div>

 


    {{-- Resultats --}}
    <div class="container mx-auto px-4 py-10 xl:py-20">
        <div class="font-roboto-slab text-green-gs mb-3 text-2xl font-bold lg:text-3xl">
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
        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-4">
            @foreach ($escorts as $escortData)
                @php
                    $escort = is_array($escortData) ? (object) $escortData['escort'] : $escortData;
                @endphp
                <livewire:escort_card name="{{ $escort->prenom }}" canton="{{ $escort->canton['nom'] ?? '' }}"
                    ville="{{ $escort->ville['nom'] ?? '' }}" avatar='{{ $escort->avatar }}'
                    escortId="{{ $escort->id }}" isOnline='{{ $escort->isOnline() }}' 
                    profileVerifie="{{ $escort->profile_verifie }}"
                    isPause="{{ $escort->is_profil_pause }}"
                    wire:key='{{ $escort->id }}' />
            @endforeach
        </div>

      

        <div class="mt-10">{{ $escorts->links('pagination::simple-tailwind') }}</div>

        @if($escortCount == 0)
    <div class="flex flex-col items-center justify-center py-10 px-4">
        <p class="text-xl font-semibold text-gray-800 mb-4">
            {{ __('escort-search.filtreApply') }}
        </p>

        <div class="w-full  bg-white shadow-md rounded-lg p-6 space-y-6">
            {{-- Canton, Ville, Genre en ligne --}}
            <div class="flex flex-wrap gap-2 items-center justify-center">
                @if(isset($filterApplay['selectedCanton']) && $filterApplay['selectedCanton'])
                    <div class="flex flex-wrap gap-2 items-center justify-center">
                    <p class="text-sm font-medium text-gray-700 mb-1">{{ __('escort-search.canton') }} :</p>
                    <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                        {{ $filterApplay['selectedCanton']['nom'] }}
                    </span>
                    </div>
                </div>
                @endif

                @if(isset($filterApplay['selectedVille']) && $filterApplay['selectedVille'])
                 

                    <div class="flex flex-wrap gap-2 items-center justify-center">
                    <p class="text-sm font-medium text-gray-700 mb-1">{{ __('escort-search.ville') }} :</p>
                    <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
                        {{ $filterApplay['selectedVille']['nom'] }}
                    </span>
                    </div>
                </div>
                @endif

                @if(isset($filterApplay['selectedGenre']) && $filterApplay['selectedGenre'])
                   

                    
                    <div class="flex flex-wrap gap-2 items-center justify-center">
                    <p class="text-sm font-medium text-gray-700 mb-1">{{ __('escort-search.genre') }} :</p>
                    <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 bg-pink-100 text-pink-800 text-sm rounded-full">
                        {{ $filterApplay['selectedGenre']['name'] }}
                    </span>
                    </div>
                </div>

                @endif
            </div>

            {{-- Catégories --}}
            @if(isset($filterApplay['selectedCategories']) && $filterApplay['selectedCategories'])
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    <p class="text-sm font-medium text-gray-700 mb-1">{{ __('escort-search.categories') }} :</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($filterApplay['selectedCategories'] as $category)
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">{{ $category['nom'] }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Services --}}
            @if(isset($filterApplay['selectedServices']) && $filterApplay['selectedServices'])
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    <p class="text-sm font-medium text-gray-700 mb-1">{{ __('escort-search.services') }} :</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($filterApplay['selectedServices'] as $service)
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">{{ $service['nom'] }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Autres filtres --}}
            @if(isset($filterApplay['autreFiltres']) && $filterApplay['autreFiltres'])
                <div class="flex flex-wrap gap-2 items-center justify-center">
                 
                    <div class="flex flex-wrap gap-2 items-center justify-center">
                    <p class="text-sm font-medium text-gray-700 mb-1">{{ __('escort-search.autre_filtres') }} :</p>
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

                            @if(array_key_exists($subKey, $labels))
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">
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
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)]
         max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 "
        wire:ignore.self>
        <div class="relative max-h-full w-[97%] p-4 lg:w-[60%]">
            {{-- Modal content --}}
            <div class="relative rounded-lg bg-white shadow-sm bg-fieldBg">

                {{-- Modal header --}}
                <div
                    class="flex  justify-between rounded-t border-b border-gray-200 p-4 md:p-5 ">
                    <div>
                    <h3
                        class="font-roboto-slab text-green-gs flex w-full items-center justify-center text-2xl font-bold md:text-3xl">
                        {{ __('escort-search.more_filters') }}</h3>
                    </div>
                    <button type="button"
                        class="text-green-gs end-2.5 ms-auto inline-flex h-4 w-4 items-center justify-center rounded-lg bg-transparent text-sm hover:bg-gray-200 hover:text-amber-400 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="search-escorte-modal">
                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">{{ __('escort-search.close') }}</span>
                    </button>
                </div>

                {{-- Modal body --}}
                <div class="relative flex flex-col  gap-3 p-4 md:p-5 md:pb-20 h-[70vh] md:h-[60vh]  overflow-y-auto">
                    <div class="flex items-center justify-between mt-4">
                            <!-- Titre à gauche -->
                            <h3 class="font-roboto-slab text-green-gs text-2xl md:text-3xl">
                                {{ __('escort-search.service_categories') }}
                            </h3>

                            <!-- Pagination à droite -->
                            <div class="flex items-center gap-2">
                                @if ($services->onFirstPage())
                                    <span class="p-2 rounded-full bg-gray-200 text-gray-400 cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </span>
                                @else
                                    <button wire:click="previousPage('servicesPage')" 
                                        class="p-2 rounded-full bg-green-gs text-white hover:bg-supaGirlRose transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                @endif

                                @if ($services->hasMorePages())
                                    <button wire:click="nextPage('servicesPage')" 
                                        class="p-2 rounded-full bg-green-gs text-white hover:bg-supaGirlRose transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                @else
                                    <span class="p-2 rounded-full bg-gray-200 text-gray-400 cursor-not-allowed">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>



                    <div x-data="{ open: true }" class="w-full">
                        <button @click="open = !open"
                            class="hover:bg-green-gs w-full rounded-lg border border-2 border-supaGirlRose text-green-gs hover:text-white p-2 text-left hover:text-amber-400 sm:hidden bg-fieldBg">
                            <div class="flex items-center justify-between">
                                <span class="font-medium">{{ __('escort-search.service_categories') }}</span>
                                <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transform transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div x-show="open" x-transition class="mt-2 sm:hidden">
                            <div class="flex flex-wrap items-center gap-4 h-[25vh] py-4 overflow-y-auto sm:hidden">
                                @foreach ($services as $service)
                                    <div class="my-1">
                                        <input wire:model.live='selectedServices' id="services-{{ $service->id }}"
                                            class="peer hidden" type="checkbox" name="{{ $service->nom }}"
                                            value="{{ $service->id }}" />
                                        <label for="services-{{ $service->id }}"
                                            class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-2 border-supaGirlRose
                                             text-green-gs hover:text-white p-1 text-center transition-all duration-200 hover:scale-[1.02]
                                              focus:outline-none focus:ring-2 focus:ring-supaGirlRose focus:ring-offset-2 peer-checked:text-white text-xs font-roboto-slab">
                                            {{ $service->nom }}
                                        </label>
                                    </div>
                                @endforeach

                              

                               
                            </div>
                         
                        </div>
                        <div class="hidden sm:block">
                            <div class="flex flex-wrap items-center gap-4">
                                @foreach ($services as $service)
                                    <div class="my-1">
                                        <input wire:model.live='selectedServices' id="services{{ $service->id }}"
                                            class="peer hidden" type="checkbox" name="{{ $service->nom }}"
                                            value="{{ $service->id }}" />
                                        <label for="services{{ $service->id }}"
                                        class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-2 border-supaGirlRose
                                             text-green-gs hover:text-white p-2 text-center transition-all duration-200 hover:scale-[1.02]
                                              focus:outline-none focus:ring-2 focus:ring-supaGirlRose focus:ring-offset-2 peer-checked:text-white text-sm font-roboto-slab">
                                            {{ $service->nom }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                        </div>
                        
                    </div>
                    <h3 class="text-green-gs font-roboto-slab text-2xl md:text-3xl">
                        {{ __('escort-search.other_filters') }}</h3>
                        <div
    class="grid w-full grid-cols-2 items-center justify-between gap-3 sm:grid-cols-2 md:grid-cols-3 2xl:grid-cols-4 h-[25vh] md:h-[40vh] overflow-y-auto md:overflow-visible">
                        <template x-if="dropdownData['origines'] && dropdownData['origines'].length > 0">
                            <select wire:model.live="autreFiltres.origine" id="origine" name="origine"
                                class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                                <option selected value="">{{ __('escort-search.origin') }}</option>
                                <template x-for="origine in dropdownData['origines']">
                                    <option :value="origine" x-text="origine"></option>
                                </template>
                            </select>
                        </template>

                        <select wire:model.live="autreFiltres.mensuration" id="mensuration" name="mensuration"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option selected value=""> {{ __('escort-search.Silhouette') }} </option>
                            <template x-for="mensuration in dropdownData['mensurations']">
                                <option :value="mensuration.id" x-text="mensuration.name[currentLocale]"></option>
                            </template>
                        </select>

                        <!-- <select wire:model.live="autreFiltres.orientation" id="orientation" name="orientation"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option selected value=""> {{ __('escort-search.sexual_orientation') }} </option>
                            <template x-for="orientation in dropdownData['oriantationSexuelles']">
                                <option :value="orientation.id" x-text="orientation.name[currentLocale]"></option>
                            </template>
                        </select> -->
                        <select wire:model.live="autreFiltres.langues" id="langue" name="langues"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option selected value=""> {{ __('escort-search.language') }} </option>
                            <template x-for="langue in dropdownData['langues']">
                                <option :value="langue" x-text="langue"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.couleur_cheveux" id="cheveux" name="cheveux"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option selected value=""> {{ __('escort-search.hair') }} </option>
                            <template x-for="cheveux in dropdownData['couleursCheveux']">
                                <option :value="cheveux.id" x-text="cheveux.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.couleur_yeux" id="yeux" name="yeux"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option selected value=""> {{ __('escort-search.eyes') }} </option>
                            <template x-for="yeux in dropdownData['couleursYeux']">
                                <option :value="yeux.id" x-text="yeux.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.poitrine" id="poitrine" name="poitrine"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option selected value=""> {{ __('escort-search.breast_state') }} </option>
                            <template x-for="poitrine in dropdownData['poitrines']">
                                <option :value="poitrine.id" x-text="poitrine.name[currentLocale]"></option>
                            </template>
                        </select>




                        <select wire:model.live="autreFiltres.pubis" id="pubis" name="pubus"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option selected value=""> {{ __('escort-search.pubic_hair') }} </option>
                            <template x-for="pubis in dropdownData['pubis']">
                                <option :value="pubis.id" x-text="pubis.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.tatouages" id="tatouages" name="tatouages"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option selected value=""> {{ __('escort-search.tattoo') }} </option>
                            <template x-for="tatous in dropdownData['tatouages']">
                                <option :value="tatous.id" x-text="tatous.name[currentLocale]"></option>
                            </template>
                        </select>






                        <select wire:model.live="autreFiltres.taille_poitrine" id="poitrine" name="poitrine"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option selected value=""> {{ __('escort-search.breast_size') }} </option>
                            <option value="petite">{{ __('escort-search.petite') }}</option>
                            <option value="moyenne">{{ __('escort-search.moyenne') }}</option>
                            <option value="grosse">{{ __('escort-search.grosse') }}</option>
                            <option value="autre">{{ __('escort-search.other') }}</option>
                            {{-- <template x-for="poitrine in dropdownData['taillesPoitrine']">
                                <option value="poitrine" x-text="poitrine"></option>
                            </template> --}}
                        </select>
                        @if($autre)
                        <select wire:model.live="autreFiltres.taille_poitrine_detail" id="poitrine" name="poitrine_detail"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option :selected="autreFiltres.taille_poitrine === 'autre'" value="">{{ __('escort-search.breast_size') }}</option>                          
                            <template x-for="poitrine in dropdownData['taillesPoitrine']">
                                <option :value="poitrine" x-text="poitrine"></option>
                            </template>
                        </select>
                        @endif















                        <select wire:model.live="autreFiltres.mobilite" id="mobilite" name="mobilite"
                        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab p-2 text-gray-900 focus:border-green-gs focus:ring-green-gs dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-green-gs dark:focus:ring-green-gs">
                        <option selected value=""> {{ __('escort-search.escort_mobility') }} </option>
                            <template x-for="mobilite in dropdownData['mobilites']">
                                <option :value="mobilite.id" x-text="mobilite.name[currentLocale]"></option>
                            </template>
                        </select>
                        <div></div>
                        <x-multi-range :min="18" :max="100" :minvalue="25" :maxvalue="75"
                            step="1" name='age' label='{{ __('escort-search.age') }}' id="age" />
                        <x-multi-range :min="90" :max="200" :minvalue="120" :maxvalue="175"
                            step="1" name='tailles' label='{{ __('escort-search.height') }} (cm)'
                            id="tailles" />
                        <x-multi-range :min="100" :max="1000" :minvalue="150" :maxvalue="550"
                            step="50" name='tarifs' label='{{ __('escort-search.rates') }} (CHF)'
                            id="tarifs" />
                    </div>
                </div>

                {{-- Modal footer --}}
                <div class="flex justify-between items-center space-x-4 rounded-t border-t border-gray-200 p-4 md:p-5">
                    <button class="flex items-center justify-center p-2 font-roboto-slab text-green-gs bg-gray-200 rounded-sm text-sm hover:bg-gray-300" wire:click="resetFilter" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="resetFilter">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                                <path fill="currentColor" d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z" />
                            </svg>
                        </span>
                        <span wire:loading wire:target="resetFilter">
                            <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <span class="ml-2">Réinitialiser</span>
                    </button>
                    <button class="flex items-center justify-center p-2 font-roboto-slab text-green-gs hover:text-supaGirlRosePastel bg-supaGirlRosePastel hover:bg-green-gs rounded-sm text-sm " data-modal-hide="search-escorte-modal">
                   
                        <span class="">Rechercher ( {{$escortCount }})</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
       

        navigator.geolocation.getCurrentPosition(function(position) {
            @this.set('latitudeUser', position.coords.latitude, true);
            @this.set('longitudeUser', position.coords.longitude, true);
         
        });

        const categories = @json($categories);

        console.log("categories log",categories);

        // Mise à jour des valeurs min/max lorsque les curseurs sont déplacés
        Livewire.on('updatedMinDistance', value => {
            document.getElementById('minDistanceValue').textContent = value;
        });

        Livewire.on('updatedMaxDistanceSelected', value => {
            document.getElementById('maxDistanceValue').textContent = value;
        });
    });
</script>

<div class="flex w-full flex-col items-center justify-center gap-2"
x-data="{
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
}" x-init="fetchDropdownData()"




>

    {{-- Loader --}}
    {{-- Loader amélioré --}}
    <div wire:loading
        wire:target="maxDistanceSelected,search,selectedCanton,selectedEscortCategories,
        selectedVille,selectedGenre,selectedCategories,gotoPage,previousPage,nextPage,resetFilters
        ,selectedSalonCategories,approximite,showClosestOnly,selectedOrigine,selectedLangue,ageInterval,tarifInterval,tailleInterval, autreFiltres"
        id="loader"
        class="w-full z-50 absolute top-0 left-0">
                                            <div class="w-full bg-gray-200  h-1">
                                                <div class="bg-green-gs h-1 animate-progress"></div>
                                            </div>
                                        </div>



    <div class="py-5 bg-supaGirlRosePastel flex min-h-64 w-full flex-col items-center justify-center px-2 md:px-5 relative">
    
        <h1 class="font-roboto-slab text-green-gs mb-5 text-center text-sm sm:text-lg md:text-3xl font-bold">
        {{ __('escort-search.discover_escorts') }}
        </h1>

        <form wire:submit.prevent="search" class="container flex w-full flex-col items-center justify-center 
        
        gap-2
        
        sm:w-[90%] 
        md:w-full
        lg:w-[90%] 
        xl:w-[90%] 
        2xl:w-[90%] 


        
        
        ">
           




            {{-- Filtres dynamiques --}}
            <div class="flex w-full flex-col gap-4">
                {{-- Filtres pour Escort --}}
               

               


                {{-- Filtres par distance --}}
                @if ($approximite || $showClosestOnly)
                    <div class="mx-auto  mt-1 w-full max-w-2xl rounded-lg bg-white p-4 shadow">
                        <div class="">
                            <div class="space-y-2">
                                <div>
                                    <div class="relative pt-1">
                                       
                                        <div
                                            class="flex  w-full items-center justify-between gap-2 text-xs text-gray-600 sm:block sm:flex sm:gap-3 md:gap-4">
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

                @else
                <div class="flex flex-row w-full items-center justify-center gap-4 sm:flex-row md:w-[70%] lg:w-[60%] xl:w-[60%] m-auto">
                        
                        <div class="@if ($userType === 'salon' || $userType === 'escort') block @else hidden @endif w-full sm:w-1/3">
                            <x-selects.canton-select :cantons="$cantons" :selectedCanton="$selectedCanton" class="w-full " />
                        </div>
                        <div class="@if ($userType === 'salon' || $userType === 'escort') block @else hidden @endif w-full sm:w-1/3">
                            <x-selects.ville-select :villes="$villes" :selectedVille="$selectedVille" class="w-full" :disabled="!$selectedCanton" />
                        </div>
                
                        <div class="@if ($userType === 'escort') block @else hidden @endif w-full sm:w-1/3">
                            <x-selects.genre-select :genres="$genres" :selectedGenre="$selectedGenre" class="w-full" />
                        </div>
                
                </div>
                @endif



                <div
                    class="@if ($userType === 'escort') block @else hidden @endif flex flex-wrap items-center justify-center gap-2 ">
                    <x-category-checkbox :categories="$escortCategories" :selected-values="$selectedEscortCategories" model="selectedEscortCategories"
                        prefixId="escort" />
                </div>


                {{-- Filtres pour Salon --}}
                <div
                    class="@if ($userType === 'salon') block @else hidden @endif flex flex-wrap items-center justify-center gap-2 text-sm font-bold xl:text-base">
                    <x-category-checkbox :categories="$salonCategories" :selected-values="$selectedSalonCategories" model="selectedSalonCategories"
                        prefixId="salon" />
                </div>

                <div class="@if ($userType === 'salon' || $userType === 'escort') block @else hidden @endif my-2 flex flex-wrap items-center justify-center gap-2 w-full md:w-[90%] m-auto ">
                    <x-filters.closest-only-filter-button wire:model.live="showClosestOnly" :loading-target="'showClosestOnly'" :label="'salon-search.filter_by_closest_only'"
                        :icon="'images/icons/nearHot.png'" class="flex-1"/>
                    <x-filters.distance-filter-button wire:model.live="approximite" :loading-target="'approximite'" :label="'escort-search.filter_by_distance'"
                        :icon="'images/icons/locationByDistance.png'" class="flex-1"/>

                        <button data-modal-target="search-escorte-modal" data-modal-toggle="search-escorte-modal"
                    class="font-roboto-slab hover:bg-green-gs border-supaGirlRose text-green-gs focus:ring-green-gs group flex w-full items-center justify-center gap-2 rounded-lg border border-2 bg-white px-2.5 py-2 text-sm transition-all duration-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    w-[100px] sm:w-auto sm:px-4
                    text-xs sm:text-xs lg:text-sm">

                    <img src="{{ url('images/icons/moreFilter.png') }}" class="sm:h-6 sm:w-6 h-4 w-4"
                        alt="icon {{ __('escort-search.more_filters') }}" />
                    {{ __('escort-search.more_filters') }}


            </button>

                        {{-- Bouton de réinitialisation --}}
                    @if ($userType !== 'all')
                    @if($this->isAnyFilterApplied())
                            <x-buttons.reset-button wire:click="resetFilters" class=" p-2" :loading-target="'resetFilters'"
                                translation="escort-search.reset_filters" loading-translation="escort-search.resetting" />
                        @endif
                    @endif
                </div>
            </div>

           
            
        </form>
    </div>

    {{-- Listing des utilisateurs --}}
    <div class=" flex flex-wrap items-center justify-center md:w-[95%]  mx-auto px-1 sm:px-4 py-1 lg:py-5 ">
            @if ($escortCount > 0 && ($countSelectedAutreFiltres > 0 && $countSelectedAutreFiltres <= 5))
            <div class="w-full text-left">
                <div class="flex flex-wrap items-center gap-2">
                    <h4 class="text-xs font-bold text-gray-800">{{ __('escort-search.filtreActifOne') }} :</h4>
                    <span class="font-roboto-slab text-green-gs text-xs  font-bold  rounded-full bg-gray-100 px-3 py-1">
                        @foreach ($selecterAutreFiltresInfo as $key => $value)
                            {{ $value }} ,
                        @endforeach
                    </span>
                </div>
            </div>
            @endif

            @if ($escortCount > 0 && ($countSelectedAutreFiltres > 5))
                <div class="w-full text-left">
                    <h4 class="text-xs font-semibold text-gray-800">{{ $countSelectedAutreFiltres }} {{ __('escort-search.filtreActifMany') }}</h4>
                </div>
            @endif
            @if ($escortCount > 0)
            <div class="font-roboto-slab text-green-gs mb-3 text-xs  lg:text-xl font-bold xl:text-2xl w-full text-start">
            {{ $escortCount }}
                @if ($users->count() > 1)
                    @if ($maxDistanceSelected > 0)
                        {{ __('escort-search.results_around', ['distance' => str_replace(',', ' ', number_format($maxDistanceSelected, 0))]) }}
                    @else
                        {{ __('escort-search.results_no_aroud') }}
                    @endif
                @else
                    {{ __('escort-search.result') }}
                @endif
           
        </div>    
            @endif

    
    <div 
            class="grid grid-cols-2 gap-2
        sm:grid-cols-3
        md:grid-cols-4
        lg:grid-cols-5
        xl:grid-cols-5
        2xl:grid-cols-6 
       
        
        "
            style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent"
            wire:key="users-list">
            @foreach ($users as $user)
                <livewire:escort-card name="{{ $user->prenom ?? $user->nom_salon }}"
                    canton="{{ $user->canton['nom'] ?? 'Inconnu' }}" ville="{{ $user->ville['nom'] ?? 'Inconnu' }}"
                    avatar="{{ $user->avatar }}" escortId="{{ $user->id }}" isOnline="{{ $user->isOnline() }}"
                    wire:key="component-{{ $user->id }}" isPause="{{ $user->is_profil_pause }}" />
            @endforeach
        </div>

        {{-- Pagination --}}
        @if ($users->hasPages())
            <div class="mt-8 flex items-center justify-center space-x-2">
                <button wire:click="previousPage"
                    class="font-roboto-slab text-green-gs border-green-gs hover:bg-supaGirlRosePastel cursor-pointer rounded border px-4 py-2"
                    @disabled($users->onFirstPage())>
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div class="hidden space-x-1 md:flex">
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        <button wire:click="gotoPage({{ $page }})"
                            class="font-roboto-slab border-green-gs text-green-gs {{ $users->currentPage() === $page ? 'bg-green-gs text-white' : 'hover:bg-gray-100' }} flex h-10 w-10 cursor-pointer items-center justify-center rounded border">
                            {{ $page }}
                        </button>
                    @endforeach
                </div>
                <button wire:click="nextPage"
                    class="font-roboto-slab text-green-gs border-green-gs hover:bg-supaGirlRosePastel cursor-pointer rounded border px-4 py-2"
                    @disabled(!$users->hasMorePages())>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        @endif

        {{-- Boutons de navigation du carrousel --}}
        <div id="arrowESScrollRight"
            class="absolute left-1 top-[40%] hidden h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow"
            data-carousel-prev>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
            </svg>
        </div>
        <div id="arrowESScrollLeft"
            class="absolute right-1 top-[40%] hidden h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow"
            data-carousel-next>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                <path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
            </svg>
        </div>
    </div>

    @if ($users->count() == 0)
        <div class="flex flex-col items-center justify-center px-4 py-10">
            <h1 class="font-roboto-slab text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
                {{ __('escort-search.result0') }}
            </h1>
            <p class="mb-4 text-xl font-semibold text-gray-800">
                {{ __('escort-search.filtreApply') }}
            </p>
            <div class="w-full space-y-6  bg-white p-6 ">
                @if (isset($filterApplay['search']) && $filterApplay['search'])
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.search') }} :</p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="rounded-full bg-indigo-100 px-3 py-1 text-sm text-indigo-800">{{ $filterApplay['search'] }}</span>
                        </div>
                    </div>
                @endif
                <div class="flex flex-wrap items-center justify-center gap-2">
                    @if (isset($filterApplay['selectedCanton']) && $filterApplay['selectedCanton'])
                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.canton') }} :</p>
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
                @if (isset($filterApplay['selectedEscortCategories']) && $filterApplay['selectedEscortCategories'])
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.categories') }} :</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($filterApplay['selectedEscortCategories'] as $category)
                                <span
                                    class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">{{ $category['nom'] }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (isset($filterApplay['selectedSalonCategories']) && $filterApplay['selectedSalonCategories'])
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.categories') }} :</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($filterApplay['selectedSalonCategories'] as $category)
                                <span
                                    class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">{{ $category['nom'] }}</span>
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
                @if (
                    isset($filterApplay['tailleInterval']) &&
                    is_array($filterApplay['tailleInterval']) &&
                    (($filterApplay['tailleInterval']['min'] ?? 0) > 0 || ($filterApplay['tailleInterval']['max'] ?? 0) > 0)
                )
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


                @if (isset($filterApplay['selectedOrigine']) && is_array($filterApplay['selectedOrigine']) && count($filterApplay['selectedOrigine']) > 0)
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.origin') }} :</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($filterApplay['selectedOrigine'] as $origine)
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">{{ $origine }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif


                @if (isset($filterApplay['selectedLangue']) && $filterApplay['selectedLangue'])
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <p class="mb-1 text-sm font-medium text-gray-700"> {{ __('escort-search.language') }} :</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($filterApplay['selectedLangue'] as $langue)
                                <span
                                    class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">{{ $langue }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif


                
            </div>
        </div>
    @endif



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
                    <x-origine-select-escort :origineData="$origineData" />
                    <x-langue-select-escort :langueData="$langueData" />
                    <div class="grid w-full grid-cols-2 items-center justify-between gap-3">

                   

                        <!-- <template x-if="dropdownData['origines'] && dropdownData['origines'].length > 0">
                            <select wire:model.live="autreFiltres.origine" id="origine" name="origine"
                                class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900">
                                <option selected value="">{{ __('escort-search.origin') }}</option>
                                <template x-for="origine in dropdownData['origines']">
                                    <option :value="origine" x-text="origine"></option>
                                </template>
                            </select>
                        </template> -->

                        <select wire:model.live="autreFiltres.mensuration" id="mensuration" name="mensuration"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900">
                            <option selected value=""> {{ __('escort-search.Silhouette') }} </option>
                            <template x-for="mensuration in dropdownData['mensurations']">
                                <option :value="mensuration.id" x-text="mensuration.name[currentLocale]"></option>
                            </template>
                        </select>


                        <!-- <select wire:model.live="autreFiltres.langues" id="langue" name="langues"
                            class="border-supaGirlRose bg-fieldBg text-green-gs font-roboto-slab focus:border-green-gs focus:ring-green-gs dark:focus:border-green-gs dark:focus:ring-green-gs block w-full rounded-lg border border-2 p-2 text-xs text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400">
                            <option selected value=""> {{ __('escort-search.language') }} </option>
                            <template x-for="langue in dropdownData['langues']">
                                <option :value="langue" x-text="langue"></option>
                            </template>
                        </select> -->
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
                    <x-multi-range wireModel="ageInterval" :value="[$ageMin, $ageMax]" :min="$ageMin" :max="$ageMax"
                        :minvalue="$ageMin" :maxvalue="$ageMax" step="1" name='ageInterval'
                        label="{{ __('escort-search.age') }}" id="ageInterval" />
                    <x-multi-range wireModel="tarifInterval" :value="[$tarifMin, $tarifMax]" :min="$tarifMin" :max="$tarifMax"
                        :minvalue="$tarifMin" :maxvalue="$tarifMax" step="50" name='tarifInterval'
                        label="{{ __('escort-search.tarif') }} (CHF)" id="tarifInterval" />
                    <x-multi-range wireModel="tailleInterval" :value="[$tailleMin, $tailleMax]" :min="$tailleMin" :max="$tailleMax"
                        :minvalue="$tailleMin" :maxvalue="$tailleMax" step="0.1" name='tailleInterval'
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
    <style>
        @keyframes progress {
    0% { width: 0%; }
    25% { width: 25%; }
    50% { width: 50%; }
    75% { width: 75%; }
    100% { width: 100%; }
}

.animate-progress {
    animation: progress 5s linear infinite;
}

    </style>
</div>
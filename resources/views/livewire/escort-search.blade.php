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
        console.log('approximite', this.approximite);
        this.approximite = !this.approximite;
    },
    async fetchDropdownData() { await fetch('{{ route('dropdown.data') }}').then(response => response.json()).then(data => { this.dropdownData = data; }); }
}" x-init="fetchDropdownData()">
    @if (!$approximite)
        <div class="py-15 flex min-h-72 w-full flex-col items-center justify-center bg-[#E4F1F1]">
            <h1 class="font-dm-serif text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
                {{ __('escort-search.discover_escorts') }}</h1>
            <div
                class="mb-3 flex w-full flex-col items-center justify-center gap-2 px-4 text-sm md:flex-row xl:text-base">
                <select wire:model.live="selectedCanton" wire:change="chargeVille"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 xl:w-80 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                    <option selected value="">{{ __('escort-search.cantons') }}</option>
                    @foreach ($cantons as $canton)
                        <option wire:key='{{ $canton->id }}' value="{{ $canton->id }}"> {{ $canton->nom }} </option>
                    @endforeach
                </select>
                <select wire:model.live="selectedVille"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 xl:w-80 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    @if (!$villes) disabled @endif>
                    <option selected value="">
                        @if ($villes)
                            {{ __('escort-search.cities') }}
                        @else
                            {{ __('escort-search.choose_canton') }}
                        @endif
                    </option>
                    @foreach ($villes as $ville)
                        <option wire:key='{{ $ville->id }}' value="{{ $ville->id }}"> {{ $ville->nom }}
                        </option>
                    @endforeach
                </select>
                <select wire:model.live='selectedGenre'
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 xl:w-80 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                    <option selected value=''>{{ __('escort-search.gender') }}</option>
                    @foreach ($genres as $genre)
                        <option wire:key='{{ $genre->id }}' value="{{ $genre->id }}">
                            {{ $genre->getTranslation('name', app()->getLocale()) }} </option>
                    @endforeach
                </select>
            </div>
            <div class="my-2 flex flex-wrap items-center justify-center gap-2 text-sm font-bold xl:text-base">
                @foreach ($categories as $categorie)
                    <div>
                        <input wire:model.live='selectedCategories' class="peer hidden" type="checkbox"
                            id="escortCategorie{{ $categorie->id }}" name="{{ $categorie->nom }}"
                            value="{{ $categorie->id }}">
                        <label for="escortCategorie{{ $categorie->id }}"
                            class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-amber-400 bg-white p-2 text-center hover:text-amber-400 peer-checked:text-amber-400">{{ $categorie->nom }}</label>
                    </div>
                @endforeach
            </div>
            <div class="flex items-center justify-center gap-2">
                <button data-modal-target="search-escorte-modal" data-modal-toggle="search-escorte-modal"
                    class="font-dm-serif hover:bg-green-gs group mt-5 flex items-center gap-2 rounded-lg border border-gray-400 bg-white p-2 text-gray-600 hover:text-white">
                    {{ __('escort-search.more_filters') }}
                    <svg class="h-5 w-5 rounded-full bg-gray-300 p-1 group-hover:bg-gray-700"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <!-- Icon from All by undefined - undefined -->
                        <g fill="none" fill-rule="evenodd">
                            <path
                                d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
                            <path fill="currentColor"
                                d="M16 15c1.306 0 2.418.835 2.83 2H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 1 1 0-2h9.17A3 3 0 0 1 16 15m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2M8 9a3 3 0 0 1 2.762 1.828l.067.172H20a1 1 0 0 1 .117 1.993L20 13h-9.17a3.001 3.001 0 0 1-5.592.172L5.17 13H4a1 1 0 0 1-.117-1.993L4 11h1.17A3 3 0 0 1 8 9m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2m8-8c1.306 0 2.418.835 2.83 2H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 0 1 0-2h9.17A3 3 0 0 1 16 3m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2" />
                        </g>
                    </svg>
                </button>
                <button wire:click="approximiteFunc()"
                    class="font-dm-serif hover:bg-green-gs group mt-5 flex items-center gap-2 rounded-lg border border-gray-400 bg-white p-2 text-gray-600 hover:text-white">
                    {{ $approximite ? __('escort-search.filter_by_region') : __('escort-search.filter_by_distance') }}
                </button>
            </div>

            <button wire:click="resetFilter"
                class="font-dm-serif hover:bg-green-gs group my-2 flex items-center gap-2 rounded-lg border border-gray-400 bg-white p-2 text-gray-600 hover:text-white">
                {{ __('escort-search.reset_filters') }}
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                    <!-- Icon from All by undefined - undefined -->
                    <path fill="currentColor"
                        d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z" />
                </svg>
            </button>
        </div>
    @else
        <div class="py-15 flex min-h-72 w-full flex-col items-center justify-center bg-[#E4F1F1]">
            <h1 class="font-dm-serif text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
                {{ __('escort-search.discover_escorts') }}</h1>
            <div class="mx-auto mb-4 mt-1 w-full max-w-2xl rounded-lg bg-white p-4 shadow">
                <div class="mb-4">

                    <div class="space-y-6">
                        <div>
                            <div class="mb-2 mt-4 flex items-center justify-between">
                                <label class="block text-sm font-medium text-gray-700">{{ __('escort-search.distance_km') }}</label>
                                <div wire:loading wire:target="maxDistanceSelected" class="flex items-center">
                                    <svg class="-ml-1 mr-2 h-4 w-4 animate-spin text-green-600"
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


                                <div class="mb-2 flex items-center space-x-4 text-xs text-gray-600">
                                    <span
                                        class="rounded-full bg-gray-100 px-2 py-1">{{ str_replace(',', ' ', number_format($minDistance, 0)) }}
                                        km</span>
                                    <input type="range" wire:model.live="maxDistanceSelected"
                                        min="{{ $minDistance }}" max="{{ $maxAvailableDistance }}" step="1"
                                        class="h-2 flex-1 cursor-pointer appearance-none rounded-lg bg-gray-200">
                                    <span
                                        class="rounded-full bg-gray-100 px-2 py-1">{{ str_replace(',', ' ', number_format($maxAvailableDistance, 0)) }}
                                        km</span>

                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <button wire:click="approximiteFunc()"
                class="font-dm-serif hover:bg-green-gs border-green-gs group mx-auto mt-4 flex w-full max-w-xs items-center justify-center gap-2 rounded-lg border-2 bg-white px-6 py-3 text-gray-700 transition-all duration-300 hover:border-transparent hover:text-white hover:shadow-md">
                <span class="font-medium">{{ $approximite ? __('escort-search.filter_by_region') : __('escort-search.filter_by_distance') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>


        </div>
    @endif

    <div class="container mx-auto px-2 py-20">
        <div class="font-dm-serif text-green-gs mb-3 text-3xl font-bold">
            {{ $escorts->count() }}
            @if ($escorts->count() > 1)
                @if ($maxDistance > 0)
                    {{ __('escort-search.results_around', ['distance' => $maxDistance]) }}
                @else
                    {{ __('escort-search.results_no_aroud') }}
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
                    wire:key='{{ $escort->id }}' />
            @endforeach
        </div>
        <div class="mt-10">{{ $escorts->links('pagination::simple-tailwind') }}</div>
    </div>

    <!-- Recherche modal -->
    <div id="search-escorte-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
        wire:ignore.self>
        <div class="relative max-h-full w-[95%] p-4 lg:w-[60%]">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow-sm dark:bg-gray-700">

                <!-- Modal header -->
                <div
                    class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 md:p-5 dark:border-gray-600">
                    <h3 class="text-green-gs font-dm-serif flex w-full items-center justify-center text-3xl font-bold">
                        {{ __('escort-search.more_filters') }}</h3>
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

                <!-- Modal body -->
                <div class="relative flex flex-col items-center justify-center gap-3 p-4 md:p-5 md:pb-20">
                    <h3 class="text-green-gs font-dm-serif text-3xl">{{ __('escort-search.service_categories') }}</h3>
                    <div class="flex flex-wrap items-center gap-4">
                        @foreach ($services as $service)
                            <div class="my-1">
                                <input wire:model.live='selectedServices' id="services{{ $service->id }}"
                                    class="peer hidden" type="checkbox" name="{{ $service->nom }}"
                                    value="{{ $service->id }}" />
                                <label for="services{{ $service->id }}"
                                    class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-gray-400 p-2 text-center hover:text-amber-400 peer-checked:text-amber-400">{{ $service->nom }}</label>
                            </div>
                        @endforeach
                    </div>
                    <h3 class="text-green-gs font-dm-serif text-3xl">{{ __('escort-search.other_filters') }}</h3>
                    <div class="grid w-full grid-cols-1 items-center justify-between gap-3 xl:grid-cols-3">
                        <select wire:model.live="autreFiltres.origine" id="origine" name="origine"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.origin') }}</option>
                            <template x-for="origine in dropdownData['origines']">
                                <option :value="origine" x-text="origine"></option>
                            </template>
                        </select>
                        <!-- Debug Info -->




                        <select wire:model.live="autreFiltres.mensuration" id="mensuration" name="mensuration"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.measurements') }}</option>
                            <template x-for="mensuration in dropdownData['mensurations']">
                                <option :value="mensuration.id" x-text="mensuration.name[currentLocale]"></option>
                            </template>

                        </select>



                        <select wire:model.live="autreFiltres.orientation" id="orientation" name="orientation"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.sexual_orientation') }}</option>
                            <template x-for="orientation in dropdownData['oriantationSexuelles']">
                                <option :value="orientation.id" x-text="orientation.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.langues" id="langue" name="langues"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.language') }}</option>
                            <template x-for="langue in dropdownData['langues']">
                                <option :value="langue" x-text="langue"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.couleur_cheveux" id="cheveux" name="cheveux"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.hair') }}</option>
                            <template x-for="cheveux in dropdownData['couleursCheveux']">
                                <option :value="cheveux.id" x-text="cheveux.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.couleur_yeux" id="yeux" name="yeux"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.eyes') }}</option>
                            <template x-for="yeux in dropdownData['couleursYeux']">
                                <option :value="yeux.id" x-text="yeux.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.poitrine" id="poitrine" name="poitrine"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.breast_state') }}</option>
                            <template x-for="poitrine in dropdownData['poitrines']">
                                <option value="poitrine.id" x-text="poitrine.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.pubis" id="pubis" name="pubus"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.pubic_hair') }}</option>
                            <template x-for="pubis in dropdownData['pubis']">
                                <option value="pubis.id" x-text="pubis.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.tatouages" id="tatouages" name="tatouages"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.tattoo') }}</option>
                            <template x-for="tatous in dropdownData['tatouages']">
                                <option value="tatous.id" x-text="tatous.name[currentLocale]"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.taille_poitrine" id="poitrine" name="poitrine"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.breast_size') }}</option>
                            <template x-for="poitrine in dropdownData['taillesPoitrine']">
                                <option value="poitrine" x-text="poitrine"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.mobilite" id="mobilite" name="mobilite"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-amber-500 dark:focus:ring-amber-500">
                            <option selected value="">{{ __('escort-search.escort_mobility') }}</option>
                            <template x-for="mobilite in dropdownData['mobilites']">
                                <option value="mobilite.id" x-text="mobilite.name[currentLocale]"></option>
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
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('livewire:load');

        navigator.geolocation.getCurrentPosition(function(position) {
            @this.set('latitudeUser', position.coords.latitude, true);
            @this.set('longitudeUser', position.coords.longitude, true);
            console.log('Position mise à jour :', position.coords.latitude, position.coords.longitude);
        });

        // Mise à jour des valeurs min/max lorsque les curseurs sont déplacés
        Livewire.on('updatedMinDistance', value => {
            document.getElementById('minDistanceValue').textContent = value;
        });

        Livewire.on('updatedMaxDistanceSelected', value => {
            document.getElementById('maxDistanceValue').textContent = value;
        });
    });
</script>

<div>
    <div class="py-15 flex min-h-72 w-full flex-col items-center justify-center bg-[#E4F1F1]">
        <h1 class="font-dm-serif text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
            {{ __('salon-search.title') }}</h1>


        @if (!$approximite)
        <div class="mb-3 flex w-full flex-col items-center justify-center gap-2 px-4 text-sm md:flex-row xl:text-base">
            <select wire:model.live="selectedSalonCanton" wire:change="chargeVille"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 xl:w-80 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                <option selected value=''>{{ __('salon-search.cantons') }}</option>
                @foreach ($cantons as $canton)
                    <option wire:key='{{ $canton->id }}' value="{{ $canton->id }}"> {{ $canton->nom }} </option>
                @endforeach
            </select>
            <select wire:model.live="selectedVille"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 xl:w-80 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                @if (!$villes) disabled @endif>
                <option selected value="">
                    @if ($villes)
                        {{ __('salon-search.villes') }}
                    @else
                        {{ __('salon-search.select_canton') }}
                    @endif
                </option>
                @if (is_iterable($villes))
                    @foreach ($villes as $ville)
                        <option wire:key='{{ $ville->id }}' value="{{ $ville->id }}">{{ $ville->nom }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="my-2 flex flex-wrap items-center justify-center gap-2 text-sm font-bold xl:text-base">
            @foreach ($categories as $categorie)
                <div wire:key="{{ $categorie->id }}">
                    <input wire:model.live='selectedSalonCategories' class="peer hidden" type="checkbox"
                        id="salonCategorie{{ $categorie->id }}" name="{{ $categorie->nom }}"
                        value="{{ $categorie->id }}" />
                    <label for="salonCategorie{{ $categorie->id }}"
                        class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-amber-400 bg-white p-2 text-center hover:text-amber-400 peer-checked:text-amber-400">{{ $categorie->nom }}</label>
                </div>
            @endforeach
        </div>
        <div class="my-2 flex flex-wrap items-center justify-center gap-2 text-sm font-bold xl:text-base">

        @foreach ($nombreFilles as $nombreFille)
            <div>
                <input wire:model.live='nbFilles' class="peer hidden" name="{{ $nombreFille->id }}" type="checkbox" id="nbfille{{ $nombreFille->id }}"
                    value="{{ $nombreFille->id }}" />
                <label for="nbfille{{ $nombreFille->id }}"
                    class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-amber-400 bg-white p-2 text-center hover:text-amber-400 peer-checked:text-amber-400">{{ $nombreFille->getTranslation('name', app()->getLocale()) }}</label>
            </div>
        @endforeach

        </div>
        <button wire:click="approximiteFunc()" 
                class="font-dm-serif hover:bg-green-gs group mt-5 flex items-center gap-2 rounded-lg border border-gray-400 bg-white p-2 text-gray-600 hover:text-white">
            {{ $approximite ? 'Filtrer par région' : 'Filtrer par distance' }}
        </button>
        <button wire:click="resetFilter"
            class="font-dm-serif hover:bg-green-gs group my-2 flex items-center gap-2 rounded-lg border border-gray-400 bg-white p-2 text-gray-600 hover:text-white">
            {{ __('salon-search.reset_filters') }}
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                <path fill="currentColor"
                    d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z" />
            </svg>
        </button>
        @else
        
        <!-- <div class="w-full max-w-2xl mx-auto mb-8 p-4 bg-white rounded-lg shadow">
            <div class="space-y-6">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-sm text-gray-500">Distance (km)</label>
                        <div wire:loading wire:target="maxDistanceSelected" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm w-12">{{ str_replace(',', ' ', number_format($minDistance, 0)) }}</span>
                        <input type="range" 
                            wire:model.live="maxDistanceSelected"
                            min="{{ $minDistance }}"
                            max="{{ $maxAvailableDistance }}"
                            step="1"
                            class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        <span class="text-sm w-12 text-right">{{ str_replace(',', ' ', number_format($maxAvailableDistance, 0)) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <button wire:click="approximiteFunc()" 
                class="font-dm-serif hover:bg-green-gs group mt-5 flex items-center gap-2 rounded-lg border border-gray-400 bg-white p-2 text-gray-600 hover:text-white">
            {{ $approximite ? 'Filtrer par région' : 'Filtrer par distance' }}
        </button> -->

        <div class="w-full max-w-2xl mx-auto mb-2 mt-4 p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
    <div class="space-y-4">
        <div>
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-medium text-gray-700">Distance (km)</label>
                <div wire:loading wire:target="maxDistanceSelected" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                   
                </div>
            </div>
            
            <div class="relative pt-1">
         

                <div class="flex items-center space-x-4 text-xs text-gray-600 mb-2">
                <span class="px-2 py-1 bg-gray-100 rounded-full">{{ str_replace(',', ' ', number_format($minDistance, 0)) }} km</span>
                        <input type="range" 
                            wire:model.live="maxDistanceSelected"
                            min="{{ $minDistance }}"
                            max="{{ $maxAvailableDistance }}"
                            step="1"
                            class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                            <span class="px-2 py-1 bg-gray-100 rounded-full">{{ str_replace(',', ' ', number_format($maxAvailableDistance, 0)) }} km</span>

                    </div>
                
               
                
               
            </div>
        </div>
    </div>
</div>

<button 
    wire:click="approximiteFunc()" 
    class="font-dm-serif hover:bg-green-gs hover:shadow-md transition-all duration-300 group mt-6 flex items-center justify-center gap-2 rounded-lg border-2 border-green-gs bg-white px-6 py-3 text-gray-700 hover:text-white hover:border-transparent w-full max-w-xs mx-auto">
    <span class="font-medium">{{ $approximite ? 'Filtrer par région' : 'Filtrer par distance' }}</span>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
    </svg>
</button>
       
        @endif

       
    </div>

    <div class="container mx-auto px-2 py-20">
        <div class="font-dm-serif text-green-gs mb-3 text-3xl font-bold">
            {{ $salons->count() }}
            @if ($salons->count() > 1)
                @if ($maxDistance > 0)
                    {{ __('salon-search.results_around') }} {{ $maxDistance }} km
                @else
                    {{ __('salon-search.results_no_aroud') }}
                @endif
            @else
                {{ __('salon-search.result') }}
            @endif
        </div>
        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-4">
            @foreach ($salons as $salonData)
            @php
                $salon = is_array($salonData) ? (object)$salonData['salon'] : $salonData;
                $distance = is_array($salonData) ? round($salonData['distance'] ?? 0, 1) . ' km' : 'N/A';
            @endphp
                <livewire:salon_card wire:key='{{ $salon->id }}' name="{{ $salon->nom_salon }}"
                    canton="{{ $salon->canton?->nom ?? $salon->cantonget?->nom }}"
                     ville="{{ $salon->ville?->nom ?? $salon->villeget?->nom }}"
                    avatar='{{ $salon->avatar }}' salonId="{{ $salon->id }}" />
            @endforeach
        </div>
        <div class="mt-10">{{ $salons->links('pagination::simple-tailwind') }}</div>
    </div>
</div>

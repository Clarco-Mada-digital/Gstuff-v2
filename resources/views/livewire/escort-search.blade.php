<?php
$nb_escorts = is_array($escorts) ? count($escorts) : $escorts->count();
?>
<div x-data="{'dropdownData':'', async fetchDropdownData(){await fetch('{{route('dropdown.data')}}').then(response => response.json()).then(data => { this.dropdownData = data; }); }}" x-init="fetchDropdownData()">
    <div class="w-full min-h-72 flex flex-col items-center justify-center bg-[#E4F1F1] py-15">
        <h1 class="font-dm-serif font-bold text-green-gs text-xl xl:text-4xl text-center mb-5">{{__('escort-search.discover_escorts')}}</h1>
        <div class="w-full px-4 flex flex-col md:flex-row items-center justify-center text-sm xl:text-base gap-2 mb-3">
            <select wire:model.live="selectedCanton" wire:change="chargeVille" class="block w-full xl:w-80 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value="">{{__('escort-search.cantons')}}</option>
                @foreach ($cantons as $canton)
                <option wire:key='{{$canton->id}}' value="{{$canton->id}}"> {{$canton->nom}} </option>
                @endforeach
            </select>
            <select wire:model.live="selectedVille" class="block w-full xl:w-80 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" @if(!$villes) disabled @endif >
                <option selected value="">
                    @if ($villes)
                        {{__('escort-search.cities')}}
                    @else
                        {{__('escort-search.choose_canton')}}
                    @endif
                </option>
                @foreach ($villes as $ville)
                <option wire:key='{{$ville->id}}' value="{{$ville->id}}"> {{$ville->nom}} </option>
                @endforeach
            </select>
            <select wire:model.live='selectedGenre' class="block w-full xl:w-80 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected value=''>{{__('escort-search.gender')}}</option>
                <option value="femme">{{__('escort-search.female')}}</option>
                <option value="homme">{{__('escort-search.male')}}</option>
                <option value="trans">{{__('escort-search.trans')}}</option>
                <option value="gay">{{__('escort-search.gay')}}</option>
                <option value="lesbienne">{{__('escort-search.lesbian')}}</option>
                <option value="bisexuelle">{{__('escort-search.bisexual')}}</option>
                <option value="queer">{{__('escort-search.queer')}}</option>
            </select>
        </div>
        <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm my-2 xl:text-base">
            @foreach($categories as $categorie)
            <div>
                <input wire:model.live='selectedCategories' class="hidden peer" type="checkbox" id="escortCategorie{{$categorie->id}}" name="{{$categorie->nom}}" value="{{$categorie->id}}">
                <label for="escortCategorie{{$categorie->id}}" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:text-amber-400 peer-checked:bg-green-gs">{{$categorie->nom}}</label>
            </div>
            @endforeach
        </div>
        <button data-modal-target="search-escorte-modal" data-modal-toggle="search-escorte-modal" class="font-dm-serif text-gray-600 flex items-center gap-2 p-2 bg-white border border-gray-400 rounded-lg mt-5 hover:bg-green-gs hover:text-white group">
            {{__('escort-search.more_filters')}}
            <svg class="w-5 h-5 p-1 bg-gray-300 rounded-full group-hover:bg-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><!-- Icon from All by undefined - undefined --><g fill="none" fill-rule="evenodd"><path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M16 15c1.306 0 2.418.835 2.83 2H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 1 1 0-2h9.17A3 3 0 0 1 16 15m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2M8 9a3 3 0 0 1 2.762 1.828l.067.172H20a1 1 0 0 1 .117 1.993L20 13h-9.17a3.001 3.001 0 0 1-5.592.172L5.17 13H4a1 1 0 0 1-.117-1.993L4 11h1.17A3 3 0 0 1 8 9m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2m8-8c1.306 0 2.418.835 2.83 2H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 0 1 0-2h9.17A3 3 0 0 1 16 3m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2"/></g></svg>
        </button>
        <button wire:click="resetFilter" class="font-dm-serif text-gray-600 flex items-center gap-2 p-2 bg-white border border-gray-400 rounded-lg my-2 hover:bg-green-gs hover:text-white group">
            {{__('escort-search.reset_filters')}}
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><!-- Icon from All by undefined - undefined --><path fill="currentColor" d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z"/></svg>
        </button>
    </div>

    <div class="container mx-auto py-20 px-2">
        <div class="font-dm-serif text-green-gs font-bold text-3xl mb-3">
            {{ $escorts->count() }}
            @if($escorts->count() > 1)
                {{__('escort-search.results_around', ['distance' => $maxDistance])}}
            @else
                {{__('escort-search.result')}}
            @endif
        </div>
        <div class="grid 2xl:grid-cols-4 xl:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-2">
            @foreach ($escorts as $escort)
            <livewire:escort_card name="{{ $escort->prenom }}" canton="{{$escort->canton['nom'] ?? ''}}" ville="{{$escort->ville['nom'] ?? ''}}" avatar='{{$escort->avatar}}' escortId="{{$escort->id}}" isOnline='{{$escort->isOnline()}}' wire:key='{{$escort->id}}'/>
            @endforeach
        </div>
        <div class="mt-10">{{$escorts->links('pagination::simple-tailwind')}}</div>
    </div>

    <!-- Recherche modal -->
    <div id="search-escorte-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" wire:ignore.self>
        <div class="relative p-4 w-[95%] lg:w-[60%]  max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="w-full flex items-center justify-center text-3xl text-green-gs font-dm-serif font-bold">{{__('escort-search.more_filters')}}</h3>
                    <button type="button" class="end-2.5 text-green-gs bg-transparent hover:bg-gray-200 hover:text-amber-400 rounded-lg text-sm w-4 h-4 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="search-escorte-modal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">{{__('escort-search.close')}}</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="relative flex flex-col gap-3 items-center justify-center p-4 md:p-5 md:pb-20">
                    <h3 class="text-green-gs text-3xl font-dm-serif">{{__('escort-search.service_categories')}}</h3>
                    <div class="flex items-center gap-4 flex-wrap">
                        @foreach ($services as $service)
                        <div class="my-1">
                            <input wire:model.live='selectedServices' id="services{{$service->id}}" class="hidden peer" type="checkbox" name="{{$service->nom}}" value="{{$service->id}}" />
                            <label for="services{{$service->id}}" class="p-2 text-center border border-gray-400 rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">{{$service->nom}}</label>
                        </div>
                        @endforeach
                    </div>
                    <h3 class="text-green-gs text-3xl font-dm-serif">{{__('escort-search.other_filters')}}</h3>
                    <div class="grid grid-cols-1 xl:grid-cols-3 w-full gap-3 justify-between items-center">
                        <select wire:model.live="autreFiltres.origine" id="origine" name="origine" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected value="">{{__('escort-search.origin')}}</option>
                            <template x-for="origine in dropdownData['origines']">
                                <option :value="origine" x-text="origine"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.mensuration" id="mensuration" name="mensuration" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected value="">{{__('escort-search.measurements')}}</option>
                            <template x-for="mensuration in dropdownData['mensurations']">
                                <option :value="mensuration" x-text="mensuration"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.orientation" id="orientation" name="orientation" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected value="">{{__('escort-search.sexual_orientation')}}</option>
                            <template x-for="orientation in dropdownData['oriantationSexuelles']">
                                <option :value="orientation" x-text="orientation"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.langues" id="langue" name="langues" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected value="">{{__('escort-search.language')}}</option>
                            <template x-for="langue in dropdownData['langues']">
                                <option :value="langue" x-text="langue"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.couleur_cheveux" id="cheveux" name="cheveux" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected hidden>{{__('escort-search.hair')}}</option>
                            <template x-for="cheveux in dropdownData['couleursCheveux']">
                                <option :value="cheveux" x-text="cheveux"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres:couleur_yeux" id="yeux" name="yeux" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected value="">{{__('escort-search.eyes')}}</option>
                            <template x-for="yeux in dropdownData['couleursYeux']">
                                <option :value="yeux" x-text="yeux"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.poitrine" id="poitrine" name="poitrine" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected value="">{{__('escort-search.breast_state')}}</option>
                            <template x-for="poitrine in dropdownData['poitrines']">
                                <option value="poitrine" x-text="poitrine"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.pubis" id="pubis" name="pubus" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected value="">{{__('escort-search.pubic_hair')}}</option>
                            <template x-for="pubis in dropdownData['pubis']">
                                <option value="pubis" x-text="pubis"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.tatouages" id="tatouages" name="tatouages" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected value="">{{__('escort-search.tattoo')}}</option>
                            <template x-for="tatous in dropdownData['tatouages']">
                                <option value="tatous" x-text="tatous"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.taille_poitrine" id="poitrine" name="poitrine" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected value="">{{__('escort-search.breast_size')}}</option>
                            <template x-for="poitrine in dropdownData['taillesPoitrine']">
                                <option value="poitrine" x-text="poitrine"></option>
                            </template>
                        </select>
                        <select wire:model.live="autreFiltres.mobilite" id="mobilite" name="mobilite" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                            <option selected value="">{{__('escort-search.escort_mobility')}}</option>
                            <template x-for="mobilite in dropdownData['mobilites']">
                                <option value="mobilite" x-text="mobilite"></option>
                            </template>
                        </select>
                        <div></div>
                        <x-multi-range :min="18" :max="100" :minvalue="25" :maxvalue="75" step="1" name='age' label='{{__('escort-search.age')}}' id="age" />
                        <x-multi-range :min="90" :max="200" :minvalue="120" :maxvalue="175" step="1" name='tailles' label='{{__('escort-search.height')}} (cm)' id="tailles" />
                        <x-multi-range :min="100" :max="1000" :minvalue="150" :maxvalue="550" step="50" name='tarifs' label='{{__('escort-search.rates')}} (CHF)' id="tarifs" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

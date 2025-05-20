<div>
    <div class="py-15 flex min-h-72 w-full flex-col items-center justify-center bg-[#E4F1F1]">
        <h1 class="font-dm-serif text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
            {{ __('salon-search.title') }}</h1>

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
            <div>
                <input wire:model.live='nbFilles' class="peer hidden" name="5" type="checkbox" id="nbfille5"
                    value="1 à 5" />
                <label for="nbfille5"
                    class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-amber-400 bg-white p-2 text-center hover:text-amber-400 peer-checked:text-amber-400">{{ __('salon-search.1_5_girls') }}</label>
            </div>
            <div>
                <input wire:model.live='nbFilles' class="peer hidden" name="15" type="checkbox" id="nbfille15"
                    value="5 à 15" />
                <label for="nbfille15"
                    class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-amber-400 bg-white p-2 text-center hover:text-amber-400 peer-checked:text-amber-400">{{ __('salon-search.6_15_girls') }}</label>
            </div>
            <div>
                <input wire:model.live='nbFilles+15' class="peer hidden" name="+15" type="checkbox" id="nbfille+15"
                    value="plus de 15" />
                <label for="nbfille+15"
                    class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-amber-400 bg-white p-2 text-center hover:text-amber-400 peer-checked:text-amber-400">{{ __('salon-search.more_than_15_girls') }}</label>
            </div>
        </div>
        <button wire:click="resetFilter"
            class="font-dm-serif hover:bg-green-gs group my-2 flex items-center gap-2 rounded-lg border border-gray-400 bg-white p-2 text-gray-600 hover:text-white">
            {{ __('salon-search.reset_filters') }}
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                <path fill="currentColor"
                    d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z" />
            </svg>
        </button>
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
            @foreach ($salons as $salon)
                <livewire:salon_card wire:key='{{ $salon->id }}' name="{{ $salon->nom_salon }}"
                    canton="{{ $salon->canton?->nom ?? '' }}" ville="{{ $salon->ville?->nom ?? '' }}"
                    avatar='{{ $salon->avatar }}' salonId="{{ $salon->id }}" />
            @endforeach
        </div>
        <div class="mt-10">{{ $salons->links('pagination::simple-tailwind') }}</div>
    </div>
</div>

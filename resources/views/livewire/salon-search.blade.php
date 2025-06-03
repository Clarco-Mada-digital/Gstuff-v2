<div>
    <div class="py-15 flex min-h-72 w-full flex-col items-center justify-center bg-[#E4F1F1] px-4">
        <h1 class="font-dm-serif text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
            {{ __('salon-search.title') }}</h1>


        @if ($showFiltreCanton)
            <div
                class="mb-3 flex w-full flex-col items-center justify-center gap-2 px-4 text-sm md:flex-row xl:text-base">
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
                            <option wire:key='{{ $ville->id }}' value="{{ $ville->id }}">{{ $ville->nom }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        @endif



        @if ($approximite || $showClosestOnly)
            <div class="mx-auto mb-4 mt-1 w-full max-w-2xl rounded-lg bg-white p-4 shadow">
                <div class="mb-4">
                    <div class="space-y-6">
                        <div>
                            <div class="mb-2 mt-4 flex items-center justify-between">
                                <label
                                    class="block text-sm font-medium text-gray-700">{{ __('escort-search.distance_km') }}
                                    {{ number_format($maxDistanceSelected, 0) }}</label>
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
                                        class="h-1.5 w-full cursor-pointer appearance-none rounded-full bg-gray-300 transition-colors hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 sm:h-2">
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
            @foreach ($categories as $categorie)
                <div wire:key="{{ $categorie->id }}" class="my-2 bg-red-500">
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
                    <input wire:model.live='nbFilles' class="peer hidden" name="{{ $nombreFille->id }}" type="checkbox"
                        id="nbfille{{ $nombreFille->id }}" value="{{ $nombreFille->id }}" />
                    <label for="nbfille{{ $nombreFille->id }}"
                        class="hover:bg-green-gs peer-checked:bg-green-gs rounded-lg border border-amber-400 bg-white p-2 text-center hover:text-amber-400 peer-checked:text-amber-400">{{ $nombreFille->getTranslation('name', app()->getLocale()) }}</label>
                </div>
            @endforeach

        </div>

       <div class="my-2 flex items-center justify-center gap-2 flex-wrap">
       <div class="min-w-[120px] flex-1 sm:min-w-[140px] sm:flex-none">
            <input wire:model.live="showClosestOnly" class="peer hidden" type="checkbox" id="filterByClosestOnly"
                name="filter_by_closest_only">
            <label for="filterByClosestOnly"
                class="border-1 hover:bg-green-gs peer-checked:bg-green-gs group flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border-gray-400 bg-white p-3 text-center text-xs transition-all duration-200 hover:text-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 peer-checked:text-amber-400 sm:text-sm">
                <span>{{ __('escort-search.filter_by_closest_only') }}</span>
                <div wire:loading.remove wire:target="showClosestOnly" class="flex-shrink-0">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M14 4C14 5.10457 13.1046 6 12 6C10.8954 6 10 5.10457 10 4C10 2.89543 10.8954 2 12 2C13.1046 2 14 2.89543 14 4Z"
                                stroke="#1C274C" stroke-width="1.5"></path>
                            <path
                                d="M6.04779 10.849L6.28497 10.1375H6.28497L6.04779 10.849ZM8.22309 11.5741L7.98592 12.2856H7.98592L8.22309 11.5741ZM9.01682 13.256L8.31681 12.9868H8.31681L9.01682 13.256ZM7.77003 16.4977L8.47004 16.7669H8.47004L7.77003 16.4977ZM17.9522 10.849L17.715 10.1375H17.715L17.9522 10.849ZM15.7769 11.5741L16.0141 12.2856H16.0141L15.7769 11.5741ZM14.9832 13.256L15.6832 12.9868L14.9832 13.256ZM16.23 16.4977L15.53 16.7669L16.23 16.4977ZM10.4242 17.7574L11.0754 18.1295L10.4242 17.7574ZM12 14.9997L12.6512 14.6276C12.5177 14.394 12.2691 14.2497 12 14.2497C11.7309 14.2497 11.4823 14.394 11.3488 14.6276L12 14.9997ZM17.1465 7.8969L16.9894 7.16355L17.1465 7.8969ZM15.249 8.30353L15.4061 9.03688V9.03688L15.249 8.30353ZM8.75102 8.30353L8.90817 7.57018V7.57018L8.75102 8.30353ZM6.85345 7.89691L6.69631 8.63026L6.85345 7.89691ZM13.5758 17.7574L12.9246 18.1295V18.1295L13.5758 17.7574ZM15.0384 8.34826L14.8865 7.61381L14.8865 7.61381L15.0384 8.34826ZM8.96161 8.34826L8.80969 9.08272L8.80969 9.08272L8.96161 8.34826ZM15.2837 11.7666L15.6777 12.4048L15.2837 11.7666ZM14.8182 12.753L15.5613 12.6514V12.6514L14.8182 12.753ZM8.71625 11.7666L8.3223 12.4048H8.3223L8.71625 11.7666ZM9.18177 12.753L9.92485 12.8546V12.8546L9.18177 12.753ZM10.3454 9.32206C10.7573 9.36558 11.1265 9.06692 11.17 8.655C11.2135 8.24308 10.9149 7.87388 10.503 7.83036L10.3454 9.32206ZM13.497 7.83036C13.0851 7.87388 12.7865 8.24308 12.83 8.655C12.8735 9.06692 13.2427 9.36558 13.6546 9.32206L13.497 7.83036ZM5.81062 11.5605L7.98592 12.2856L8.46026 10.8626L6.28497 10.1375L5.81062 11.5605ZM8.31681 12.9868L7.07002 16.2284L8.47004 16.7669L9.71683 13.5252L8.31681 12.9868ZM17.715 10.1375L15.5397 10.8626L16.0141 12.2856L18.1894 11.5605L17.715 10.1375ZM14.2832 13.5252L15.53 16.7669L16.93 16.2284L15.6832 12.9868L14.2832 13.5252ZM11.0754 18.1295L12.6512 15.3718L11.3488 14.6276L9.77299 17.3853L11.0754 18.1295ZM16.9894 7.16355L15.0918 7.57017L15.4061 9.03688L17.3037 8.63026L16.9894 7.16355ZM8.90817 7.57018L7.0106 7.16355L6.69631 8.63026L8.59387 9.03688L8.90817 7.57018ZM11.3488 15.3718L12.9246 18.1295L14.227 17.3853L12.6512 14.6276L11.3488 15.3718ZM15.0918 7.57017C14.9853 7.593 14.9356 7.60366 14.8865 7.61381L15.1903 9.08272C15.2458 9.07123 15.3016 9.05928 15.4061 9.03688L15.0918 7.57017ZM8.59387 9.03688C8.6984 9.05928 8.75416 9.07123 8.80969 9.08272L9.11353 7.61381C9.06443 7.60366 9.01468 7.593 8.90817 7.57018L8.59387 9.03688ZM9.14506 19.2497C9.94287 19.2497 10.6795 18.8222 11.0754 18.1295L9.77299 17.3853C9.64422 17.6107 9.40459 17.7497 9.14506 17.7497V19.2497ZM15.53 16.7669C15.7122 17.2406 15.3625 17.7497 14.8549 17.7497V19.2497C16.4152 19.2497 17.4901 17.6846 16.93 16.2284L15.53 16.7669ZM15.5397 10.8626C15.3178 10.9366 15.0816 11.01 14.8898 11.1283L15.6777 12.4048C15.6688 12.4102 15.6763 12.4037 15.7342 12.3818C15.795 12.3588 15.877 12.3313 16.0141 12.2856L15.5397 10.8626ZM15.6832 12.9868C15.6313 12.8519 15.6004 12.7711 15.5795 12.7095C15.5596 12.651 15.5599 12.6411 15.5613 12.6514L14.0751 12.8546C14.1057 13.0779 14.1992 13.3069 14.2832 13.5252L15.6832 12.9868ZM14.8898 11.1283C14.3007 11.492 13.9814 12.1687 14.0751 12.8546L15.5613 12.6514C15.5479 12.5534 15.5935 12.4567 15.6777 12.4048L14.8898 11.1283ZM18.25 9.39526C18.25 9.73202 18.0345 10.031 17.715 10.1375L18.1894 11.5605C19.1214 11.2499 19.75 10.3777 19.75 9.39526H18.25ZM7.07002 16.2284C6.50994 17.6846 7.58484 19.2497 9.14506 19.2497V17.7497C8.63751 17.7497 8.28784 17.2406 8.47004 16.7669L7.07002 16.2284ZM7.98592 12.2856C8.12301 12.3313 8.20501 12.3588 8.26583 12.3818C8.32371 12.4037 8.33115 12.4102 8.3223 12.4048L9.1102 11.1283C8.91842 11.01 8.68219 10.9366 8.46026 10.8626L7.98592 12.2856ZM9.71683 13.5252C9.80081 13.3069 9.89432 13.0779 9.92485 12.8546L8.43868 12.6514C8.44009 12.6411 8.4404 12.6509 8.42051 12.7095C8.3996 12.7711 8.36869 12.8519 8.31681 12.9868L9.71683 13.5252ZM8.3223 12.4048C8.40646 12.4567 8.45208 12.5534 8.43868 12.6514L9.92485 12.8546C10.0186 12.1687 9.69929 11.492 9.1102 11.1283L8.3223 12.4048ZM4.25 9.39526C4.25 10.3777 4.87863 11.2499 5.81062 11.5605L6.28497 10.1375C5.96549 10.031 5.75 9.73202 5.75 9.39526H4.25ZM5.75 9.39526C5.75 8.89717 6.20927 8.52589 6.69631 8.63026L7.0106 7.16355C5.58979 6.8591 4.25 7.9422 4.25 9.39526H5.75ZM12.9246 18.1295C13.3205 18.8222 14.0571 19.2497 14.8549 19.2497V17.7497C14.5954 17.7497 14.3558 17.6107 14.227 17.3853L12.9246 18.1295ZM19.75 9.39526C19.75 7.9422 18.4102 6.85909 16.9894 7.16355L17.3037 8.63026C17.7907 8.52589 18.25 8.89717 18.25 9.39526H19.75ZM10.503 7.83036C10.0374 7.78118 9.57371 7.709 9.11353 7.61381L8.80969 9.08272C9.31831 9.18792 9.83084 9.2677 10.3454 9.32206L10.503 7.83036ZM14.8865 7.61381C14.4263 7.709 13.9626 7.78118 13.497 7.83036L13.6546 9.32206C14.1692 9.2677 14.6817 9.18792 15.1903 9.08272L14.8865 7.61381Z"
                                fill="#1C274C"></path>
                            <path
                                d="M19.4537 15C21.0372 15.7961 22 16.8475 22 18C22 18.7484 21.594 19.4541 20.8758 20.0749M4.54631 15C2.96285 15.7961 2 16.8475 2 18C2 20.4853 6.47715 22.5 12 22.5C13.8214 22.5 15.5291 22.2809 17 21.898"
                                stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"></path>
                        </g>
                    </svg>
                </div>
                <div wire:loading wire:target="showClosestOnly" class="flex-shrink-0">
                    <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
            </label>
        </div>


        <div class="min-w-[120px] flex-1 sm:min-w-[140px] sm:flex-none">
            <input wire:model.live="approximite" class="peer hidden" type="checkbox" id="filterByDistance"
                name="filter_by_distance">
            <label for="filterByDistance"
                class="border-1 hover:bg-green-gs peer-checked:bg-green-gs group flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border-gray-400 bg-white p-3 text-center text-xs transition-all duration-200 hover:text-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2 peer-checked:text-amber-400 sm:text-sm">
                <span>{{ __('escort-search.filter_by_distance') }}</span>
                <div wire:loading.remove wire:target="approximite" class="flex-shrink-0">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div wire:loading wire:target="approximite" class="flex-shrink-0">
                    <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
            </label>
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

    <div class="container mx-auto px-4 py-10 sm:py-20">
        <div class="font-dm-serif text-green-gs mb-3 text-2xl font-bold sm:text-3xl">
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

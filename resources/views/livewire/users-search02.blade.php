<div class="flex w-full flex-col items-center justify-center gap-2">
    {{-- Loader --}}
    {{-- Loader amélioré --}}
    <div wire:loading.flex
        wire:target="search,selectedCanton,selectedVille,selectedGenre,selectedCategories,gotoPage,previousPage,nextPage,resetFilters"
        id="loader"
        class="pointer-events-none fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">

        <div class="flex flex-col items-center space-y-4">
            {{-- Animation spinner --}}
            <div class="h-12 w-12 animate-spin rounded-full border-4 border-white border-t-transparent"></div>

            {{-- Texte de chargement --}}
            <div class="animate-pulse text-lg font-medium tracking-wide text-white">
                {{ __('user-search.loading') }}
            </div>
        </div>
    </div>



    <div class="py-5 bg-supaGirlRosePastel flex min-h-64 w-full flex-col items-center justify-center px-10">
        <h1 class="font-roboto-slab text-green-gs mb-5 text-center text-sm sm:text-lg md:text-3xl font-bold">
            {{ __('user-search.title') }}
        </h1>

        <form wire:submit.prevent="search" class="container flex w-full flex-col items-center justify-center 
        
        gap-2
        
        sm:w-[90%] 
        md:w-full
        lg:w-[90%] 
        xl:w-[90%] 
        2xl:w-[90%] 


        
        
        ">
           <div class="flex flex-col sm:flex-row w-full md:w-[90%] lg:w-[70%] xl:w-[60%] gap-2 items-center justify-around">
           {{-- Filtre par nom --}}
            <input wire:model.live.debounce.500ms="search" wire:keydown.enter.prevent="search" type="search"
                id="userName-search"
                class="text-green-gs font-roboto-slab border-supaGirlRose focus:border-supaGirlRose/50 focus:ring-supaGirlRose/50 block w-full  rounded-lg border
                 border-2 bg-gray-50 p-2 sm:p-2 sm:px-3 text-xs md:text-sm  sm:py-2 
                  focus:border-transparent "
                placeholder="{{ __('user-search.search_placeholder') }}" />

            {{-- Sélecteur Escort/Salon --}}
            <div class="grid w-full sm:w-[300px] grid-cols-2 gap-2 ">
                {{-- Bouton Escort --}}
                <button type="button" wire:click.prevent="setUserType('escort')" wire:loading.attr="disabled"
                    class="{{ $userType === 'escort' ? 'bg-pink-50 ring-2 ring-supaGirlRose' : 'bg-gray-50 hover:bg-pink-50' }} flex cursor-pointer  items-center rounded-lg p-2 transition-all duration-200  justify-center text-center">
                    {{-- Icône normale --}}
                  

                        <img src="{{ url('images/icons/escort_icon.png') }}"
                        class="h-6 w-6 " alt="escort" wire:loading.remove wire:target="setUserType('escort')" />

                    {{-- Icône de chargement --}}
                    <i class="fas fa-spinner fa-spin text-supaGirlRose mb-1 text-xs md:text-sm " wire:loading
                        wire:target="setUserType('escort')"></i>

                    <span
                        class="{{ $userType === 'escort' ? 'text-supaGirlRose' : 'text-gray-500' }} text-xs ml-2 md:text-sm font-medium">
                        {{ __('user-search.escort') }}
                    </span>
                </button>

                {{-- Bouton Salon --}}
                <button type="button" wire:click.prevent="setUserType('salon')" wire:loading.attr="disabled"
                    class="{{ $userType === 'salon' ? 'bg-pink-50 ring-2 ring-supaGirlRose' : 'bg-gray-50 hover:bg-pink-50' }} flex cursor-pointer  items-center rounded-lg p-2 transition-all duration-200 justify-center text-center">
                    {{-- Icône normale --}}
                  

                        <img src="{{ url('images/icons/salon.png') }}"
                        class="h-6 w-6" alt="salon"  wire:loading.remove wire:target="setUserType('salon')" />

                    {{-- Icône de chargement --}}
                    <i class="fas fa-spinner fa-spin text-green-gs mb-1 text-xs md:text-sm" wire:loading
                        wire:target="setUserType('salon')"></i>

                    <span class="{{ $userType === 'salon' ? 'text-green-gs' : 'text-gray-500' }} text-xs ml-2 md:text-sm font-medium">
                        {{ __('user-search.salon') }}
                    </span>
                </button>
            </div>
           </div>




            {{-- Filtres dynamiques --}}
            <div class="flex w-full flex-col gap-4">
                {{-- Filtres pour Escort --}}
                <div class="flex flex-col items-center justify-center gap-4 sm:flex-row md:w-[70%] lg:w-[60%] xl:w-[60%] m-auto">
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


            </div>

            {{-- Bouton de réinitialisation --}}
            @if ($userType !== 'all')
                @if (
                    !empty($search) ||
                        !empty($selectedCanton) ||
                        !empty($selectedVille) ||
                        !empty($selectedGenre) ||
                        !empty($selectedEscortCategories) ||
                        !empty($selectedSalonCategories))
                    <x-buttons.reset-button wire:click="resetFilters" class="m-auto w-56 p-2" :loading-target="'resetFilters'"
                        translation="escort-search.reset_filters" loading-translation="escort-search.resetting" />
                @endif
            @endif

        </form>
    </div>

    {{-- Listing des utilisateurs --}}
    <div class="mt-4 flex flex-col items-center justify-center md:w-[95%]  mx-auto px-1 sm:px-4 py-2 lg:py-5 ">
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
            <div class="w-full space-y-6 rounded-lg bg-white p-6 shadow-md">
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
            </div>
        </div>
    @endif
</div>

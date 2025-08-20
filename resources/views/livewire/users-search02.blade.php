<div class="w-full flex flex-col items-center justify-center gap-2">
    {{-- Loader --}}
    {{-- Loader amélioré --}}
    <div wire:loading.flex wire:target="search,selectedCanton,selectedVille,selectedGenre,selectedCategories,gotoPage,previousPage,nextPage,resetFilters"
        id="loader"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm pointer-events-none">

        <div class="flex flex-col items-center space-y-4">
            {{-- Animation spinner --}}
            <div class="w-12 h-12 border-4 border-white border-t-transparent rounded-full animate-spin"></div>

            {{-- Texte de chargement --}}
            <div class="text-white text-lg font-medium tracking-wide animate-pulse">
                {{ __('user-search.loading') }}
            </div>
        </div>
    </div>



    <div class="w-full px-10 py-15 flex min-h-72 flex-col items-center justify-center bg-supaGirlRosePastel">
        <h1 class="font-roboto-slab text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
            {{ __('user-search.title') }}
        </h1>

        <form wire:submit.prevent="search" class="w-full xl:w-1/2 2xl:w-1/2 sm:w-2/3 container flex flex-col gap-5">
            {{-- Filtre par nom --}}
            <input
                wire:model.live.debounce.500ms="search"
                wire:keydown.enter.prevent="search"
                type="search"
                id="userName-search"
                class="block w-full p-2 ps-10 text-green-gs font-roboto-slab border border-2 border-supaGirlRose rounded-lg bg-gray-50 px-3 py-2 focus:border-supaGirlRose/50 focus:ring-supaGirlRose/50 focus:border-transparent"
                placeholder="{{ __('user-search.search_placeholder') }}"
            />

            {{-- Sélecteur Escort/Salon --}}
            <div class="w-full grid grid-cols-2 gap-4 mb-4">
    {{-- Bouton Escort --}}
    <button
        type="button"
        wire:click.prevent="setUserType('escort')"
        wire:loading.attr="disabled"
        class="flex flex-col items-center cursor-pointer p-3 rounded-lg transition-all duration-200 {{ $userType === 'escort' ? 'bg-pink-50 ring-2 ring-supaGirlRose' : 'bg-gray-50 hover:bg-pink-50' }}"
    >
        {{-- Icône normale --}}
        <i
            class="fas fa-female text-2xl mb-1 {{ $userType === 'escort' ? 'text-supaGirlRose' : 'text-gray-400' }}"
            wire:loading.remove
            wire:target="setUserType('escort')"
        ></i>

        {{-- Icône de chargement --}}
        <i
            class="fas fa-spinner fa-spin text-2xl mb-1 text-supaGirlRose"
            wire:loading
            wire:target="setUserType('escort')"
        ></i>

        <span class="text-sm font-medium {{ $userType === 'escort' ? 'text-supaGirlRose' : 'text-gray-500' }}">
            {{ __('user-search.escort') }}
        </span>
    </button>

    {{-- Bouton Salon --}}
    <button
        type="button"
        wire:click.prevent="setUserType('salon')"
        wire:loading.attr="disabled"
        class="flex flex-col items-center cursor-pointer p-3 rounded-lg transition-all duration-200 {{ $userType === 'salon' ? 'bg-pink-50 ring-2 ring-supaGirlRose' : 'bg-gray-50 hover:bg-pink-50' }}"
    >
        {{-- Icône normale --}}
        <i
            class="fas fa-store text-2xl mb-1 {{ $userType === 'salon' ? 'text-green-gs' : 'text-gray-400' }}"
            wire:loading.remove
            wire:target="setUserType('salon')"
        ></i>

        {{-- Icône de chargement --}}
        <i
            class="fas fa-spinner fa-spin text-2xl mb-1 text-green-gs"
            wire:loading
            wire:target="setUserType('salon')"
        ></i>

        <span class="text-sm font-medium {{ $userType === 'salon' ? 'text-green-gs' : 'text-gray-500' }}">
            {{ __('user-search.salon') }}
        </span>
    </button>
</div>




            {{-- Filtres dynamiques --}}
            <div class="w-full flex flex-col gap-4">
                {{-- Filtres pour Escort --}}
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-center ">
                        <div class="w-full sm:w-1/3  @if($userType === 'salon' || $userType === 'escort') block @else hidden @endif">
                            <x-selects.canton-select
                                :cantons="$cantons"
                                :selectedCanton="$selectedCanton"
                                class="w-full"
                            />
                        </div>
                        <div class="w-full sm:w-1/3 @if($userType === 'salon' || $userType === 'escort') block @else hidden @endif">
                            <x-selects.ville-select
                                :villes="$villes"
                                :selectedVille="$selectedVille"
                                class="w-full"
                                :disabled="!$selectedCanton"
                            />
                        </div>
                        <div class="w-full sm:w-1/3 @if($userType === 'escort') block @else hidden @endif">
                            <x-selects.genre-select
                                :genres="$genres"
                                :selectedGenre="$selectedGenre"
                                class="w-full"
                            />
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base @if($userType === 'escort') block @else hidden @endif">
                        <x-category-checkbox
                            :categories="$escortCategories"
                            :selected-values="$selectedCategories"
                            model="selectedCategories"
                            prefixId="escort"
                        />
                    </div>
                

                {{-- Filtres pour Salon --}}
                <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base @if($userType === 'salon') block @else hidden @endif">
                        <x-category-checkbox
                            :categories="$salonCategories"
                            :selected-values="$selectedCategories"
                            model="selectedCategories"
                            prefixId="salon"
                        />
                    </div>
                   
                   
            </div>

            {{-- Bouton de réinitialisation --}}
            @if($userType !== 'all')
            @if(
           
                !empty($search) ||
                !empty($selectedCanton) ||
                !empty($selectedVille) ||
                !empty($selectedGenre) ||
                !empty($selectedCategories)
            )
                <x-buttons.reset-button
                    wire:click="resetFilters"
                    class="w-56 m-auto p-2"
                    :loading-target="'resetFilters'"
                    translation="escort-search.reset_filters"
                    loading-translation="escort-search.resetting"
                />
            @endif
            @endif

        </form>
    </div>

    {{-- Listing des utilisateurs --}}
    <div class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
        <div id="ESContainer" class="grid grid-cols-1 gap-2 md:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-4 mt-5 mb-4 px-10" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent" wire:key="users-list">
            @foreach ($users as $user)
                <livewire:escort-card
                    name="{{ $user->prenom ?? $user->nom_salon }}"
                    canton="{{ $user->canton['nom'] ?? 'Inconnu' }}"
                    ville="{{ $user->ville['nom'] ?? 'Inconnu' }}"
                    avatar="{{ $user->avatar }}"
                    escortId="{{ $user->id }}"
                    isOnline="{{ $user->isOnline() }}"
                    wire:key="component-{{ $user->id }}"
                    isPause="{{ $user->is_profil_pause }}"
                />
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="mt-8 flex justify-center items-center space-x-2">
                <button
                    wire:click="previousPage"
                    class="cursor-pointer font-roboto-slab text-green-gs border border-green-gs rounded px-4 py-2 hover:bg-supaGirlRosePastel"
                    @disabled($users->onFirstPage())
                >
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div class="hidden md:flex space-x-1">
                    @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        <button
                            wire:click="gotoPage({{ $page }})"
                            class="w-10 h-10 flex cursor-pointer items-center justify-center border rounded font-roboto-slab border-green-gs text-green-gs {{ $users->currentPage() === $page ? 'bg-green-gs text-white' : 'hover:bg-gray-100' }}"
                        >
                            {{ $page }}
                        </button>
                    @endforeach
                </div>
                <button
                    wire:click="nextPage"
                    class="cursor-pointer font-roboto-slab text-green-gs border border-green-gs rounded px-4 py-2 hover:bg-supaGirlRosePastel"
                    @disabled(!$users->hasMorePages())
                >
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        @endif

        {{-- Boutons de navigation du carrousel --}}
        <div id="arrowESScrollRight" class="hidden absolute top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 items-center justify-center cursor-pointer" data-carousel-prev>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/></svg>
        </div>
        <div id="arrowESScrollLeft" class="hidden absolute top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 items-center justify-center cursor-pointer" data-carousel-next>
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
        </div>
    </div>

    @if($users->count() == 0)
        <div class="flex flex-col items-center justify-center py-10 px-4">
            <h1 class="font-roboto-slab text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
                {{ __('escort-search.result0') }}
            </h1>
            <p class="text-xl font-semibold text-gray-800 mb-4">
                {{ __('escort-search.filtreApply') }}
            </p>
            <div class="w-full bg-white shadow-md rounded-lg p-6 space-y-6">
                @if(isset($filterApplay['search']) && $filterApplay['search'])
                    <div class="flex flex-wrap gap-2 items-center justify-center">
                        <p class="text-sm font-medium text-gray-700 mb-1">{{ __('escort-search.search') }} :</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">{{ $filterApplay['search'] }}</span>
                        </div>
                    </div>
                @endif
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
            </div>
        </div>
    @endif
</div>

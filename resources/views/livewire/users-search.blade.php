<div class="flex w-full flex-col items-center justify-center gap-2">
    {{-- loader --}}
    <div wire:loading id="loader"
        class="pointer-events-none absolute inset-0 z-50 flex h-full max-w-[100vw] items-center justify-center overflow-hidden bg-black/75 bg-opacity-50">
        <div class="flex h-[100vh] w-full items-center justify-center text-center text-2xl font-semibold text-white">
            {{ __('user-search.loading') }}
        </div>
    </div>

    <div class="py-15 bg-supaGirlRosePastel flex min-h-72 w-full flex-col items-center justify-center px-10">
        <h1 class="font-roboto-slab text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
            {{ __('user-search.title') }}</h1>

        <form wire:submit.prevent="search" class="container flex w-full flex-col gap-5 sm:w-2/3 xl:w-1/2 2xl:w-1/2">
            <input wire:model.live.debounce.500ms="search" wire:keydown.enter.prevent="search" type="search"
                id="userName-search"
                class="text-green-gs font-roboto-slab border-supaGirlRose focus:border-supaGirlRose/50 focus:ring-supaGirlRose/50 block w-full rounded-lg border border-2 bg-gray-50 p-2 px-3 py-2 ps-10 focus:border-transparent"
                placeholder="{{ __('user-search.search_placeholder') }}" />

            <!-- Filtres de recherche -->
            <div
                class="flex w-full flex-col items-center justify-center space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0">
                <div class="w-full min-w-[200px] max-w-xs">
                    <x-selects.canton-select :cantons="$cantons" :selectedCanton="$selectedCanton" class="w-full" />
                </div>
                <div class="w-full min-w-[200px] max-w-xs">
                    <x-selects.ville-select :villes="$villes" :selectedVille="$selectedVille" class="w-full" :disabled="!$selectedCanton" />
                </div>
                <div class="w-full min-w-[200px] max-w-xs">
                    <x-selects.genre-select :genres="$genres" :selectedGenre="$selectedGenre" class="w-full" />
                </div>
            </div>

            <!-- Catégories Salons -->
            <div class="mb-2 flex flex-wrap items-center justify-center gap-2 text-sm font-bold xl:text-base">
                <x-category-checkbox :categories="$salonCategories" :selected-values="$selectedSalonCategories" model="selectedSalonCategories"
                    prefixId="salon" />
            </div>

            <!-- Catégories Escorts -->
            <div class="flex flex-wrap items-center justify-center gap-2 text-sm font-bold xl:text-base">
                <x-category-checkbox :categories="$escortCategories" :selected-values="$selectedEscortCategories" model="selectedEscortCategories"
                    prefixId="escort" />
            </div>

            @if (
                !empty($search) ||
                    !empty($selectedCanton) ||
                    !empty($selectedVille) ||
                    !empty($selectedGenre) ||
                    !empty($selectedSalonCategories) ||
                    !empty($selectedEscortCategories))
                <x-buttons.reset-button wire:click="resetFilters" class="m-auto w-56 p-2" :loading-target="'resetFilters'"
                    translation="escort-search.reset_filters" loading-translation="escort-search.resetting" />
            @endif

        </form>
    </div>

    <!-- Listing des utilisateurs -->
    <div class="relative mx-auto mt-4 flex w-full flex-col items-center justify-center">
        <div id="ESContainer"
            class="mb-4 mt-5 grid grid-cols-1 gap-2 px-10 md:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-4"
            style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent"
            wire:key="users-list">
            @foreach ($users as $user)
                <livewire:escort-card name="{{ $user->prenom ?? $user->nom_salon }}"
                    canton="{{ $user->canton['nom'] ?? 'Inconnu' }}" ville="{{ $user->ville['nom'] ?? 'Inconnu' }}"
                    avatar="{{ $user->avatar }}" escortId="{{ $user->id }}" isOnline="{{ $user->isOnline() }}"
                    wire:key="component-{{ $user->id }}" isPause="{{ $user->is_profil_pause }}" />
            @endforeach
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="mt-8 flex items-center justify-center space-x-2">
                {{-- Premier/Précédent --}}
                <button
                    class="font-roboto-slab text-green-gs border-green-gs hover:bg-supaGirlRosePastel cursor-pointer rounded border px-4 py-2"
                    wire:click="previousPage" @disabled($users->onFirstPage())
                    class="{{ $users->onFirstPage() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100' }} rounded border px-4 py-2">
                    <i class="fas fa-arrow-left"></i>
                </button>

                {{-- Pages --}}
                <div class="hidden space-x-1 md:flex">
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        <button wire:click="gotoPage({{ $page }})"
                            class="font-roboto-slab border-green-gs text-green-gs {{ $users->currentPage() === $page ? 'bg-green-gs text-white' : 'hover:bg-gray-100' }} flex h-10 w-10 cursor-pointer items-center justify-center rounded border">
                            {{ $page }}
                        </button>
                    @endforeach
                </div>

                {{-- Suivant/Dernier --}}
                <button wire:click="nextPage"
                    class="font-roboto-slab text-green-gs border-green-gs hover:bg-supaGirlRosePastel cursor-pointer rounded border px-4 py-2"
                    @disabled(!$users->hasMorePages())
                    class="{{ !$users->hasMorePages() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100' }} rounded border px-4 py-2">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        @endif

        <!-- Boutons de navigation du carrousel -->
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
                {{ __('escort-search.result0') }}</h1>

            <p class="mb-4 text-xl font-semibold text-gray-800">
                {{ __('escort-search.filtreApply') }}
            </p>

            <div class="w-full space-y-6 rounded-lg bg-white p-6 shadow-md">

                {{-- search --}}
                @if (isset($filterApplay['search']) && $filterApplay['search'])
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.search') }} :</p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="rounded-full bg-indigo-100 px-3 py-1 text-sm text-indigo-800">{{ $filterApplay['search'] }}</span>
                        </div>
                    </div>
                @endif
                {{-- Canton, Ville, Genre en ligne --}}
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

                {{-- Catégories --}}
                @if (isset($filterApplay['selectedCategories']) && $filterApplay['selectedCategories'])
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <p class="mb-1 text-sm font-medium text-gray-700">{{ __('escort-search.categories') }} :</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($filterApplay['selectedCategories'] as $category)
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

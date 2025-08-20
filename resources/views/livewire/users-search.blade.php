<div class="w-full flex flex-col items-center justify-center gap-2">
  {{-- loader --}}
  <div wire:loading id="loader" class="absolute inset-0  max-w-[100vw] h-full pointer-events-none overflow-hidden flex items-center justify-center bg-black/75 bg-opacity-50 z-50">
    <div class="text-white text-2xl text-center font-semibold h-[100vh] w-full flex items-center justify-center">
        {{ __('user-search.loading') }}
    </div>
  </div>

    <div class="w-full px-10  py-15 flex min-h-72 flex-col items-center justify-center bg-supaGirlRosePastel">
        <h1 class="font-roboto-slab text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
            {{ __('user-search.title') }}</h1>
            
        <form wire:submit.prevent="search" class="w-full xl:w-1/2 2xl:w-1/2 sm:w-2/3 container flex flex-col gap-5">
            <input wire:model.live.debounce.500ms="search" wire:keydown.enter.prevent="search" type="search" id="userName-search" 
            class="block w-full p-2 ps-10  text-green-gs font-roboto-slab border border-2 border-supaGirlRose rounded-lg bg-gray-50 px-3 py-2 focus:border-supaGirlRose/50 focus:ring-supaGirlRose/50 focus:border-transparent" placeholder="{{__('user-search.search_placeholder')}}" />

            <!-- Filtres de recherche -->
            <div class="flex w-full flex-col items-center justify-center space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0">
                <div class="w-full min-w-[200px] max-w-xs">
                    <x-selects.canton-select 
                        :cantons="$cantons"
                        :selectedCanton="$selectedCanton"
                        class="w-full"
                    />
                </div>
                <div class="w-full min-w-[200px] max-w-xs">
                    <x-selects.ville-select 
                        :villes="$villes"
                        :selectedVille="$selectedVille"
                        class="w-full"
                        :disabled="!$selectedCanton"
                    />
                </div>
                <div class="w-full min-w-[200px] max-w-xs">
                    <x-selects.genre-select 
                        :genres="$genres"
                        :selectedGenre="$selectedGenre"
                        class="w-full"
                    />
                </div>
            </div>

            <!-- Catégories Salons -->
            <div class="flex flex-wrap items-center justify-center gap-2 mb-2 font-bold text-sm xl:text-base">
                <x-category-checkbox 
                    :categories="$salonCategories"
                    :selected-values="$selectedCategories"
                    model="selectedCategories"
                    prefixId="salon"
                />
            </div>

            <!-- Catégories Escorts -->
            <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base">
                <x-category-checkbox 
                    :categories="$escortCategories"
                    :selected-values="$selectedCategories"
                    model="selectedCategories"
                    prefixId="escort"
                />
            </div>

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

        </form>
    </div>

  <!-- Listing des utilisateurs -->
  <div class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
      <div id="ESContainer" class="grid grid-cols-1 gap-2 md:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-4 mt-5 mb-4 px-10" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent" wire:key="users-list">
          @foreach ($users as $user)
              <livewire:escort-card name="{{ $user->prenom ?? $user->nom_salon }}" canton="{{ $user->canton['nom'] ?? 'Inconnu' }}" ville="{{ $user->ville['nom'] ?? 'Inconnu' }}" avatar="{{ $user->avatar }}" escortId="{{ $user->id }}" isOnline="{{ $user->isOnline() }}" wire:key="component-{{ $user->id }}" isPause="{{ $user->is_profil_pause }}"/>
          @endforeach
      </div>

      <!-- Pagination -->
        @if($users->hasPages())
        <div class="mt-8 flex justify-center items-center space-x-2">
            {{-- Premier/Précédent --}}
            <button 
            class="cursor-pointer font-roboto-slab text-green-gs border border-green-gs rounded px-4 py-2 hover:bg-supaGirlRosePastel"
                wire:click="previousPage"
                @disabled($users->onFirstPage())
                class="px-4 py-2 border rounded {{ $users->onFirstPage() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100' }}">
                <i class="fas fa-arrow-left"></i>
            </button>

            {{-- Pages --}}
            <div class="hidden md:flex space-x-1">
                @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    <button
                        wire:click="gotoPage({{ $page }})"
                        class="w-10 h-10 flex cursor-pointer items-center justify-center border rounded  font-roboto-slab border-green-gs text-green-gs {{ $users->currentPage() === $page ? 'bg-green-gs text-white' : 'hover:bg-gray-100' }}">
                        {{ $page }}
                    </button>
                @endforeach
            </div>

            {{-- Suivant/Dernier --}}
            <button 
                wire:click="nextPage"
                class="cursor-pointer font-roboto-slab text-green-gs border border-green-gs rounded px-4 py-2 hover:bg-supaGirlRosePastel"
                @disabled(!$users->hasMorePages())
                class="px-4 py-2 border rounded {{ !$users->hasMorePages() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100' }}">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
        @endif
        
      <!-- Boutons de navigation du carrousel -->
      <div id="arrowESScrollRight" class="hidden absolute top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 items-center justify-center cursor-pointer" data-carousel-prev>
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/></svg>
      </div>
      <div id="arrowESScrollLeft" class="hidden absolute top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 items-center justify-center cursor-pointer" data-carousel-next>
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
      </div>
  </div>


  @if($users->count() == 0)
    <div class="flex flex-col items-center justify-center py-10 px-4">
    <h1 class="font-roboto-slab text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl"> {{ __('escort-search.result0') }}</h1>

        <p class="text-xl font-semibold text-gray-800 mb-4">
            {{ __('escort-search.filtreApply') }}
        </p>

        <div class="w-full  bg-white shadow-md rounded-lg p-6 space-y-6">

        {{-- search --}}
            @if(isset($filterApplay['search']) && $filterApplay['search'])
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    <p class="text-sm font-medium text-gray-700 mb-1">{{ __('escort-search.search') }} :</p>
                    <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">{{ $filterApplay['search'] }}</span>
                    </div>
                </div>
            @endif
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

           
        </div>
    </div>
@endif



</div>
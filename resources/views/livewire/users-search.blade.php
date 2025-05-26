<div class="w-full flex flex-col items-center justify-center gap-2">
  {{-- loader --}}
  <div wire:loading id="loader" class="absolute inset-0  max-w-[100vw] h-full pointer-events-none overflow-hidden flex items-center justify-center bg-black/75 bg-opacity-50 z-50">
    <div class="text-white text-2xl text-center font-semibold h-[100vh] w-full flex items-center justify-center">
        Chargement en cours...
    </div>
  </div>

    <div class="w-full py-15 flex min-h-72 flex-col items-center justify-center bg-[#E4F1F1]">
        <h1 class="font-dm-serif text-green-gs mb-5 text-center text-xl font-bold xl:text-4xl">
            {{ __('Découvrer les escortes et les salons de votre région') }}</h1>
        <form wire:submit.prevent="search" class="w-full container flex flex-col gap-5">
            <input wire:model.live.debounce.500ms="search" wire:keydown.enter.prevent="search" type="search" id="userName-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500" placeholder="{{__('search_modal.search_placeholder')}}" />

            <!-- Sélection des cantons -->
            <div class="w-full flex flex-col md:flex-row items-center justify-center text-sm xl:text-base gap-2 mb-3">
                <select wire:model.live="selectedCanton" id="canton-search" class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                    <option value="">{{__('search_modal.cantons')}}</option>
                    @foreach ($cantons as $canton)
                        <option value="{{ $canton->id }}">{{ $canton->nom }}</option>
                    @endforeach
                </select>

                <!-- Sélection des villes -->
                <select wire:model.live="selectedVille" id="ville-search" class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500" {{ $villes->isEmpty() ? 'disabled' : '' }}>
                    <option value="">{{ $villes->isEmpty() ? __('search_modal.choose_canton') : __('search_modal.cities') }}</option>
                    @foreach ($villes as $ville)
                        <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                    @endforeach
                </select>

                <!-- Sélection du genre -->
                <select wire:model.live="selectedGenre" id="genre-search" class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                    <option value="">{{__('search_modal.gender')}}</option>
                    <option value="Femme">{{__('search_modal.female')}}</option>
                    <option value="Homme">{{__('search_modal.male')}}</option>
                    <option value="Trans">{{__('search_modal.trans')}}</option>
                    <option value="Gay">{{__('search_modal.gay')}}</option>
                    <option value="Lesbienne">{{__('search_modal.lesbian')}}</option>
                    <option value="Bisexuelle">{{__('search_modal.bisexual')}}</option>
                    <option value="Queer">{{__('search_modal.queer')}}</option>
                </select>
            </div>

            <!-- Catégories -->
            <div class="flex flex-wrap items-center justify-center gap-2 mb-3 font-bold text-sm xl:text-base">
                @foreach ($salonCategories as $categorie)
                    <div wire:key="salon-{{ $categorie->id }}">
                        <input wire:model.live="selectedCategories" type="checkbox" name="{{ $categorie->nom }}" id="categorie{{ $categorie->id }}" value="{{ $categorie->id }}" class="peer hidden">
                        <label for="categorie{{ $categorie->id }}" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">
                            {{ $categorie->nom }}
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base">
                @foreach ($escortCategories as $categorie)
                    <div wire:key="escort-{{ $categorie->id }}">
                        <input wire:model.live="selectedCategories" type="checkbox" name="{{ $categorie->nom }}" id="categorie{{ $categorie->id }}" value="{{ $categorie->id }}" class="peer hidden">
                        <label for="categorie{{ $categorie->id }}" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">
                            {{ $categorie->nom }}
                        </label>
                    </div>
                @endforeach
            </div>

        </form>
    </div>

  <!-- Listing des utilisateurs -->
  <div class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
      <div id="ESContainer" class="grid grid-cols-1 gap-2 md:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-4 mt-5 mb-4 px-10" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent" wire:key="users-list">
          @foreach ($users as $user)
              <livewire:escort-card name="{{ $user->prenom ?? $user->nom_salon }}" canton="{{ $user->canton['nom'] ?? 'Inconnu' }}" ville="{{ $user->ville['nom'] ?? 'Inconnu' }}" avatar="{{ $user->avatar }}" escortId="{{ $user->id }}" isOnline="{{ $user->isOnline() }}" wire:key="component-{{ $user->id }}" />
          @endforeach
      </div>

      <!-- Pagination -->
        @if($users->hasPages())
        <div class="mt-8 flex justify-center items-center space-x-2">
            {{-- Premier/Précédent --}}
            <button 
                wire:click="previousPage"
                @disabled($users->onFirstPage())
                class="px-4 py-2 border rounded {{ $users->onFirstPage() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100' }}">
                &larr; Précédent
            </button>

            {{-- Pages --}}
            <div class="hidden md:flex space-x-1">
                @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    <button
                        wire:click="gotoPage({{ $page }})"
                        class="w-10 h-10 flex items-center justify-center border rounded {{ $users->currentPage() === $page ? 'bg-blue-500 text-white' : 'hover:bg-gray-100' }}">
                        {{ $page }}
                    </button>
                @endforeach
            </div>

            {{-- Suivant/Dernier --}}
            <button 
                wire:click="nextPage"
                @disabled(!$users->hasMorePages())
                class="px-4 py-2 border rounded {{ !$users->hasMorePages() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100' }}">
                Suivant &rarr;
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
</div>
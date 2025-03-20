{{-- <div>
  <!-- Barre de recherche principale -->
  <input 
      type="text" 
      
      placeholder="Rechercher par nom, prénom ou salon..."
      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
  >

  <!-- Filtres supplémentaires -->
  <div class="mt-4 flex gap-4">
      <select 
          wire:model="category"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
          <option value="">Catégorie</option>
          <option value="1">Catégorie 1</option>
          <option value="2">Catégorie 2</option>
      </select>

      <select 
          wire:model="language"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
          <option value="">Langue</option>
          <option value="fr">Français</option>
          <option value="en">Anglais</option>
      </select>
  </div>

  <!-- Affichage des résultats -->
  <div class="mt-6">
    @foreach($users as $user)
    <div>
        {{ $user->prenom }} {{ $user->categorie }}
    </div>
    @endforeach
    {{ $users->links() }}
  </div>
</div> --}}

<div wire:ignore.self id="search-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative p-4 w-[95%] lg:w-[60%]  max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">

          <!-- Modal header -->
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h1 class="flex-1 font-dm-serif font-bold text-3xl text-green-gs text-center">Rechercer une fille ou un salon</h1>
              <button type="button" class="end-2.5 text-green-gs bg-transparent hover:bg-gray-200 hover:text-amber-400 rounded-lg text-sm w-4 h-4 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="search-modal">
                  <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                  </svg>
                  <span class="sr-only">Close modal</span>
              </button>
          </div>

          <!-- Modal body -->
          <div x-data="{villes:'', cantons:{{$cantons}}, selectedCanton:'', availableVilles:{{$villes}}}" class="relative flex flex-col gap-3 items-center justify-center p-4 md:p-5">
            
            <input wire:model.live.debounce.500ms="search" type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500" placeholder="Recherche escort, salon..." required />
            <div class="w-full flex flex-col md:flex-row items-center justify-center text-sm xl:text-base gap-2 mb-3">
              <select wire:model.live="selectedCanton" x-model="selectedCanton" x-on:change="villes = availableVilles.filter(ville => ville.canton_id == selectedCanton)" id="small" class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                <option selected value="">Cantons</option>
                <template x-for="canton in cantons" :key="canton.id">
                  <option :value="canton.id" x-text="canton.nom"></option>
                </template>
              </select>
              <select wire:model.live="selectedVille" id="small" class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500" :disabled="villes == '' ? true : false" >
                <option selected value="" x-text="villes == '' ? 'Choisier un canton pour voir les villes' : 'Villes' ">Villes</option>
                <template x-for="ville in villes" :key="ville.id">
                  <option :value="ville.id" x-text="ville.nom"></option>
                </template>
              </select>
              <select wire:model.live='selectedGenre' id="small" class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                <option selected value=''>Sexe</option>
                <option value="femme">Femme</option>
                <option value="homme">Homme</option>
                <option value="trans">Trans</option>
                <option value="gay">Gay</option>
                <option value="lesbienne">Lesbienne</option>
                <option value="bisexuelle">Bisexuelle</option>
                <option value="queer">Queer</option>
              </select>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-2 mb-3 font-bold text-sm xl:text-base">
              @foreach ($salonCategories as $categorie)
                <div>
                  <input  wire:model.live='selectedCategories' type="checkbox" name="{{$categorie->id}}" id="categorie{{$categorie->id}}" value="{{$categorie->id}}" class="hidden peer">
                  <label for="categorie{{$categorie->id}}" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">{{$categorie->nom}}</label>
                </div>                
              @endforeach
            </div>
            <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base">
              @foreach ($escortCategories as $categorie)
                <div>
                  <input  wire:model.live='selectedCategories' type="checkbox" name="{{$categorie->id}}" id="categorie{{$categorie->id}}" value="{{$categorie->id}}" class="hidden peer">
                  <label for="categorie{{$categorie->id}}" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">{{$categorie->nom}}</label>
                </div>                
              @endforeach
            </div>

            {{-- Listing d'escort/salon --}}
            <div class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
              <div id="ESContainer" class="w-full flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-10 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                @foreach ($users as $user)                
                <x-escort_card name="{{ $user->prenom}}" canton="{{$user->canton->nom}}" ville="{{$user->ville->nom}}" avatar='{{$user->avatar}}' escortId='{{$user->id}}' />                
                @endforeach
              </div>
              <div id="arrowESScrollRight" class="absolute top-[40%] left-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-prev>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z"/></svg>
              </div>
              <div id="arrowESScrollLeft" class="absolute top-[40%] right-1 w-10 h-10 rounded-full shadow bg-amber-300/60 flex items-center justify-center cursor-pointer" data-carousel-next>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z"/></svg>
              </div>
            </div>

          </div>
      </div>
  </div>
</div>
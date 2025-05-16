<!-- Modal body -->
<div x-data="{villes:'', cantons:{{$cantons}}, selectedCanton:'', availableVilles:{{$villes}}}" class="relative flex flex-col gap-3 items-center justify-center w-full h-full p-4 md:p-5">

{{-- loader --}}
  <div wire:loading id="loader" class="absolute inset-0 flex items-center justify-center bg-black/75 bg-opacity-50 z-50">
    <div class="text-white text-2xl font-semibold h-full w-full flex items-center justify-center">
        Chargement en cours...
    </div>
  </div>

  {{-- Le champ de recherche --}}
  <form wire:submit.prevent="search" class="w-full" method="POST">
    @csrf
    <input wire:model.live.debounce.500ms="search" wire:keydown.enter.prevent="search" type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500" placeholder="{{__('search_modal.search_placeholder')}}" />
  </form>
  {{-- Les selects --}}
  <form wire:submit.prevent="selectedCanton" class="w-full">
    <div class="w-full flex flex-col md:flex-row items-center justify-center text-sm xl:text-base gap-2 mb-3">
      <select  x-model="selectedCanton" 
      @change="$wire.set('selectedCanton', selectedCanton); villes = availableVilles.filter(ville => ville.canton_id == selectedCanton)" 
      id="small" 
      class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
        <option selected value="">{{__('search_modal.cantons')}}</option>
        <template x-for="canton in cantons" :key="canton.id">
          <option :value="canton.id" x-text="canton.nom"></option>
        </template>
      </select>
      <select wire:model.live.prevent="selectedVille" 
      @change="$wire.set('selectedVille', selectedVille)"
      id="small" 
      class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500" :disabled="villes == '' ? true : false" >
        <option selected value="" x-text="villes == '' ? '{{__('search_modal.choose_canton')}}' : '{{__('search_modal.cities')}}' "></option>
        <template x-for="ville in villes" :key="ville.id">
          <option :value="ville.id" x-text="ville.nom"></option>
        </template>
      </select>
      <select wire:model.live.prevent='selectedGenre' 
      @change="$wire.set('selectedGenre', selectedGenre)"
      id="small" 
      class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
        <option selected value=''>{{__('search_modal.gender')}}</option>
        <option value="Femme">{{__('search_modal.female')}}</option>
        <option value="Homme">{{__('search_modal.male')}}</option>
        <option value="Trans">{{__('search_modal.trans')}}</option>
        <option value="Gay">{{__('search_modal.gay')}}</option>
        <option value="Lesbienne">{{__('search_modal.lesbian')}}</option>
        <option value="Bisexuelle">{{__('search_modal.bisexual')}}</option>
        <option value="Queer">{{__('search_modal.queer')}}</option>
      </select>
    </div>
  </form>
  {{-- Les checkboxes --}}
  <form wire:submit.prevent="selectedCategories" class="w-full flex flex-col items-center justify-center gap-2">
    <div class="flex flex-wrap items-center justify-center gap-2 mb-3 font-bold text-sm xl:text-base">
      @foreach ($salonCategories as $categorie)
        <div wire:key="salon-{{ $categorie->id }}">
          <input wire:model.live="selectedCategories" type="checkbox" name="categories[]" id="categorie{{ $categorie->id }}" value="{{ $categorie->id }}" class="hidden peer">
          <label for="categorie{{ $categorie->id }}" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">
            {{ $categorie->nom }}
          </label>
        </div>
      @endforeach
    </div>

    <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base">
        @foreach ($escortCategories as $categorie)
          <div wire:key="escort-{{ $categorie->id }}">
            <input wire:model.live="selectedCategories" type="checkbox" name="categories[]" id="categorie{{ $categorie->id }}" value="{{ $categorie->id }}" class="hidden peer">
            <label for="categorie{{ $categorie->id }}" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">
              {{ $categorie->nom }}
            </label>
          </div>
        @endforeach
    </div>
  </form>

  {{-- Listing d'escort/salon --}}
  <div class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
    <div id="ESContainer" class="w-full flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-10 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent" wire:key="users-list">
      @foreach ($users as $user)
      {{-- @if ($user->profile_type == 'escorte') --}}
      <livewire:escort-card name="{{ $user->prenom ?? $user->nom_salon}}" canton="{{$user->canton['nom'] ?? 'Inconue'}}" ville="{{$user->ville['nom'] ?? 'Inconue'}}" avatar='{{$user->avatar}}' escortId='{{$user->id}}' isOnline='{{$user->isOnline()}}' wire:key="component-{{$user->id}}"/>
      {{-- @else
      <livewire:salon-card name="{{ $user->nom_salon}}" canton="{{$user->canton['nom'] ?? 'Inconue'}}" ville="{{$user->ville['nom'] ?? 'Inconue'}}" avatar='{{$user->avatar}}' salonId='{{$user->id}}' wire:key="component-{{$user->id}}"/>
      @endif --}}
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

      

<div>
  <div class="w-full min-h-72 flex flex-col items-center justify-center bg-[#E4F1F1] py-15">
      <h1 class="font-dm-serif font-bold text-green-gs text-xl xl:text-4xl text-center mb-5">Découvrez les salons dans votre région</h1>

      <div class="w-full px-4 flex flex-col md:flex-row items-center justify-center text-sm xl:text-base gap-2 mb-3">
        <select wire:model.live="selectedSalonCanton" wire:change="chargeVille" class="block w-full xl:w-80 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option selected value='' >Cantons</option>
          @foreach ($cantons as $canton)
          <option wire:key='{{$canton->id}}' value="{{$canton->id}}"> {{$canton->nom}} </option>              
          @endforeach
        </select>
        <select wire:model.live="selectedVille" class="block w-full xl:w-80 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  @if (!$villes) disabled @endif>
          <option selected value="">
            @if ($villes)
              Villes
            @else
            Choisier un canton pour voir les villes
            @endif
          </option>
          @foreach ($villes as $ville)
          <option wire:key='{{$ville->id}}' value="{{$ville->id}}"> {{$ville->nom}} </option>              
          @endforeach
        </select>
      </div>
      <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm my-2 xl:text-base">
        @foreach($categories as $categorie)
        <div wire:key="{{$categorie->id}}">
          <input wire:model.live='selectedSalonCategories' class="hidden peer" type="checkbox" id="salonCategorie{{$categorie->id}}" name="{{$categorie->nom}}" value="{{$categorie->id}}" />
          <label for="salonCategorie{{$categorie->id}}" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:text-amber-400 peer-checked:bg-green-gs">{{$categorie->nom}}</label>
        </div>
        @endforeach
      </div>
      <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm my-2 xl:text-base">          
        <div>
          <input wire:model.live='nbFilles' class="hidden peer" name="5" type="checkbox" id="nbfille5"  value="1 à 5" />
          <label for="nbfille5" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:text-amber-400 peer-checked:bg-green-gs">1 à 5 filles</label>
        </div>
        <div>
          <input wire:model.live='nbFilles' class="hidden peer" name="15" type="checkbox" id="nbfille15"  value="5 à 15" />
          <label for="nbfille15" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:text-amber-400 peer-checked:bg-green-gs">6 à 15 filles</label>
        </div>
        <div>
          <input wire:model.live='nbFilles+15' class="hidden peer" name="+15" type="checkbox" id="nbfille+15"  value="plus de 15" />
          <label for="nbfille+15" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:text-amber-400 peer-checked:bg-green-gs">plus de 15 filles</label>
        </div>
      </div>
      <button wire:click="resetFilter" class="font-dm-serif text-gray-600 flex items-center gap-2 p-2 bg-white border border-gray-400 rounded-lg my-2 hover:bg-green-gs hover:text-white group">
        Réinitialiser les filtres
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="currentColor" d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z"/></svg>
      </button>
    </div>

    <div class="container mx-auto py-20 px-2">
      <div class="font-dm-serif text-green-gs font-bold text-3xl mb-3">
        {{ $salons->count() }}
        @if($salons->count() > 1)
            Résultats autour de {{ $maxDistance }} km
        @else
            Résultat
        @endif
    </div>
          <div class="grid 2xl:grid-cols-4 xl:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-2">
        @foreach ($salons as $salon)
          <livewire:salon_card wire:key='{{$salon->id}}' name="{{ $salon->nom_salon }}" canton="{{$salon->canton['nom']}}" ville="{{$salon->ville['nom']}}" avatar='{{$salon->avatar}}' salonId="{{$salon->id}}" />
        @endforeach
      </div>
      <div class="mt-10">{{$salons->links('pagination::simple-tailwind')}}</div>
    </div>
   
</div>


{{-- @livewireStyles
<div>
  <div class="w-full min-h-72 flex flex-col items-center justify-center bg-[#E4F1F1] py-15">
      <h1 class="font-dm-serif font-bold text-green-gs text-xl xl:text-4xl text-center mb-5">Découvrez les salons dans votre région</h1>
      <div id="search-radius">{{ $searchRadius }}</div>

      <div class="w-full px-4 flex flex-col md:flex-row items-center justify-center text-sm xl:text-base gap-2 mb-3">
          <select wire:model.live="selectedSalonCanton" wire:change="chargeVille" class="block w-full xl:w-80 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option selected value=''>Cantons</option>
              @foreach ($cantons as $canton)
                  <option wire:key='{{$canton->id}}' value="{{$canton->id}}"> {{$canton->nom}} </option>
              @endforeach
          </select>
          <select wire:model.live="selectedSalonVille" class="block w-full xl:w-80 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" @if (!$villes) disabled @endif>
              <option selected value="">
                  @if ($villes)
                      Villes
                  @else
                      Choisir un canton pour voir les villes
                  @endif
              </option>
              @foreach ($villes as $ville)
                  <option wire:key='{{$ville->id}}' value="{{$ville->id}}"> {{$ville->nom}} </option>
              @endforeach
          </select>
      </div>
      <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm my-2 xl:text-base">
          @foreach($categories as $categorie)
              <div wire:key="{{$categorie->id}}">
                  <input wire:model.live='selectedSalonCategories' class="hidden peer" type="checkbox" id="salonCategorie{{$categorie->id}}" name="{{$categorie->nom}}" value="{{$categorie->id}}" />
                  <label for="salonCategorie{{$categorie->id}}" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:text-amber-400 peer-checked:bg-green-gs">{{$categorie->nom}}</label>
              </div>
          @endforeach
      </div>
      <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm my-2 xl:text-base">
          <div>
              <input wire:model.live='nbFilles' class="hidden peer" name="5" type="checkbox" id="nbfille5" value="1 à 5" />
              <label for="nbfille5" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:text-amber-400 peer-checked:bg-green-gs">1 à 5 filles</label>
          </div>
          <div>
              <input wire:model.live='nbFilles' class="hidden peer" name="15" type="checkbox" id="nbfille15" value="5 à 15" />
              <label for="nbfille15" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:text-amber-400 peer-checked:bg-green-gs">6 à 15 filles</label>
          </div>
          <div>
              <input wire:model.live='nbFilles' class="hidden peer" name="+15" type="checkbox" id="nbfille+15" value="plus de 15" />
              <label for="nbfille+15" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:text-amber-400 peer-checked:bg-green-gs">plus de 15 filles</label>
          </div>
      </div>
      <button wire:click="resetFilter" class="font-dm-serif text-gray-600 flex items-center gap-2 p-2 bg-white border border-gray-400 rounded-lg my-2 hover:bg-green-gs hover:text-white group">
          Réinitialiser les filtres
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="currentColor" d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z"/></svg>
      </button>
  </div>

  <div class="container mx-auto py-20 px-2">
      <div class="font-dm-serif text-green-gs font-bold text-3xl mb-3">{{$salons->count()}} {{$salons->count() > 1 ? 'Résultats' : 'Résultat'}}</div>
      <div class="grid 2xl:grid-cols-4 xl:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-2">
          @foreach ($salons as $salon)
              <div>{{ $salon->distance }}</div>
              <livewire:salon_card wire:key='{{$salon->id}}' name="{{ $salon->nom_salon }}" canton="{{$salon->canton['nom']}}" ville="{{$salon->ville['nom']}}" avatar='{{$salon->avatar}}' salonId="{{$salon->id}}" />
          @endforeach
      </div>
      <div class="mt-10">{{$salons->links('pagination::simple-tailwind')}}</div>
  </div>
</div> --}}

{{-- <script>
  async function getUserLocation() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
              position => {
                  Livewire.emit('setUserLocation', {
                      latitude: position.coords.latitude,
                      longitude: position.coords.longitude
                  });
              },
              error => {
                  console.error('Erreur lors de la récupération de la localisation :', error);
                  // Fallback to IP-based location if geolocation fails
                  getUserIp();
              }
          );
      } else {
          // Fallback to IP-based location if geolocation is not supported
          getUserIp();
      }
  }

  async function getUserIp() {
      try {
          const response = await fetch('https://ipinfo.io/json');
          const data = await response.json();
          Livewire.emit('setUserIp', data.ip);
      } catch (error) {
          console.error('Erreur lors de la récupération de l\'adresse IP :', error);
      }
  }

  window.onload = function() {
      getUserLocation();
  };
</script> --}}

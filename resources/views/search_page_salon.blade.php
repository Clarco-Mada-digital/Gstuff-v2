@extends('layouts.base')

  @section('pageTitle')
    Escort
  @endsection

  @section('content')

    <div class="w-full min-h-72 py-10 flex flex-col items-center justify-center gap-5 bg-[#E4F1F1]">
      <h1 class="font-dm-serif font-bold text-green-gs text-xl xl:text-4xl text-center" >Découvrez les salons de votre région</h1>
      <div class="w-full px-4 flex flex-col md:flex-row items-center justify-center text-sm xl:text-base gap-2 mb-3">
        <select id="small" class="block w-full xl:w-55 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
          <option selected hidden>Cantons</option>
        </select>
        <select id="small" class="block w-full xl:w-55 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
          <option selected hidden>Villes</option>
        </select>
      </div>
      <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base">
        <div>
          <input type="checkbox" name="escorte" id="agenceEscorte" value="escorte" class="hidden peer">
          <label for="agenceEscorte" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">Agence d'escort</label>
        </div>
        <div>
          <input type="checkbox" name="erotique" id="erotique" value="erotique" class="hidden peer">
          <label for="erotique" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">Salon erotique</label>
        </div>
        <div>
          <input type="checkbox" name="massage" id="massage" value="massage" class="hidden peer">
          <label for="massage" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">Institut de massage</label>
        </div>
        <div>
          <input type="checkbox" name="sauna" id="sauna" value="sauna" class="hidden peer">
          <label for="sauna" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">Sauna</label>
        </div>
      </div>
      <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base">
        <div>
          <input type="checkbox" name="5fille" id="5fille" value="5fille" class="hidden peer">
          <label for="5fille" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">1 à 5 filles</label>
        </div>
        <div>
          <input type="checkbox" name="15fille" id="15fille" value="15fille" class="hidden peer">
          <label for="15fille" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">5 à 15 filles</label>
        </div>
        <div>
          <input type="checkbox" name="plusFille" id="plusFille" value="plusFille" class="hidden peer">
          <label for="plusFille" class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400 peer-checked:bg-green-gs peer-checked:text-amber-400">Plus de 15 filles</label>
        </div>
      </div>
      <button data-modal-target="search-escorte-modal" data-modal-toggle="search-escorte-modal" class="font-dm-serif text-gray-600 flex items-center gap-2 p-2 bg-white border border-gray-400 rounded-lg my-2 hover:bg-green-gs hover:text-white group">
        Réinitialiser les filtres
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><!-- Icon from All by undefined - undefined --><path fill="currentColor" d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z"/></svg>
      </button>
    </div>

    <div class="container mx-auto py-20 px-2">
      <div class="font-dm-serif text-green-gs font-bold text-3xl mb-3">16 Résultats</div>
      <div class="grid xl:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-2">
        @foreach ($salons->slice(0,8) as $salon)
          <x-salon_card name="{{ $salon->prenom }}" canton="{{$salon->canton['nom']}}" ville="{{$salon->ville['nom']}}" salonId="{{$salon->id}}" avatar="{{$salon->avatar}}" />
        @endforeach
      </div>
    </div>

    <x-feedback-section />

    <x-call-to-action-inscription />
  @endsection

  @section('extraScripts')

  @endsection

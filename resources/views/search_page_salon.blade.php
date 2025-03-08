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
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Agence d'escort</span>
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Salon erotique</span>
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Institut de massage</span>
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Sauna</span>
      </div>
      <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base">
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">1 à 5 filles</span>
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">5 à 15 filles</span>
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Plus de 15 filles</span>
      </div>
    </div>

    <div class="container mx-auto py-20 px-2">
      <div class="font-dm-serif text-green-gs font-bold text-3xl mb-3">16 Résultats</div>
      <div class="grid xl:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-2">
        @foreach (array_slice($apiData['escorts'], 0, 8) as $escort)
          <x-escort-card name="{{ $escort['data']['display_name'] }}" canton="Suisse Allemanique" ville="Genève" />
        @endforeach
      </div>
    </div>

    <x-feedback-section />

    <x-call-to-action-inscription />
  @endsection

  @section('extraScripts')

  @endsection

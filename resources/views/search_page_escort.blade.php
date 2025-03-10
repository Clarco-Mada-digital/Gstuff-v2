@extends('layouts.base')

  @section('pageTitle')
    Escort
  @endsection

  @section('content')

    <div class="w-full min-h-72 flex flex-col items-center justify-center bg-[#E4F1F1]">
      <h1 class="font-dm-serif font-bold text-green-gs text-xl xl:text-4xl text-center mb-5">Découvrez les escortes de votre région</h1>
      <div class="w-full px-4 flex flex-col md:flex-row items-center justify-center text-sm xl:text-base gap-2 mb-3">
        <select id="small" class="block w-full xl:w-55 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option selected hidden>Cantons</option>
        </select>
        <select id="small" class="block w-full xl:w-55 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option selected hidden>Villes</option>
        </select>
        <select id="small" class="block w-full xl:w-55 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option selected hidden>Sexe</option>
          <option value="US">Femme</option>
          <option value="CA">Homme</option>
          <option value="FR">Trans</option>
          <option value="DE">Gay</option>
          <option value="DE">Lesbienne</option>
          <option value="DE">Bisexuelle</option>
          <option value="DE">Queer</option>
        </select>
      </div>
      <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base">
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Trans</span>
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Dominatrice BDSM</span>
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Masseuse (no sex)</span>
        <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Escort</span>
      </div>
      <div class="font-dm-serif text-gray-600 flex items-center gap-2 p-2 bg-white border border-gray-400 rounded-lg my-5 hover:bg-green-gs hover:text-white group">
        Plus de filtres
        <svg class="w-5 h-5 p-1 bg-gray-300 rounded-full group-hover:bg-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><!-- Icon from All by undefined - undefined --><g fill="none" fill-rule="evenodd"><path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M16 15c1.306 0 2.418.835 2.83 2H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 1 1 0-2h9.17A3 3 0 0 1 16 15m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2M8 9a3 3 0 0 1 2.762 1.828l.067.172H20a1 1 0 0 1 .117 1.993L20 13h-9.17a3.001 3.001 0 0 1-5.592.172L5.17 13H4a1 1 0 0 1-.117-1.993L4 11h1.17A3 3 0 0 1 8 9m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2m8-8c1.306 0 2.418.835 2.83 2H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 0 1 0-2h9.17A3 3 0 0 1 16 3m0 2a1 1 0 1 0 0 2a1 1 0 0 0 0-2"/></g></svg>
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

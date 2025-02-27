@extends('layouts.base')

  @section('pageTitle')
      Profile page
  @endsection

  @section('content')
  <div class="w-full min-h-[30vh]" style="background: url('images/girl_deco_image.jpg') center center /cover"></div>
  <div class="container flex flex-col xl:flex-row justify-center mx-auto">

    <div class="min-w-1/4 flex flex-col items-center gap-3">

      <div class="w-55 h-55  -translate-y-[50%] rounded-full border-5 border-white mx-auto" style="background: url('{{ asset('images/user_presentation.png') }}') center center /cover">
      </div>
      <a href="#" class="flex items-center gap-3 -mt-[25%]"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M15.275 12.475L11.525 8.7L14.3 5.95l-.725-.725L8.1 10.7L6.7 9.3l5.45-5.475q.6-.6 1.413-.6t1.412.6l.725.725l1.25-1.25q.3-.3.713-.3t.712.3L20.7 5.625q.3.3.3.713t-.3.712zM6.75 21H3v-3.75l7.1-7.125l3.775 3.75z"/></svg>Modifier photo de profil</a>
      <p class="font-bold">{{ Auth::user()->pseudo ?? Auth::user()->prenom ?? Auth::user()->nom_salon }}</p>
      <div class="flex items-center justify-center gap-2 text-green-gs">
        <a href="#" class="flex items-center gap-1"> <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="none"><path d="M4 13.2864C2.14864 14.1031 1 15.2412 1 16.5C1 18.9853 5.47715 21 11 21C16.5228 21 21 18.9853 21 16.5C21 15.2412 19.8514 14.1031 18 13.2864M17 7C17 11.0637 12.5 13 11 16C9.5 13 5 11.0637 5 7C5 3.68629 7.68629 1 11 1C14.3137 1 17 3.68629 17 7ZM12 7C12 7.55228 11.5523 8 11 8C10.4477 8 10 7.55228 10 7C10 6.44772 10.4477 6 11 6C11.5523 6 12 6.44772 12 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg> Suisse Alémanique</a>
        <a href="tel:0000000" class="flex items-center gap-1"> <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M19.95 21q-3.125 0-6.187-1.35T8.2 15.8t-3.85-5.55T3 4.05V3h5.9l.925 5.025l-2.85 2.875q.55.975 1.225 1.85t1.45 1.625q.725.725 1.588 1.388T13.1 17l2.9-2.9l5 1.025V21z"/></svg> 26155489635</a>
      </div>
      <hr class="w-full h-2">
      <div class="w-full flex flex-col gap-0 items-center mb-5">
        <button class="w-full py-2 text-green-gs border-b border-gray-400 text-left hover:bg-green-gs hover:text-white">Mon compte</button>
        <button class="w-full py-2 text-green-gs border-b border-gray-400 text-left hover:bg-green-gs hover:text-white">Mes favoris</button>
        <button class="w-full py-2 text-green-gs border-b border-gray-400 text-left hover:bg-green-gs hover:text-white">Discussion</button>
      </div>
    </div>

    <div class="min-w-3/4 px-3 py-5">
      <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <svg class="shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Danger</span>
        <div class="text-dm-serif">
          <span class="font-bold">Votre profil est actuellement rempli à 10%.</span>
          <div class="my-1.5">
            Pour profiter pleinement des services offerts par Gstuff, nous vous recommandons vivement de compléter vos informations avec des données réelles. Chez Gstuff, nous nous engageons à respecter votre vie privée. Toutes les données collectées sont utilisées pour vous offrir une expérience optimale sur la plateforme. Consultez notre politique de confidentialité ici : <a class="font-bold" href="{{route('pdc')}}">Politique de confidentialité</a>
          </div>
          <a href="#" class="font-dm-serif font-bold border text-green-gs border-green-600 px-2 py-1 hover:bg-green-gs hover:text-white rounded-lg transition-all">Amelioré mon profile</a>
        </div>
      </div>
    </div>

  </div>
  @stop

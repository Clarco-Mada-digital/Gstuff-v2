@extends('layouts.base')
  @section('pageTitle')
      Page d'inscription
  @endsection

  @section('content')
    <div x-data="{'InviteForm': true}" class="relative w-full overflow-x-hidden">

      {{-- Button de switch escort/invtée Form --}}
       <ul class="absolute top-5 left-[50%] -translate-x-[50%] w-[75%] xl:w-[20%] text-xs lg:text-xl font-medium text-center text-gray-500 rounded-lg shadow-sm flex mx-auto dark:divide-gray-700 dark:text-gray-400 z-30">
        <li class="w-1/2 focus-within:z-10">
            <button  x-on:click="InviteForm = true" :class="InviteForm ? 'btn-gs-gradient' : ''" class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-s-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-current="page">Membre</button>
        </li>
        <li class="w-1/2 focus-within:z-10">
            <button x-on:click="InviteForm = false" :class="InviteForm ? '' : 'btn-gs-gradient' " class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-e-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Proffessionel</button>
        </li>
      </ul>

      {{-- Invitée section --}}
      <div x-data="{'registerForm':''}" x-show="InviteForm" class="w-full h-full flex items-center justify-center">

        {{-- Formulaire --}}
        <div  class="w-full xl:w-1/2 mx-auto px-2 pb-5 pt-30 xl:pt-0 xl:px-30 flex flex-col items-center justify-center gap-20">
          <h2 class="font-dm-serif text-2xl font-bold text-center">{{__('Devenir membre')}}</h2>

          {{-- Inscription Invité Formulaire --}}
          <form class="flex w-full mx-auto  flex-col gap-5" action="{{ route('register') }}" method="POST">
            @csrf

            <input type="hidden" name="profile_type" value="invite">

            <div class="relative z-0 w-full mb-5 group">
              <input type="text" name="pseudo" id="floating_pseudo" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('pseudo') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('pseudo') }}" autocomplete="pseudo" required />
              <label for="floating_pseudo" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('pseudo') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">{{__('Pseudo')}} *</label>
              @error('pseudo')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="email" name="email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('email') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
              <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('email') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">{{__('Email address')}} *</label>
              @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="date" name="date_naissance" id="floating_date_naissance" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('date_naissance') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance" required />
              <label for="floating_date_naissance" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('date_naissance') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">{{__('Date anniversaire')}} *</label>
              @error('date_naissance')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="password" name="password" id="floating_pass" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('password') }}" autocomplete="new-password" required />
              <label for="floating_pass" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('password') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">{{__('Mot de passe')}} *</label>
              @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="password" name="password_confirmation" id="floating_pass_conf" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('password') }}" autocomplete="new-password" required />
              <label for="floating_pass_conf" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('password') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">{{__('Confirmer votre mot de passe')}} *</label>
              @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="font-dm-serif font-bold">{{__("Merci de consulter nos conditions générales d'utilisation.")}} <br> Voir les <a class="text-green-gs" href="{{ route('cgv') }}">{{__("condition générales d'utilisation.")}}</a></div>
            <div class="flex items-start mb-5">
              <div class="flex items-center h-5">
                <input id="cgu_accepted" type="checkbox" name="cgu_accepted" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-green-gs dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-gs dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" value="{{ old('cgu_accepted') }}" autocomplete="cgu_accepted" {{ old('cgu_accepted') ? 'checked' : '' }} required />
              </div>
              <label for="cgu_accepted" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 @error('cgu_accepted') text-red-300 dark:text-red-500 @enderror">{{__("J'ai lu et j'accepte les conditions générales")}}</a></label>

            </div>
            <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">{{__('Inscription')}}</button>
          </form>
        </div>

        {{-- Image deco --}}
        <div class="hidden xl:block relative w-1/2 min-h-[90vh]" style="background: url(images/girl_deco_register.jpg) center center /cover"></div>

      </div>

      {{-- Escort section --}}
      <div x-show="!InviteForm" class="w-full h-full flex items-center justify-center">

        {{-- Image deco --}}
        <div class="hidden xl:block relative w-1/2 min-h-[90vh] h-[1000px] py-0 my-0" style="background: url(images/girl_deco_register.jpg) center center /cover"></div>

        {{-- Formulaire --}}
        <div x-data="{'escortForm':true}" class="w-full xl:w-1/2 mx-auto px-2 pt-30 xl:pt-20 pb-5 xl:px-30 flex flex-col items-center justify-center gap-15">
          <h2 class="font-dm-serif text-2xl font-bold text-center">{{__('Inscription pour devenir pro')}}</h2>

          {{-- Button de switch escort/salon Form --}}
          <ul class="hidden xl:flex w-[40%] text-xs lg:text-xl font-medium text-center text-gray-500 rounded-lg shadow-sm mx-auto dark:divide-gray-700 dark:text-gray-400 z-30">
            <li class="w-1/2 focus-within:z-10">
                <button  x-on:click="escortForm = true" :class="escortForm ? 'btn-gs-gradient' : ''" class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-s-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-current="page">Independante</button>
            </li>
            <li class="w-1/2 focus-within:z-10">
                <button x-on:click="escortForm = false" :class="escortForm ? '' : 'btn-gs-gradient' " class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-e-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Salon</button>
            </li>
          </ul>

          <div class="xl:hidden relative z-0 w-full mb-5 group">
            <label for="floating_profile_type" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">profile_type *</label>
            <select x-on:change="(e)=>{document.getElementById('floating_profile_type').value=='escorte' ? escortForm=true : escortForm=false};" id="floating_profile_type" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs peer">
              <option value="escorte">Escorte</option>
              <option value="salon">Salon</option>
            </select>
          </div>

          {{-- Inscription Escort Formulaire --}}
          <form x-show="escortForm" class="w-full mx-auto flex flex-col gap-5" action="{{ route('register') }}" method="POST">
            @csrf
            <input type="hidden" name="profile_type" value="escorte">

            <div class="relative z-0 w-full mb-5 group">
              <input type="text" name="prenom" id="floating_prenom" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('prenom') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('prenom') }}" autocomplete="pseudo" required />
              <label for="floating_prenom" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('prenom') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Prenom *</label>
              @error('prenom')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <label for="floating_genre" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('prenom') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Genre *</label>
              <select name="genre" id="floating_genre" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('genre') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('genre') }}" autocomplete="pseudo" required >
                <option >---</option>
                <option value="femme">Femme</option>
                <option value="homme">Homme</option>
                <option value="non-binaire">non-binaire</option>
                <option value="autre">autre</option>
              </select>
              @error('genre')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="email" name="email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('email') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
              <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('email') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Email address *</label>
              @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="date" name="date_naissance" id="floating_date_naissance" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('date_naissance') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance" required />
              <label for="floating_date_naissance" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('date_naissance') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Date anniversaire *</label>
              @error('date_naissance')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="password" name="password" id="floating_pass" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('password') }}" autocomplete="password" required />
              <label for="floating_pass" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('password') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Mot de passe *</label>
              @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="password" name="confirmed" id="floating_pass_conf" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('password') }}" autocomplete="password" required />
              <label for="floating_pass_conf" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('password') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Confirmer votre mot de passe *</label>
              @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="font-dm-serif font-bold">Merci de consulter nos conditions générales d'utilisation. <br> Voir les <a class="text-green-gs" href="{{ route('cgv') }}">condition générales d'utilisation.</a></div>
            <div class="flex items-start mb-5">
              <div class="flex items-center h-5">
                <input id="terms" type="checkbox" name="cgu_accepted" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-green-gs dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-gs dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" value="{{ old('cgu_accepted') }}" autocomplete="cgu_accepted" required />
              </div>
              <label for="terms" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">J'ai lu et j'accepte les conditions générales</a></label>
            </div>
            <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">Inscription</button>
          </form>

          {{-- Inscription Salon Formulaire --}}
          <form x-show="!escortForm" class="w-full mx-auto flex flex-col gap-3" action="{{ route('register') }}" method="POST">
            @csrf
            <input type="hidden" name="profile_type" value="salon">
            <div class="relative z-0 w-full mb-5 group">
              <input type="text" name="nom_salon" id="floating_nom_salon" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('nom_salon') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('nom_salon') }}" autocomplete="pseudo" required />
              <label for="floating_nom_salon" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('nom_salon') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">nom salon *</label>
              @error('nom_salon')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="text" name="nom_proprietaire" id="floating_nom_proprietaire" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('nom_proprietaire') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('nom_proprietaire') }}" autocomplete="pseudo" required />
              <label for="floating_nom_proprietaire" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('nom_proprietaire') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">nom_proprietaire *</label>
              @error('nom_proprietaire')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <label for="floating_intitule" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('intitule') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Intitule *</label>
              <select name="intitule" id="floating_intitule" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('intitule') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('intitule') }}" autocomplete="intitule" required >
                <option >---</option>
                <option value="monsieur">monsieur</option>
                <option value="madame">madame</option>
                <option value="mademoiselle">mademoiselle</option>
                <option value="autre">autre</option>
              </select>
              @error('intitule')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="email" name="email" id="floating_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('email') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('email') }}" autocomplete="email" required />
              <label for="floating_email" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('email') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Email address *</label>
              @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="date" name="date_naissance" id="floating_date_naissance" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('date_naissance') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('date_naissance') }}" autocomplete="date_naissance" required />
              <label for="floating_date_naissance" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('date_naissance') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Date anniversaire *</label>
              @error('date_naissance')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="password" name="password" id="floating_pass" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('password') }}" autocomplete="password" required />
              <label for="floating_pass" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('password') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Mot de passe *</label>
              @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="password" name="confirmed" id="floating_pass_conf" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('password') }}" autocomplete="password" required />
              <label for="floating_pass_conf" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('password') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Confirmer votre mot de passe *</label>
              @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="font-dm-serif font-bold">Merci de consulter nos conditions générales d'utilisation. <br> Voir les <a class="text-green-gs" href="{{ route('cgv') }}">condition générales d'utilisation.</a></div>
            <div class="flex items-start mb-5">
              <div class="flex items-center h-5">
                <input id="terms" type="checkbox" name="cgu_accepted" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-green-gs dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-gs dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" value="{{ old('cgu_accepted') }}" autocomplete="cgu_accepted" required />
              </div>
              <label for="terms" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">J'ai lu et j'accepte les conditions générales</a></label>
            </div>
            <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">Inscription</button>
          </form>

        </div>

      </div>
    </div>
  @stop

  @section('extraScripts')

  @endsection

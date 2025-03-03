@extends('layouts.base')
  @section('pageTitle')
      Page d'inscription
  @endsection

  @section('content')
    <div x-data="{'InviteForm': true}" class="relative w-full overflow-x-hidden">

      {{-- Invitée section --}}
      <div x-data="{'registerForm':''}"
        x-show="InviteForm"
        x-transition:enter="transition ease-in-out duration-500"
        x-transition:enter-start="opacity-0 -translate-x-[50%]"
        x-transition:enter-end="opacity-100"
        class="w-full h-full flex items-center justify-center">

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
                <input id="cgu_accepted" type="checkbox" name="cgu_accepted" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-green-gs dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-gs dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" autocomplete="cgu_accepted" {{ old('cgu_accepted') ? 'checked' : '' }} required />
              </div>
              <label for="cgu_accepted" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 @error('cgu_accepted') text-red-300 dark:text-red-500 @enderror">{{__("J'ai lu et j'accepte les conditions générales")}}</a></label>

            </div>
            <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">{{__('Inscription')}}</button>
          </form>
        </div>

        {{-- Image deco --}}
        <div class="hidden xl:block relative w-1/2 min-h-[90vh]" style="background: url(images/girl_deco_register.jpg) center center /cover"></div>

      </div>

    </div>
  @stop

  @section('extraScripts')

  @endsection

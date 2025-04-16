@extends('layouts.base')
  @section('pageTitle')
      Page d'inscription
  @endsection

  @section('content')
    <div class="relative w-full overflow-x-hidden">

      {{-- Salon section --}}
      <div class="w-full h-full flex items-center justify-center">

        {{-- Image deco --}}
        <div class="hidden xl:block relative w-1/2 min-h-[90vh] py-0 my-0" style="background: url(images/girl_deco_salon.jpg) center center /cover"></div>

        {{-- Formulaire --}}
        <div class="w-full xl:w-1/2 mx-auto py-3 px-2 xl:px-30 flex flex-col items-center justify-center gap-15">
          <h2 class="font-dm-serif text-2xl font-bold text-center">{{__('Inscription pour les professionels (Salon)')}}</h2>

          {{-- Inscription Salon Formulaire --}}
          <form x-show="!escortForm" class="w-full mx-auto flex flex-col gap-3" action="{{ route('register') }}" method="POST">
            @csrf
            <input type="hidden" name="profile_type" value="salon">
            <div class="relative z-0 w-full mb-5 group">
              <input type="text" name="nom_salon" id="floating_nom_salon" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('nom_salon') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('nom_salon') }}" autocomplete="user_name" required />
              <label for="floating_nom_salon" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('nom_salon') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">nom salon *</label>
              @error('nom_salon')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <input type="text" name="nom_proprietaire" id="floating_nom_proprietaire" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('nom_proprietaire') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('nom_proprietaire') }}" autocomplete="user_name" required />
              <label for="floating_nom_proprietaire" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('nom_proprietaire') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">nom_proprietaire *</label>
              @error('nom_proprietaire')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span> {{ $message }}</p>
              @enderror
            </div>
            <div class="relative z-0 w-full mb-5 group">
              <label for="floating_intitule" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-green-gs peer-focus:dark:text-green-gs peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 @error('intitule') text-red-700 dark:text-red-500 peer-focus:text-red-700 peer-focus:dark:text-red-500 @enderror">Intitule *</label>
              <select name="intitule" id="floating_intitule" class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-amber-300 appearance-none dark:text-white dark:border-amber-600 dark:focus:border-green-gs focus:outline-none focus:ring-0 focus:border-green-gs @error('intitule') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror peer" placeholder=" " value="{{ old('intitule') }}" autocomplete="intitule" required >
                <option >---</option>
                <option value="madame">Madame</option>
                <option value="monsieur">Monsieur</option>
                <option value="mademoiselle">Mademoiselle</option>
                <option value="autre">Autre</option>
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
            <div class="font-dm-serif font-bold">{{__("Merci de consulter nos conditions générales d'utilisation.")}} <br> Voir les <a class="text-green-gs" href="{{ route('static.cgv') }}">{{__("condition générales d'utilisation.")}}</a></div>
            <div class="flex items-start mb-5">
              <div class="flex items-center h-5">
                <input id="cgu_accepted" type="checkbox" name="cgu_accepted" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-green-gs dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-gs dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" autocomplete="cgu_accepted" {{ old('cgu_accepted') ? 'checked' : '' }} required />
              </div>
              <label for="cgu_accepted" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 @error('cgu_accepted') text-red-300 dark:text-red-500 @enderror">{{__("J'ai lu et j'accepte les conditions générales")}}</a></label>

            </div>
            <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-500 dark:focus:ring-amber-600">{{__('Inscription')}}</button>
          </form>

        </div>

      </div>

    </div>
  @stop

  @section('extraScripts')

  @endsection


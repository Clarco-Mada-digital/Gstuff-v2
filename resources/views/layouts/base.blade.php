<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="shortcut icon" href="{{ url('icon-logo.png')}}" type="image/x-icon">

      <title>Gstuff - @yield('pageTitle')</title>

      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

      {{-- js import --}}
      <!-- Alpine Plugins -->
      <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js" defer></script>
      <!-- Alpine Core -->
      {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}
      <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js" defer></script>

      {{-- leaflet --}}
      <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
      <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

      <!-- Styles -->
      <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

      {{-- @vite('resources/css/app.css', 'resources/js/app.js') --}}
      {{ Vite::useBuildDirectory('build')->withEntryPoints(['resources/js/app.js', 'resources/css/app.css']) }}
           
      @livewireStyles    
      @livewireScripts

      <style>
        .lettre{
          animation: flash 1.2s linear infinite;
        }
        .lettre:nth-child(1){
          animation-delay: 0.1s;
        }
        .lettre:nth-child(2){
          animation-delay: 0.2s;
        }
        .lettre:nth-child(3){
          animation-delay: 0.3s;
        }
        .lettre:nth-child(4){
          animation-delay: 0.4s;
        }
        .lettre:nth-child(5){
          animation-delay: 0.5s;
        }
        .lettre:nth-child(6){
          animation-delay: 0.6s;
        }
        .fondu-out {
          opacity: 0;
          transition: opacity 0.4s ease-out;
        }
        @keyframes flash {
          0%{
            color: #ffd230;
            text-shadow: 0 0 7px #ffd230;
          }
          90%{
            color: #05595b;
            text-shadow: none;
          }
          100%{
            color: #ffd230;
            text-shadow: 0 0 7px #ffd230;
          }
        }
      </style>
      @yield('extraStyle')

  </head>
  <body class="w-full min-h-[100vh] overflow-x-hidden relative antialiased font-dm text-sm md:text-base font-normal transition-all">
    @if (session('success'))
      <div id="sessionAlert" class="absolute top-3 ring-2 flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Info</span>
        <div class="ms-3 text-sm font-medium">
          {{ session('success') }}
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#sessionAlert" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
          </svg>
        </button>
      </div>
    @endif

    {{-- Loader section --}}
    <div id="loader" class="absolute top-0 left-0 w-full h-full bg-white z-50">
      <div class="fixed top-[50%] left-[50%] -translate-x-[50%] -translate-y-[50%] w-full h-screen flex items-center gap-4 justify-center text-5xl xl:text-6xl">
        <span class="font-dm-serif text-green-gs lettre">G</span>
        <span class="font-dm-serif text-[#484848] lettre">S</span>
        <span class="font-dm-serif text-[#484848] lettre">T</span>
        <span class="font-dm-serif text-[#484848] lettre">U</span>
        <span class="font-dm-serif text-[#484848] lettre">F</span>
        <span class="font-dm-serif text-[#484848] lettre">F</span>
      </div>
    </div>

    <div x-data="{ imgModal : false, imgModalSrc : '', imgModalDesc : '' }">
      <template @img-modal.window="imgModal = true; imgModalSrc = $event.detail.imgModalSrc; imgModalDesc = $event.detail.imgModalDesc;" x-if="imgModal">
        <div
          x-on:click.stop="imgModal = false"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-90"
          x-transition:enter-end="opacity-100 transform scale-100"
          x-transition:leave="transition ease-in duration-300"
          x-transition:leave-start="opacity-100 transform scale-100"
          x-transition:leave-end="opacity-0 transform scale-90"
          class="p-2 fixed w-full h-full inset-0 z-50 overflow-hidden flex justify-center items-center bg-black/90">
          <div @click.stop class="flex flex-col w-full max-w-[90vw] max-h-[90vh] overflow-auto">
            <div class="z-50">
              <button @click="imgModal = false" class="float-right pt-2 pr-2 outline-none focus:outline-none">
                <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                  <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
                  </path>
                </svg>
              </button>
            </div>
            <div  class="w-full flex items-center justify-center p-2">
              <img class="object-contain object-center w-full max-w-[75vw] max-h-[80vh]" :src="imgModalSrc">
              <p x-text="imgModalDesc" class="text-center text-white"></p>
            </div>
          </div>
        </div>
      </template>
    </div>

    {{-- header --}}
    @livewire('header')

    {{-- Content --}}
    @yield('content')

    <!-- Modal toggle -->
    {{-- <button  class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
      Toggle modal
    </button> --}}

    <!-- Connexion modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-[95%] lg:w-[60%]  max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="w-full flex items-center justify-center">
                        <img class="w-[20%]" src="{{ asset('images/Logo_lg.png') }}" alt="Logo Gstuff" />
                    </h3>
                    <button type="button" class="end-2.5 text-green-gs bg-transparent hover:bg-gray-200 hover:text-amber-400 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body formulaire -->
                @guest
                <div x-data="loginForm" class="relative p-4 md:p-5">

                  {{-- Message du formulaire --}}
                  <div x-show="message" class="flex items-center p-4 mb-4 text-sm  border rounded-lg dark:bg-gray-800" :class="status ? 'text-green-800 border-green-300 bg-green-50 dark:text-green-400 dark:border-green-800' : 'text-red-800 bg-red-50 border-red-300 dark:border-red-800 dark:text-red-400' " role="alert">
                    <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div x-text="message">
                    </div>
                  </div>

                  {{-- Content formulaire --}}
                    <form x-show="showloginForm" x-on:submit.prevent="submitForm()" id="loginForm" class="space-y-4" action="{{ route('login') }}" method="POST">
                      @csrf
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Email') }} *</label>
                            <input x-model="email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  focus:border-amber-300 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white @error('email') border-red-300 @enderror" placeholder="name@company.com" required autocomplete="email" autofocus />
                        </div>
                        <div class="relative" x-data="{ 'pwdShow': true }">
                            <label for="conex_pass" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__('Mot de passe')}} *</label>
                            <input x-model="password" :type="pwdShow ? 'password' : 'text'" name="pass" id="conex_pass" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-amber-300 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />

                            <div class="absolute bottom-3 right-0 pr-3 flex items-center text-sm leading-5">

                              <svg class="h-4 text-gray-700" fill="none" @click="pwdShow = !pwdShow"
                                :class="{'hidden': !pwdShow, 'block':pwdShow }" xmlns="http://www.w3.org/2000/svg"
                                viewbox="0 0 576 512">
                                <path fill="currentColor"
                                  d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                </path>
                              </svg>

                              <svg class="h-4 text-gray-700" fill="none" @click="pwdShow = !pwdShow"
                                :class="{'block': !pwdShow, 'hidden':pwdShow }" xmlns="http://www.w3.org/2000/svg"
                                viewbox="0 0 640 512">
                                <path fill="currentColor"
                                  d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                </path>
                              </svg>

                            </div>

                        </div>
                        <div class="flex justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input x-model="remember" id="remember" type="checkbox" name="remember" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-amber-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-amber-300 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" {{ old('remember') ? 'checked' : ''}} />
                                </div>
                                <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{__('Se souvenir de moi')}}</label>
                            </div>
                            {{-- @if (Route::has('password.request')) --}}
                            <a href="#" x-on:click="showloginForm = false" class="text-sm text-green-gs hover:underline hover:text-amber-300 dark:text-green-gs">{{__('Mot de passe oublié')}}</a>
                            {{-- @endif --}}
                        </div>
                        <button type="submit" class="w-full text-white bg-green-gs hover:bg-amber-300 hover:text-green-gs focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-gs dark:hover:bg-green-gs/30">
                          <svg x-show="loadingRequest" aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-green-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                          </svg>
                          {{__('Se connecter')}}
                        </button>
                        <div class="flex items-center justify-center">
                          <div class="flex-1 bg-black h-1"></div>
                          <span class="font-dm-serif p-2 text-xl">Ou</span>
                          <div class="flex-1 bg-black h-1"></div>
                        </div>
                        <div class="flex flex-col gap-2 py-5 w-full text-sm lg:text-base items-center justify-center transition-all">
                          <a href="{{ route('registerForm') }}" class="w-full p-3 text-center border border-amber-300 hover:bg-amber-300 hover:text-green-gs">S'inscrire gratuitement</a>
                          <a href="{{ route('escort_register') }}" class="w-full p-3 text-center border border-amber-300 hover:bg-amber-300 hover:text-green-gs">S'inscrire en tant qu'escorte (Indépendante)</a>
                          <a href="{{ route('salon_register') }}" class="w-full p-3 text-center border border-amber-300 hover:bg-amber-300 hover:text-green-gs">S'inscrire en tant que professionnel</a>
                        </div>
                    </form>

                    {{-- Formulaire de reset pwd --}}
                    <form x-show="!showloginForm" x-on:submit.prevent="submitForm(true)" id="resetPwdForm" class="space-y-4" action="{{ route('reset_password') }}" method="POST">
                      @csrf
                      <div>
                        <label for="res_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Email') }} *</label>
                        <input x-model="emailReset" type="email" name="res_email" id="res_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  focus:border-amber-300 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder=" " required autofocus />
                      </div>
                      <a href="#" x-on:click="showloginForm = true" class="text-sm text-green-gs hover:underline hover:text-amber-300 dark:text-green-gs">{{__('Retour au formulaire de connexion')}}</a>
                      <button type="submit" class="w-full text-white bg-green-gs hover:bg-amber-300 hover:text-green-gs focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-gs dark:hover:bg-green-gs/30">
                        <svg x-show="loadingRequest" aria-hidden="true" class="inline w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-green-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                          <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        {{__('Reunitialisé mon mot de passe')}}
                      </button>
                    </form>

                </div>
                @endguest

                {{-- Modal body deja connecter --}}
                @auth
                <div class="relative text-center p-4 md:p-5">
                  Vous êtes déjà connecté en tant que {{ Auth::user()->user_name ?? Auth::user()->name ?? Auth::user()->nom_salon }}.
                </div>
                @endauth
            </div>
        </div>
    </div>


    {{-- Footer --}}
    <div class="relative w-full min-h-[375px] bg-green-gs transition-all mt-10 z-30">
      <div class="flex flex-col items-center lg:flex-row justify-center lg:items-start gap-10 lg:gap-40 container mx-auto py-24 text-white text-sm xl:text-base">
        <div class="flex flex-col items-center justify-center w-full lg:w-auto lg:items-start gap-3">
          <a href="{{ route('home') }}" class="w-full">
            <img class="mx-auto lg:m-0 w-60" src="{{ url('images/Logo_lg.svg') }}" alt="Logo gstuff" />
          </a>
          <p class="w-96 lg:text-start text-center">Votre portail suisse des rencontres érotique sécurisées et inclusives.</p>
        </div>

        <div class="flex flex-col items-center lg:items-start gap-2">
          <h3 class="font-dm-serif text-4xl font-bold mb-3">Liens rapides</h3>
          @foreach ($apiData['cantons']->slice(0, 5) as $canton)
          <a href="{{route('escortes').'?selectedCanton='.$canton->id}}">Escort girl {{ $canton->nom }}</a>
          @endforeach
        </div>

        <div class="flex flex-col items-center lg:items-start gap-2">
          <h3 class="font-dm-serif text-4xl font-bold mb-3">Liens rapides</h3>
          <a href="{{ route('glossaires.index') }}">Glossaire</a>
          <a href="{{ route('faq') }}">FAQ</a>
          <a href="{{ route('about')}}">Qui sommes-nous ?</a>
          <a href="{{ route('cgv') }}">Conditions générales de vente (GGV)</a>
          <a href="{{ route('contact') }}">Contact</a>
        </div>

      </div>
    </div>
    <div class="relative flex items-center justify-center bg-black text-white text-xs lg:text-base py-7 transition-all z-30">
      Copyright 2025 - <a href="{{ route('home') }}" class="text-yellow-500 mx-2"> Gstuff </a> - <a href="{{ route('pdc') }}" class="text-yellow-500 mx-2"> Politique de confidentialité </a>
    </div>

    @livewire('chat')
    
    <script>
      const mega_menu_link = document.getElementById('mega-menu-full-dropdown-button');
      const mega_menu_item = document.getElementById('mega-menu-full-dropdown');
      const loader = document.getElementById('loader');

      const ESrightBtn = document.getElementById('arrowESScrollRight')
      const ESleftBtn = document.getElementById('arrowESScrollLeft')
      const EScontainer = document.getElementById('ESContainer')

      ESrightBtn.addEventListener('click', ()=>{scrollByPercentage(EScontainer, false)})
      ESleftBtn.addEventListener('click', ()=>{scrollByPercentage(EScontainer, true)})

      window.addEventListener('load', ()=>{
        loader.classList.add('fondu-out');
        setTimeout(() => {
          loader.classList.add('hidden');
        }, 500);
      })

      // mega_menu_link.addEventListener('mouseover', (e)=>{
      //   mega_menu_item.classList.remove('hidden');
      // })
      // mega_menu_item.addEventListener('mouseover', (e)=>{
      //   mega_menu_item.classList.remove('hidden');
      // })
      // mega_menu_item.addEventListener('mouseleave', (e)=>{
      //   mega_menu_item.classList.add('hidden');
      // });
      // Fonction pour faire défiler verticalement ou horizontalement en pourcentage
      function scrollByPercentage(element, ltr=true, percentageX=0, percentageY=0) {
          // Si aucun élément n'est fourni, on utilise la fenêtre
          const target = element || document.documentElement;

          // Nombre d'element dans le container
          let containerChild = parseInt(element.children.length);
          itemPercent = Math.ceil(100 / containerChild) ;

          if (percentageX == 0) {
            percentageX = itemPercent +1;
          }

          // Calcul des distances de défilement
          const scrollX = ltr ? (target.scrollWidth - target.clientWidth) * (percentageX / 100) : -(target.scrollWidth - target.clientWidth) * (percentageX / 100);
          // const scrollY = (target.scrollHeight - target.clientHeight) * (percentageY / 100);

          // Défilement vers la position calculée
          target.scrollBy({
              left: scrollX,
              top: scrollY,
              behavior: 'smooth' // Optionnel : pour un défilement fluide
          });
      }

      function loginForm() {
        return {
          email: '',
          emailReset: '',
          password: '',
          remember: false,
          message: '',
          showloginForm: true,
          loadingRequest: false,
          status: true,
          async submitForm(reset=false) {
            this.loadingRequest = true;
            this.message = "";
            if (reset) {
              Resetform = document.getElementById('resetPwdForm');
              try {
                const response = await fetch(Resetform.action, {
                    method: Resetform.method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                      email: this.emailReset,
                    })
                });

                if (response.ok) {
                  const data = await response.json();
                  this.loadingRequest = false;
                  this.message = data.message;
                  this.status = data.success;
                  // Redirige l'utilisateur ou effectue une autre action
                  // window.location.href = '{{ route('profile.index') }}';
                } else {
                  const error = await response.json();
                  this.loadingRequest = false;
                  this.message = error.message;
                  this.status = error.success;
                }
              } catch (error) {
                  this.message = 'Une erreur est survenue. Veuillez réessayer.';
                  this.loadingRequest = false;
                  this.status = false;
              }
            }else{
              form = document.getElementById('loginForm');
              try {
                  const response = await fetch(form.action, {
                      method: form.method,
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                      },
                      body: JSON.stringify({
                          email: this.email,
                          password: this.password,
                          remember: this.remember
                      })
                  });

                  if (response.ok) {
                    const data = await response.json();
                    this.loadingRequest = false;
                    this.message = data.message;
                    this.status = data.success;
                    // Redirige l'utilisateur ou effectue une autre action
                    window.location.href = '{{ route('profile.index') }}';
                  } else {
                    const error = await response.json();
                    this.loadingRequest = false;
                    this.message = error.message;
                    this.status = error.success;
                  }
              } catch (error) {
                  this.message = 'Une erreur est survenue. Veuillez réessayer.';
                  this.loadingRequest = false;
                  this.status = false;
              }
            }
          }

        //   async resetPwdForm(){
        //     this.loadingRequest = true;

        // };
        }
      }

      // Script for multi-object-Select
      function multiObjectSelect(options, value) {
          return {
              options: options,
              selectedOptions: value != "" ? value : [],
              search: '',
              filteredOptions: [],
              isOpen: false,

              init() {
                  this.filteredOptions = this.options;
              },

              filterOptions() {
                  this.filteredOptions = this.options.filter(option =>
                      option.toLowerCase().includes(this.search.toLowerCase())
                  );
              },

              selectOption(option) {
                  if (!this.selectedOptions.includes(option)) {
                      this.selectedOptions.push(option);
                  }
                  this.search = '';
                  //this.filterOptions();
                  this.isOpen = false;
              },

              removeOption(index) {
                  this.selectedOptions.splice(index, 1);
              },

              closeDropdown() {
                  setTimeout(() => {
                      this.isOpen = false;
                  }, 200);
              },
              selectedValues(){
                let val = [];
                this.selectedOptions.map((option)=>{
                  val.push(option['id']);
                })
                return val;
              }
          };
      }

      // Script for multi-select
      function multiSelect(options, value) {
        return {
            options: options,
            selectedOptions: value != "" ? value : [],
            search: '',
            filteredOptions: [],
            isOpen: false,

            init() {
                this.filteredOptions = this.options;
            },

            filterOptions() {
                this.filteredOptions = this.options.filter(option =>
                    option.toLowerCase().includes(this.search.toLowerCase())
                );
            },

            selectOption(option) {
                if (!this.selectedOptions.includes(option)) {
                    this.selectedOptions.push(option);
                }
                this.search = '';
                this.filterOptions();
                this.isOpen = false;
            },

            removeOption(index) {
                this.selectedOptions.splice(index, 1);
            },

            closeDropdown() {
                setTimeout(() => {
                    this.isOpen = false;
                }, 200);
            },
            selectedValues(){
              let val = [];
              this.selectedOptions.map((option)=>{
                val.push(option);
              })
              return val;
            }
        };
      }

      // Pour le gallerie
      function gallery() {
        return {
          viewMode: 'grid', 
          fullscreen: false, 
          currentMedia: null, 
          showDeleteModal: false,
          mediaToDelete: null, 
          deleteModalTitle: '',
          currentMediaIndex:0,

          get mediaCount() { return this.$wire.gallerieItem.length; },

          navigateMedia(direction) {
            let newIndex = this.currentMediaIndex + direction;
            if (newIndex >= 0 && newIndex < this.mediaCount) {
              this.currentMediaIndex = newIndex;
              this.updateCurrentMedia();
            }
          },
          updateCurrentMedia() {
            let media = this.$wire.gallerieItem[this.currentMediaIndex];
            this.currentMedia = {
              type: media.type,
              url: media.url,
              title: media.title,
              description: media.description
            };
          },
          // Modifier les clics initiaux pour mettre à jour l'index
          initGallery() {
            this.$watch('fullscreen', (value) => {
              if (value) {
                // Trouver l'index du média actuel
                this.currentMediaIndex = this.$wire.gallerieItem.findIndex(
                  m => m.url === this.currentMedia.url
                );
              }
            });
          }
        }
      }

    </script>
    @yield('extraScripts')
    @yield('specialScripts')
    @stack('scripts')

  </body>  
</html>

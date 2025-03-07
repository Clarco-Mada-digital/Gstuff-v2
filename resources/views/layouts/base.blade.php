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
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js" defer></script>

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
        @vite('resources/css/app.css')
        {{-- <link href="resources/css/app.css" rel="stylesheet"> --}}
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
    <body class="w-full overflow-x-hidden relative antialiased font-dm text-sm md:text-base font-normal transition-all">
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
      <nav class="relative bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-900 shadow-lg z-30">
        <div x-data="{'showUserDrop':false}" class="flex flex-wrap lg:justify-between items-center mx-auto max-w-screen-xl p-4 gap-3">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img class="w-24 lg:w-44" src="{{ asset('images/Logo_lg.svg') }}" alt="Gstuff Logo" />
            </a>

            {{-- Btn humberger for mobile --}}
            <button data-collapse-toggle="mega-menu-full" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg xl:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 -order-1" aria-controls="mega-menu-full" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>

            {{-- Menu --}}
            <div id="mega-menu-full" class="items-center m-auto lg:m-0 justify-between font-medium hidden w-full order-1 xl:flex xl:w-auto">
                <ul class="flex flex-col p-4 xl:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 xl:space-x-8 rtl:space-x-reverse xl:flex-row xl:mt-0 xl:border-0 xl:bg-white dark:bg-gray-800 xl:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                      <a href="{{route('escortes')}}" id="mega-menu-full-dropdown-button" data-collapse-toggle="mega-menu-full-dropdown" class="flex items-center py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">Escorte <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('salons')}}" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded-sm xl:w-auto hover:bg-gray-100 xl:hover:bg-transparent xl:border-0 xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">Salon </a>
                    </li>
                    <li>
                        <a href="{{ url('about') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">A propos</a>
                    </li>
                    <li>
                        <a href="{{ url('glossaires') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">Glossaire</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                    </li>
                </ul>

              <div class="flex items-center mx-2 space-x-1 md:space-x-0">
                <button type="button" data-dropdown-toggle="language-dropdown-menu" class="inline-flex items-center font-medium justify-center px-4 py-2 text-sm text-gray-900 dark:text-white rounded-lg cursor-pointer hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white">
                  <svg  class="w-5 h-5 rounded-full me-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><mask id="circleFlagsLangFr0"><circle cx="256" cy="256" r="256" fill="#fff"/></mask><g mask="url(#circleFlagsLangFr0)"><path fill="#eee" d="M167 0h178l25.9 252.3L345 512H167l-29.8-253.4z"/><path fill="#0052b4" d="M0 0h167v512H0z"/><path fill="#d80027" d="M345 0h167v512H345z"/></g></svg>
                  Fr
                </button>

                <!-- Dropdown Langue -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700" id="language-dropdown-menu">
                  <ul class="py-2 font-medium" role="none">
                    <li>
                      <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                        <div class="inline-flex items-center">
                          <svg aria-hidden="true" class="h-3.5 w-3.5 rounded-full me-2" xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-us" viewBox="0 0 512 512"><g fill-rule="evenodd"><g stroke-width="1pt"><path fill="#bd3d44" d="M0 0h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z" transform="scale(3.9385)"/><path fill="#fff" d="M0 10h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0zm0 20h247v10H0z" transform="scale(3.9385)"/></g><path fill="#192f5d" d="M0 0h98.8v70H0z" transform="scale(3.9385)"/><path fill="#fff" d="M8.2 3l1 2.8H12L9.7 7.5l.9 2.7-2.4-1.7L6 10.2l.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7L74 8.5l-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 7.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 24.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 21.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 38.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 35.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 52.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 49.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm-74.1 7l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7H65zm16.4 0l1 2.8H86l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm-74 7l.8 2.8h3l-2.4 1.7.9 2.7-2.4-1.7L6 66.2l.9-2.7-2.4-1.7h3zm16.4 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8H45l-2.4 1.7 1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9zm16.4 0l1 2.8h2.8l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h3zm16.5 0l.9 2.8h2.9l-2.3 1.7.9 2.7-2.4-1.7-2.3 1.7.9-2.7-2.4-1.7h2.9zm16.5 0l.9 2.8h2.9L92 63.5l1 2.7-2.4-1.7-2.4 1.7 1-2.7-2.4-1.7h2.9z" transform="scale(3.9385)"/></g></svg>
                          English (US)
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                        <div class="inline-flex items-center">
                          <svg class="h-3.5 w-3.5 rounded-full me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-de" viewBox="0 0 512 512"><path fill="#ffce00" d="M0 341.3h512V512H0z"/><path d="M0 0h512v170.7H0z"/><path fill="#d00" d="M0 170.7h512v170.6H0z"/></svg>
                          Deutsch
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                        <div class="inline-flex items-center">
                          <svg class="h-3.5 w-3.5 rounded-full me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" id="flag-icon-css-it" viewBox="0 0 512 512"><g fill-rule="evenodd" stroke-width="1pt"><path fill="#fff" d="M0 0h512v512H0z"/><path fill="#009246" d="M0 0h170.7v512H0z"/><path fill="#ce2b37" d="M341.3 0H512v512H341.3z"/></g></svg>
                          Italiano
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                        <div class="inline-flex items-center">
                          <svg class="h-3.5 w-3.5 rounded-full me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><path fill="#ffce31" d="M2 32c0 5.9 1.7 11.4 4.6 16h50.7c2.9-4.6 4.6-10.1 4.6-16s-1.7-11.4-4.6-16H6.6C3.7 20.6 2 26.1 2 32"/><path fill="#ed4c5c" d="M57.4 16C52.1 7.6 42.7 2 32 2S11.9 7.6 6.6 16zM6.6 48c5.3 8.4 14.7 14 25.4 14s20.1-5.6 25.4-14z"/><path fill="#c8b100" d="M9.2 28.7h3.2v1.8H9.2zm0 13.2h3.3v1.7H9.2z"/><path fill="#ed4c5c" d="M8.9 39.1c-.3.2-.5.4-.5.5q0 .15.3.3c.2.1.4.3.3.5q.3-.3.3-.6c0-.3-.2-.6-.4-.7"/><path fill="#fff" d="M9.7 30.5H12v11.4H9.7z"/><g fill="#ed4c5c"><path d="M14.4 34.7c-.5-.2-1.4-.4-2.4-.4c-.3 0-.7 0-1.1.1c-1.4.2-2.5.8-2.4 1.2L8 34.5c-.1-.5 1.1-1.1 2.6-1.4c.5-.1 1-.1 1.4-.1c1 0 1.9.1 2.4.3z"/><path d="M9.7 36.2c-.6 0-1.1-.2-1.1-.5c0-.2.2-.5.6-.7h.6zm2.3-.9q.6.15.9.3c.1.1-.3.5-.9.8z"/><path d="M8.2 38.4c-.1-.2.6-.6 1.5-.9c.4-.1.7-.3 1.2-.5c1.2-.5 2.2-1.2 2-1.4l.2 1.2c.1.2-.7.8-1.9 1.4c-.4.2-1.1.5-1.5.6c-.7.2-1.3.6-1.3.7z"/></g><path fill="#c8b100" d="M30.7 28.7h3.2v1.8h-3.2zm-.1 13.2h3.3v1.7h-3.3z"/><path fill="#ed4c5c" d="M34.2 39.1c.3.2.5.4.5.5q0 .15-.3.3c-.2.2-.4.5-.3.6q-.3-.3-.3-.6c0-.4.2-.7.4-.8"/><path fill="#fff" d="M31.1 30.5h2.3v11.4h-2.3z"/><g fill="#ed4c5c"><path d="M28.7 34.7c.5-.2 1.4-.4 2.4-.4c.3 0 .7 0 1.1.1c1.4.2 2.5.8 2.4 1.2l.5-1.2c.1-.5-1.1-1.1-2.6-1.4h-1.4c-1 0-1.9.1-2.4.3z"/><path d="M33.4 36.2c.6 0 1.1-.2 1.1-.5c0-.2-.2-.5-.6-.7h-.6zm-2.3-.9q-.6.15-.9.3c-.1.1.3.5.9.8z"/><path d="M34.9 38.4c.1-.2-.6-.6-1.5-.9c-.4-.1-.7-.3-1.2-.5c-1.2-.5-2.2-1.2-2-1.4l-.2 1.2c-.1.2.7.8 1.9 1.4c.4.2 1.1.5 1.5.6c.7.2 1.3.7 1.2.8zM21.5 22.3c1.9 0 5.8.4 7.2 1.8c-1.5 3.6-3.9 2.1-7.2 2.1c-3.2 0-5.7 1.5-7.2-2.1c1.4-1.4 5.2-1.8 7.2-1.8"/></g><path fill="#c8b100" d="M26.4 26.3c-1.2-.7-3-.8-4.9-.8s-3.7.2-4.9.8L17 28c1.1.3 2.7.5 4.5.5s3.3-.2 4.5-.5zm1.7-4.3c-.4-.3-1.2-.6-1.9-.6c-.3 0-.6 0-.9.1c0 0-.6-.8-2-.8c-.5 0-.9.1-1.3.3v-.1c-.1-.2-.3-.4-.5-.4s-.5.3-.5.5v.1c-.4-.2-.8-.3-1.3-.3c-1.4 0-2 .9-2 .8c-.3-.1-.6-.1-.9-.1c-4.6 0-2.3 3.1-2.3 3.1l.5-.6c-1.1-1.4-.1-2.2 1.9-2.2c.3 0 .5 0 .7.1c-.7 1 .6 1.9.6 1.9l.3-.5c-.7-.5-.8-2.2 1.2-2.2c.5 0 .9.1 1.3.4c0 .1-.1 1.5-.2 1.7l.8.7l.8-.7c-.1-.3-.2-1.6-.2-1.7c.3-.2.8-.4 1.3-.4c2.1 0 2.1 1.7 1.2 2.2l.3.5s1.1-.9.6-1.9c.2 0 .5-.1.7-.1c2.4 0 2.5 1.8 1.9 2.2l.4.6c-.2 0 .9-1.4-.5-2.6"/><path fill="#005bbf" d="M20.9 20.1c0-.3.3-.6.6-.6c.4 0 .6.3.6.6s-.3.6-.6.6s-.6-.3-.6-.6"/><path fill="#c8b100" d="M21.3 18.4v.3H21v.3h.3v1h-.4v.3h1.2l.1-.2l-.1-.1h-.4v-1h.3v-.3h-.3v-.3z"/><path fill="#ed4c5c" d="M21.5 28.3c-1.6 0-3-.2-4.1-.5c1.1-.3 2.5-.5 4.1-.5s3 .2 4.1.5c-1 .3-2.5.5-4.1.5"/><path fill="#fff" d="M21.6 45.6c-1.9 0-3.7-.5-5.3-1.2c-1.2-.6-1.9-1.7-1.9-3v-4.8h14.4v4.8c0 1.3-.8 2.5-1.9 3c-1.6.8-3.4 1.2-5.3 1.2m-.1-17h7.2v8h-7.2z"/><path fill="#ed4c5c" d="M21.6 41.4c0 1.9-1.6 3.4-3.6 3.4s-3.6-1.5-3.6-3.4v-4.8h7.2z"/><path fill="#c8b100" d="M15.9 44.2c.2.1.5.3.9.4v-8.2H16zm-1.6-2.9c0 1 .4 1.8.8 2.2v-7.1h-.8z"/><path fill="#c7b500" d="M17.5 44.8h.8v-8.4h-.8z"/><path fill="#c8b100" d="M19.1 44.6c.3-.1.7-.3.9-.4v-7.8h-.8z"/><path fill="#ed4c5c" d="M14.3 28.6h7.2v8h-7.2z"/><path fill="#c8b100" d="M20.8 43.5c.4-.3.7-1 .8-1.8v-5.2h-.8z"/><path fill="#ed4c5c" d="M28.8 36.6v4.8c0 1.9-1.6 3.4-3.6 3.4s-3.6-1.5-3.6-3.4v-4.8zM26.2 30c.3.6.3 2.1-.6 1.8c.2.1.3.8.6 1.2c.5.6 1.1.1 1-.6c-.2-1.1-.1-1.8.1-2.9c0 .1.5.1.7-.1c-.1.3-.2.7 0 .7c-.2.3-.7.8-.8 1.1c-.1.7 1 2-.2 2.3c-.8.2-.3.8 0 1.1c0 0-.4 1.3-.2 1.2c-.8.3-.6-.4-.6-.4c.4-1.2-.7-1.3-.6-1.5c-1-.1.1.9-.8.9c-.2 0-.6.2-.6.2c-1.1-.1-.5-1.1-.1-1c.3.1.6.6.6-.1c0 0-.5-.8.8-.8c-.5 0-.8-.4-1-.9c-.2.1-.5.6-1.6.7c0 0-.3-1.1 0-.9c.4.2.6.2 1-.2c-.2-.3-1.4-.7-1.2-1.4c0-.2.6-.5.6-.5c-.1.5.2 1 .8 1c.8.1.5-.2.6-.4s.7.1.5-.4c0-.1-.7-.2-.5-.5c.4-.5 1-.1 1.5.4m-4.6 14.6l-.2-.5l.2-.6l.2.6z"/><path fill="#c8b100" d="M16.5 30.3v.5h.2v.4h-.5v1h.3v2.2h-.6v1.1H20v-1.1h-.5v-2.2h.2v-1h-.5v-.4h.3v-.5h-1v.5h.2v.4h-.5V30h.3v-.5h-1.1v.5h.3v1.2h-.5v-.4h.2v-.5zm11.3 12.3v-5h-5.2v5l2.4 1.1h.3zM25 38v1.7L23.3 38zm-2.1.1l2 2l-2 2zm.2 4.4l1.9-1.9v2.8zm2.2.8v-2.8l1.9 1.9zm2.1-1.2l-2-2l2-2zM25.3 38H27l-1.7 1.7z"/><path fill="#ed4c5c" d="M19.2 36.5c0-1.5 1-2.6 2.3-2.6s2.3 1.2 2.3 2.6s-1 2.6-2.3 2.6s-2.3-1.1-2.3-2.6"/><path fill="#005bbf" d="M19.9 36.5c0-1.1.7-1.9 1.6-1.9s1.6.9 1.6 1.9c0 1.1-.7 1.9-1.6 1.9c-.8.1-1.6-.8-1.6-1.9"/><path fill="#c8b100" d="m20.8 35.2l-.4 1.1l.3.1l-.2.4h.6l-.2-.4l.3-.1zm1.5 0l-.4 1.1l.3.1l-.2.4h.6l-.1-.4l.3-.1zm-.7 1.3l-.5 1.1l.3.1l-.1.4h.5l-.1-.4l.3-.1z"/></svg>
                          Spain
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            {{-- Search --}}
            <div class="flex ml-auto mr-0 xl:order-1">
              <button data-modal-target="search-modal" data-modal-toggle="search-modal" type="button" class="md:hidden text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-1">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z" stroke="#05595B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                <span class="sr-only">Search</span>
              </button>
              <div data-modal-target="search-modal" data-modal-toggle="search-modal" class="relative hidden md:block">
                <input type="text" id="search-navbar" class="block w-full p-2 pe-10 text-sm text-gray-950 border border-gray-300 rounded-xl bg-gray-100 focus:ring-green-gs focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Recherche...">
                <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z" stroke="#05595B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  <span class="sr-only">Search icon</span>
                </div>
              </div>
            </div>

            @guest
              {{-- Btn de connexion --}}
              <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button" class="hidden xl:block text-black btn-gs-gradient font-bold focus:outline-none rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-yellow-800 lg:order-1">
                Connexion/Inscription
              </button>
              <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"  type="button" class="xl:hidden text-yellow-500 hover:bg-yellow-500 hover:text-white focus:outline-none font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:border-yellow-500 dark:text-yellow-500 dark:hover:text-white dark:focus:ring-yellow-800 dark:hover:bg-yellow-500 xl:order-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M15 14c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4m-9-4V7H4v3H1v2h3v3h2v-3h3v-2m6 2a4 4 0 0 0 4-4a4 4 0 0 0-4-4a4 4 0 0 0-4 4a4 4 0 0 0 4 4"/></svg>
                <span class="sr-only">Icon description</span>
              </button>
            @endguest

            @auth
              {{-- Notification icon and user presentation --}}
              <div x-data="{userType: '{{ Auth::user()->profile_type}}'}" class="flex gap-3 xl:order-1">
                <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" type="button" class="relative bg-gray-200 focus:outline-none font-medium rounded-full text-sm p-2 text-center inline-flex items-center xl:order-1 cursor-pointer">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5 19q-.425 0-.712-.288T4 18t.288-.712T5 17h1v-7q0-2.075 1.25-3.687T10.5 4.2v-.7q0-.625.438-1.062T12 2t1.063.438T13.5 3.5v.7q2 .5 3.25 2.113T18 10v7h1q.425 0 .713.288T20 18t-.288.713T19 19zm7 3q-.825 0-1.412-.587T10 20h4q0 .825-.587 1.413T12 22"/></svg>
                  <span class="sr-only">Icon description</span>
                  <div class="absolute block w-3 h-3 bg-red-500 border-2 border-white rounded-full top-1 start-5.5 dark:border-gray-900"></div>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownNotification" class="z-20 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-800 dark:divide-gray-700" aria-labelledby="dropdownNotificationButton">
                  <div class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
                      Notifications
                  </div>
                  <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    <a href="#" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                      <div class="shrink-0">
                        <img class="rounded-full w-11 h-11" src="{{ asset('images/icons/user_icon.svg')}}" alt="Jese image">
                        <div class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-blue-600 border border-white rounded-full dark:border-gray-800">
                          <svg class="w-2 h-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                            <path d="M1 18h16a1 1 0 0 0 1-1v-6h-4.439a.99.99 0 0 0-.908.6 3.978 3.978 0 0 1-7.306 0 .99.99 0 0 0-.908-.6H0v6a1 1 0 0 0 1 1Z"/>
                            <path d="M4.439 9a2.99 2.99 0 0 1 2.742 1.8 1.977 1.977 0 0 0 3.638 0A2.99 2.99 0 0 1 13.561 9H17.8L15.977.783A1 1 0 0 0 15 0H3a1 1 0 0 0-.977.783L.2 9h4.239Z"/>
                          </svg>
                        </div>
                      </div>
                      <div class="w-full ps-3">
                          <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">New message from <span class="font-semibold text-gray-900 dark:text-white">Jese Leos</span>: "Hey, what's up? All set for the presentation?"</div>
                          <div class="text-xs text-blue-600 dark:text-blue-500">a few moments ago</div>
                      </div>
                    </a>
                    <a href="#" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                      <div class="shrink-0">
                        <img class="rounded-full w-11 h-11" src="{{ asset('images/icons/user_icon.svg')}}" alt="Joseph image">
                        <div class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-gray-900 border border-white rounded-full dark:border-gray-800">
                          <svg class="w-2 h-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Zm11-3h-2V5a1 1 0 0 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 0 0 2 0V9h2a1 1 0 1 0 0-2Z"/>
                          </svg>
                        </div>
                      </div>
                      <div class="w-full ps-3">
                          <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"><span class="font-semibold text-gray-900 dark:text-white">Joseph Mcfall</span> and <span class="font-medium text-gray-900 dark:text-white">5 others</span> started following you.</div>
                          <div class="text-xs text-blue-600 dark:text-blue-500">10 minutes ago</div>
                      </div>
                    </a>
                    <a href="#" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                      <div class="shrink-0">
                        <img class="rounded-full w-11 h-11" src="{{ asset('images/icons/user_icon.svg')}}" alt="Bonnie image">
                        <div class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-red-600 border border-white rounded-full dark:border-gray-800">
                          <svg class="w-2 h-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M17.947 2.053a5.209 5.209 0 0 0-3.793-1.53A6.414 6.414 0 0 0 10 2.311 6.482 6.482 0 0 0 5.824.5a5.2 5.2 0 0 0-3.8 1.521c-1.915 1.916-2.315 5.392.625 8.333l7 7a.5.5 0 0 0 .708 0l7-7a6.6 6.6 0 0 0 2.123-4.508 5.179 5.179 0 0 0-1.533-3.793Z"/>
                          </svg>
                        </div>
                      </div>
                      <div class="w-full ps-3">
                          <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"><span class="font-semibold text-gray-900 dark:text-white">Bonnie Green</span> and <span class="font-medium text-gray-900 dark:text-white">141 others</span> love your story. See it and view more stories.</div>
                          <div class="text-xs text-blue-600 dark:text-blue-500">44 minutes ago</div>
                      </div>
                    </a>
                    <a href="#" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                      <div class="shrink-0">
                        <img class="rounded-full w-11 h-11" src="{{ asset('images/icons/user_icon.svg')}}" alt="Leslie image">
                        <div class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-green-400 border border-white rounded-full dark:border-gray-800">
                          <svg class="w-2 h-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z"/>
                          </svg>
                        </div>
                      </div>
                      <div class="w-full ps-3">
                          <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"><span class="font-semibold text-gray-900 dark:text-white">Leslie Livingston</span> mentioned you in a comment: <span class="font-medium text-blue-500" href="#">@bonnie.green</span> what do you say?</div>
                          <div class="text-xs text-blue-600 dark:text-blue-500">1 hour ago</div>
                      </div>
                    </a>
                    <a href="#" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                      <div class="shrink-0">
                        <img class="rounded-full w-11 h-11" src="{{ asset('images/icons/user_icon.svg')}}" alt="Robert image">
                        <div class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-purple-500 border border-white rounded-full dark:border-gray-800">
                          <svg class="w-2 h-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                            <path d="M11 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm8.585 1.189a.994.994 0 0 0-.9-.138l-2.965.983a1 1 0 0 0-.685.949v8a1 1 0 0 0 .675.946l2.965 1.02a1.013 1.013 0 0 0 1.032-.242A1 1 0 0 0 20 12V2a1 1 0 0 0-.415-.811Z"/>
                          </svg>
                        </div>
                      </div>
                      <div class="w-full ps-3">
                          <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"><span class="font-semibold text-gray-900 dark:text-white">Robert Brown</span> posted a new video: Glassmorphism - learn how to implement the new design trend.</div>
                          <div class="text-xs text-blue-600 dark:text-blue-500">3 hours ago</div>
                      </div>
                    </a>
                  </div>
                  <a href="#" class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white">
                    <div class="inline-flex items-center ">
                      <svg class="w-4 h-4 me-2 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                        <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                      </svg>
                        Voir tous
                    </div>
                  </a>
                </div>

                <button id="dropdownHoverUser" data-dropdown-toggle="dropdownUser" data-dropdown-trigger="hover" class="bg-gray-200 focus:outline-none font-bold rounded-lg text-center inline-flex items-center py-1.5 px-2 gap-2 xl:order-1 cursor-pointer" type="button">
                  <img class="rounded-full w-7 h-7" src="https://ui-avatars.com/api/?background=random&name={{ Auth::user()->pseudo ?? Auth::user()->prenom ?? Auth::user()->nom_salon}}" alt="Image profile" />
                  <span class="hidden xl:inline-flex"> {{ Auth::user()->pseudo ?? Auth::user()->prenom ?? Auth::user()->nom_salon }} </span>
                  <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                  </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdownUser" class="z-10 hidden bg-gray-300 divide-y divide-gray-400 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                  <ul class="py-2 text-sm text-green-gs font-bold dark:text-gray-200" aria-labelledby="dropdownHoverUser">

                    <li>
                      <a href="{{route('profile')}}" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">Mon compte</a>
                    </li>
                    <div x-show="userType=='invite'">
                      <li>
                        <a href="#" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">Mes favoris</a>
                      </li>
                    </div>
                    <div x-show="!userType=='invite'">
                      <li>
                        <a href="#" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">Mes Galerie</a>
                      </li>
                    </div>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">Discussion</a>
                    </li>
                    <li>
                      <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">
                        {{ __('Déconnexion') }}
                      </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                      @csrf
                    </form>
                  </ul>
                </div>
              </div>
            @endauth

        </div>

        {{-- Mega menu items --}}
        <div id="mega-menu-full-dropdown" class="absolute p-0 m-0 w-full shadow-xs bg-green-gs hidden transition-all">
            <div class="hidden mt-1 xl:flex max-w-screen-xl px-4 py-5 items-start justify-start gap-60 container p-20 mx-auto text-white md:px-6">
              <div class="flex flex-col">
                <h2 class="font-dm-serif font-bold text-2xl my-6">Service</h2>
                <div class="grid grid-cols-2 gap-3 text-black">
                  @foreach ($apiData['services'] as $service)
                  <a href="#" class="flex items-center justify-center gap-1 z-10">
                    <div class="w-72 lg:w-72 flex items-center justify-center gap-1.5 p-2.5 bg-white rounded-md shadow border border-gray-300 hover:bg-green-gs hover:text-white transition-all">
                      <img src="{{ url('images/icons/'.$service['post_name'].'_icon.svg')}}" alt="icon {{ $service['post_name'] }}" />
                      <span>{{ $service['post_title'] }}</span>
                    </div>
                  </a>
                  @endforeach
                </div>
              </div>
              <div class="flex flex-col gap-4">
                <div class="border-l border-gray-500 px-4">
                  <h2 class="font-dm-serif font-bold text-2xl my-6">Orientation</h2>
                  <div class="flex gap-2">
                    <a href="#" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Homme</a>
                    <a href="#" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Femme</a>
                    <a href="#" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Trans</a>
                    <a href="#" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Gay</a>
                    <a href="#" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Lesbienne</a>
                  </div>
                </div>
                <div class="px-4">
                  <h2 class="font-dm-serif font-bold text-2xl my-6">Localisation</h2>
                  <div class="flex flex-wrap gap-2">
                    @foreach ($apiData['cantons'] as $canton)
                    <a href="#" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">{{ $canton['title']['rendered'] }}</a>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
        </div>
      </nav>

      {{-- Content --}}
      @yield('content')

      <!-- Modal toggle -->
      {{-- <button  class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Toggle modal
      </button> --}}


      <!-- Recherche modal -->
      <div id="search-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-[95%] lg:w-[60%]  max-h-full">
              <!-- Modal content -->
              <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">

                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                      {{-- <h3 class="w-full flex items-center justify-center">
                      </h3> --}}
                      <button type="button" class="end-2.5 text-green-gs bg-transparent hover:bg-gray-200 hover:text-amber-400 rounded-lg text-sm w-4 h-4 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="search-modal">
                          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                          </svg>
                          <span class="sr-only">Close modal</span>
                      </button>
                  </div>

                  <!-- Modal body -->
                  <div class="relative flex flex-col gap-3 items-center justify-center p-4 md:p-5">

                    <h1 class="font-dm-serif font-bold text-3xl text-green-gs text-center">Rechercer une fille ou un salon</h1>
                    <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500" placeholder="Recherche escort, salon..." required />
                    <div class="w-full flex flex-col md:flex-row items-center justify-center text-sm xl:text-base gap-2 mb-3">
                      <select id="small" class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                        <option selected hidden>Canton</option>
                      </select>
                      <select id="small" class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
                        <option selected hidden>Ville</option>
                      </select>
                      <select id="small" class="block w-1/3 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">
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
                      <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Agence d'escort</span>
                      <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Salon erotique</span>
                      <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Institut de massage</span>
                      <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Sauna</span>
                    </div>
                    <div class="flex flex-wrap items-center justify-center gap-2 font-bold text-sm xl:text-base">
                      <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Trans</span>
                      <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Dominatrice BDSM</span>
                      <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Masseuse (no sex)</span>
                      <span class="p-2 text-center border border-amber-400 bg-white rounded-lg hover:bg-green-gs hover:text-amber-400">Escort</span>
                    </div>

                    {{-- Listing d'escort/salon --}}
                    <div class="relative w-full mx-auto flex flex-col items-center justify-center mt-4">
                      <div id="ESContainer" class="w-full flex items-center justify-start overflow-x-auto flex-nowrap mt-5 mb-4 px-10 gap-4" style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                        @foreach ($apiData['escorts'] as $escort)
                        <x-escort-card name="{{ $escort['data']['display_name'] }}" canton="Suisse Allemanique" ville="Genève" />
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
              </div>
          </div>
      </div>

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

                  <!-- Modal body -->
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
              </div>
          </div>
      </div>


      {{-- Footer --}}
      <div class="w-full min-h-[375px] bg-green-gs transition-all">
        <div class="flex flex-col items-center lg:flex-row justify-center lg:items-start gap-10 lg:gap-40 container mx-auto py-24 text-white text-sm xl:text-base">
          <div class="flex flex-col items-center justify-center w-full lg:w-auto lg:items-start gap-3">
            <a href="{{ route('home') }}" class="w-full">
              <img class="mx-auto lg:m-0 w-60" src="{{ url('images/Logo_lg.svg') }}" alt="Logo gstuff" />
            </a>
            <p class="w-96 lg:text-start text-center">Votre portail suisse des rencontres érotique sécurisées et inclusives.</p>
          </div>

          <div class="flex flex-col items-center lg:items-start gap-2">
            <h3 class="font-dm-serif text-4xl font-bold mb-3">Liens rapides</h3>
            {{-- <a href="#">Escort girl Suisse Alémanique</a>
            <a href="#">Escort girl Zurich</a>
            <a href="#">Escort girl Berne</a>
            <a href="#">Escort girl Friboug</a>
            <a href="#">Escort girl Jura</a> --}}
            @foreach (array_slice($apiData['cantons'], 0, 5) as $canton)
            <a href="#">{{ $canton['title']['rendered'] }}</a>
            @endforeach
          </div>

          <div class="flex flex-col items-center lg:items-start gap-2">
            <h3 class="font-dm-serif text-4xl font-bold mb-3">Liens rapides</h3>
            <a href="{{ route('glossaires') }}">Glossaire</a>
            <a href="{{ route('faq') }}">FAQ</a>
            <a href="{{ route('about')}}">Qui sommes-nous ?</a>
            <a href="{{ route('cgv') }}">Conditions générales de vente (GGV)</a>
            <a href="{{ route('contact') }}">Contact</a>
          </div>

        </div>
      </div>
      <div class="flex items-center justify-center bg-black text-white text-xs lg:text-base py-7 transition-all">
        Copyright 2025 - <a href="{{ route('home') }}" class="text-yellow-500 mx-2"> Gstuff </a> - <a href="{{ route('pdc') }}" class="text-yellow-500 mx-2"> Politique de confidentialité </a>
      </div>

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

        mega_menu_link.addEventListener('mouseover', (e)=>{
          mega_menu_item.classList.remove('hidden');
        })
        mega_menu_item.addEventListener('mouseover', (e)=>{
          mega_menu_item.classList.remove('hidden');
        })
        mega_menu_item.addEventListener('mouseleave', (e)=>{
          mega_menu_item.classList.add('hidden');
        });
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
                    // window.location.href = '{{ route('profile') }}';
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
                      window.location.href = '{{ route('profile') }}';
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

      </script>
      @yield('extraScripts')

    </body>
</html>

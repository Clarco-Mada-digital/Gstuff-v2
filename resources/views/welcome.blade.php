<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

        {{-- js import --}}
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js" defer></script>

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
        @vite('resources/css/app.css')
        {{-- <link href="resources/css/app.css" rel="stylesheet"> --}}

    </head>
    <body class="antialiased font-dm text-base font-normal">

      {{-- header --}}
      <nav class="bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-900">
        <div class="flex flex-wrap lg:justify-between items-center mx-auto max-w-screen-xl p-4 gap-3">
            <a href="#" class="flex items-center space-x-3">
                <img class="w-24 lg:w-44" src="images/Logo_lg.svg" alt="Gstuff Logo" />
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
                      <a href="#" class="flex items-center py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">Escorte <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                      </a>
                    </li>
                    <li>
                      <button id="mega-menu-full-dropdown-button" data-collapse-toggle="mega-menu-full-dropdown" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded-sm xl:w-auto hover:bg-gray-100 xl:hover:bg-transparent xl:border-0 xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">Salon <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                          </svg>
                      </button>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">A propos</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">Blog</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
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
                  </ul>
                </div>
              </div>
            </div>

            {{-- Search --}}
            <div class="flex ml-auto mr-0 xl:order-1">
              <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false" class="md:hidden text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-1">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z" stroke="#05595B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                <span class="sr-only">Search</span>
              </button>
              <div class="relative hidden md:block">
                <input type="text" id="search-navbar" class="block w-full p-2 pe-10 text-sm text-gray-950 border border-gray-300 rounded-xl bg-gray-100 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Recherche...">
                <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z" stroke="#05595B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  <span class="sr-only">Search icon</span>
                </div>
              </div>
            </div>

            {{-- Btn de connexion --}}
            <a href="#" type="button" class="hidden xl:block text-black btn-gs-gradient font-bold focus:ring-4 focus:outline-none focus:ring-yellow-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-yellow-800 lg:order-1">
              Connexion/Inscription
            </a>
            <a href="#" type="button" class="xl:hidden text-yellow-500 hover:bg-yellow-500 hover:text-white focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:border-yellow-500 dark:text-yellow-500 dark:hover:text-white dark:focus:ring-yellow-800 dark:hover:bg-yellow-500 xl:order-1">
              <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M15 14c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4m-9-4V7H4v3H1v2h3v3h2v-3h3v-2m6 2a4 4 0 0 0 4-4a4 4 0 0 0-4-4a4 4 0 0 0-4 4a4 4 0 0 0 4 4"/></svg>
              <span class="sr-only">Icon description</span>
            </a>

        </div>

        {{-- Mega menu items --}}
        <div id="mega-menu-full-dropdown" class="mt-1 border-gray-200 shadow-xs bg-gray-50 md:bg-white border-y hidden dark:bg-gray-800 dark:border-gray-600">
            <div class="grid max-w-screen-xl px-4 py-5 mx-auto text-gray-900 dark:text-white sm:grid-cols-2 md:px-6">
                <ul>
                    <li>
                        <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="font-semibold">Online Stores</div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that you're already using.</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="font-semibold">Segmentation</div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that you're already using.</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="font-semibold">Marketing CRM</div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that you're already using.</span>
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="font-semibold">Online Stores</div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that you're already using.</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="font-semibold">Segmentation</div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that you're already using.</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="font-semibold">Marketing CRM</div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that you're already using.</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
      </nav>

      {{-- Hero content --}}
      <div class="relative flex items-center justify-center flex-col gap-8 w-full px-3 py-20 lg:h-[418px] bg-no-repeat" style="background: url('images/Hero image.jpeg') center center /cover;">
        <div class="w-full h-full z-0 absolute inset-0 to-0% right-0% bg-[#05595B]/74"></div>
        <div class="flex items-center justify-center flex-col z-10">
          <h2 class="lg:text-6xl md:text-5xl text-4xl text-center font-semibold text-white font-dm-serif">Rencontres élégantes et discrètes en Suisse</h2>
        </div>
        <div class="flex flex-col lg:flex-row gap-2 text-black">
          @foreach (['Escorte', 'Masseuse', 'Dominatrice', 'Trans'] as $item)
          <a href="#" class="flex items-center justify-center gap-1 z-10">
            <div class="w-64 lg:w-56 flex items-center justify-center gap-1.5 p-2.5 bg-white rounded-md">
              <img src="icons/{{$item}}_icon.svg" alt="icon trans presentation" srcset="icon trans">
              <span>{{$item}}</span>
            </div>
          </a>
          @endforeach
        </div>
        <div class="z-10">
          <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-blue-800">Tout voir <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
          </a>
        </div>
      </div>

      {{-- Main content --}}
      <div class="mt-10 container m-auto">

        <div class="sm:hidden m-4">
          <label for="tabs" class="sr-only">Select salon or escorte</label>
          <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option>Top escortes du jour</option>
              <option>Les Salons</option>
          </select>
        </div>
        <ul class="hidden w-[50%] text-sm font-medium text-center text-gray-500 rounded-lg shadow-sm sm:flex sm:m-auto dark:divide-gray-700 dark:text-gray-400">
          <li class="w-full focus-within:z-10">
              <a href="#" class="inline-block w-full p-4 text-xs md:text-sm lg:text-base text-gray-900 font-bold rounded-none btn-gs-gradient border-r border-yellow-200 dark:border-gray-700 rounded-s-lg active focus:outline-none dark:bg-gray-700 dark:text-white" aria-current="page">Top escortes du jour</a>
          </li>
          <li class="w-full focus-within:z-10">
              <a href="#" class="inline-block w-full p-4 text-xs md:text-sm lg:text-base bg-white border-r font-bold border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50  rounded-e-lg focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Les salons</a>
          </li>
        </ul>
        <dev class="w-[90%] mx-auto flex flex-col items-center justify-center mt-4">
          <h3 class="font-dm-serif text-green-800 font-bold text-4xl text-center">Nos nouvelles escortes</h3>
          <div class="w-full grid grid-cols-1 md:w-full md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mx-auto mt-5 mb-4 gap-1">
            @foreach ([1,2,3,4] as $item)
            <div class="flex flex-col justify-center w-[90%] mx-auto mb-2 p-1 md:w-72 lg:w-80 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
              <a class="m-auto w-full rounded-lg overflow-hidden" href="#">
                  <img class="w-full object-cover rounded-t-lg" src="images/girl_001.png" alt="" />
              </a>
              <div class="flex flex-col gap-2 mt-4">
                  <a class="flex items-center gap-1" href="#">
                      <h5 class="text-base tracking-tight text-gray-900 dark:text-white">Carrine</h5>
                      <div class="w-2 h-2 rounded-full bg-green-600"></div>
                  </a>
                  <p class="font-normal text-gray-700 dark:text-gray-400">Suisse Allemanique</p>
              </div>
            </div>
            @endforeach
          </div>
        </dev>
        <dev class="w-[90%] mx-auto flex flex-col items-center justify-center mt-4">
          <h3 class="font-dm-serif text-green-800 font-bold text-3xl lg:text-4xl text-center">A la recherche d'un plaisir coquin ?</h3>
          <div class="w-[90%] grid grid-cols-1 md:w-full md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mx-auto mt-5 mb-4 gap-1">
            @foreach ([1,2,3,4] as $item)
            <div class="flex flex-col justify-center w-[90%] mx-auto mb-2 p-1 md:w-72 lg:w-80 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
              <a class="m-auto w-full rounded-lg overflow-hidden" href="#">
                  <img class="w-full object-cover rounded-t-lg" src="images/girl_001.png" alt="" />
              </a>
              <div class="flex flex-col gap-2 mt-4">
                  <a class="flex items-center gap-1" href="#">
                      <h5 class="text-base tracking-tight text-gray-900 dark:text-white">Carrine</h5>
                      <div class="w-2 h-2 rounded-full bg-green-600"></div>
                  </a>
                  <p class="font-normal text-gray-700 dark:text-gray-400">Suisse Allemanique</p>
              </div>
            </div>
            @endforeach
          </div>
          <div class="z-10 mb-6">
            <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-blue-800">Tout voir <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
            </a>
          </div>
        </dev>

      </div>
      <div class="relative flex flex-col items-center justify-center py-10 w-full" style="background: url('images/girl_deco_image.jpg') center center /cover">
        <div class="bg-white/70 absolute top-0 right-0 w-full h-full z-0"></div>
          <h3 class="font-dm-serif text-green-800 text-2xl md:text-3xl lg:text-4xl xl:text-5xl my-4 mx-2 text-center font-bold z-10">Trouver des escortes, masseuses et plus encore sur Gstuff !</h3>
          <div class="flex flex-col w-full px-4 md:flex-row items-center justify-center gap-2 py-6 z-10">
          @foreach ([1, 2, 3] as $item)
          <div class="w-full lg:w-[367px] lg:h-[263px] bg-green-800/80 p-3 flex flex-col text-white text-2xl lg:text-4xl font-bold items-center justify-center gap-3">
            <span class="text-center font-dm-serif w-[70%]">+ de 500 partenaires</span>
            <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">Profils vérifiés pour des rencontres authentiques</span>
          </div>
          @endforeach
        </div>
      </div>
      <div class="relative py-10 w-full">
        <div class="bg-green-200/30 absolute top-0 right-0 w-full h-full z-0"></div>
        <div class="w-full flex items-center justify-center gap-5 flex-nowrap overflow-hidden">
        @foreach ([1, 2, 3] as $item)
        <div class=" @if ($item==2) scale-100 @else scale-75 @endif min-w-[300px] lg:w-[625px] h-[250px] p-5 bg-white rounded-lg flex flex-col items-center justify-center gap-4 text-xl lg:text-3xl z-10">
          <span class="text-center w-[80%] mx-auto">"Amazing experience i love it a lot. Thanks to the team that dreams come true, great!"</span>
          <div class="flex items-center w-full justify-center gap-4">
            <img class="w-12 h-12 rounded-full" src="icons/user_icon.svg" alt="user_default icon" srcset="user icon">
            <div class="flex flex-col font-bold">
              <span class="font-dm-serif text-base lg:text-2xl text-green-800">Lassy Chester</span>
              <span class="text-sm lg:text-base">Escort</span>
            </div>
          </div>
        </div>
        @endforeach
        </div>
      </div>
      <div class="relative flex flex-col items-start justify-center w-full h-[375px]" style="background: url('images/girl_deco_image_001.jpg') center center /cover">
        <div class="text-white flex flex-col gap-4 container mx-auto px-3">
          <h3 class="font-dm-serif text-2xl lg:text-5xl font-bold w-full lg:w-[40%]">Inscrivez vous dès aujourd'hui sur Gstuff ...</h3>
          <span class="font-dm-serif">La meilleure plateforme érotique en Suisse !</span>
          <div class="z-10 w-45">
            <a href="#" type="button" class="flex items-center justify-center gap-2 btn-gs-gradient text-black font-bold focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-blue-800">S'inscrire <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z"/></svg>
            </a>
          </div>
        </div>

      </div>

      {{-- Footer --}}
      <div class="w-full min-h-[375px] bg-[#05595B]">
        <div class="flex flex-col items-center lg:flex-row justify-center lg:items-start gap-10 lg:gap-20 container mx-auto py-24 text-white">
          <div class="flex flex-col items-center justify-center w-full lg:w-auto lg:items-start gap-3">
            <div class="w-full">
              <img class="mx-auto lg:m-0 w-60" src="images/Logo_lg.svg" alt="Logo gstuff" srcset="Logo gstuff">
            </div>
            <p class="w-96 lg:text-start text-center">Votre portail suisse des rencontres érotique sécurisées et inclusives.</p>
          </div>

          <div class="flex flex-col items-center lg:items-start gap-2">
            <h3 class="font-dm-serif text-4xl font-bold mb-3">Liens rapides</h3>
            <a href="#">Escort girl Appenzell Rh.-Ext</a>
            <a href="#">Escort girl Vaud</a>
            <a href="#">Escort girl Zurich</a>
            <a href="#">Escort girl Jura</a>
          </div>

          <div class="flex flex-col items-center lg:items-start gap-2">
            <h3 class="font-dm-serif text-4xl font-bold mb-3">Liens rapides</h3>
            <a href="#">Glossaire</a>
            <a href="#">FAQ</a>
            <a href="#">Qui sommes-nous ?</a>
            <a href="#">Conditions générales de vente (GGV)</a>
            <a href="#">Contact</a>
          </div>

        </div>
      </div>
      <div class="flex items-center justify-center bg-black text-white text-xs lg:text-base py-7">
        Copyright 2025 - <span class="text-yellow-500 mx-2"> Gstuff </span> - <span class="text-yellow-500 mx-2"> Politique de confidentialité </span>
      </div>


    </body>
</html>

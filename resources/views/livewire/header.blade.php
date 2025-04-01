<div>
    {{-- header --}}
<nav class="relative bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-900 shadow-lg z-30">
    <div x-data="{'showUserDrop':false}" class="flex flex-wrap lg:justify-between items-center mx-auto container p-4 gap-3">
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
                  <a href="{{route('escortes')}}" id="dropdownHoverMenu" data-dropdown-toggle="dropdownMegaMenu" data-dropdown-trigger="hover" data-dropdown-offset-distance="25" class="flex items-center py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">Escortes <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="{{route('salons')}}" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded-sm xl:w-auto hover:bg-gray-100 xl:hover:bg-transparent xl:border-0 xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">Salons </a>
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
          <div class="flex gap-3 xl:order-1">
            @livewire('notification')
            <button id="dropdownHoverUser" data-dropdown-toggle="dropdownUser" class="bg-gray-200 focus:outline-none font-bold rounded-lg text-center inline-flex items-center py-1.5 px-2 gap-2 xl:order-1 cursor-pointer" type="button">
              <img class="rounded-full w-7 h-7"
              @if($avatar = auth()->user()->avatar)
              src="{{ asset('storage/avatars/'.$avatar) }}"
              @else
              src="https://ui-avatars.com/api/?background=random&name={{ Auth::user()->pseudo ?? Auth::user()->prenom ?? Auth::user()->nom_salon}}"
              @endif
              alt="Image profile" />
              <span class="hidden xl:inline-flex"> {{ Auth::user()->pseudo ?? Auth::user()->prenom ?? Auth::user()->nom_salon }} </span>
              <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
              </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownUser" class="z-10 hidden bg-gray-300 divide-y divide-gray-400 rounded-lg shadow-sm w-44 dark:bg-gray-700">
              <ul x-data="{pageSection: $persist('compte')}" class="py-2 text-sm text-green-gs font-bold dark:text-gray-200" aria-labelledby="dropdownHoverUser">

                <li>
                  <a x-on:click="pageSection='compte'" href="{{route('profile.index')}}" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">Mon compte</a>
                </li>
                <div x-show="userType=='invite'">
                  <li>
                    <a x-on:click="pageSection='favoris'" href="{{route('profile.index')}}" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">Mes favoris</a>
                  </li>
                </div>
                <div x-show="!userType=='invite'">
                  <li>
                    <a x-on:click="pageSection='galerie'" href="{{route('profile.index')}}" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">Mes Galerie</a>
                  </li>
                </div>
                <li>
                  <a x-on:click="pageSection='discussion'" href="{{route('profile.index')}}" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">Discussion</a>
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
    <div id="dropdownMegaMenu" aria-labelledby="dropdownHoverMenu" class="absolute p-0 m-0 w-full shadow-xs bg-green-gs hidden">
        <div class="hidden xl:flex max-w-screen-xl px-4 py-2 items-start justify-start gap-60 container p-20 mx-auto text-white md:px-6">
          <div class="flex flex-col">
            <h2 class="font-dm-serif font-bold text-2xl my-6">Services</h2>
            <div class="grid grid-cols-2 gap-3 text-black">
              @foreach ($categories as $categorie)
              <a href="{{route('escortes')}}?selectedCategories=[{{ $categorie->id }}]" class="flex items-center justify-center gap-1 z-10">
                <div class="w-72 lg:w-80 flex items-center justify-center gap-1.5 p-2.5 bg-white rounded-md shadow border border-gray-300 hover:bg-green-gs hover:text-white transition-all">
                  <img src="{{ url('images/icons/'.$categorie['display_name'].'_icon.svg')}}" alt="icon {{ $categorie['display_name'] }}" />
                  <span>{{ $categorie['nom'] }}</span>
                </div>
              </a>
              @endforeach
            </div>
          </div>
          <div class="flex flex-col gap-4">
            <div class="border-l border-gray-500 px-4">
              <h2 class="font-dm-serif font-bold text-2xl my-6">Orientation</h2>
              <div class="flex flex-wrap w-full xl:w-[350px] gap-2">
                <a href="{{route('escortes')}}?selectedGenre=homme" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Homme</a>
                <a href="{{route('escortes')}}?selectedGenre=Femme" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Femme</a>
                <a href="{{route('escortes')}}?selectedGenre=trans" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Trans</a>
                <a href="{{route('escortes')}}?selectedGenre=gay" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Gay</a>
                <a href="{{route('escortes')}}?selectedGenre=lesbienne" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Lesbienne</a>
                <a href="{{route('escortes')}}?selectedGenre=bisexuelle" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Bisex</a>
                <a href="{{route('escortes')}}?selectedGenre=queer" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">Queer</a>
              </div>
            </div>
            <div class="px-4">
              <h2 class="font-dm-serif font-bold text-2xl my-6">Localisation</h2>
              <div class="flex flex-wrap gap-2">
                @foreach ($cantons as $canton)
                <a href="{{route('escortes')}}?selectedCanton={{ $canton['id'] }}" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">{{ $canton['nom'] }}</a>
                @endforeach
              </div>
            </div>
          </div>
        </div>
    </div>
</nav>

<!-- Recherche modal -->
<livewire:users-search />
</div>

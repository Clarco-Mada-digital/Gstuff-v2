<div>
    {{-- header --}}
    <nav x-data="{
        isMobileMenuOpen: false,
        isDesktop: window.innerWidth >= 1280,
        init() {
            // Mettre à jour l'état desktop/mobile lors du redimensionnement
            const updateView = () => {
                this.isDesktop = window.innerWidth >= 1280;
                if (this.isDesktop) {
                    this.isMobileMenuOpen = false;
                }
            };
            
            // Ajouter l'écouteur de redimensionnement
            window.addEventListener('resize', updateView);
            
            // Nettoyer l'écouteur lors de la destruction du composant
            this.$watch('$store.app.sidebarOpen', () => {
                window.removeEventListener('resize', updateView);
            });
        }
    }" class="relative z-30 border-gray-200 bg-white shadow-lg dark:border-gray-600 dark:bg-gray-900">
        <div x-data="{ 'showUserDrop': false }" class="container mx-auto flex flex items-center gap-3 p-4 lg:justify-between">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img class="w-24 lg:w-44" src="{{ asset('images/Logo_lg.svg') }}" alt="Gstuff Logo" />
            </a>


            {{-- Btn humberger for mobile --}}
            <button @click="isMobileMenuOpen = !isMobileMenuOpen" type="button"
                class="-order-1 inline-flex h-10 w-10 items-center justify-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 xl:hidden dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                :aria-expanded="isMobileMenuOpen" aria-controls="mega-menu-full-humberger">
                <span class="sr-only">Open main menu</span>
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            {{-- Menu --}}
            <div id="mega-menu-full" 
                x-show="isMobileMenuOpen || isDesktop" 
                @click.away="isMobileMenuOpen = false"
                class="order-1 m-auto w-full items-center justify-between font-medium lg:m-0 xl:flex xl:w-auto"
                :class="{
                    'hidden xl:flex': !isMobileMenuOpen && !isDesktop,
                    'block xl:flex': isMobileMenuOpen || isDesktop,
                    'absolute left-0 right-0 top-full bg-white dark:bg-gray-900 shadow-lg xl:relative xl:shadow-none': true
                }">
                <ul class="mt-4 flex flex-col rounded-lg border border-gray-100 bg-gray-50 p-4 xl:mt-0 xl:flex-row xl:space-x-8 xl:border-0 xl:bg-white xl:p-0 rtl:space-x-reverse dark:border-gray-700 dark:bg-gray-800 xl:dark:bg-gray-900">
                    <li>
                        <a href="{{ route('escortes') }}" id="dropdownHoverMenu" data-dropdown-toggle="dropdownMegaMenu"
                            data-dropdown-trigger="hover" data-dropdown-offset-distance="25"
                            class="flex items-center rounded-sm px-3 py-2 text-gray-900 hover:bg-gray-100 xl:p-0 xl:hover:bg-transparent xl:hover:text-yellow-500 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent xl:dark:hover:text-yellow-500"
                            aria-current="page">
                            {{ __('header.escorts') }}
                            <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('salons') }}" class="flex w-full items-center justify-between rounded-sm px-3 py-2 text-gray-900 hover:bg-gray-100 xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent xl:hover:text-yellow-500 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent xl:dark:hover:text-yellow-500">
                            {{ __('header.salons') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('about') }}" class="block rounded-sm px-3 py-2 text-gray-900 hover:bg-gray-100 xl:p-0 xl:hover:bg-transparent xl:hover:text-yellow-500 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent xl:dark:hover:text-yellow-500">
                            {{ __('header.about') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('glossaires') }}" class="block rounded-sm px-3 py-2 text-gray-900 hover:bg-gray-100 xl:p-0 xl:hover:bg-transparent xl:hover:text-yellow-500 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent xl:dark:hover:text-yellow-500">
                            {{ __('header.glossary') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="block rounded-sm px-3 py-2 text-gray-900 hover:bg-gray-100 xl:p-0 xl:hover:bg-transparent xl:hover:text-yellow-500 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent xl:dark:hover:text-yellow-500">
                            {{ __('header.contact') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gallery.show') }}" class="block rounded-sm px-3 py-2 text-gray-900 hover:bg-gray-100 xl:p-0 xl:hover:bg-transparent xl:hover:text-yellow-500 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent xl:dark:hover:text-yellow-500">
                            {{ __('header.galleries') }}
                        </a>
                    </li>
                </ul>

                <x-language-selector />
            </div>


            

            {{-- Search --}}
            <div class="ml-auto mr-0 flex xl:order-1">
                <button data-modal-target="search-modal" data-modal-toggle="search-modal" type="button"
                    class="me-1 rounded-lg p-2.5 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 md:hidden dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z"
                            stroke="#05595B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
                <a href="{{ route('search') }}" class="relative hidden md:block">
                    <div id="search-navbar"
                        class="focus:ring-green-gs block w-full rounded-xl border border-gray-300 bg-gray-100 p-2 pe-10 text-sm text-gray-950 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">{{ __('header.search_placeholder') }}</div>
                    <div class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z"
                                stroke="#05595B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="sr-only">Search icon</span>
                    </div>
                </a>
            </div>

            @guest
                {{-- Btn de connexion --}}
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button"
                    class="btn-gs-gradient hidden rounded-lg px-4 py-2 text-center text-sm font-bold text-black focus:outline-none lg:order-1 xl:block dark:focus:ring-yellow-800">
                    {{ __('header.login_register') }}
                </button>
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button"
                    class="inline-flex items-center rounded-full p-2 text-center text-sm font-medium text-yellow-500 hover:bg-yellow-500 hover:text-white focus:outline-none xl:order-1 xl:hidden dark:border-yellow-500 dark:text-yellow-500 dark:hover:bg-yellow-500 dark:hover:text-white dark:focus:ring-yellow-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M15 14c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4m-9-4V7H4v3H1v2h3v3h2v-3h3v-2m6 2a4 4 0 0 0 4-4a4 4 0 0 0-4-4a4 4 0 0 0-4 4a4 4 0 0 0 4 4" />
                    </svg>
                    <span class="sr-only">Icon description</span>
                </button>
            @endguest

            @auth
                {{-- Notification icon and user presentation --}}
                <div class="flex gap-3 xl:order-1 items-center">
                    @livewire('notification')
                    <button id="dropdownHoverUser" data-dropdown-toggle="dropdownUser"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-gray-200 px-2 py-1.5 text-center font-bold focus:outline-none xl:order-1"
                        type="button">
                        <img class="h-7 w-7 rounded-full"
                            @if ($avatar = auth()->user()->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                    @else
                    src="https://ui-avatars.com/api/?background=random&name={{ Auth::user()->pseudo ?? (Auth::user()->prenom ?? Auth::user()->nom_salon) }}" @endif
                            alt="Image profile" />
                        <span class="hidden xl:inline-flex">
                            {{ Auth::user()->pseudo ?? (Auth::user()->prenom ?? Auth::user()->nom_salon) }} </span>
                        <svg class="ms-3 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownUser"
                        class="z-10 hidden w-44 divide-y divide-gray-400 rounded-lg bg-gray-300 shadow-sm dark:bg-gray-700">
                        <ul x-data="{ pageSection: $persist('compte') }" class="text-green-gs py-2 text-sm font-bold dark:text-gray-200"
                            aria-labelledby="dropdownHoverUser">

                            <li>
                                <a x-on:click="pageSection='compte'" href="{{ route('profile.index') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 hover:text-black dark:hover:bg-gray-900 dark:hover:text-white">{{ __('header.my_account') }}</a>
                            </li>
                            <div x-show="userType=='invite'">
                                <li>
                                    <a x-on:click="pageSection='favoris'" href="{{ route('profile.index') }}"
                                        class="block px-4 py-2 hover:bg-gray-100 hover:text-black dark:hover:bg-gray-900 dark:hover:text-white">{{ __('header.my_favorites') }}</a>
                                </li>
                            </div>
                            <div x-show="!userType=='invite'">
                                <li>
                                    <a x-on:click="pageSection='galerie'" href="{{ route('profile.index') }}"
                                        class="block px-4 py-2 hover:bg-gray-100 hover:text-black dark:hover:bg-gray-900 dark:hover:text-white">{{ __('header.my_gallery') }}</a>
                                </li>
                            </div>
                            <li>
                                <a x-on:click="pageSection='discussion'" href="{{ route('profile.index') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 hover:text-black dark:hover:bg-gray-900 dark:hover:text-white">{{ __('header.discussion') }}</a>
                            </li>
                            @if (Auth::user()->createbysalon)
                                <li>
                                    <a href="{{ route('salon.revenirSalon', ['id' => $salonCreator->id]) }}"
                                        class="block px-4 py-2 hover:bg-gray-100 hover:text-black dark:hover:bg-gray-900 dark:hover:text-white">
                                        <h2>{{ __('header.go_to') }} {{ $salonCreator->nom_salon }}</h2>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                    class="block px-4 py-2 hover:bg-gray-100 hover:text-black dark:hover:bg-gray-900 dark:hover:text-white">
                                    {{ __('header.logout') }}
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
        <div id="dropdownMegaMenu" aria-labelledby="dropdownHoverMenu"
            class="shadow-xs bg-green-gs absolute m-0 hidden w-full p-0">
            <div
                class="container mx-auto hidden max-w-screen-xl items-start justify-start gap-60 p-20 px-4 py-2 text-white md:px-6 xl:flex">
                <div class="flex flex-col">
                    <h2 class="font-dm-serif my-6 text-2xl font-bold">{{ __('header.services') }}</h2>
                    <div class="grid grid-cols-2 gap-3 text-black">
                        @foreach ($categories as $categorie)
                            <a href="{{ route('escortes') }}?selectedCategories=[{{ $categorie->id }}]"
                                class="z-10 flex items-center justify-center gap-1">
                                <div
                                    class="hover:bg-green-gs flex w-72 items-center justify-center gap-1.5 rounded-md border border-gray-300 bg-white p-2.5 shadow transition-all hover:text-white lg:w-80">
                                    <img src="{{ url('images/icons/' . $categorie['display_name'] . '_icon.svg') }}"
                                        alt="icon {{ $categorie['display_name'] }}" />
                                    <span>{{ $categorie['nom'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="border-l border-gray-500 px-4">
                        <h2 class="font-dm-serif my-6 text-2xl font-bold">{{ __('header.orientation') }}</h2>
                        <div class="flex w-full flex-wrap gap-2 xl:w-[350px]">
                            <a href="{{ route('escortes') }}?selectedGenre=homme"
                                class="rounded-lg border border-gray-400 p-2 hover:border-amber-300 hover:text-amber-300">{{ __('header.man') }}</a>
                            <a href="{{ route('escortes') }}?selectedGenre=Femme"
                                class="rounded-lg border border-gray-400 p-2 hover:border-amber-300 hover:text-amber-300">{{ __('header.woman') }}</a>
                            <a href="{{ route('escortes') }}?selectedGenre=trans"
                                class="rounded-lg border border-gray-400 p-2 hover:border-amber-300 hover:text-amber-300">{{ __('header.transgender') }}</a>
                            <a href="{{ route('escortes') }}?selectedGenre=gay"
                                class="rounded-lg border border-gray-400 p-2 hover:border-amber-300 hover:text-amber-300">{{ __('header.gay') }}</a>
                            <a href="{{ route('escortes') }}?selectedGenre=lesbienne"
                                class="rounded-lg border border-gray-400 p-2 hover:border-amber-300 hover:text-amber-300">{{ __('header.lesbian') }}</a>
                            <a href="{{ route('escortes') }}?selectedGenre=bisexuelle"
                                class="rounded-lg border border-gray-400 p-2 hover:border-amber-300 hover:text-amber-300">{{ __('header.bisexual') }}</a>
                            <a href="{{ route('escortes') }}?selectedGenre=queer"
                                class="rounded-lg border border-gray-400 p-2 hover:border-amber-300 hover:text-amber-300">{{ __('header.queer') }}</a>
                        </div>
                    </div>
                    <div class="px-4">
                        <h2 class="font-dm-serif my-6 text-2xl font-bold">{{ __('header.localization') }}</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($cantons as $canton)
                                <a href="{{ route('escortes') }}?selectedCanton={{ $canton['id'] }}"
                                    class="rounded-lg border border-gray-400 p-2 hover:border-amber-300 hover:text-amber-300">{{ $canton['nom'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Recherche modal -->
    <div wire:ignore.self id="search-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-[95%] lg:w-[60%] max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h1 class="flex-1 font-dm-serif font-bold text-3xl text-green-gs text-center">{{__('search_modal.search_title')}}</h1>
                    <button type="button" class="end-2.5 text-green-gs bg-transparent hover:bg-gray-200 hover:text-amber-400 rounded-lg text-sm w-4 h-4 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="search-modal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">{{__('search_modal.close')}}</span>
                    </button>
                </div>
                <livewire:users-search />
                {{-- <iframe src="{{route('search')}}" width="100%" height="800px" frameborder="0" wire:ignore.self></iframe> --}}
            </div>            
        </div>
    </div>
</div>

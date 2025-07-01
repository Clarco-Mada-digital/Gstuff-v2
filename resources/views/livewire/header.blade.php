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
    }"
        class="relative z-30 border-gray-200 bg-white shadow-lg dark:border-gray-600 dark:bg-gray-900">
        <div x-data="{ 'showUserDrop': false }" class="container mx-auto flex items-center gap-3 p-4 lg:justify-between">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img class="w-32 h-[3.875rem] lg:w-44" src="{{ asset('images/logoSupaG.png') }}" alt="Gstuff Logo" />
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
            <div id="mega-menu-full" x-show="isMobileMenuOpen || isDesktop" @click.away="isMobileMenuOpen = false"
                class="order-1 m-auto w-full items-center justify-between font-medium lg:m-0 xl:flex xl:w-auto"
                :class="{
                    'hidden xl:flex': !isMobileMenuOpen && !isDesktop,
                    'block xl:flex': isMobileMenuOpen || isDesktop,
                    'absolute left-0 right-0 top-full bg-white dark:bg-gray-900 shadow-lg xl:relative xl:shadow-none': true
                }">
                <ul
                    class="mt-4 flex flex-col font-roboto-slab  rounded-lg border border-gray-100 bg-gray-50 p-4 xl:mt-0 xl:flex-row xl:space-x-8 xl:border-0 xl:bg-white xl:p-0 rtl:space-x-reverse dark:border-gray-700 dark:bg-gray-800 xl:dark:bg-gray-900">
                    <li>
                    <a href="{{ route('escortes') }}" id="dropdownHoverMenu" data-dropdown-toggle="dropdownMegaMenu"
                            data-dropdown-trigger="hover" data-dropdown-offset-distance="25"
                            class="flex items-center rounded-sm px-3 py-2 text-gray-900 hover:bg-gray-100 xl:p-0 xl:hover:bg-transparent hover:text-complementaryColorViolet xl:hover:text-complementaryColorViolet transition-colors duration-200"
                            aria-current="page">
                            {{ __('header.escorts') }}
                            <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('salons') }}">
                            {{ __('header.salons') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ url('about') }}">
                            {{ __('header.about') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ url('glossaires') }}">
                            {{ __('header.glossary') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('contact') }}">
                            {{ __('header.contact') }}
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('gallery.show') }}">
                            {{ __('header.galleries') }}
                        </x-nav-link>
                    </li>
                </ul>

                <x-language-selector />
            </div>




            {{-- Search --}}
            <div class="ml-auto mr-0 flex xl:order-1">
                <a href="{{ route('search') }}"
                    class="border border-supaGirlRose me-1 rounded-lg p-2.5 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 md:hidden">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z"
                            stroke="#05595B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sr-only">Search</span>
                </a>
                <a href="{{ route('search') }}" class="relative hidden md:block w-52">
                    <div id="search-navbar"
                        class="focus:ring-green-gs block w-full rounded-xl border border-supaGirlRose bg-[#FFFAFC] p-2 pe-10 text-sm text-supaGirlRose focus:border-blue-500 text-roboto-slab ">{{ __('header.search_placeholder') }}</div>
                    <div class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3 text-supaGirlRose">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z"
                                stroke="#FDA5D6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="sr-only">Search icon</span>
                    </div>  
                </a>
            </div>

            @guest
                {{-- Btn de connexion --}}
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button"
                    class="btn-complementaryColorViolet bg-complementaryColorViolet hidden rounded-lg px-4 py-2 text-center text-sm font-bold text-white focus:outline-none lg:order-1 xl:block">
                    {{ __('header.login_register') }}
                </button>
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button"
                    class="inline-flex items-center rounded-full p-2 text-center text-sm font-medium text-complementaryColorViolet hover:bg-complementaryColorViolet  focus:outline-none xl:order-1 xl:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M15 14c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4m-9-4V7H4v3H1v2h3v3h2v-3h3v-2m6 2a4 4 0 0 0 4-4a4 4 0 0 0-4-4a4 4 0 0 0-4 4a4 4 0 0 0 4 4" />
                    </svg>
                    <span class="sr-only">Icon description</span>
                </button>
            @endguest

            @auth
                {{-- Notification icon and user presentation --}}
                <div class="flex items-center gap-3 xl:order-1">
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
            class="shadow-xs bg-supaGirlRose absolute m-0 hidden w-full p-0">
            <div
                class="container mx-auto hidden max-w-screen-xl items-start justify-start gap-30 p-20 px-4 py-2 text-white md:px-6 xl:flex">
                <div class="flex flex-col">
                    <h2 class="font-roboto-slab my-6 text-2xl font-bold">{{ __('header.services') }}</h2>
        
                    <div class="grid grid-cols-2 gap-3 text-black  w-[450px]">
                        @foreach ($categories as $categorie)
                            <a href="{{ route('escortes') }}?selectedCategories=[{{ $categorie->id }}]"
                                class="z-10 flex items-center justify-center gap-1">
                                <div
                                    class="flex w-[200px] items-center justify-center gap-1.5 rounded-md border border-1 border-supaGirlRose bg-fieldBg  hover:bg-supaGirlRose hover:border-complementaryColorViolet hover:text-white text-[#101828] p-2.5 shadow transition-all lg:w-80">
                                    <img src="{{ url('images/icons/' . $categorie['display_name'] . '_icon.png') }}" class="w-8 h-8"
                                        alt="icon {{ $categorie['display_name'] }}" />
                                    <span class="font-roboto-slab font-normal text-base leading-6 align-middle hover:text-white">{{ $categorie['nom'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="border-l border-fieldBg px-4">
                        <h2 class="font-roboto-slab my-6 text-2xl font-bold">{{ __('header.orientation') }}</h2>
                        
                        <div class="flex w-full flex-wrap gap-2 xl:w-[350px]">
                            @foreach ($genres as $genre)
                                <x-animated-button 
                                    :href="route('escortes') . '?selectedGenre=' . $genre->id"
                                    color="complementaryColorViolet"
                                    borderColor="supaGirlRose"
                                    bgColor="fieldBg"
                                    hoverBgColor="complementaryColorViolet"
                                    hoverTextColor="white"
                                    size="md"
                                >
                                    {{ $genre->name }}
                                </x-animated-button>
                            @endforeach
                        </div>
                    </div>
                    <div class="px-4 mb-2">
                        <h2 class="font-roboto-slab my-6 text-2xl font-bold">{{ __('header.localization') }}</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($cantons->slice(0, 10) as $canton)
                                <x-animated-button 
                                    :href="route('escortes') . '?selectedCanton=' . $canton->id"
                                    color="complementaryColorViolet"
                                    borderColor="supaGirlRose"
                                    bgColor="fieldBg"
                                    hoverBgColor="complementaryColorViolet"
                                    hoverTextColor="white"
                                    size="md"
                                >
                                    {{ $canton->nom }}
                                </x-animated-button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Recherche modal -->
    {{-- <div wire:ignore.self id="search-modal" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative max-h-full w-[95%] p-4 lg:w-[60%]">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow-sm dark:bg-gray-700">

                <!-- Modal header -->
                <div
                    class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 md:p-5 dark:border-gray-600">
                    <div class="w-[70%] sm:flex sm:items-center">
                        <h1 class="font-dm-serif text-green-gs flex-1 text-center text-2xl font-bold">
                            {{ __('search_modal.search_title') }}</h1>
                    </div>
                    <button type="button"
                        class="text-green-gs end-2.5 ms-auto inline-flex h-4 w-4 items-center justify-center rounded-lg bg-transparent text-sm hover:bg-gray-200 hover:text-amber-400 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="search-modal">
                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">{{ __('search_modal.close') }}</span>
                    </button>
                </div>
                <livewire:users-search />
                <iframe src="{{route('search')}}" width="100%" height="800px" frameborder="0" wire:ignore.self></iframe>
            </div>
        </div>
    </div> --}}
</div>

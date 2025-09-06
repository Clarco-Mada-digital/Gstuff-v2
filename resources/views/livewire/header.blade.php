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
        <div x-data="{ 'showUserDrop': false }" class="container mx-auto flex items-center gap-3 lg:justify-between">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <img class="" src="{{ asset('images/logoSupa.png') }}" alt="Gstuff Logo" />
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
                    class="font-roboto-slab mt-4 flex flex-col rounded-lg border border-gray-100 bg-gray-50 p-4 xl:mt-0 xl:flex-row xl:space-x-8 xl:border-0 xl:bg-white xl:p-0 rtl:space-x-reverse dark:border-gray-700 dark:bg-gray-800 xl:dark:bg-gray-900">
                    <li id="escorts-link" class="header-link flex hidden items-center justify-between p-2">
                        <div id="dropdownHoverMenu" data-dropdown-toggle="dropdownMegaMenu"
                            data-dropdown-trigger="hover" data-dropdown-offset-distance="25"
                            class="flex items-center justify-between">
                            <a href="{{ route('escortes') }}"
                                class="font-roboto-slab text-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs ria-current= flex hidden w-full items-center justify-between rounded-sm px-3 py-2 text-gray-900 xl:block xl:p-0 xl:hover:bg-transparent"page">
                                {{ __('header.escorts') }}

                            </a>
                            <div class="hover:text-green-gs hidden cursor-pointer xl:block">
                                <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </div>
                        </div>

                        <a href="{{ route('escortes') }}"
                            class="font-roboto-slab text-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs ria-current= flex w-full items-center justify-between rounded-sm px-3 py-2 text-gray-900 xl:hidden xl:p-0 xl:hover:bg-transparent"page">
                            {{ __('header.escorts') }}

                        </a>
                        <div class="hover:bg-supaGirlRose flex cursor-pointer items-center justify-center rounded-sm p-4 hover:text-white xl:hidden"
                            id="dropbtn">
                            <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </div>
                    </li>
                    <li id="salons-link" class="header-link hidden p-2">
                        <a href="{{ route('salons') }}"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-gray-900 xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.salons') }}
                        </a>
                    </li>

                    <li id="galleries-link" class="header-link p-2">
                        <a href="{{ route('gallery.show') }}"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-gray-900 xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.galleries') }}
                        </a>
                    </li>
                    <li id="glossary-link" class="header-link p-2">
                        <a href="{{ url('glossaires') }}"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-gray-900 xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.glossary') }}
                        </a>
                    </li>
                    <li id="about-link" class="header-link p-2">
                        <a href="{{ url('about') }}"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-gray-900 xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.about') }}
                        </a>
                    </li>
                    <li id="contact-link" class="header-link p-2">
                        <a href="{{ route('contact') }}"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-gray-900 xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.contact') }}
                        </a>
                    </li>

                </ul>

                <x-language-selector />
            </div>






            {{-- Search --}}
            <div class="ml-auto mr-0 flex xl:order-1">
                <a href="{{ route('search') }}"
                    class="group flex h-10 w-10 items-center justify-center rounded-full bg-pink-50 transition-colors hover:bg-pink-100 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:ring-offset-2"
                    title="{{ __('header.search_placeholder') }}">
                    <svg class="h-5 w-5 text-pink-500 transition-colors group-hover:text-pink-600" viewBox="0 0 20 20"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sr-only">{{ __('header.search_placeholder') }}</span>
                </a>
            </div>


            @guest
                {{-- Btn de connexion --}}
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button"
                    class="btn-complementaryColorViolet bg-complementaryColorViolet hidden cursor-pointer rounded-lg px-4 py-2 text-center text-sm font-bold text-white focus:outline-none lg:order-1 xl:block">
                    {{ __('header.login_register') }}
                </button>
                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button"
                    class="text-complementaryColorViolet hover:bg-complementaryColorViolet inline-flex cursor-pointer items-center rounded-full p-2 text-center text-sm font-medium focus:outline-none xl:order-1 xl:hidden">
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
                        class="bg-fieldBg border-1 border-supaGirlRose hover:border-supaGirlRose/50 inline-flex cursor-pointer items-center gap-2 rounded-lg border px-2 py-1.5 text-center font-bold focus:outline-none xl:order-1"
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
                        class="bg-fieldBg border-1 border-supaGirlRose z-10 hidden w-44 divide-y divide-gray-400 rounded-lg border shadow-sm">
                        <ul x-data="{ pageSection: $persist('compte') }" class="text-green-gs py-2 text-sm font-bold dark:text-gray-200"
                            aria-labelledby="dropdownHoverUser">

                            <li>
                                <a x-on:click="pageSection='compte'" href="{{ route('profile.index') }}"
                                    class="hover:bg-supaGirlRosePastel text-green-gs font-roboto-slab flex items-center px-4 py-2 text-sm font-[500]">
                                    <span
                                        class="bg-supaGirlRose text-green-gs mr-2 inline-flex h-6 w-6 items-center justify-center rounded-full">
                                        <i class="fas fa-user-circle text-xs"></i>
                                    </span>{{ __('header.my_account') }}
                                </a>
                            </li>
                            <div x-show="userType=='invite'">
                                <li>
                                    <a x-on:click="pageSection='favoris'" href="{{ route('profile.index') }}"
                                        class="hover:bg-supaGirlRosePastel text-green-gs font-roboto-slab flex items-center px-4 py-2 text-sm font-[500]">
                                        <span
                                            class="bg-supaGirlRose text-green-gs mr-2 inline-flex h-6 w-6 items-center justify-center rounded-full">
                                            <i class="fas fa-heart text-xs"></i>
                                        </span>{{ __('header.my_favorites') }}
                                    </a>
                                </li>
                            </div>
                            <div x-show="!userType=='invite'">
                                <li>
                                    <a x-on:click="pageSection='galerie'" href="{{ route('profile.index') }}"
                                        class="hover:bg-supaGirlRosePastel text-green-gs font-roboto-slab flex items-center px-4 py-2 text-sm font-[500]">
                                        <span
                                            class="bg-supaGirlRose text-green-gs mr-2 inline-flex h-6 w-6 items-center justify-center rounded-full">
                                            <i class="fas fa-images text-xs"></i>
                                        </span>{{ __('header.my_gallery') }}
                                    </a>
                                </li>
                            </div>
                            <li>
                                <a x-on:click="pageSection='discussion'" href="{{ route('profile.index') }}"
                                    class="hover:bg-supaGirlRosePastel text-green-gs font-roboto-slab flex items-center px-4 py-2 text-sm font-[500]">
                                    <span
                                        class="bg-supaGirlRose text-green-gs mr-2 inline-flex h-6 w-6 items-center justify-center rounded-full">
                                        <i class="fas fa-comments text-xs"></i>
                                    </span>{{ __('header.discussion') }}
                                </a>
                            </li>
                            @if (Auth::user()->createbysalon)
                                <li>
                                    <a href="{{ route('salon.revenirSalon', ['id' => $salonCreator->id]) }}"
                                        class="hover:bg-supaGirlRosePastel text-green-gs font-roboto-slab flex items-center px-4 py-2 text-sm font-[500]">
                                        <span
                                            class="bg-supaGirlRose text-green-gs mr-2 inline-flex h-6 w-6 items-center justify-center rounded-full">
                                            <i class="fas fa-store text-xs"></i>
                                        </span>
                                        <h2>{{ __('header.go_to') }} {{ $salonCreator->nom_salon }}</h2>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                    class="hover:bg-supaGirlRosePastel text-green-gs font-roboto-slab flex items-center px-4 py-2 text-sm font-[500]">
                                    <span
                                        class="bg-supaGirlRose text-green-gs mr-2 inline-flex h-6 w-6 items-center justify-center rounded-full">
                                        <i class="fas fa-sign-out-alt text-green-gs text-xs"></i>
                                    </span>{{ __('header.logout') }}
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
            class="shadow-xs bg-supaGirlRose top-15 absolute absolute hidden w-full p-0">
            <div
                class="gap-30 mx-auto hidden max-w-screen-2xl items-start justify-start p-20 px-4 py-2 text-white md:px-6 xl:flex">
                <div class="flex flex-col">
                    <h2 class="font-roboto-slab my-6 text-2xl font-bold">{{ __('header.services') }}</h2>

                    <div class="grid w-[450px] grid-cols-2 gap-3 text-black">
                        @foreach ($categories as $categorie)
                            <a href="{{ route('escortes') }}?selectedCategories=[{{ $categorie->id }}]"
                                class="z-10 flex items-center justify-center gap-1">
                                <div
                                    class="border-1 border-supaGirlRose bg-fieldBg hover:bg-supaGirlRose hover:border-complementaryColorViolet flex w-[200px] items-center justify-center gap-1.5 rounded-md border p-2.5 text-[#101828] shadow transition-all hover:text-white lg:w-80">
                                    <img src="{{ url('images/icons/' . $categorie['display_name'] . '_icon.png') }}"
                                        class="h-8 w-8" alt="icon {{ $categorie['display_name'] }}" />
                                    <span
                                        class="font-roboto-slab align-middle text-base font-normal leading-6 hover:text-white">{{ $categorie['nom'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="border-fieldBg flex w-full flex-col border-l">
                    <div class="px-4">
                        <h2 class="font-roboto-slab my-2 text-xl font-bold">{{ __('header.orientation') }}</h2>

                        <div class="flex w-full flex-wrap gap-2">
                            @foreach ($genres as $genre)
                                <x-animated-button :href="route('escortes') . '?selectedGenre=' . $genre->id"
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
                    <div class="mb-2 px-4">
                        <h2 class="font-roboto-slab my-2 text-xl font-bold">{{ __('header.localization') }}</h2>
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

        <div id="dropdownMegaMenuMobile"  x-show="isMobileMenuOpen"
            class="shadow-xs absolute absolute top-16 hidden w-full px-4">
            <div id="subDiv"
                class="bg-supaGirlRose gap-30 container mx-auto max-w-screen-xl items-start justify-start p-20 px-4 py-2 text-white md:px-6 xl:flex">
                <div class="flex flex-col">
                    <h2 class="font-roboto-slab my-6 text-2xl font-bold">{{ __('header.services') }}</h2>
        
                    <div class="grid w-full grid-cols-2 gap-3 text-black">
                        @foreach ($categories as $categorie)
<a href="{{ route('escortes') }}?selectedCategories=[{{ $categorie->id }}]"
                                class="z-10 flex items-center justify-center gap-1">
                                <div
                                    class="border-1 border-supaGirlRose bg-fieldBg hover:bg-supaGirlRose hover:border-complementaryColorViolet flex w-[200px] items-center justify-center gap-1.5 rounded-md border p-2.5 text-[#101828] shadow transition-all hover:text-white lg:w-80">
                                    <img src="{{ url('images/icons/' . $categorie['display_name'] . '_icon.png') }}" class="h-8 w-8"
                                        alt="icon {{ $categorie['display_name'] }}" />
                                    <span class="font-roboto-slab align-middle text-sm font-normal leading-6 hover:text-white">{{ $categorie['nom'] }}</span>
                                </div>
                            </a>
@endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="border-fieldBg border-l px-4">
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
                    <div class="mb-2 px-4">
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
        <div id="dropdownMegaMenuMobile2"  
            class="shadow-xs absolute absolute top-16 hidden w-full px-4 lg:top-7">
            <div id="subDiv2"
                class="bg-supaGirlRose gap-30 container mx-auto max-w-screen-xl items-start justify-start p-20 px-4 py-2 text-white md:px-6 xl:flex">
                <div class="flex flex-col px-4">
                    <h2 class="font-roboto-slab my-2 text-xl font-bold">{{ __('header.services') }}</h2>
        
                    <div class="flex w-full flex-wrap justify-around text-black lg:grid lg:grid-cols-4">
                        @foreach ($categories as $categorie)
<a href="{{ route('escortes') }}?selectedCategories=[{{ $categorie->id }}]"
                                class="z-10 flex items-center justify-center">
                                <div
                                    class="border-1 border-supaGirlRose bg-fieldBg hover:bg-supaGirlRose hover:border-complementaryColorViolet flex items-center justify-center gap-1.5 rounded-md border p-2.5 text-[#101828] shadow transition-all hover:text-white md:w-[150px] lg:w-80 lg:w-[160px] xl:w-[200px]">
                                    <img src="{{ url('images/icons/' . $categorie['display_name'] . '_icon.png') }}" class="h-6 w-6 sm:h-6 sm:w-6 md:h-5 md:w-5 lg:h-6 lg:w-6"
                                        alt="icon {{ $categorie['display_name'] }}" />
                                        <span class="font-roboto-slab overflow-hidden truncate whitespace-nowrap align-middle text-sm text-xs font-normal leading-6 hover:text-white">
                                            {{ $categorie['nom'] }}
                                        </span>

                                </div>
                            </a>
@endforeach
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="border-fieldBg border-l px-4">
                        <h2 class="font-roboto-slab my-2 text-xl font-bold">{{ __('header.orientation') }}</h2>
                        
                        <div class="flex w-full flex-wrap gap-2 xl:w-[350px]">
                            @foreach ($genres as $genre)
@if ($genre->id != 3)
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
@endif
@endforeach
                        </div>
                    </div>
                    <div class="mb-2 px-4">
                        <h2 class="font-roboto-slab my-2 text-xl font-bold">{{ __('header.localization') }}</h2>
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

        <!-- second header mobile sm-->
        <div class="bg-supaGirlRose w-full md:hidden">
            <ul class="flex w-full items-center justify-between  mx-auto px-2">
                <!-- Liens toujours visibles -->
                
                <li id="escorts-link" class="header-link flex items-center justify-between xl:p-4">
                        <div id="dropdownHoverMenu" data-dropdown-toggle="dropdownMegaMenu"
                        data-dropdown-trigger="hover" data-dropdown-offset-distance="25" class="flex items-center justify-between">
                        <a href="{{ route('escortes') }}" 
                            class="font-roboto-slab text-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs ria-current= flex hidden w-full items-center justify-between rounded-sm px-3 py-4 text-xs text-gray-900 md:text-sm xl:block xl:p-0 xl:hover:bg-transparent"page">
                           {{ __('header.escorts') }}
                          
                        </a>
                        <div class="hover:text-green-gs hidden cursor-pointer xl:block">
                        <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </div>
                        </div>
                      
                        <a href="{{ route('escortes') }}" 
                            class="font-roboto-slab text-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs ria-current= flex w-full items-center justify-between rounded-sm px-3 text-xs text-gray-900 md:text-sm xl:hidden xl:p-0 xl:py-2 xl:hover:bg-transparent"page">
                            {{ __('header.escorts') }}
    
                        </a>
                        <div class="hover:bg-supaGirlRose flex cursor-pointer items-center justify-center rounded-sm p-4 hover:text-white xl:hidden" id="dropbtn2">
                              <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                          </div>
                    </li>
                    <li id="salons-link" class="header-link flex items-center justify-between xl:p-4">
                        <a href="{{ route('salons') }}"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-xs text-gray-900 md:text-sm xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.salons') }}
                        </a>
                    </li>
               

              
                <li class="xl:hidden">
   
                    <button
                    id="accordionToggle"
                    onclick="toggleAccordion()"
                    class="px-3 py-2 text-sm font-semibold text-gray-900 hover:text-green-gs rounded-sm inline-flex items-center gap-2"
                    aria-controls="menuAccordion"
                    aria-expanded="false"
                    type="button"
                    >
                
                    <svg
                        class="h-5 w-5 transition-transform duration-200 ease-out"
                        :class="{ 'rotate-90': open }"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                        >
                        <path d="M12 5.5C13.1 5.5 14 6.4 14 7.5C14 8.6 13.1 9.5 12 9.5C10.9 9.5 10 8.6 10 7.5C10 6.4 10.9 5.5 12 5.5ZM12 10.5C13.1 10.5 14 11.4 14 12.5C14 13.6 13.1 14.5 12 14.5C10.9 14.5 10 13.6 10 12.5C10 11.4 10.9 10.5 12 10.5ZM12 15.5C13.1 15.5 14 16.4 14 17.5C14 18.6 13.1 19.5 12 19.5C10.9 19.5 10 18.6 10 17.5C10 16.4 10.9 15.5 12 15.5Z"/>
                        </svg>
                    </button>

                </li>
            </ul>

  
            <!-- Liens cachés dans l'accordéon -->
            <ul id="menuAccordion" class="hidden flex flex-wrap space-y-2  mx-auto px-2 py-2">
                    <li id="masseuse-link" class="header-link flex items-center justify-between xl:p-4">
                        <a href="{{ route('escortes') }}?selectedCategories=[2]"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-xs text-gray-900 md:text-sm xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                           {{ __('header.masseuse') }}
                        </a>
                    </li>

                    <li id="dominatrice-link" class="header-link flex items-center justify-between xl:p-4">
                        <a href="{{ route('escortes') }}?selectedCategories=[3]"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-xs text-gray-900 md:text-sm xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.dominatrice') }}
                        </a>
                    </li>
                    <li id="trans-link" class="header-link flex items-center justify-between text-xs md:text-sm xl:p-4">
                        <a href="{{ route('escortes') }}?selectedCategories=[4]"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-xs text-gray-900 md:text-sm xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.trans') }}
                        </a>
                    </li>

                    <li id="telephoneRose-link" class="header-link flex items-center justify-between text-xs md:text-sm xl:p-4">
                        <a href="{{ route('escortes') }}?selectedCategories=[9]"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-xs text-gray-900 md:text-sm xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.telephoneRose') }}
                        </a>
                    </li>
            </ul>
        </div>


        <div class="bg-supaGirlRose w-full hidden md:block">
                <div class="mx-auto flex w-full flex-wrap items-center justify-around xl:w-[80%]">
                <li id="escorts-link" class="header-link flex items-center justify-between xl:p-4">
                    <div id="dropdownHoverMenu" data-dropdown-toggle="dropdownMegaMenu"
                    data-dropdown-trigger="hover" data-dropdown-offset-distance="25" class="flex items-center justify-between">
                    <a href="{{ route('escortes') }}" 
                        class="font-roboto-slab text-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs ria-current= flex hidden w-full items-center justify-between rounded-sm px-3 py-4 text-xs text-gray-900 md:text-sm xl:block xl:p-0 xl:hover:bg-transparent"page">
                    {{ __('header.escorts') }}
                    
                    </a>
                    <div class="hover:text-green-gs hidden cursor-pointer xl:block">
                    <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </div>
                    </div>
                
                    <a href="{{ route('escortes') }}" 
                        class="font-roboto-slab text-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs ria-current= flex w-full items-center justify-between rounded-sm px-3 text-xs text-gray-900 md:text-sm xl:hidden xl:p-0 xl:py-2 xl:hover:bg-transparent"page">
                        {{ __('header.escorts') }}
                    </a>
                    <div class="hover:bg-supaGirlRose flex cursor-pointer items-center justify-center rounded-sm p-4 hover:text-white xl:hidden" id="dropbtn2">
                            <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </div>
                </li>
                    <li id="salons-link" class="header-link flex items-center justify-between xl:p-4">
                        <a href="{{ route('salons') }}"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-xs text-gray-900 md:text-sm xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.salons') }}
                        </a>
                    </li>
                    <li id="masseuse-link" class="header-link flex items-center justify-between xl:p-4">
                        <a href="{{ route('escortes') }}?selectedCategories=[2]"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-xs text-gray-900 md:text-sm xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                           {{ __('header.masseuse') }}
                        </a>
                    </li>
                    <li id="dominatrice-link" class="header-link flex items-center justify-between xl:p-4">
                        <a href="{{ route('escortes') }}?selectedCategories=[3]"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-xs text-gray-900 md:text-sm xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.dominatrice') }}
                        </a>
                    </li>
                    <li id="trans-link" class="header-link flex items-center justify-between text-xs md:text-sm xl:p-4">
                        <a href="{{ route('escortes') }}?selectedCategories=[4]"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-xs text-gray-900 md:text-sm xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.trans') }}
                        </a>
                    </li>
                    <li id="telephoneRose-link" class="header-link flex items-center justify-between text-xs md:text-sm xl:p-4">
                        <a href="{{ route('escortes') }}?selectedCategories=[9]"
                            class="font-roboto-slab hover:text-green-gs hover:bg-supaGirlRose xl:hover:text-green-gs flex w-full items-center justify-between rounded-sm px-3 py-2 text-xs text-gray-900 md:text-sm xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent">
                            {{ __('header.telephoneRose') }}
                        </a>
                    </li>
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

    
<style>
    .active-header {
    background-color:rgba(254, 231, 241, 0.91); /* Remplacez par la couleur souhaitée */
    color: #7F55B1 !important; /* Remplacez par la couleur de texte souhaitée */
    border-bottom: 2px solid #FDA5D6;
    /* Ajoutez d'autres propriétés CSS selon vos besoins */
}
</style>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headerLinks = document.querySelectorAll('.header-link');

            function setActiveLinkBasedOnURL() {
                const currentURL = window.location.href;
                const urlParams = new URLSearchParams(window.location.search);
                const selectedCategory = urlParams.get("selectedCategories[0]");

                headerLinks.forEach(link => {
                    const anchor = link.querySelector('a');
                    const linkURL = anchor.getAttribute('href');

                    // Réinitialise l'état
                    link.classList.remove('active-header');

                    // Active si l'URL contient le lien
                    if (currentURL.includes(linkURL)) {
                        link.classList.add('active-header');
                        localStorage.setItem('activeLinkId', link.id);
                    }

                    // Vérifie si le lien correspond à une catégorie spécifique
                    const linkCategoryMatch = linkURL.match(/selectedCategories=\[(\d+)\]/);
                    if (linkCategoryMatch && linkCategoryMatch[1] === selectedCategory) {
                        link.classList.add('active-header');
                        localStorage.setItem('activeLinkId', link.id);
                    }
                });
            }


            // Restaurer l'état actif depuis localStorage
            const activeLinkId = localStorage.getItem('activeLinkId');
            if (activeLinkId) {
                const activeLink = document.getElementById(activeLinkId);
                if (activeLink) {
                    activeLink.classList.add('active-header');
                }
            }

            // Set the active link based on the current URL when the page loads
            setActiveLinkBasedOnURL();

            headerLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    // Retirer la classe active de tous les liens
                    headerLinks.forEach(link => {
                        link.classList.remove('active-header');
                    });

                    // Ajouter la classe active au lien cliqué
                    this.classList.add('active-header');

                    // Stocker l'identifiant du lien actif dans localStorage
                    localStorage.setItem('activeLinkId', this.id);
                });
            });

            const dropdownToggle = document.getElementById('dropbtn');
            const dropdownToggle2 = document.getElementById('dropbtn2');

            const dropdownMenu = document.getElementById('dropdownMegaMenuMobile');
            const subDiv = document.getElementById('subDiv');

            const dropdownMenu2 = document.getElementById('dropdownMegaMenuMobile2');
            const subDiv2 = document.getElementById('subDiv2');

            dropdownToggle.addEventListener('click', function(event) {
                console.log('click');
                event.preventDefault();
                dropdownMenu.classList.toggle('hidden');
                subDiv.classList.remove('hidden');
                dropdownMenu.style.transform = 'translate(0px, 100px)';
            });

            dropdownToggle2.addEventListener('click', function(event) {
                console.log('click2 remove');
                event.preventDefault();
                dropdownMenu2.classList.toggle('hidden');
                subDiv2.classList.remove('hidden');
                dropdownMenu2.style.transform = 'translate(0px, 100px)';
            });

            // Fermer le menu déroulant lorsqu'on clique en dehors
            document.addEventListener('click', function(event) {
                const isClickInsideDropdown = dropdownMenu.contains(event.target);
                const isClickOnToggle = dropdownToggle.contains(event.target);
                const isClickOnToggle2 = dropdownToggle2.contains(event.target);
                if (!isClickInsideDropdown && !isClickOnToggle && !isClickOnToggle2) {
                    dropdownMenu.classList.add('hidden');
                    subDiv.classList.add('hidden');
                    dropdownMenu2.classList.add('hidden');
                    subDiv2.classList.add('hidden');
                }
            });
        });
    </script>
    <script>
    function toggleAccordion() {
        const menu = document.getElementById('menuAccordion');
        const btn = document.getElementById('accordionToggle');
        const icon = document.getElementById('accordionIcon');

        const isHidden = menu.classList.toggle('hidden');
        const expanded = !isHidden;

        btn.setAttribute('aria-expanded', expanded.toString());
        icon.classList.toggle('rotate-180', expanded);
    }
    </script>

@endpush

</div>

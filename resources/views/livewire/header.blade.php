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
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>

            {{-- Menu --}}
            <div id="mega-menu-full" class="items-center m-auto lg:m-0 justify-between font-medium hidden w-full order-1 xl:flex xl:w-auto">
                <ul class="flex flex-col p-4 xl:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 xl:space-x-8 rtl:space-x-reverse xl:flex-row xl:mt-0 xl:border-0 xl:bg-white dark:bg-gray-800 xl:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="{{route('escortes')}}" id="dropdownHoverMenu" data-dropdown-toggle="dropdownMegaMenu" data-dropdown-trigger="hover" data-dropdown-offset-distance="25" class="flex items-center py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">{{ __('header.escorts') }}  <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('salons')}}" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded-sm xl:w-auto hover:bg-gray-100 xl:hover:bg-transparent xl:border-0 xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">{{ __('header.salons') }} </a>
                    </li>
                    <li>
                        <a href="{{ url('about') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">{{ __('header.about') }} </a>
                    </li>
                    <li>
                        <a href="{{ url('glossaires') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">{{ __('header.glossary') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">{{ __('header.contact') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('gallery.show') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 xl:hover:bg-transparent xl:hover:text-yellow-500 xl:p-0 dark:text-white xl:dark:hover:text-yellow-500 dark:hover:bg-gray-700 dark:hover:text-yellow-500 xl:dark:hover:bg-transparent dark:border-gray-700">{{ __('header.galleries') }}</a>
                    </li>
                </ul>

                <x-language-selector />

            </div>

            {{-- Search --}}
            <div class="flex ml-auto mr-0 xl:order-1">
                <button data-modal-target="search-modal" data-modal-toggle="search-modal" type="button" class="md:hidden text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-1">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z" stroke="#05595B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
                <div data-modal-target="search-modal" data-modal-toggle="search-modal" class="relative hidden md:block">
                    <input type="text" id="search-navbar" class="block w-full p-2 pe-10 text-sm text-gray-950 border border-gray-300 rounded-xl bg-gray-100 focus:ring-green-gs focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('header.search_placeholder') }}">
                    <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z" stroke="#05595B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="sr-only">Search icon</span>
                    </div>
                </div>
            </div>

            @guest
            {{-- Btn de connexion --}}
            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button" class="hidden xl:block text-black btn-gs-gradient font-bold focus:outline-none rounded-lg text-sm px-4 py-2 text-center dark:focus:ring-yellow-800 lg:order-1">
              {{ __('header.login_register') }}
            </button>
            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button" class="xl:hidden text-yellow-500 hover:bg-yellow-500 hover:text-white focus:outline-none font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:border-yellow-500 dark:text-yellow-500 dark:hover:text-white dark:focus:ring-yellow-800 dark:hover:bg-yellow-500 xl:order-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M15 14c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4m-9-4V7H4v3H1v2h3v3h2v-3h3v-2m6 2a4 4 0 0 0 4-4a4 4 0 0 0-4-4a4 4 0 0 0-4 4a4 4 0 0 0 4 4" /></svg>
                <span class="sr-only">Icon description</span>
            </button>
            @endguest

            @auth
            {{-- Notification icon and user presentation --}}
            <div class="flex gap-3 xl:order-1">
                @livewire('notification')
                <button id="dropdownHoverUser" data-dropdown-toggle="dropdownUser" class="bg-gray-200 focus:outline-none font-bold rounded-lg text-center inline-flex items-center py-1.5 px-2 gap-2 xl:order-1 cursor-pointer" type="button">
                    <img class="rounded-full w-7 h-7" @if($avatar=auth()->user()->avatar)
                    src="{{ asset('storage/avatars/'.$avatar) }}"
                    @else
                    src="https://ui-avatars.com/api/?background=random&name={{ Auth::user()->pseudo ?? Auth::user()->prenom ?? Auth::user()->nom_salon}}"
                    @endif
                    alt="Image profile" />
                    <span class="hidden xl:inline-flex"> {{ Auth::user()->pseudo ?? Auth::user()->prenom ?? Auth::user()->nom_salon }} </span>
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdownUser" class="z-10 hidden bg-gray-300 divide-y divide-gray-400 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                    <ul x-data="{pageSection: $persist('compte')}" class="py-2 text-sm text-green-gs font-bold dark:text-gray-200" aria-labelledby="dropdownHoverUser">

                        <li>
                            <a x-on:click="pageSection='compte'" href="{{route('profile.index')}}" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">{{ __('header.my_account') }}</a>
                        </li>
                        <div x-show="userType=='invite'">
                            <li>
                                <a x-on:click="pageSection='favoris'" href="{{route('profile.index')}}" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">{{ __('header.my_favorites') }}</a>
                            </li>
                        </div>
                        <div x-show="!userType=='invite'">
                            <li>
                                <a x-on:click="pageSection='galerie'" href="{{route('profile.index')}}" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">{{ __('header.my_gallery') }}</a>
                            </li>
                        </div>
                        <li>
                            <a x-on:click="pageSection='discussion'" href="{{route('profile.index')}}" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">{{ __('header.discussion') }}</a>
                        </li>
                        @if(Auth::user()->createbysalon)

                        <li>
                            <a href="{{ route('salon.revenirSalon', ['id' => $salonCreator->id]) }}" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">
                                <h2>{{ __('header.go_to') }} {{ $salonCreator->nom_salon }}</h2> 
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="block px-4 py-2 hover:text-black hover:bg-gray-100 dark:hover:bg-gray-900 dark:hover:text-white">
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
        <div id="dropdownMegaMenu" aria-labelledby="dropdownHoverMenu" class="absolute p-0 m-0 w-full shadow-xs bg-green-gs hidden">
            <div class="hidden xl:flex max-w-screen-xl px-4 py-2 items-start justify-start gap-60 container p-20 mx-auto text-white md:px-6">
                <div class="flex flex-col">
                    <h2 class="font-dm-serif font-bold text-2xl my-6">{{ __('header.services') }}</h2>
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
                        <h2 class="font-dm-serif font-bold text-2xl my-6">{{ __('header.orientation') }}</h2>
                        <div class="flex flex-wrap w-full xl:w-[350px] gap-2">
                            <a href="{{route('escortes')}}?selectedGenre=homme" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">{{ __('header.man') }}</a>
                            <a href="{{route('escortes')}}?selectedGenre=Femme" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">{{ __('header.woman') }}</a>
                            <a href="{{route('escortes')}}?selectedGenre=trans" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">{{ __('header.transgender') }}</a>
                            <a href="{{route('escortes')}}?selectedGenre=gay" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">{{ __('header.gay') }}</a>
                            <a href="{{route('escortes')}}?selectedGenre=lesbienne" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">{{ __('header.lesbian') }}</a>
                            <a href="{{route('escortes')}}?selectedGenre=bisexuelle" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">{{ __('header.bisexual') }}</a>
                            <a href="{{route('escortes')}}?selectedGenre=queer" class="p-2 border border-gray-400 rounded-lg hover:text-amber-300 hover:border-amber-300">{{ __('header.queer') }}</a>
                        </div>
                    </div>
                    <div class="px-4">
                        <h2 class="font-dm-serif font-bold text-2xl my-6">{{ __('header.localization') }}</h2>
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

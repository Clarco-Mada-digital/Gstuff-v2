@extends('layouts.base')

@php
    use Carbon\Carbon;
    $noSpecial = __('profile.no_specified');
@endphp

@section('pageTitle')
    {{ $salon->nom_salon }}
@endsection

@section('content')
    <div x-data="{}"
        x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{ $couverture_image = $salon->couverture_image }}' ? '{{ asset('storage/couvertures/' . $couverture_image) }}' : '{{ asset('images/Logo_lg.svg') }}', imgModalDesc: '' })"
        class="relative max-h-[30vh] min-h-[30vh] w-full overflow-hidden"
        style="background: url({{ $salon->couverture_image ? asset('storage/couvertures/' . $salon->couverture_image) : asset('images/Logo_lg.svg') }}) center center /cover;">
    </div>

    <div class="container mx-auto flex flex-col justify-center xl:flex-row">

        <div x-data="{}" class="min-w-1/4 flex flex-col items-center gap-3 p-4">

            <div class="w-55 h-55 border-5 mx-auto -translate-y-[50%] rounded-full border-white">
                <img x-on:click="$dispatch('img-modal', {  imgModalSrc:'{{ $avatar = $salon->avatar }}' ? '{{ asset('storage/avatars/' . $avatar) }}' : '{{ asset('images/icon_logo.png') }}', imgModalDesc: '' })"
                    class="h-full w-full rounded-full object-cover object-center"
                    @if ($avatar = $salon->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                    @else
                    src="{{ asset('images/icon_logo.png') }}" @endif
                    alt="{{ __('salon_profile.profile_image') }}" />
            </div>
            <p class="-mt-[25%] font-bold md:-mt-[10%] xl:-mt-[25%]">{{ Str::ucfirst($salon->nom_salon) }}</p>
            <span class="font-dm-serif flex items-center gap-2 font-bold">
                @php
                    $locale = session('locale', 'fr');
                    $categoryName =
                        $salon->categorie['nom'][$locale] ??
                        ($salon->categorie['nom']['fr'] ?? ($salon->categorie['nom'] ?? '-'));
                @endphp


                {{ Str::ucfirst($categoryName) }}</span>


            @php
                $no_phone = __('salon_profile.no_phone');
            @endphp
            <a href="tel:0000000" class="font-dm-serif flex items-center gap-2 font-bold"><svg class="h-5 w-5"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M19.95 21q-3.125 0-6.187-1.35T8.2 15.8t-3.85-5.55T3 4.05V3h5.9l.925 5.025l-2.85 2.875q.55.975 1.225 1.85t1.45 1.625q.725.725 1.588 1.388T13.1 17l2.9-2.9l5 1.025V21zM16.5 11q-.425 0-.712-.288T15.5 10t.288-.712T16.5 9t.713.288t.287.712t-.288.713T16.5 11" />
                </svg>{{ $salon->telephone ?? $no_phone }}</a>
            <div class="text-green-gs flex items-center justify-center gap-2">
                <a href="{{ route('escortes') }}?selectedCanton={{ $salon->canton->id ?? ''  }}" class="flex items-center gap-1">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="none">
                        <path
                            d="M4 13.2864C2.14864 14.1031 1 15.2412 1 16.5C1 18.9853 5.47715 21 11 21C16.5228 21 21 18.9853 21 16.5C21 15.2412 19.8514 14.1031 18 13.2864M17 7C17 11.0637 12.5 13 11 16C9.5 13 5 11.0637 5 7C5 3.68629 7.68629 1 11 1C14.3137 1 17 3.68629 17 7ZM12 7C12 7.55228 11.5523 8 11 8C10.4477 8 10 7.55228 10 7C10 6.44772 10.4477 6 11 6C11.5523 6 12 6.44772 12 7Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg> {{ $salon->canton->nom ?? '' }}</a>
                <button class="flex items-center gap-1"> <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M5 12h.5m3 0H10m3 0h6m-6 6l6-6m-6-6l6 6" />
                    </svg></svg> {{ $salon->ville->nom ?? '' }}</button>
            </div>
            <div class="text-green-gs flex items-center justify-center gap-2">
                <span class="flex items-center gap-1">{{ __('salon_profile.recruitment') }} :
                    @if ($salon->recrutement == 'Ouvert')
                        {{ __('salon_profile.open') }}
                    @else
                        {{ __('salon_profile.closed') }}
                    @endif
                </span>
            </div>
            <hr class="h-2 w-full">

            @auth
                <button
                    class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-400 p-2 text-sm hover:text-white">
                    <livewire:favorite-button :userId='$salon->id' wire:key='{{ $salon->id }}' />
                    {{ __('salon_profile.add_to_favorites') }}
                </button>
            @endauth
            <button
                @auth x-on:click="$dispatch('loadForSender', [{{ $salon->id }}])" @else data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" @endauth
                class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-400 p-2 text-sm hover:text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 3c5.5 0 10 3.58 10 8s-4.5 8-10 8c-1.24 0-2.43-.18-3.53-.5C5.55 21 2 21 2 21c2.33-2.33 2.7-3.9 2.75-4.5C3.05 15.07 2 13.13 2 11c0-4.42 4.5-8 10-8m5 9v-2h-2v2zm-4 0v-2h-2v2zm-4 0v-2H7v2z" />
                </svg>
                {{ __('salon_profile.send_message') }}
            </button>
            <button
                class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-400 p-2 text-sm hover:text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M256 448c141.4 0 256-93.1 256-208S397.4 32 256 32S0 125.1 0 240c0 45.1 17.7 86.8 47.7 120.9c-1.9 24.5-11.4 46.3-21.4 62.9c-5.5 9.2-11.1 16.6-15.2 21.6c-2.1 2.5-3.7 4.4-4.9 5.7c-.6.6-1 1.1-1.3 1.4l-.3.3c-4.6 4.6-5.9 11.4-3.4 17.4s8.3 9.9 14.8 9.9c28.7 0 57.6-8.9 81.6-19.3c22.9-10 42.4-21.9 54.3-30.6c31.8 11.5 67 17.9 104.1 17.9zM96 212.8c0-20.3 16.5-36.8 36.8-36.8H152c8.8 0 16 7.2 16 16s-7.2 16-16 16h-19.2c-2.7 0-4.8 2.2-4.8 4.8c0 1.6.8 3.1 2.2 4l29.4 19.6c10.3 6.8 16.4 18.3 16.4 30.7c0 20.3-16.5 36.8-36.8 36.8l-27.2.1c-8.8 0-16-7.2-16-16s7.2-16 16-16h27.2c2.7 0 4.8-2.2 4.8-4.8c0-1.6-.8-3.1-2.2-4l-29.4-19.6c-10.2-6.9-16.4-18.4-16.4-30.8M372.8 176H392c8.8 0 16 7.2 16 16s-7.2 16-16 16h-19.2c-2.7 0-4.8 2.2-4.8 4.8c0 1.6.8 3.1 2.2 4l29.4 19.6c10.2 6.8 16.4 18.3 16.4 30.7c0 20.3-16.5 36.8-36.8 36.8l-27.2.1c-8.8 0-16-7.2-16-16s7.2-16 16-16h27.2c2.7 0 4.8-2.2 4.8-4.8c0-1.6-.8-3.1-2.2-4l-29.4-19.6c-10.2-6.8-16.4-18.3-16.4-30.7c0-20.3 16.5-36.8 36.8-36.8zm-152 6.4l35.2 46.9l35.2-46.9c4.1-5.5 11.3-7.8 17.9-5.6S320 185.1 320 192v96c0 8.8-7.2 16-16 16s-16-7.2-16-16v-48l-19.2 25.6c-3 4-7.8 6.4-12.8 6.4s-9.8-2.4-12.8-6.4L224 240v48c0 8.8-7.2 16-16 16s-16-7.2-16-16v-96c0-6.9 4.4-13 10.9-15.2s13.7.1 17.9 5.6" />
                </svg>
                {{ __('salon_profile.no_sms_contact') }}
            </button>
            <button
                class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-400 p-2 text-sm hover:text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g fill="none" fill-rule="evenodd">
                        <path
                            d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                        <path fill="currentColor"
                            d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2.546 20.2A1.01 1.01 0 0 0 3.8 21.454l3.032-.892A9.96 9.96 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2M9.738 14.263c2.023 2.022 3.954 2.289 4.636 2.314c1.037.038 2.047-.754 2.44-1.673a.7.7 0 0 0-.088-.703c-.548-.7-1.289-1.203-2.013-1.703a.71.71 0 0 0-.973.158l-.6.915a.23.23 0 0 1-.305.076c-.407-.233-1-.629-1.426-1.055s-.798-.992-1.007-1.373a.23.23 0 0 1 .067-.291l.924-.686a.71.71 0 0 0 .12-.94c-.448-.656-.97-1.49-1.727-2.043a.7.7 0 0 0-.684-.075c-.92.394-1.716 1.404-1.678 2.443c.025.682.292 2.613 2.314 4.636" />
                    </g>
                </svg>
                {{ __('salon_profile.no_whatsapp_contact') }}
            </button>
            <a href="mailto:{{ $salon->email }}"
                class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-400 p-2 text-sm hover:text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10h5v-2h-5c-4.34 0-8-3.66-8-8s3.66-8 8-8s8 3.66 8 8v1.43c0 .79-.71 1.57-1.5 1.57s-1.5-.78-1.5-1.57V12c0-2.76-2.24-5-5-5s-5 2.24-5 5s2.24 5 5 5c1.38 0 2.64-.56 3.54-1.47c.65.89 1.77 1.47 2.96 1.47c1.97 0 3.5-1.6 3.5-3.57V12c0-5.52-4.48-10-10-10m0 13c-1.66 0-3-1.34-3-3s1.34-3 3-3s3 1.34 3 3s-1.34 3-3 3" />
                </svg>
                {{ $salon->email ?? '' }}
            </a>

        </div>

        <div class="min-w-3/4 px-5 py-5">

            <div>

                <section>

                    <div class="min-w-3/4 py-5">
                        <div class="text-green-gs font-dm-serif w-full text-right font-bold">
                            <a
                                href="{{ route('salons') . '?selectedSalonCategories=' . ($salon->categorie['id'] ?? '') }}">

                                @php
                                    $locale = session('locale', 'fr');
                                    $categoryName =
                                        $salon->categorie['nom'][$locale] ??
                                        ($salon->categorie['nom']['fr'] ?? ($salon->categorie['nom'] ?? '-'));
                                @endphp
                                {{ Str::ucfirst($categoryName) }}
                            </a>
                            /
                            <a href="{{ route('salons') . '?selectedSalonCanton=' . ($salon->canton['id'] ?? '') }}">
                                {{ Str::ucfirst($salon->canton['nom'] ?? '') }}
                            </a>
                            /
                            {{ Str::ucfirst($salon->profile_type ?? '') }}
                            /
                            {{ Str::ucfirst($salon->nom_salon) }}
                        </div>

                        <section>

                            {{-- Galerie --}}
                            @livewire('gallery-manager', ['user' => $salon], key($salon->id))

                            {{-- A propos de moi --}}
                            <div class="flex items-center justify-between gap-5 py-5">

                                <h2 class="font-dm-serif text-green-gs text-2xl font-bold">
                                    {{ __('salon_profile.about_me') }}</h2>
                                <div class="bg-green-gs h-0.5 flex-1"></div>

                            </div>
                            <div class="flex flex-wrap items-center gap-10">
                                <div class="grid w-full grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">


                                    <x-profile-info-item 
                                        icon="escort_icon.svg"
                                        :alt="__('salon_profile.girls_icon')"
                                        :label="__('salon_profile.number_of_girls')"
                                        :value="$salon->nombre_filles"
                                        suffix="{{ __('salon_profile.girls') }}"
                                    />
                                 
                                    <x-profile-info-item 
                                        icon="tarif_icon.svg"
                                        :alt="__('salon_profile.rate_icon')"
                                        :label="__('salon_profile.rates_from')"
                                        :value="$salon->tarif"
                                        suffix=".-CHF"
                                    />

                                    <x-profile-info-item 
                                        icon="cart_icon.svg"
                                        :alt="__('salon_profile.other_contact_icon')"
                                        :label="__('salon_profile.other_contact')"
                                        :value="$salon->autre_contact"
                                    />

                                    <x-info-display :items="$salon->paiement" type="payment" />

                                    <x-info-display :items="$salon->langues" type="language" />


                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="flex items-center justify-between gap-5 py-5">

                                <h2 class="font-dm-serif text-green-gs text-2xl font-bold">
                                    {{ __('salon_profile.description') }}</h2>
                                <div class="bg-green-gs h-0.5 flex-1"></div>

                            </div>
                            <div class="flex flex-wrap items-center gap-10">
                                <p class="text-justify">{{ $salon->apropos ?? '-' }}</p>
                            </div>

                            {{-- Escort associé --}}
                            <div class="flex items-center justify-between gap-5 py-5">

                                <h2 class="font-dm-serif text-green-gs text-2xl font-bold">
                                    {{ __('salon_profile.our_professionals') }}</h2>
                                <div class="bg-green-gs h-0.5 flex-1"></div>

                            </div>
                            @if ($acceptedInvitations->isNotEmpty())
                                <div class="relative w-full">
                                    <div class="swiper-container professionals-swiper">
                                        <div class="swiper-wrapper">
                                            @foreach ($acceptedInvitations as $index => $acceptedInvitation)
                                                <div class="swiper-slide">
                                                    @if ($acceptedInvitation->type === 'associe au salon')
                                                        <livewire:escort_card
                                                            name="{{ $acceptedInvitation->inviter->prenom ?? $acceptedInvitation->inviter->nom_salon }}"
                                                            canton="{{ $acceptedInvitation->inviter->cantonget->nom ?? $noSpecial }}"
                                                            ville="{{ $acceptedInvitation->inviter->villeget->nom ?? $noSpecial }}"
                                                            avatar="{{ $acceptedInvitation->inviter->avatar }}"
                                                            escortId="{{ $acceptedInvitation->inviter->id }}"
                                                            wire:key="{{ $acceptedInvitation->inviter->id }}" />
                                                    @else
                                                        <livewire:escort_card
                                                            name="{{ $acceptedInvitation->invited->prenom ?? $acceptedInvitation->invited->nom_salon }}"
                                                            canton="{{ $acceptedInvitation->invited->cantonget->nom ?? $noSpecial }}"
                                                            ville="{{ $acceptedInvitation->invited->villeget->nom ?? $noSpecial }}"
                                                            avatar="{{ $acceptedInvitation->invited->avatar }}"
                                                            escortId="{{ $acceptedInvitation->invited->id }}"
                                                            wire:key="{{ $acceptedInvitation->invited->id }}" />
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <!-- Navigation buttons -->
                                        <button type="button"
                                            class="group absolute start-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none swiper-button-prev">
                                            <span
                                                class="bg-green-gs group-hover:bg-green-gs/80 group-focus:ring-green-gs/50 inline-flex h-10 w-10 items-center justify-center rounded-full group-focus:outline-none group-focus:ring-4">
                                                <svg class="h-4 w-4 text-white rtl:rotate-180" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                                </svg>
                                                <span class="sr-only">Previous</span>
                                            </span>
                                        </button>

                                        <button type="button"
                                            class="group absolute end-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none swiper-button-next">
                                            <span
                                                class="bg-green-gs group-hover:bg-green-gs/80 group-focus:ring-green-gs/50 inline-flex h-10 w-10 items-center justify-center rounded-full group-focus:outline-none group-focus:ring-4">
                                                <svg class="h-4 w-4 text-white rtl:rotate-180" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                                </svg>
                                                <span class="sr-only">Next</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="flex h-full w-full items-center justify-center">
                                    <span class="text-green-gs font-dm-serif text-center font-bold">
                                        {{ __('salon_profile.no_escort_associated') }}
                                    </span>
                                </div>
                            @endif

                            @push('scripts')
                            <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
                            <style>
                                .professionals-swiper {
                                    padding: 20px 60px;
                                    position: relative;
                                    width: 100%;
                                    overflow: hidden;
                                }
                                .swiper-wrapper {
                                    display: flex;
                                    width: 100%;
                                }
                                .swiper-slide {
                                    display: flex;
                                    justify-content: center;
                                    align-items: flex-start;
                                    width: 300px; /* Largeur fixe pour chaque carte */
                                    height: auto;
                                    flex-shrink: 0;
                                }
                                
                                @media (max-width: 1024px) {
                                    .swiper-slide {
                                        width: 250px; /* Largeur réduite sur les tablettes */
                                    }
                                }
                                
                                @media (max-width: 640px) {
                                    .swiper-slide {
                                        width: 100%; /* Pleine largeur sur mobile */
                                    }
                                }
                                .swiper-button-next,
                                .swiper-button-prev {
                                    position: absolute;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    z-index: 10;
                                    padding: 0;
                                    border: none;
                                    background: transparent;
                                }
                                .swiper-button-next {
                                    right: 0;
                                }
                                .swiper-button-prev {
                                    left: 0;
                                }
                                .swiper-button-next:after,
                                .swiper-button-prev:after {
                                    font-size: 20px;
                                    font-weight: bold;
                                }
                            </style>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const swiper = new Swiper('.professionals-swiper', {
                                        slidesPerView: 'auto',
                                        spaceBetween: 20,
                                        centeredSlides: false,
                                        freeMode: true,
                                        loop: true,
                                        autoplay: {
                                            delay: 10000, // 10 secondes
                                            disableOnInteraction: false,
                                        },
                                        navigation: {
                                            nextEl: '.swiper-button-next',
                                            prevEl: '.swiper-button-prev',
                                        },
                                        breakpoints: {
                                            640: {
                                                slidesPerView: 2,
                                            },
                                            1024: {
                                                slidesPerView: 3,
                                            },
                                        },
                                    });
                                });
                            </script>
                            @endpush

                            {{-- Galerie privée --}}
                            @guest
                                <div
                                    class="font-dm-serif text-green-gs my-3 flex w-full flex-col items-center justify-center gap-5">
                                    <svg class="w-25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M6 7.5a5.5 5.5 0 1 1 11 0a5.5 5.5 0 0 1-11 0M18 14c.69 0 1.25.56 1.25 1.25V16h-2.5v-.75c0-.69.56-1.25 1.25-1.25m3.25 2v-.75a3.25 3.25 0 0 0-6.5 0V16h-1.251v6.5h9V16zm-9.75 6H2v-2a6 6 0 0 1 6-6h3.5z" />
                                    </svg>
                                    <p class="text-center text-3xl font-extrabold">
                                        {{ __('salon_profile.login_to_see_private_content') }}</p>
                                    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                                        class="font-dm-serif btn-gs-gradient rounded-lg font-bold">{{ __('salon_profile.login_signup') }}</button>
                                </div>
                            @endguest
                            @auth
                                @livewire('gallery-manager', ['user' => $salon, 'isPublic' => false], key($salon->id))
                            @endauth

                            {{-- Feed-back et note --}}
                            <livewire:feedback :userToId=$salon />

                        </section>

                    </div>

                </section>

            </div>

        </div>

    </div>

@stop

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
        x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{ $couverture_image = $salon->couverture_image }}' ? '{{ asset('storage/couvertures/' . $couverture_image) }}' : '{{ asset('images/Logo_lg.png') }}', imgModalDesc: '' })"
        class="relative max-h-[30vh] min-h-[30vh] w-full overflow-hidden"
        style="background: url({{ $salon->couverture_image ? asset('storage/couvertures/' . $salon->couverture_image) : asset('images/Logo_lg.png') }}) center center /cover;">
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
            <p class="-mt-[25%] font-bold md:-mt-[10%] xl:-mt-[25%] font-roboto-slab">{{ Str::ucfirst($salon->nom_salon) }}</p>
            <span class="font-roboto-slab flex items-center gap-2  text-sm text-textColorParagraph">
                @php
                    $locale = session('locale', 'fr');
                    $categoryName =
                        $salon->categorie['nom'][$locale] ??
                        ($salon->categorie['nom']['fr'] ?? ($salon->categorie['nom'] ?? '-'));
                @endphp


                {{ Str::ucfirst($categoryName) }}</span>


            <x-contact.phone-link 
                :phone="$salon->telephone ?? null"
                :noPhoneText="__('salon_profile.no_phone')"
            />
        
            <x-location.escort-location 
                :cantonId="$salon->canton->id ?? null" 
                :cantonName="$salon->canton['nom'] ?? null" 
                :cityName="$salon->ville['nom'] ?? null"
            />


            <div class="text-green-gs flex items-center justify-center gap-2 font-roboto-slab">
                <span class="flex items-center gap-1 bg-fieldBg px-2 py-1">{{ __('salon_profile.recruitment') }} :
                </span>
                <span class="font-bold text-green-gs">
                    @if ($salon->recrutement == 'Ouvert')
                        {{ __('salon_profile.open') }}  
                    @else
                        {{ __('salon_profile.closed') }}
                    @endif
                </span>
            </div>


            <hr class="h-2 w-full text-green-gs ">

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

            <x-contact.sms-button 
                :phone="$salon->telephone ?? null"
                :noContactText="__('salon_profile.no_sms_contact')"
            />
            <x-contact.whatsapp-button 
                :phone="$salon->whatsapp ?? null"
                :noContactText="__('salon_profile.no_whatsapp_contact')"
            />
      

            <x-contact.email-button 
                :email="$salon->email"
                :noEmailText="__('salon_profile.no_email')"
            />

        </div>

        <div class="min-w-3/4 px-5 py-5">

            <div>

                <section>

                    <div class="min-w-3/4 py-5">
                        <div class="text-green-gs font-roboto-slab w-full text-right font-bold">
                            <a
                                href="{{ route('salons') . '?selectedSalonCategories=' . ($salon->categorie['id'] ?? '') }}" 
                                class="hover:text-green-gs">

                                @php
                                    $locale = session('locale', 'fr');
                                    $categoryName =
                                        $salon->categorie['nom'][$locale] ??
                                        ($salon->categorie['nom']['fr'] ?? ($salon->categorie['nom'] ?? '-'));
                                @endphp
                                {{ Str::ucfirst($categoryName) }}
                            </a>
                            /
                            <a href="{{ route('salons') . '?selectedSalonCanton=' . ($salon->canton['id'] ?? '') }}"
                                class="hover:text-green-gs">
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

                                <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">
                                    {{ __('salon_profile.about_me') }}</h2>
                                <div class="bg-green-gs h-0.5 flex-1"></div>

                            </div>
                            <div class="flex flex-wrap items-center gap-10">
                                <div class="grid w-full grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">


                                    <x-profile-info-item 
                                        icon="escort_icon.png"
                                        :alt="__('salon_profile.girls_icon')"
                                        :label="__('salon_profile.number_of_girls')"
                                        :value="$salon->nombre_filles"
                                        suffix="{{ __('salon_profile.girls') }}"
                                    />
                                 
                                    <x-profile-info-item 
                                        icon="tarif_icon.png"
                                        :alt="__('salon_profile.rate_icon')"
                                        :label="__('salon_profile.rates_from')"
                                        :value="$salon->tarif"
                                        suffix=".-CHF"
                                    />

                                    <x-profile-info-item 
                                        icon="cart_icon.png"
                                        :alt="__('salon_profile.other_contact_icon')"
                                        :label="__('salon_profile.other_contact')"
                                        :value="$salon->autre_contact"
                                    />

                                    <x-info-display :items="$salon->paiement" type="payment" />

                                    <x-info-display :items="$salon->langues" type="language" />


                                </div>
                            </div>

                            {{-- Description --}}
                            <x-profile.description 
                                :title="__('salon_profile.description')"
                                :content="$salon->apropos"
                            />

                            {{-- Escort associé --}}
                            <div class="flex items-center justify-between gap-5 py-5">

                                <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">
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
                             

                                <x-auth.login-required 
                                    :title="__('salon_profile.login_to_see_private_content')"
                                    :buttonText="__('salon_profile.login_signup')"
                                />
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

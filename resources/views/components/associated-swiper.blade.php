@props([
    'data' => null,
    'type' => null,
    'profil' => null,
])


@php

    $noSpecial = __('profile.no_specified');
@endphp
<div>
    @if ($data->isNotEmpty())
        <!-- <div class="flex items-center justify-between gap-5 py-5">
        <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">
            {{ $type === 'escort' ? __('escort_profile.associated_salon') : __('salon_profile.our_professionals') }}
        </h2>
        <div class="bg-green-gs h-0.5 flex-1"></div>
    </div> -->

        <div class="flex items-center justify-between gap-5 py-5">
            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">
                {{ $type === 'escort' ? __('escort_profile.associated_salon') : __('salon_profile.our_professionals') }}
            </h2>
            <div class="bg-green-gs h-0.5 flex-1"></div>
            @if ($profil === 'user')
                <button data-modal-target="sendInvitationSalon" data-modal-toggle="sendInvitationSalon"
                    class="text-green-gs hover:text-green-gs hover:bg-fieldBg bg-supaGirlRose font-roboto-slab flex cursor-pointer items-center gap-2 rounded-md px-5 py-2">
                    {{ __('profile.invite_salon') }}
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                    </svg>
                </button>
            @endif
        </div>

        <div class="relative w-full">
            <div class="swiper-container professionals-swiper">
                <div class="swiper-wrapper">

                    @if ($type === 'escort')
                        @foreach ($data as $salonAssocier)
                            <div class="swiper-slide">
                                <livewire:salon-card name="{{ $salonAssocier->inviter->nom_salon }}"
                                    canton="{{ $salonAssocier->inviter->cantonget->nom ?? '' }}"
                                    ville="{{ $salonAssocier->inviter->villeget->nom ?? '' }}"
                                    avatar="{{ $salonAssocier->inviter->avatar }}"
                                    salonId="{{ $salonAssocier->inviter->id }}"
                                    isPause="{{ $salonAssocier->inviter->is_profil_pause }}"
                                    wire:key="{{ $salonAssocier->inviter->id }}" />
                            </div>
                        @endforeach

                    @endif

                    @if ($type === 'salon')
                        @foreach ($data as $index => $acceptedInvitation)
                            <div class="swiper-slide">
                                @if ($acceptedInvitation->type === 'associe au salon')
                                    <livewire:escort_card
                                        name="{{ $acceptedInvitation->inviter->prenom ?? $acceptedInvitation->inviter->nom_salon }}"
                                        canton="{{ $acceptedInvitation->inviter->cantonget->nom ?? $noSpecial }}"
                                        ville="{{ $acceptedInvitation->inviter->villeget->nom ?? $noSpecial }}"
                                        avatar="{{ $acceptedInvitation->inviter->avatar }}"
                                        escortId="{{ $acceptedInvitation->inviter->id }}"
                                        profileVerifie="{{ $acceptedInvitation->inviter->profile_verifie }}"
                                        wire:key="{{ $acceptedInvitation->inviter->id }}"
                                        isPaused="{{ $acceptedInvitation->inviter->is_profil_pause }}" />
                                @else
                                    <livewire:escort_card
                                        name="{{ $acceptedInvitation->invited->prenom ?? $acceptedInvitation->invited->nom_salon }}"
                                        canton="{{ $acceptedInvitation->invited->cantonget->nom ?? $noSpecial }}"
                                        ville="{{ $acceptedInvitation->invited->villeget->nom ?? $noSpecial }}"
                                        avatar="{{ $acceptedInvitation->invited->avatar }}"
                                        escortId="{{ $acceptedInvitation->invited->id }}"
                                        profileVerifie="{{ $acceptedInvitation->invited->profile_verifie }}"
                                        wire:key="{{ $acceptedInvitation->invited->id }}"
                                        isPaused="{{ $acceptedInvitation->invited->is_profil_pause }}" />
                                @endif
                            </div>
                        @endforeach
                    @endif

                </div>

                <!-- Navigation buttons -->
                <button type="button" class="swiper-button-prev"></button>
                <button type="button" class="swiper-button-next"></button>
            </div>
        </div>
    @else
        <div class="flex h-full w-full items-center justify-center">
            <span class="text-green-gs font-dm-serif text-center font-bold">
                {{ __('escort_profile.no_associated_salon') }}
            </span>
        </div>
    @endif

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
            justify-content: space-between;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin: 0 10px;
            width: 300px;
            /* Largeur fixe pour chaque carte */
            height: auto;
            flex-shrink: 0;
        }

        @media (max-width: 1024px) {
            .swiper-slide {
                width: 300px;
                /* Largeur réduite sur les tablettes */
            }
        }

        @media (max-width: 640px) {
            .swiper-slide {
                width: 100%;
                /* Pleine largeur sur mobile */
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
            font-size: 12px;
            background-color: #7F55B1;
            color: #fff;
            padding: 10px;
            border-radius: 100%;
            font-weight: bold;
        }
    </style>
</div>

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.professionals-swiper', {
                slidesPerView: 'auto',
                spaceBetween: 100,
                centeredSlides: false,
                freeMode: true,
                loop: true,
                autoplay: {
                    delay: 10000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1
                    },
                    640: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    },
                },
            });
        });
    </script>
@endpush

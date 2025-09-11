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
        <div class="flex items-center justify-between gap-2 md:gap-5 py-2 md:py-5">
            <h2 class="font-roboto-slab text-green-gs text-sm sm:text-2xl font-bold">
                {{ $type === 'escort' ? __('escort_profile.associated_salon') : __('salon_profile.our_professionals') }}
            </h2>
            <div class="bg-green-gs h-0.5 flex-1"></div>
            @if ($profil === 'user')
                <button data-modal-target="sendInvitationSalon" data-modal-toggle="sendInvitationSalon"
                    class="text-green-gs hover:text-green-gs hover:bg-fieldBg bg-supaGirlRose font-roboto-slab flex cursor-pointer items-center gap-2 rounded-md px-3 sm:px-5 py-2 text-xs sm:text-sm">
                    <span class="hidden sm:inline">{{ __('profile.invite_salon') }}</span>
                    <span class="sm:hidden">{{ __('profile.invite') }}</span>
                    <svg class="h-4 w-4 sm:h-5 sm:w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h6.525q.5 0 .75.313t.25.687t-.262.688T11.5 5H5v14h14v-6.525q0-.5.313-.75t.687-.25t.688.25t.312.75V19q0 .825-.587 1.413T19 21zm4-7v-2.425q0-.4.15-.763t.425-.637l8.6-8.6q.3-.3.675-.45t.75-.15q.4 0 .763.15t.662.45L22.425 3q.275.3.425.663T23 4.4t-.137.738t-.438.662l-8.6 8.6q-.275.275-.637.438t-.763.162H10q-.425 0-.712-.288T9 14m12.025-9.6l-1.4-1.4zM11 13h1.4l5.8-5.8l-.7-.7l-.725-.7L11 11.575zm6.5-6.5l-.725-.7zl.7.7z" />
                    </svg>
                </button>
            @endif
        </div>

        <div class="relative w-full overflow-hidden">
            <div class="professionals-swiper">
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
                <button type="button" class="swiper-button-prev" aria-label="Previous slide"></button>
                <button type="button" class="swiper-button-next" aria-label="Next slide"></button>
            </div>
        </div>
    @else
        <div class="flex h-32 w-full items-center justify-center">
            <span class="text-green-gs font-dm-serif text-center font-bold px-4">
                {{ $type === 'escort' ? __('escort_profile.no_associated_salon') : __('salon_profile.no_professionals') }}
            </span>
        </div>
    @endif

    <style>
        .professionals-swiper {
            position: relative;
            width: 100%;
            padding: 20px 0;
        }

        .swiper-wrapper {
            display: flex;
            align-items: flex-start;
        }

        .swiper-slide {
            display: flex !important;
            justify-content: center !important;
            align-items: flex-start;
            width: 280px;
            height: auto;
            flex-shrink: 0;
        }

        /* Navigation buttons */
        .swiper-button-next,
        .swiper-button-prev {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 20;
            width: 40px;
            height: 40px;
            margin-top: -20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(127, 85, 177, 0.9);
            border-radius: 50%;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(127, 85, 177, 1);
            transform: translateY(-50%) scale(1.1);
        }

        .swiper-button-next {
            right: 10px;
        }

        .swiper-button-prev {
            left: 10px;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 16px;
            color: white;
            font-weight: bold;
        }

        /* Responsive design */
        @media (max-width: 640px) {
            .professionals-swiper {
                padding: 15px 0;
            }
            
            .swiper-slide {
                width: 260px;
                margin: 0 auto;
            }
            
            .swiper-button-next,
            .swiper-button-prev {
                width: 35px;
                height: 35px;
                margin-top: -17.5px;
            }
            
            .swiper-button-next {
                right: 5px;
            }
            
            .swiper-button-prev {
                left: 5px;
            }
            
            .swiper-button-next:after,
            .swiper-button-prev:after {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .swiper-slide {
                width: 240px;
            }
        }

        @media (max-width: 320px) {
            .swiper-slide {
                width: 220px;
            }
        }

        /* Masquer les boutons quand il n'y a qu'une slide visible */
        .swiper-button-disabled {
            opacity: 0.3;
            pointer-events: none;
        }
    </style>
</div>

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.professionals-swiper', {
                slidesPerView: 'auto',
                spaceBetween: 20,
                centeredSlides: true, // Centre les slides sur mobile
                freeMode: false,
                loop: false, // Désactivé pour éviter les problèmes de centrage
                grabCursor: true,
                autoplay: {
                    delay: 8000,
                    disableOnInteraction: true,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10,
                        centeredSlides: true,
                    },
                    480: {
                        slidesPerView: 1,
                        spaceBetween: 15,
                        centeredSlides: true,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                        centeredSlides: false,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 25,
                        centeredSlides: false,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                        centeredSlides: false,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                        centeredSlides: false,
                    },
                },
                on: {
                    init: function() {
                        // Masquer les boutons s'il n'y a pas assez de slides
                        this.updateNavigationButtons();
                    },
                    slideChange: function() {
                        this.updateNavigationButtons();
                    }
                }
            });

            // Fonction pour gérer l'affichage des boutons de navigation
            swiper.updateNavigationButtons = function() {
                const prevButton = document.querySelector('.swiper-button-prev');
                const nextButton = document.querySelector('.swiper-button-next');
                
                if (this.slides.length <= this.params.slidesPerView) {
                    if (prevButton) prevButton.style.display = 'none';
                    if (nextButton) nextButton.style.display = 'none';
                } else {
                    if (prevButton) prevButton.style.display = 'flex';
                    if (nextButton) nextButton.style.display = 'flex';
                }
            };
        });
    </script>
@endpush
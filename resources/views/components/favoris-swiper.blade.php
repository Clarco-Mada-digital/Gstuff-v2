@props([
    'data' => null,
    'type' => null,
    'profil' => null,
])

@php
    $componentId = 'swiper-' . uniqid();
@endphp


@php
    $noSpecial = __('profile.no_specified');
@endphp

<div>
    @if ($data->isNotEmpty())
        <div class="flex items-center justify-between gap-2 md:gap-5 py-2 md:py-5">
            <h2 class="font-roboto-slab text-green-gs text-xs sm:text-xl font-bold ">
                {{ $type === 'escort' ? __('profile.favorite_escorts') : __('profile.favorite_salons') }}
            </h2>
        </div>

        <div class="relative w-full overflow-hidden">
            <div id="{{ $componentId }}" class="professionals-swiper">
                <div class="swiper-wrapper">
                        @foreach ($data as $escort)
                            <div class="swiper-slide">
                            <livewire:escort-card name="{{ $escort->prenom }}"
                                                    canton="{{ $escort->canton['nom'] ?? '' }}"
                                                    ville="{{ $escort->ville['nom'] ?? '' }}"
                                                    avatar='{{ $escort->avatar }}' escortId='{{ $escort->id }}'
                                                    isOnline='{{ $escort->isOnline() }}'
                                                    isPause="{{ $escort->is_profil_pause }}" />
                            </div>
                        @endforeach
                </div>

                <!-- Navigation buttons -->
                <button type="button" class="swiper-button-prev" id="{{ $componentId }}-prev" aria-label="Previous slide"></button>
                <button type="button" class="swiper-button-next" id="{{ $componentId }}-next" aria-label="Next slide"></button>
            </div>
        </div>
    @else
        <div class="flex h-32 w-full items-center justify-center">
            <span class="text-green-gs font-dm-serif text-center font-bold px-4">
                {{ $type === 'escort' ? __('profile.no_favorite_escorts') : __('profile.no_favorite_salons') }}
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
            width: 260px;
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
            font-size: 10px;
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

        .swiper-navigation-icon {
            font-size: 10px;
            color: white;
            font-weight: bold;
            width: 10px !important;
            height: 10px !important;
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
            const swiper = new Swiper('#{{ $componentId }}', {
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
                    nextEl: '#{{ $componentId }}-next',
                    prevEl: '#{{ $componentId }}-prev',
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10,
                        centeredSlides: true,
                    },
                    480: {
                        slidesPerView: 2,
                        spaceBetween: 15,
                        centeredSlides: true,
                    },
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 20,
                        centeredSlides: false,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 25,
                        centeredSlides: false,
                    },
                    1024: {
                        slidesPerView: 4,
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
                const prevButton = document.querySelector('#{{ $componentId }}-prev');
                const nextButton = document.querySelector('#{{ $componentId }}-next');
                
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
@props([
    'data' => null,
    'type' => null,
    'profil' => null,
])

<div>



<div class="flex min-w-full flex-col items-center justify-center gap-4 xl:w-1/2">
    <h3 class="font-roboto-slab text-green-gs text-xl">{{ __('profile.favorite_salons') }}</h3>
    @if ($data->isNotEmpty())
        <div class="relative w-full">
            <div class="swiper-container professionals-swiper">
                <div class="swiper-wrapper">
                @if ($type === 'salon')
                    @foreach ($data as $favorie)
                        <div class="swiper-slide">
                            <livewire:escort-card name="{{  $favorie->nom_salon ?? $favorie->prenom }}"
                                canton="{{ $favorie->canton['nom'] ?? '' }}"
                                ville="{{ $favorie->ville['nom'] ?? '' }}" avatar='{{ $favorie->avatar }}'
                                escortId="{{ $favorie->id }}" isPause="{{ $favorie->is_profil_pause }}" />       
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
        <div class="text-roboto-slab text-sm text-textColorParagraph">{{ __('profile.no_favorite_salons') }}</div>
    @endif
</div>

                    

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
                                    width: 300px; /* Largeur fixe pour chaque carte */
                                    height: auto;
                                    flex-shrink: 0;
                                }
                                
                                @media (max-width: 1024px) {
                                    .swiper-slide {
                                        width: 300px; /* Largeur réduite sur les tablettes */
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
                320: { slidesPerView: 1 },
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 2 },
            },
        });
    });
</script>
@endpush

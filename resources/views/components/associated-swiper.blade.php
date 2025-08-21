@props([
    'data' => null,
    'type' => null,
])

<div>
@if ($data->isNotEmpty())
    <div class="flex items-center justify-between gap-5 py-5">
        <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">
            {{ $type === 'escort' ? __('escort_profile.associated_salon') : __('salon_profile.our_professionals') }}
        </h2>
        <div class="bg-green-gs h-0.5 flex-1"></div>
    </div>

    <div class="relative w-full">
        <div class="swiper-container professionals-swiper">
            <div class="swiper-wrapper">

            @if ($type === 'escort')
                @foreach ($data as $salonAssocier)
                    <div class="swiper-slide">
                        <livewire:salon-card
                            name="{{ $salonAssocier->inviter->nom_salon }}"
                            canton="{{ $salonAssocier->inviter->cantonget->nom ?? '' }}"
                            ville="{{ $salonAssocier->inviter->villeget->nom ?? '' }}"
                            avatar="{{ $salonAssocier->inviter->avatar }}"
                            salonId="{{ $salonAssocier->inviter->id }}"
                            isPause="{{ $salonAssocier->inviter->is_profil_pause }}"
                            wire:key="{{ $salonAssocier->inviter->id }}"
                        />
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
                                wire:key="{{ $acceptedInvitation->inviter->id }}" />
                        @else
                            <livewire:escort_card
                                name="{{ $acceptedInvitation->invited->prenom ?? $acceptedInvitation->invited->nom_salon }}"
                                canton="{{ $acceptedInvitation->invited->cantonget->nom ?? $noSpecial }}"
                                ville="{{ $acceptedInvitation->invited->villeget->nom ?? $noSpecial }}"
                                avatar="{{ $acceptedInvitation->invited->avatar }}"
                                escortId="{{ $acceptedInvitation->invited->id }}"
                                profileVerifie="{{ $acceptedInvitation->invited->profile_verifie }}"
                                wire:key="{{ $acceptedInvitation->invited->id }}" />
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
                1024: { slidesPerView: 3 },
            },
        });
    });
</script>
@endpush

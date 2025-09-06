@php
    $limitedEscorts = array_slice($escorts->toArray(), 0, 10); // Convertit en tableau et coupe
@endphp

@extends('layouts.base')

@section('pageTitle')
    {{ __('home.page_title') }}
@endsection

@section('content')


    {{-- Hero content --}}
    <div class="relative flex w-full flex-col items-center justify-center gap-8 bg-no-repeat px-3 py-20 lg:h-[418px]"
        style="background: url('images/Hero image.jpeg') center center /cover;">
        <div class="right-0% bg-green-gs/65 absolute inset-0 z-0 h-full w-full to-0%"></div>
        <div class="z-10 flex flex-col items-center justify-center">
            <h2
                class="font-roboto-slab text-fieldBg text-center text-md  xl:text-4xl font-semibold [text-shadow:_2px_6px_9px_rgb(0_0_0_/_0.8)] md:text-5xl lg:text-6xl">
                {{ __('home.meetings') }} <span class="text-supaGirlRose">{{ __('home.elegant_discreet') }}</span>
                {{ __('home.in_switzerland') }}</h2>
        </div>
        <div class="grid grid-cols-2 gap-2 text-black transition-all lg:flex-row">
            @foreach ($categories->take(4) as $categorie)
                @if ($categorie->type == 'escort' || $categorie->display_name != 'telephone-rose-&-video-chat')
                    <a href="{{ route('escortes') }}?selectedCategories=[{{ $categorie->id }}]"
                        class="z-10 flex items-center justify-center gap-1 transition-all">
                        <div
                            class="hover:bg-complementaryColorViolet border-supaGirlRose flex w-64 items-center justify-center gap-1 xl:gap-1.5 rounded-md border bg-white p-1 xl:p-2.5 transition-all hover:border-white hover:text-white lg:w-56">
                            <img src="{{ asset('images/icons/' . $categorie['display_name'] . '_icon.png') }}"
                                class="h-4 w-4 xl:h-8 xl:w-8" alt="icon service {{ $categorie['display_name'] }}" />
                            <span class="whitespace-nowrap text-xs">
                                @php
                                    $locale = session('locale', 'fr');
                                    $categoryName = $categorie['nom'];
                                @endphp

                                {{ $categoryName }}</span>

                        </div>
                    </a>
                @endif
            @endforeach
        </div>
        <div class="z-10">
            <x-btn href="{{ route('escortes') }}" text="{{ __('home.see_all') }}" />
        </div>
    </div>

    {{-- Main content --}}
    <div class="container m-auto mt-10 overflow-hidden px-5">

        <div x-data="{ viewEscorte: true }" x-cloak>

            {{-- Switch salon escort Btn --}}
            <ul
                class="mx-auto flex w-full cursor-pointer rounded-lg text-center text-xs font-medium shadow-sm lg:w-[50%] lg:text-xl">
                <li class="w-full focus-within:z-10">
                    <button @click="viewEscorte = true"
                        :class="viewEscorte
                            ?
                            'bg-supaGirlRose text-white hover:bg-supaGirlRose/90' :
                            'bg-white text-complementaryColorViolet hover:bg-gray-50'"
                        class="inline-block w-full cursor-pointer rounded-s-lg border border-gray-200 p-4 text-xs font-bold transition-colors duration-200 focus:outline-none md:text-sm lg:text-base"
                        :aria-current="viewEscorte ? 'page' : null">
                        {{ __('home.top_escorts_today') }}
                    </button>
                </li>
                <li class="w-full focus-within:z-10">
                    <button @click="viewEscorte = false"
                        :class="!viewEscorte
                            ?
                            'bg-supaGirlRose text-white hover:bg-supaGirlRose/90' :
                            'bg-white text-complementaryColorViolet hover:bg-gray-50'"
                        class="inline-block w-full cursor-pointer rounded-e-lg border border-gray-200 p-4 text-xs font-bold transition-colors duration-200 focus:outline-none md:text-sm lg:text-base"
                        :aria-current="!viewEscorte ? 'page' : null">
                        {{ __('home.the_salons') }}
                    </button>
                </li>
            </ul>

            {{-- Section listing Escort --}}

            <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-show="viewEscorte"
                class="relative mx-auto mt-4 flex w-full flex-col items-center justify-center">
                <h3 class="font-roboto-slab text-green-gs text-center text-2xl font-bold">{{ __('home.new_escorts') }}</h3>
                <div id="NewEscortContainer"
                    class="relative mb-4 mt-5 flex h-full w-full flex-nowrap items-center justify-start gap-4 overflow-x-auto overflow-y-hidden px-10"
                    style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                    @foreach ($escorts as $escort)
                        <livewire:escort-card wire:key="escort-{{ $escort->id }}" name="{{ $escort->prenom }}"
                            canton="{{ $escort->canton['nom'] ?? '' }}" ville="{{ $escort->ville['nom'] ?? '' }}"
                            avatar='{{ $escort->avatar }}' isPause="{{ $escort->is_profil_pause }}"
                            isOnline='{{ $escort->isOnline() }}' escortId='{{ $escort->id }}'
                            profileVerifie='{{ $escort->profile_verifie }}' />
                    @endforeach
                </div>
                <div id="arrowEscortScrollRight"
                    class="bg-green-gs absolute left-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full shadow"
                    data-carousel-prev>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="white"
                            d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
                    </svg>
                </div>
                <div id="arrowEscortScrollLeft"
                    class="bg-green-gs absolute right-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full shadow"
                    data-carousel-next>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="white" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
                    </svg>
                </div>
            </div>

            {{-- Section listing Salon --}}
            <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-show="!viewEscorte"
                class="relative mx-auto mt-4 flex w-full flex-col items-center justify-center">
                <h3 class="font-roboto-slab text-green-gs text-center text-2xl font-bold">{{ __('home.our_salons') }}</h3>
                <div id="OurSalonContainer"
                    class="min-h-30 mb-4 mt-5 flex w-full flex-nowrap items-center justify-start gap-4 overflow-x-auto px-10"
                    style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                    @foreach ($salons as $salon)
                        <livewire:salon-card name="{{ $salon->nom_salon ?? '' }}"
                            canton="{{ $salon->canton['nom'] ?? '' }}" ville="{{ $salon->ville['nom'] ?? '' }}"
                            isPause="{{ $salon->is_profil_pause }}" salonId='{{ $salon->id }}'
                            avatar='{{ $salon->avatar }}' profileVerifie='{{ $salon->profile_verifie }}' />
                    @endforeach
                    @if ($salons == '[]')
                        <h3 class="font-roboto-slab text-green-gs w-full text-center text-3xl">
                            {{ __('home.no_salon_yet') }}
                        </h3>
                    @endif
                </div>
                <div id="arrowSalonScrollRight"
                    class="bg-green-gs absolute left-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full shadow"
                    data-carousel-prev>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="white"
                            d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
                    </svg>
                </div>
                <div id="arrowSalonScrollLeft"
                    class="bg-green-gs absolute right-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full shadow"
                    data-carousel-next>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="white" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
                    </svg>
                </div>

            </div>
        </div>



        {{-- Section listing escort --}}
        <div class="relative mx-auto mt-4 flex w-full flex-col items-center justify-center">
            <h3 class="font-roboto-slab text-green-gs text-center text-2xl font-bold lg:text-4xl">
                {{ __('home.looking_for_fun') }}</h3>
            <div id="listingContainer"
                class="relative mb-4 mt-5 flex w-full flex-nowrap items-center justify-start gap-4 overflow-x-auto px-10"
                style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">

                @foreach ($escorts as $escort)
                    <livewire:escort-card name="{{ $escort->prenom }}" canton="{{ $escort->canton['nom'] ?? '' }}"
                        ville="{{ $escort->ville['nom'] ?? '' }}" avatar='{{ $escort->avatar }}'
                        isOnline='{{ $escort->isOnline() }}' isPause="{{ $escort->is_profil_pause }}"
                        escortId='{{ $escort->id }}' profileVerifie='{{ $escort->profile_verifie }}' />
                @endforeach

            </div>
            <div id="arrowListScrollRight"
                class="bg-green-gs absolute left-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full shadow"
                data-carousel-prev>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="white"
                        d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
                </svg>
            </div>
            <div id="arrowListScrollLeft"
                class="bg-green-gs absolute right-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full shadow"
                data-carousel-next>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="white" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
                </svg>
            </div>
            <div class="z-10 mb-6">


                <x-btn href="{{ route('escortes') }}" text="{{ __('home.see_all') }}" />

            </div>
        </div>

    </div>

    <div class="relative flex w-full flex-col items-center justify-center py-10"
        style="background: url('images/girl_deco_image.jpg') center center /cover">
        <div class="absolute right-0 top-0 z-0 h-full w-full bg-white/70"></div>
        <h3
            class="font-roboto-slab text-green-gs z-10 mx-2 my-4 text-center text-2xl font-bold md:text-3xl lg:text-4xl xl:text-5xl">
            {{ __('home.find_escorts') }}</h3>
        <div class="z-10 flex w-full flex-col items-center justify-center gap-2 px-4 py-6 md:flex-row">

            <x-stat-card :count="__('home.partners_count')" :description="__('home.verified_profiles')" />
            <x-stat-card :count="__('home.amateurs_count')" :description="__('home.amateur_experiences')" />
            <x-stat-card :count="__('home.professional_salons_count')" :description="__('home.professional_salons_offer')" />

        </div>
    </div>
    <x-FeedbackSection />

    <div class="w-full bg-white px-4 py-8 sm:px-6 lg:py-12">
        <div class="mx-auto max-w-4xl">
            <h3 class="font-roboto-slab text-green-gs text-center text-2xl font-bold md:text-2xl lg:text-4xl">
                {{ __('home.become_escort_title') }}
            </h3>
            <p class="font-roboto-slab mt-2 text-center text-[#4A5565]">{{ __('home.become_escort_steps') }}</p>

            <div class="relative mt-10">
                <!-- Ligne de connexion (visible uniquement sur desktop) -->
                <div
                    class="left-1/5 bg-supaGirlRose absolute right-1/4 top-10 z-0 hidden h-1 w-[68%] -translate-y-1/2 transform md:block">
                </div>

                <div class="relative z-10 grid grid-cols-1 gap-8 md:grid-cols-3 md:gap-4">
                    @php
                        $steps = [
                            [
                                'icon' => asset('images/icons/icon_coeur.png'),
                                'text' =>
                                    __('home.send_selfies') .
                                    '<br> <a href="mailto:escort-gstuff@gstuff.ch" class="text-supaGirlRose hover:underline">escrot-supagir@supagirl.ch</a>',
                            ],
                            [
                                'icon' => asset('images/icons/icon_coeur.png'),
                                'text' => __('home.photo_shoot_appointment'),
                            ],
                            ['icon' => asset('images/icons/icon_coeur.png'), 'text' => __('home.publish_profile')],
                        ];
                    @endphp

                    @foreach ($steps as $step)
                        <div class="flex flex-col items-center">
                            <img src="{{ $step['icon'] }}" alt=""
                                class="z-10 mx-auto h-16 w-16 md:h-20 md:w-20">
                            <div class="font-roboto-slab mt-4 text-center text-sm text-gray-700 md:text-base">
                                {!! $step['text'] !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <x-CallToActionInscription />

    <x-CallToActionContact />

    <style>
        .accordion-button {
            background-color: #FED5E9;
            color: #6A7282;
            transition: all 0.2s ease;
        }

        .accordion-button:hover,
        .accordion-button.active {
            background-color: #FDA5D6 !important;
            color: #7F55B1 !important;
        }

        .accordion-content {
            background-color: #FFFAFC;
            border-color: #E5E7EB;
            color: #6A7282;
        }
    </style>
    {{-- FAQ --}}
    <div class="container mx-auto flex flex-col items-center justify-center gap-10 p-4">
        <h3 id="FAQ" class="font-roboto-slab text-green-gs text-3xl lg:text-5xl">
            {{ __('home.frequent_questions') }}
        </h3>
        <div id="accordion-collapse" class="w-full lg:min-w-[1114px]" data-accordion="collapse">
            <div class="mb-2">
                <h2 id="accordion-collapse-heading-1">
                    <button type="button"
                        class="accordion-button flex w-full items-center justify-between gap-3 rounded-t-xl border border-b-0 border-white p-5 font-medium rtl:text-right"
                        data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                        aria-controls="accordion-collapse-body-1">
                        <span class="font-roboto-slab flex items-center"><svg class="me-2 h-5 w-5 shrink-0"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>{{ __('home.photo_shoot_mandatory') }}</span>
                        <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-1" aria-labelledby="accordion-collapse-heading-1">
                    <div class="accordion-content border border-b-0 p-5">
                        <p class="font-roboto-slab mb-2 text-gray-500 dark:text-gray-400">{{ __('home.unique_platform') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <h2 id="accordion-collapse-heading-2">
                    <button type="button"
                        class="accordion-button flex w-full items-center justify-between gap-3 border border-b-0 border-white p-5 font-medium rtl:text-right"
                        data-accordion-target="#accordion-collapse-body-2" aria-expanded="false"
                        aria-controls="accordion-collapse-body-2">
                        <span class="font-roboto-slab flex items-center"><svg class="me-2 h-5 w-5 shrink-0"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>{{ __('home.apartments_rent') }}</span>
                        <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                    <div class="accordion-content border border-b-0 p-5">
                        <p class="font-roboto-slab mb-2 text-gray-500 dark:text-gray-400">
                            {{ __('home.no_apartments_for_escorts') }}</p>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <h2 id="accordion-collapse-heading-3">
                    <button type="button"
                        class="accordion-button flex w-full items-center justify-between gap-3 border border-white p-5 font-medium rtl:text-right"
                        data-accordion-target="#accordion-collapse-body-3" aria-expanded="false"
                        aria-controls="accordion-collapse-body-3">
                        <span class="font-roboto-slab flex items-center"><svg class="me-2 h-5 w-5 shrink-0"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                    clip-rule="evenodd"></path>
                            </svg>{{ __('home.how_much_can_i_earn') }}</span>
                        <svg data-accordion-icon class="h-3 w-3 shrink-0 rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
                    <div class="accordion-content border border-t-0 p-5">
                        <p class="font-roboto-slab mb-2 text-gray-500 dark:text-gray-400">
                            {{ __('home.escort_monthly_income') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Glossaire --}}
    @if ($glossaires != '[]')
        <div class="mx-auto my-10 lg:container">
            <div class="my-10 flex flex-wrap items-center justify-between px-5 lg:px-20">
                <h3 class="font-dm-serif text-green-gs font-roboto-slab text-2xl font-bold lg:text-4xl">
                    {{ __('home.glossary_articles') }}
                </h3>
                <div class="z-10 my-2 w-auto">
                    <x-btn href="{{ url('glossaires') }}" text="{{ __('home.see_more_articles') }}" />
                </div>
            </div>
            <x-GlossaireSection />
        </div>
    @endif


@section('extraScripts')
    <script>
        console.log("escorts", @json($escorts));
        console.log("salons", @json($salons));
        // Script pour l'accordéon FAQ
        document.addEventListener('DOMContentLoaded', function() {
            const accordionButtons = document.querySelectorAll('[data-accordion-target]');

            // Fonction pour réinitialiser tous les boutons
            function resetAllButtons() {
                accordionButtons.forEach(btn => {
                    btn.classList.remove('active');
                    const target = document.querySelector(btn.getAttribute('data-accordion-target'));
                    if (target) target.classList.add('hidden');
                    btn.setAttribute('aria-expanded', 'false');
                    const icon = btn.querySelector('[data-accordion-icon]');
                    if (icon) icon.classList.remove('rotate-180');
                });
            }

            // Initialisation
            const firstButton = accordionButtons[0];
            if (firstButton) {
                const firstTarget = document.querySelector(firstButton.getAttribute('data-accordion-target'));
                if (firstTarget) {
                    firstTarget.classList.remove('hidden');
                    firstButton.classList.add('active');
                    firstButton.setAttribute('aria-expanded', 'true');
                    const icon = firstButton.querySelector('[data-accordion-icon]');
                    if (icon) icon.classList.add('rotate-180');
                }
            }

            // Gestion des clics
            accordionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const target = document.querySelector(this.getAttribute(
                        'data-accordion-target'));
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';

                    // Fermer tous les autres accordéons
                    resetAllButtons();

                    // Basculer l'état actuel si nécessaire
                    if (isExpanded) {
                        this.classList.remove('active');
                        this.setAttribute('aria-expanded', 'false');
                        if (target) target.classList.add('hidden');
                        const icon = this.querySelector('[data-accordion-icon]');
                        if (icon) icon.classList.remove('rotate-180');
                    } else {
                        this.classList.add('active');
                        this.setAttribute('aria-expanded', 'true');
                        if (target) target.classList.remove('hidden');
                        const icon = this.querySelector('[data-accordion-icon]');
                        if (icon) icon.classList.add('rotate-180');
                    }
                });
            });
        });

        const EscortrightBtn = document.getElementById('arrowEscortScrollRight')
        const EscortleftBtn = document.getElementById('arrowEscortScrollLeft')
        const Escortcontainer = document.getElementById('NewEscortContainer')
        const SalonrightBtn = document.getElementById('arrowSalonScrollRight')
        const SalonleftBtn = document.getElementById('arrowSalonScrollLeft')
        const Saloncontainer = document.getElementById('OurSalonContainer')
        const ListrightBtn = document.getElementById('arrowListScrollRight')
        const ListleftBtn = document.getElementById('arrowListScrollLeft')
        const Listcontainer = document.getElementById('listingContainer')

        EscortrightBtn.addEventListener('click', () => {


            scrollByPercentage(Escortcontainer, false, 10);
        });

        EscortleftBtn.addEventListener('click', () => {

            scrollByPercentage(Escortcontainer, true, 10);
        });

        SalonrightBtn.addEventListener('click', () => {

            scrollByPercentage(Saloncontainer, false, 35);
        });

        SalonleftBtn.addEventListener('click', () => {

            scrollByPercentage(Saloncontainer, true, 35);
        });

        ListrightBtn.addEventListener('click', () => {

            scrollByPercentage(Listcontainer, false, 10)
        })
        ListleftBtn.addEventListener('click', () => {

            scrollByPercentage(Listcontainer, true, 10)
        })
    </script>
@endsection

@stop

@extends('layouts.base')

@section('pageTitle')
    Home
@endsection

@section('content')


    {{-- Hero content --}}
    <div class="relative flex w-full flex-col items-center justify-center gap-8 bg-no-repeat px-3 py-20 lg:h-[418px]"
        style="background: url('images/Hero image.jpeg') center center /cover;">
        <div class="right-0% bg-green-gs/65 absolute inset-0 z-0 h-full w-full to-0%"></div>
        <div class="z-10 flex flex-col items-center justify-center">
            <h2
                class="font-cormorant text-center text-4xl font-semibold text-white [text-shadow:_2px_6px_9px_rgb(0_0_0_/_0.8)] md:text-5xl lg:text-6xl">
                {{ __('home.meetings') }} <span class="text-amber-400">{{ __('home.elegant_discreet') }}</span>
                {{ __('home.in_switzerland') }}</h2>
        </div>
        <div class="flex flex-col gap-2 text-black transition-all lg:flex-row">
            @foreach ($categories as $categorie)
                <a href="{{ route('escortes') }}?selectedCategories=[{{ $categorie->id }}]"
                    class="z-10 flex items-center justify-center gap-1 transition-all">
                    <div
                        class="hover:bg-green-gs flex w-64 items-center justify-center gap-1.5 rounded-md border border-amber-400 bg-white p-2.5 transition-all hover:text-white lg:w-56">
                        <img src="{{ asset('images/icons/' . $categorie['display_name'] . '_icon.svg') }}"
                            alt="icon service {{ $categorie['display_name'] }}" />
                        <span>
                            @php
                                $locale = session('locale', 'fr');
                                $categoryName =
                                    $categorie['nom'][$locale] ??
                                    ($categorie['nom']['fr'] ?? ($categorie['nom'] ?? '-'));
                            @endphp

                            {{ $categoryName }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="z-10">
            <a href="{{ route('escortes') }}" type="button"
                class="btn-gs-gradient flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-center text-sm font-bold text-black focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">{{ __('home.see_all') }}
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" />
                </svg>
            </a>
        </div>
    </div>

    {{-- Main content --}}
    <div class="container m-auto mt-10 overflow-hidden px-5">

        <div x-data="{ viewEscorte: true }" x-cloak>

            {{-- Switch salon escort Btn --}}
            <ul
                class="mx-auto flex w-full rounded-lg text-center text-xs font-medium text-gray-500 shadow-sm lg:w-[50%] lg:text-xl dark:divide-gray-700 dark:text-gray-400">
                <li class="w-full focus-within:z-10">
                    <button @click="viewEscorte = true" :class="viewEscorte ? 'btn-gs-gradient' : ''"
                        class="inline-block w-full rounded-s-lg border-r border-gray-200 bg-white p-4 text-xs font-bold hover:bg-gray-50 hover:text-gray-700 focus:outline-none md:text-sm lg:text-base dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white"
                        aria-current="page">{{ __('home.top_escorts_today') }}</button>
                </li>
                <li class="w-full focus-within:z-10">
                    <button @click="viewEscorte = false" :class="viewEscorte ? '' : 'btn-gs-gradient'"
                        class="inline-block w-full rounded-e-lg border-r border-gray-200 bg-white p-4 text-xs font-bold hover:bg-gray-50 hover:text-gray-700 focus:outline-none md:text-sm lg:text-base dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">{{ __('home.the_salons') }}</button>
                </li>
            </ul>

            {{-- Section listing Escort --}}

            <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-show="viewEscorte"
                class="relative mx-auto mt-4 flex w-full flex-col items-center justify-center">
                <h3 class="font-dm-serif text-green-gs text-center text-2xl font-bold">{{ __('home.new_escorts') }}</h3>
                <div id="NewEscortContainer"
                    class="mb-4 mt-5 flex w-full flex-nowrap items-center justify-start gap-4 overflow-x-auto px-10"
                    style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                    @foreach ($escorts as $escort)
                        <livewire:escort-card name="{{ $escort->prenom }}" canton="{{ $escort->canton['nom'] ?? '' }}"
                            ville="{{ $escort->ville['nom'] ?? '' }}" avatar='{{ $escort->avatar }}'
                            isOnline='{{ $escort->isOnline() }}' escortId='{{ $escort->id }}' />
                    @endforeach
                </div>
                <div id="arrowEscortScrollRight"
                    class="absolute left-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow"
                    data-carousel-prev>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
                    </svg>
                </div>
                <div id="arrowEscortScrollLeft"
                    class="absolute right-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow"
                    data-carousel-next>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
                    </svg>
                </div>
            </div>

            {{-- Section listing Salon --}}
            <div x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100" x-show="!viewEscorte"
                class="relative mx-auto mt-4 flex w-full flex-col items-center justify-center">
                <h3 class="font-dm-serif text-green-gs text-center text-2xl font-bold">{{ __('home.our_salons') }}</h3>
                <div id="OurSalonContainer"
                    class="min-h-30 mb-4 mt-5 flex w-full flex-nowrap items-center justify-start gap-4 overflow-x-auto px-10"
                    style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">
                    @foreach ($salons as $salon)
                        <livewire:salon-card name="{{ $salon->nom_salon ?? '' }}"
                            canton="{{ $salon->canton['nom'] ?? '' }}" ville="{{ $salon->ville['nom'] ?? '' }}"
                            salonId='{{ $salon->id }}' avatar='{{ $salon->avatar }}' />
                    @endforeach
                    @if ($salons == '[]')
                        <h3 class="font-dm-serif text-green-gs w-full text-center text-3xl">{{ __('home.no_salon_yet') }}
                        </h3>
                    @endif
                </div>
                <div id="arrowSalonScrollRight"
                    class="absolute left-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow"
                    data-carousel-prev>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
                    </svg>
                </div>
                <div id="arrowSalonScrollLeft"
                    class="absolute right-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow"
                    data-carousel-next>
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
                    </svg>
                </div>

            </div>
        </div>

        {{-- Section listing escort --}}
        <div class="relative mx-auto mt-4 flex w-full flex-col items-center justify-center">
            <h3 class="font-dm-serif text-green-gs text-center text-2xl font-bold lg:text-4xl">
                {{ __('home.looking_for_fun') }}</h3>
            <div id="listingContainer"
                class="relative mb-4 mt-5 flex w-full flex-nowrap items-center justify-start gap-4 overflow-x-auto px-10"
                style="scroll-snap-type: x proximity; scrollbar-size: none; scrollbar-color: transparent transparent">

                @foreach ($escorts as $escort)
                    <livewire:escort-card name="{{ $escort->prenom }}" canton="{{ $escort->canton['nom'] ?? '' }}"
                        ville="{{ $escort->ville['nom'] ?? '' }}" avatar='{{ $escort->avatar }}'
                        isOnline='{{ $escort->isOnline() }}' escortId='{{ $escort->id }}' />
                @endforeach

            </div>
            <div id="arrowListScrollRight"
                class="absolute left-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow"
                data-carousel-prev>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m7.85 13l2.85 2.85q.3.3.288.7t-.288.7q-.3.3-.712.313t-.713-.288L4.7 12.7q-.3-.3-.3-.7t.3-.7l4.575-4.575q.3-.3.713-.287t.712.312q.275.3.288.7t-.288.7L7.85 11H19q.425 0 .713.288T20 12t-.288.713T19 13z" />
                </svg>
            </div>
            <div id="arrowListScrollLeft"
                class="absolute right-1 top-[40%] flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-amber-300/60 shadow"
                data-carousel-next>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m14 18l-1.4-1.45L16.15 13H4v-2h12.15L12.6 7.45L14 6l6 6z" />
                </svg>
            </div>
            <div class="z-10 mb-6">
                <a href="{{ route('escortes') }}" type="button"
                    class="btn-gs-gradient flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-center text-sm font-bold text-black focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">{{ __('home.see_all') }}
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" />
                    </svg>
                </a>
            </div>
        </div>

    </div>

    <div class="relative flex w-full flex-col items-center justify-center py-10"
        style="background: url('images/girl_deco_image.jpg') center center /cover">
        <div class="absolute right-0 top-0 z-0 h-full w-full bg-white/70"></div>
        <h3
            class="font-dm-serif text-green-gs z-10 mx-2 my-4 text-center text-2xl font-bold md:text-3xl lg:text-4xl xl:text-5xl">
            {{ __('home.find_escorts') }}</h3>
        <div class="z-10 flex w-full flex-col items-center justify-center gap-2 px-4 py-6 md:flex-row">

            <div
                class="flex w-full flex-col items-center justify-center gap-3 bg-[#618E8D] p-3 text-2xl font-bold text-white lg:h-[263px] lg:w-[367px] lg:text-4xl">
                <span class="font-dm-serif w-[70%] text-center">{{ __('home.partners_count') }}</span>
                <span
                    class="mx-auto w-[75%] text-center text-sm font-normal lg:text-base">{{ __('home.verified_profiles') }}</span>
            </div>
            <div
                class="flex w-full flex-col items-center justify-center gap-3 bg-[#618E8D] p-3 text-2xl font-bold text-white lg:h-[263px] lg:w-[367px] lg:text-4xl">
                <span class="font-dm-serif w-[70%] text-center">{{ __('home.amateurs_count') }}</span>
                <span
                    class="mx-auto w-[75%] text-center text-sm font-normal lg:text-base">{{ __('home.amateur_experiences') }}</span>
            </div>
            <div
                class="flex w-full flex-col items-center justify-center gap-3 bg-[#618E8D] p-3 text-2xl font-bold text-white lg:h-[263px] lg:w-[367px] lg:text-4xl">
                <span class="font-dm-serif w-[70%] text-center">{{ __('home.professional_salons_count') }}</span>
                <span
                    class="mx-auto w-[75%] text-center text-sm font-normal lg:text-base">{{ __('home.professional_salons_offer') }}</span>
            </div>

        </div>
    </div>
    <x-FeedbackSection />

    <div class="w-full bg-white px-4 py-8 sm:px-6 lg:py-12">
        <div class="mx-auto max-w-4xl">
            <h3 class="font-dm-serif text-green-gs text-center text-2xl font-bold md:text-4xl lg:text-5xl">
                {{ __('home.become_escort_title') }}
            </h3>
            <p class="mt-2 text-center text-gray-600">{{ __('home.become_escort_steps') }}</p>

            <div class="relative mt-10">
                <!-- Ligne de connexion (visible uniquement sur desktop) -->
                <div
                    class="left-1/5 bg-green-gs absolute right-1/4 top-10 z-0 hidden h-1 w-[68%] -translate-y-1/2 transform md:block">
                </div>

                <div class="relative z-10 grid grid-cols-1 gap-8 md:grid-cols-3 md:gap-4">
                    @php
                        $steps = [
                            [
                                'icon' => asset('images/icons/icon_coeur.svg'),
                                'text' =>
                                    __('home.send_selfies') .
                                    ' <a href="mailto:escort-gstuff@gstuff.ch" class="text-amber-500 hover:underline">escort-gstuff@gstuff.ch</a>',
                            ],
                            [
                                'icon' => asset('images/icons/icon_coeur.svg'),
                                'text' => __('home.photo_shoot_appointment'),
                            ],
                            ['icon' => asset('images/icons/icon_coeur.svg'), 'text' => __('home.publish_profile')],
                        ];
                    @endphp

                    @foreach ($steps as $step)
                        <div class="flex flex-col items-center">
                            <img src="{{ $step['icon'] }}" alt=""
                                class="z-10 mx-auto h-16 w-16 md:h-20 md:w-20">
                            <div class="mt-4 text-center text-sm text-gray-700 md:text-base">
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

    {{-- FAQ --}}
    <div class="container mx-auto flex flex-col items-center justify-center gap-10 p-4">
        <h3 id="FAQ" class="font-dm-serif text-green-gs text-3xl lg:text-5xl">{{ __('home.frequent_questions') }}
        </h3>
        <div id="accordion-collapse text-wrap w-full lg:min-w-[1114px]" data-accordion="collapse">
            <h2 id="accordion-collapse-heading-1" class="w-full lg:min-w-[1114px]">
                <button type="button"
                    class="flex w-full items-center justify-between gap-3 rounded-t-xl border border-b-0 border-gray-200 p-5 font-medium text-gray-500 hover:bg-gray-100 rtl:text-right dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800"
                    data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                    aria-controls="accordion-collapse-body-1">
                    <span class="flex items-center"><svg class="me-2 h-5 w-5 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
            <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                <div class="border border-b-0 border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900">
                    <p class="mb-2 text-gray-500 dark:text-gray-400">{{ __('home.unique_platform') }}</p>
                </div>
            </div>
            <h2 id="accordion-collapse-heading-2" class="w-full lg:min-w-[1114px]">
                <button type="button"
                    class="flex w-full items-center justify-between gap-3 border border-b-0 border-gray-200 p-5 font-medium text-gray-500 hover:bg-gray-100 rtl:text-right dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800"
                    data-accordion-target="#accordion-collapse-body-2" aria-expanded="false"
                    aria-controls="accordion-collapse-body-2">
                    <span class="flex items-center"><svg class="me-2 h-5 w-5 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                <div class="border border-b-0 border-gray-200 bg-white p-5 dark:border-gray-700">
                    <p class="mb-2 text-gray-500 dark:text-gray-400">{{ __('home.no_apartments_for_escorts') }}</p>
                </div>
            </div>
            <h2 id="accordion-collapse-heading-3" class="w-full lg:min-w-[1114px]">
                <button type="button"
                    class="flex w-full items-center justify-between gap-3 border border-gray-200 p-5 font-medium text-gray-500 hover:bg-gray-100 rtl:text-right dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800"
                    data-accordion-target="#accordion-collapse-body-3" aria-expanded="false"
                    aria-controls="accordion-collapse-body-3">
                    <span class="flex items-center"><svg class="me-2 h-5 w-5 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
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
                <div class="border border-t-0 border-gray-200 bg-white p-5 dark:border-gray-700">
                    <p class="mb-2 text-gray-500 dark:text-gray-400">{{ __('home.escort_monthly_income') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Glossaire --}}
    @if ($glossaires != '[]')
        <div class="mx-auto my-10 lg:container">
            <div class="my-10 flex flex-wrap items-center justify-between px-5 lg:px-20">
                <h3 class="font-dm-serif text-green-gs text-2xl font-bold lg:text-4xl">{{ __('home.glossary_articles') }}
                </h3>
                <div class="z-10 my-2 w-auto">
                    <a href="#" type="button"
                        class="btn-gs-gradient flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-center text-sm font-bold text-black focus:outline-none focus:ring-4 focus:ring-blue-300 lg:text-base dark:focus:ring-blue-800">{{ __('home.see_more_articles') }}
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" />
                        </svg>
                    </a>
                </div>
            </div>
            <x-GlossaireSection />
        </div>
    @endif


@section('extraScripts')
    <script>
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
            scrollByPercentage(Escortcontainer, false, 35)
        })
        EscortleftBtn.addEventListener('click', () => {
            scrollByPercentage(Escortcontainer, true, 35)
        })
        SalonrightBtn.addEventListener('click', () => {
            scrollByPercentage(Saloncontainer, false, 35)
        })
        SalonleftBtn.addEventListener('click', () => {
            scrollByPercentage(Saloncontainer, true, 35)
        })
        ListrightBtn.addEventListener('click', () => {
            scrollByPercentage(Listcontainer, false)
        })
        ListleftBtn.addEventListener('click', () => {
            scrollByPercentage(Listcontainer)
        })
    </script>
@endsection

@stop

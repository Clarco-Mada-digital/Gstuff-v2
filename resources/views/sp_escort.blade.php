@extends('layouts.base')

@php
    use Carbon\Carbon;
@endphp

@section('pageTitle')
    {{ $escort->prenom }}
@endsection

@section('content')
    <div x-data="{}"
        x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{ $couverture_image = $escort->couverture_image }}' ? '{{ asset('storage/couvertures/' . $couverture_image) }}' : '{{ asset('images/Logo_lg.png') }}', imgModalDesc: '' })"
        class="relative max-h-[30vh] min-h-[30vh] w-full overflow-hidden"
        style="background: url({{ $escort->couverture_image ? asset('storage/couvertures/' . $escort->couverture_image) : asset('images/Logo_lg.png') }}) center center /cover;">
    </div>

    <div x-data="{}" class="container mx-auto flex flex-col justify-center xl:flex-row">

        {{-- Profile picture and status --}}
        <div class="min-w-1/4 flex flex-col items-center gap-3 px-4">

            <div class="w-55 h-55 border-5 relative mx-auto -translate-y-[50%] rounded-full border-white">
                <!-- {{ __('escort_profile.profile_picture') }} -->
                <img x-on:click="$dispatch('img-modal', {  imgModalSrc:'{{ $avatar = $escort->avatar }}' ? '{{ asset('storage/avatars/' . $avatar) }}' : '{{ asset('images/icon_logo.png') }}', imgModalDesc: '' })"
                    class="h-full w-full rounded-full object-cover object-center"
                    @if ($avatar = $escort->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                    @else
                    src="{{ asset('images/icon_logo.png') }}" @endif
                    alt="{{ __('escort_profile.profile_picture') }}" />
                <!-- {{ __('escort_profile.status_badge') }} -->
                <span
                    class="{{ $escort->isOnline() ? 'bg-green-gs' : 'bg-gray-400' }} absolute bottom-4 right-5 block h-3 w-3 rounded-full ring-2 ring-white">
                </span>
            </div>
            <div class="-mt-[25%] ml-3 flex flex-col items-center justify-center md:-mt-[10%] xl:-mt-[25%]">
                <p class="flex items-center gap-2 font-bold">{{ Str::ucfirst($escort->prenom) }} @if ($escort->profile_verifie == 'verifier')
                        <svg xmlns="http://www.w3.org/2000/svg" title="{{ __('escort_profile.verified_profile') }}"
                            class="h55 text-green-gs inline-block w-5" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M12 4c-4.41 0-8 3.59-8 8s3.59 8 8 8s8-3.59 8-8s-3.59-8-8-8m-2 13l-4-4l1.41-1.41L10 14.17l6.59-6.59L18 9z"
                                opacity=".3" />
                            <path fill="currentColor"
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4l8-8z" />
                        </svg>
                    @endif
                </p>
                <p class="{{ $escort->isOnline() ? 'text-green-gs' : 'text-gray-500' }} text-sm">
                    ({{ $escort->last_seen_for_humans }})
                </p>
            </div>
            <span class="font-dm-serif flex items-center gap-2 font-bold"><svg class="h-5 w-5"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M9.775 12q-.9 0-1.5-.675T7.8 9.75l.325-2.45q.2-1.425 1.3-2.363T12 4t2.575.938t1.3 2.362l.325 2.45q.125.9-.475 1.575t-1.5.675zM4 18v-.8q0-.85.438-1.562T5.6 14.55q1.55-.775 3.15-1.162T12 13t3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2v.8q0 .825-.587 1.413T18 20H6q-.825 0-1.412-.587T4 18" />
                </svg>{{ Str::ucfirst($escort->genre->getTranslation('name', app()->getLocale(), 'fr')) }}</span>
            @php
                $noPhoneText = __('escort_profile.no_phone');
            @endphp

            <a href="tel:{{ $escort->telephone ?? '' }}" class="font-dm-serif flex items-center gap-2 font-bold">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M19.95 21q-3.125 0-6.187-1.35T8.2 15.8t-3.85-5.55T3 4.05V3h5.9l.925 5.025l-2.85 2.875q.55.975 1.225 1.85t1.45 1.625q.725.725 1.588 1.388T13.1 17l2.9-2.9l5 1.025V21zM16.5 11q-.425 0-.712-.288T15.5 10t.288-.712T16.5 9t.713.288t.287.712t-.288.713T16.5 11" />
                </svg>
                {{ $escort->telephone ?? $noPhoneText }}
            </a>

            <div class="text-green-gs flex items-center justify-center gap-2">
                <a href="{{ route('escortes') }}?selectedCanton={{ $escort->canton->id ?? '' }}"
                    class="flex items-center gap-1"> <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 22 22" fill="none">
                        <path
                            d="M4 13.2864C2.14864 14.1031 1 15.2412 1 16.5C1 18.9853 5.47715 21 11 21C16.5228 21 21 18.9853 21 16.5C21 15.2412 19.8514 14.1031 18 13.2864M17 7C17 11.0637 12.5 13 11 16C9.5 13 5 11.0637 5 7C5 3.68629 7.68629 1 11 1C14.3137 1 17 3.68629 17 7ZM12 7C12 7.55228 11.5523 8 11 8C10.4477 8 10 7.55228 10 7C10 6.44772 10.4477 6 11 6C11.5523 6 12 6.44772 12 7Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg> {{ $escort->canton['nom'] ?? '' }}</a>
                <button class="flex items-center gap-1"> <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M5 12h.5m3 0H10m3 0h6m-6 6l6-6m-6-6l6 6" />
                    </svg></svg> {{ $escort->ville['nom'] ?? '' }}</button>
            </div>
            <hr class="h-2 w-full">

            @auth
                <button
                    class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-400 p-2 text-sm hover:text-white">
                    <livewire:favorite-button :userId='$escort->id' wire:key='{{ $escort->id }}' />
                    {{ __('escort_profile.add_to_favorites') }}
                </button>
            @endauth
            <button
                @auth x-on:click="$dispatch('loadForSender', [{{ $escort->id }}])" @else data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" @endauth
                class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-400 p-2 text-sm hover:text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 3c5.5 0 10 3.58 10 8s-4.5 8-10 8c-1.24 0-2.43-.18-3.53-.5C5.55 21 2 21 2 21c2.33-2.33 2.7-3.9 2.75-4.5C3.05 15.07 2 13.13 2 11c0-4.42 4.5-8 10-8m5 9v-2h-2v2zm-4 0v-2h-2v2zm-4 0v-2H7v2z" />
                </svg>
                {{ __('escort_profile.send_message') }}
            </button>
            <button
                class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-400 p-2 text-sm hover:text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M256 448c141.4 0 256-93.1 256-208S397.4 32 256 32S0 125.1 0 240c0 45.1 17.7 86.8 47.7 120.9c-1.9 24.5-11.4 46.3-21.4 62.9c-5.5 9.2-11.1 16.6-15.2 21.6c-2.1 2.5-3.7 4.4-4.9 5.7c-.6.6-1 1.1-1.3 1.4l-.3.3c-4.6 4.6-5.9 11.4-3.4 17.4s8.3 9.9 14.8 9.9c28.7 0 57.6-8.9 81.6-19.3c22.9-10 42.4-21.9 54.3-30.6c31.8 11.5 67 17.9 104.1 17.9zM96 212.8c0-20.3 16.5-36.8 36.8-36.8H152c8.8 0 16 7.2 16 16s-7.2 16-16 16h-19.2c-2.7 0-4.8 2.2-4.8 4.8c0 1.6.8 3.1 2.2 4l29.4 19.6c10.3 6.8 16.4 18.3 16.4 30.7c0 20.3-16.5 36.8-36.8 36.8l-27.2.1c-8.8 0-16-7.2-16-16s7.2-16 16-16h27.2c2.7 0 4.8-2.2 4.8-4.8c0-1.6-.8-3.1-2.2-4l-29.4-19.6c-10.2-6.9-16.4-18.4-16.4-30.8M372.8 176H392c8.8 0 16 7.2 16 16s-7.2 16-16 16h-19.2c-2.7 0-4.8 2.2-4.8 4.8c0 1.6.8 3.1 2.2 4l29.4 19.6c10.2 6.8 16.4 18.3 16.4 30.7c0 20.3-16.5 36.8-36.8 36.8l-27.2.1c-8.8 0-16-7.2-16-16s7.2-16 16-16h27.2c2.7 0 4.8-2.2 4.8-4.8c0-1.6-.8-3.1-2.2-4l-29.4-19.6c-10.2-6.8-16.4-18.3-16.4-30.7c0-20.3 16.5-36.8 36.8-36.8zm-152 6.4l35.2 46.9l35.2-46.9c4.1-5.5 11.3-7.8 17.9-5.6S320 185.1 320 192v96c0 8.8-7.2 16-16 16s-16-7.2-16-16v-48l-19.2 25.6c-3 4-7.8 6.4-12.8 6.4s-9.8-2.4-12.8-6.4L224 240v48c0 8.8-7.2 16-16 16s-16-7.2-16-16v-96c0-6.9 4.4-13 10.9-15.2s13.7.1 17.9 5.6" />
                </svg>
                {{ __('escort_profile.no_sms_contact') }}
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
                {{ __('escort_profile.no_whatsapp_contact') }}
            </button>
            @php
                $noEmailText = __('escort_profile.no_email');
            @endphp
            <a href="mailto:{{ $escort->email }}"
                class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-gray-400 p-2 text-sm hover:text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10h5v-2h-5c-4.34 0-8-3.66-8-8s3.66-8 8-8s8 3.66 8 8v1.43c0 .79-.71 1.57-1.5 1.57s-1.5-.78-1.5-1.57V12c0-2.76-2.24-5-5-5s-5 2.24-5 5s2.24 5 5 5c1.38 0 2.64-.56 3.54-1.47c.65.89 1.77 1.47 2.96 1.47c1.97 0 3.5-1.6 3.5-3.57V12c0-5.52-4.48-10-10-10m0 13c-1.66 0-3-1.34-3-3s1.34-3 3-3s3 1.34 3 3s-1.34 3-3 3" />
                </svg>
                {{ $escort->email ?? $noEmailText }}
            </a>

        </div>

        {{-- Escort profile --}}
        <div class="min-w-3/4 px-5 py-5">

            <section>

                {{-- Category --}}
                <div class="flex items-center gap-5 py-5">

                    <h2 class="font-dm-serif text-green-gs text-2xl font-bold">{{ __('escort_profile.category') }}</h2>
                    <div class="flex items-center gap-5">
                        @foreach ($escort->getCategoriesAttribute() as $category)
                            <span
                                class="border-green-gs text-green-gs rounded-lg border px-2 hover:bg-amber-300">{{ $category->getTranslation('nom', app()->getLocale()) }}</span>
                        @endforeach
                    </div>

                </div>

                {{-- Stories --}}
                <div class="flex items-center justify-between gap-5 py-5">

                    <h2 class="font-dm-serif text-green-gs text-2xl font-bold">{{ __('escort_profile.stories') }}</h2>
                    <div class="bg-green-gs h-0.5 flex-1"></div>

                </div>
                <div class="flex flex-wrap items-center gap-10">
                    @livewire('stories-viewer', ['userViewStorie' => $escort->id], key($escort->id))
                </div>

                {{-- Gallery --}}
                @livewire('gallery-manager', ['user' => $escort], key($escort->id))

                {{-- About Me --}}
                <div class="flex items-center justify-between gap-5 py-5">

                    <h2 class="font-dm-serif text-green-gs text-2xl font-bold">{{ __('escort_profile.about_me') }}</h2>
                    <div class="bg-green-gs h-0.5 flex-1"></div>

                </div>
                <div class="flex flex-wrap items-center gap-10">
                    <div class="grid w-full grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                        <x-profile-info-item 
                            icon="age_icon.svg"
                            :alt="__('escort_profile.age_icon')"
                            :label="__('escort_profile.age')"
                            :value="Carbon::parse($escort->date_naissance)->age"
                            suffix="{{ __('escort_profile.years_old') }}"
                        />


                        <x-profile-info-item 
                            icon="origine_icon.svg"
                            :alt="__('escort_profile.origin_icon')"
                            :label="__('escort_profile.origin')"
                            :value="$escort->origine"
                        />



                        <x-profile-info-item 
                            icon="yeux_icon.svg"
                            :alt="__('escort_profile.eye_color_icon')"
                            :label="__('escort_profile.eye_color')"
                            :value="$escort->couleurYeux"
                            translation-path="name"
                        />
                   

                        <x-profile-info-item 
                            icon="cheveux_icon.svg"
                            :alt="__('escort_profile.hair_color_icon')"
                            :label="__('escort_profile.hair_color')"
                            :value="$escort->couleurCheveux"
                            translation-path="name"
                        />

                        <x-profile-info-item 
                            icon="tarif_icon.svg"
                            :alt="__('escort_profile.rate_icon')"
                            :label="__('escort_profile.rates_from')"
                            :value="$escort->tarif"
                            suffix="CHF"
                        />

                        <x-profile-info-item 
                            icon="taille_icon.svg"
                            :alt="__('escort_profile.height_icon')"
                            :label="__('escort_profile.height')"
                            :value="$escort->tailles"
                            suffix="cm"
                        />

                        <x-profile-info-item 
                            icon="poitrine_icon.svg"
                            :alt="__('escort_profile.bust_icon')"
                            :label="__('escort_profile.bust')"
                            :value="$escort->poitrine"
                            translation-path="name"
                        />

                        <x-profile-info-item 
                            icon="mobilite.svg"
                            :alt="__('escort_profile.mobility_icon')"
                            :label="__('escort_profile.mobility')"
                            :value="$escort->mobilite"
                            translation-path="name"
                        />

                        <x-profile-info-item 
                            icon="mensuration.svg"
                            :alt="__('escort_profile.measurements_icon')"
                            :label="__('escort_profile.measurements')"
                            :value="$escort->mensuration"
                            translation-path="name"
                        />

                        <x-profile-info-item 
                            icon="taill_poit.svg"
                            :alt="__('escort_profile.bust_size_icon')"
                            :label="__('escort_profile.bust_size')"
                            :value="$escort->poitrine"
                            translation-path="name"
                            :suffix="$escort->poitrine ? __('escort_profile.cup') : ''"
                        />
                      
                        <x-info-display :items="$escort->langues" type="language" />


                        <x-info-display :items="$escort->paiement" type="payment"/>

                    </div>
                </div>

                {{-- Description --}}
                <div class="flex items-center justify-between gap-5 py-5">

                    <h2 class="font-dm-serif text-green-gs text-2xl font-bold">{{ __('escort_profile.description') }}</h2>
                    <div class="bg-green-gs h-0.5 flex-1"></div>

                </div>
                <div class="flex flex-wrap items-center gap-10">
                    <p class="text-justify">{{ $escort->apropos ?? '-' }}</p>
                </div>

                {{-- Services --}}
                <div class="flex items-center justify-between gap-5 py-5">

                    <h2 class="font-dm-serif text-green-gs text-2xl font-bold">{{ __('escort_profile.services_offered') }}
                    </h2>
                    <div class="bg-green-gs h-0.5 flex-1"></div>

                </div>
                <div class="flex flex-wrap items-center gap-2">
                    @foreach ($escort->services as $service)
                        <span class="border-green-gs text-green-gs rounded-lg border px-2 py-1 text-sm hover:bg-amber-300">
                            {{ $service->getTranslation('nom', app()->getLocale()) }}
                        </span>
                    @endforeach

                </div>

                {{-- Associated Salon --}}
                <div class="flex items-center justify-between gap-5 py-5">

                    <h2 class="font-dm-serif text-green-gs text-2xl font-bold">{{ __('escort_profile.associated_salon') }}
                    </h2>
                    <div class="bg-green-gs h-0.5 flex-1"></div>

                </div>
                <div class="flex w-full flex-wrap items-center gap-10">
                    @if ($salonAssociers->isNotEmpty())
                        @foreach ($salonAssociers as $salonAssocier)
                            <livewire:salon-card name="{{ $salonAssocier->inviter->nom_salon }}"
                                canton="{{ $salonAssocier->inviter->cantonget->nom ?? '' }}"
                                ville="{{ $salonAssocier->inviter->villeget->nom ?? '' }}"
                                avatar='{{ $salonAssocier->inviter->avatar }}'
                                salonId='{{ $salonAssocier->inviter->id }}'
                                wire:key="{{ $salonAssocier->inviter->id }}" />
                        @endforeach
                    @else
                        <span
                            class="text-green-gs font-dm-serif w-full text-center font-bold">{{ __('escort_profile.no_associated_salon') }}</span>
                    @endif

                </div>

                {{-- Private Gallery --}}
                @guest
                    <div class="font-dm-serif text-green-gs my-3 flex w-full flex-col items-center justify-center gap-5">
                        <svg class="w-25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M6 7.5a5.5 5.5 0 1 1 11 0a5.5 5.5 0 0 1-11 0M18 14c.69 0 1.25.56 1.25 1.25V16h-2.5v-.75c0-.69.56-1.25 1.25-1.25m3.25 2v-.75a3.25 3.25 0 0 0-6.5 0V16h-1.251v6.5h9V16zm-9.75 6H2v-2a6 6 0 0 1 6-6h3.5z" />
                        </svg>
                        <p class="text-center text-3xl font-extrabold">
                            {{ __('escort_profile.connect_to_view_private_content') }}</p>
                        <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                            class="font-dm-serif btn-gs-gradient rounded-lg font-bold">{{ __('escort_profile.connect_signup') }}</button>
                    </div>
                @endguest
                @auth
                    @livewire('gallery-manager', ['user' => $escort, 'isPublic' => false], key($escort->id))
                @endauth

                {{-- Feedback and Rating --}}
                <livewire:feedback :userToId=$escort />

            </section>

        </div>

    </div>

    </div>

@stop

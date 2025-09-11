@extends('layouts.base')

@php
    use Carbon\Carbon;
    $noSpecial = __('profile.no_specified');
    $profileVerifier = $salon->profile_verifie == 'verifier' ? true : false;
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

        @php
            $avatar = $salon->avatar;
            $avatarSrc = $avatar ? asset('storage/avatars/' . $avatar) : asset('images/icon_logo.png');
            $isPaused = $salon->is_profil_pause ?? false;
        @endphp

        <div x-data="{}" class="mx-auto flex w-full max-w-sm flex-col items-center gap-2 sm:gap-4 p-4">

            <x-profileAvatar :isPaused="$isPaused" :avatarSrc="$avatarSrc" :gallery="$gallery" :status="$salon->isOnline()" />



            <!-- Nom du salon + badge pause -->
            <div class="mb-2 flex items-center justify-center gap-2">
                <p class="font-roboto-slab text-center font-bold leading-tight">
                    {{ Str::ucfirst($salon->nom_salon) }}
                </p>

            </div>

            <!-- Catégories -->
            @foreach ($salon->categorie as $categorie)
                @php
                    $locale = session('locale', 'fr');
                    $categoryName =
                        $categorie['nom'][$locale] ?? ($categorie['nom']['fr'] ?? ($categorie['nom'] ?? '-'));
                @endphp
                <span class="font-roboto-slab text-textColorParagraph text-xs sm:text-sm">
                    {{ Str::ucfirst($categoryName) }}
                </span>
            @endforeach

            <!-- Téléphone -->
            <x-contact.phone-link :phone="$salon->code_phone . $salon->telephone ?? null" :noPhoneText="__('salon_profile.no_phone')" :isPause="$isPaused" />

            <!-- Localisation -->
            <x-location.escort-location :cantonId="$salon->canton->id ?? null" :cantonName="$salon->canton['nom'] ?? null" :cityName="$salon->ville['nom'] ?? null" />

            <!-- Recrutement -->
            <div class="text-green-gs font-roboto-slab flex items-center justify-center gap-2">
                <span class="bg-fieldBg flex items-center gap-1 px-2 py-1 text-xs sm:text-sm">
                    {{ __('salon_profile.recruitment') }} :
                </span>
                <span class="text-green-gs font-bold text-xs sm:text-sm">
                    {{ $salon->recrutement === 'Ouvert' ? __('salon_profile.open') : __('salon_profile.closed') }}
                </span>
            </div>

            <hr class="text-green-gs h-2 w-full">

            <!-- Favoris -->
            @auth
                <livewire:favorite-button :userId='$salon->id' wire:key='{{ $salon->id }}' placement="profile" />
            @endauth

            <div class='grid grid-cols-2 xl:grid-cols-1 gap-2 w-full' >
                <!-- Bouton message -->
            <div class="group relative w-full">
                <button id="chatButtonProfile" data-user-id="{{ $salon->id }}"
                    @if ($isPaused) disabled aria-disabled="true" @endif
                    @auth
                    @unless ($isPaused)
                            x-on:click="$dispatch('loadForSender', [{{ $salon->id }}])"
                        @endunless
                    @else
                        data-modal-target="authentication-modal"
                        data-modal-toggle="authentication-modal" @endauth
                    class="@if ($isPaused) cursor-not-allowed bg-gray-200 text-gray-500 border-gray-300
                        @else
                             text-green-gs border-green-gs hover:bg-green-gs hover:text-white @endif flex w-full items-center justify-center  md:gap-2 gap-1 rounded-lg border 
                            py-2 px-1 sm:p-2 text-xs md:text-sm transition-all duration-300 trucate">
                    <svg class="sm:h-5 sm:w-5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12 3c5.5 0 10 3.58 10 8s-4.5 8-10 8c-1.24 0-2.43-.18-3.53-.5C5.55 21 2 21 2 21c2.33-2.33 2.7-3.9 2.75-4.5C3.05 15.07 2 13.13 2 11c0-4.42 4.5-8 10-8m5 9v-2h-2v2zm-4 0v-2h-2v2zm-4 0v-2H7v2z" />
                    </svg>
                    {{ __('salon_profile.send_message') }}
                </button>

                @if ($isPaused)
                    <x-badgePauseToolTip />
                @endif
            </div>

            <x-contact.whatsapp-button :phone="$salon->code_phone . $salon->telephone ?? null" :noContactText="__('salon_profile.no_whatsapp_contact')" :isPause="$isPaused" :name="$salon->nom_salon"
                :price="$salon->tarif ?? null" :profileVerifier="$profileVerifier" />
            </div>

            <!-- Contacts -->
            <!-- <x-contact.sms-button
                    :phone="$salon->telephone ?? null"
                    :noContactText="__('salon_profile.no_sms_contact')"
                    :isPause="$isPaused"
                /> -->
            
            <!-- <x-contact.email-button
                    :email="$salon->email"
                    :noEmailText="__('salon_profile.no_email')"
                    :isPause="$isPaused"
                /> -->

        </div>


        <div class="min-w-3/4 px-5 py-5">

            <div>

                <section>

                    <div class="min-w-3/4">
                        <div class="text-green-gs font-roboto-slab w-full text-right font-bold text-xs sm:text-sm">
                            @foreach ($salon->categorie as $categorie)
                                <a href="{{ route('salons') . '?selectedSalonCategories=' . ($categorie['id'] ?? '') }}"
                                    class="hover:text-green-gs text-xs sm:text-sm">

                                    @php
                                        $locale = session('locale', 'fr');
                                        $categoryName =
                                            $categorie['nom'][$locale] ??
                                            ($categorie['nom']['fr'] ?? ($categorie['nom'] ?? '-'));
                                    @endphp
                                    {{ Str::ucfirst($categoryName) }}
                                </a>
                            @endforeach
                            /
                            <a href="{{ route('salons') . '?selectedSalonCanton=' . ($salon->canton['id'] ?? '') }}"
                                class="hover:text-green-gs text-xs sm:text-sm">

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
                            @if ($salon->nombre_filles || $salon->tarif || $salon->autre_contact || $salon->paiement || $salon->langues)
                                <div class="flex items-center justify-between sm:gap-4 sm:py-4 py-2">

                                    <h2 class="font-roboto-slab text-green-gs text-sm sm:text-2xl font-bold">
                                        {{ __('salon_profile.about_me') }}</h2>
                                    <div class="bg-green-gs h-0.5 flex-1"></div>

                                </div>
                                <div class="flex flex-wrap items-center">
                                    <div class="grid w-full grid-cols-1 gap-2 sm:gap-4 md:grid-cols-3 xl:grid-cols-3">


                                        <x-profile-info-item icon="escort_icon.png" :alt="__('salon_profile.girls_icon')" :label="__('salon_profile.number_of_girls')"
                                            :value="$salon->nombre_filles" suffix="{{ __('salon_profile.girls') }}" />

                                        <x-profile-info-item icon="tarif_icon.png" :alt="__('salon_profile.rate_icon')" :label="__('salon_profile.rates_from')"
                                            :value="$salon->tarif" suffix=".-CHF" />

                                        <x-profile-info-item icon="cart_icon.png" :alt="__('salon_profile.other_contact_icon')" :label="__('salon_profile.other_contact')"
                                            :value="$salon->autre_contact" />

                                        <x-info-display :items="$salon->paiement" type="payment" />

                                        <x-info-display :items="$salon->langues" type="language" />


                                    </div>
                                </div>
                            @endif

                            {{-- Description --}}

                            <x-profile.description :title="__('salon_profile.description')" :content="$salon->apropos" />
                            {{-- Escort associé --}}

                            <x-associated-swiper :data="$acceptedInvitations" type="salon" />

                            {{-- Galerie privée --}}

                            @if ($salon['havePrivateGallery'])
                                @guest
                                    <x-auth.login-required :title="__('salon_profile.login_to_see_private_content')" :buttonText="__('salon_profile.login_signup')" />
                                @endguest
                            @endif
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

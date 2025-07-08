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
                <p class="flex items-center gap-2 font-bold font-roboto-slab">{{ Str::ucfirst($escort->prenom) }} @if ($escort->profile_verifie == 'verifier')
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
                <p class="{{ $escort->isOnline() ? 'text-green-gs' : 'text-gray-500' }} text-sm font-roboto-slab">
                    ({{ $escort->last_seen_for_humans }})
                </p>
            </div>
            <x-profile.gender-badge 
                :genderName="Str::ucfirst($escort->genre->getTranslation('name', app()->getLocale(), 'fr'))"
            />
            
            
            <x-contact.phone-link 
                :phone="$escort->telephone ?? null"
                :noPhoneText="__('escort_profile.no_phone')"
            />

            <x-location.escort-location 
                :cantonId="$escort->canton->id ?? null" 
                :cantonName="$escort->canton['nom'] ?? null" 
                :cityName="$escort->ville['nom'] ?? null"
            />
            <hr class="h-2 w-full text-green-gs ">


            @auth
                <button
                    class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-green-gs p-2 text-sm hover:text-white">
                    <livewire:favorite-button :userId='$escort->id' wire:key='{{ $escort->id }}' />
                    {{ __('escort_profile.add_to_favorites') }}
                </button>
            @endauth
            <button
                @auth x-on:click="$dispatch('loadForSender', [{{ $escort->id }}])" @else data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" @endauth
                class="text-green-gs hover:bg-green-gs flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-green-gs p-2 text-sm hover:text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M12 3c5.5 0 10 3.58 10 8s-4.5 8-10 8c-1.24 0-2.43-.18-3.53-.5C5.55 21 2 21 2 21c2.33-2.33 2.7-3.9 2.75-4.5C3.05 15.07 2 13.13 2 11c0-4.42 4.5-8 10-8m5 9v-2h-2v2zm-4 0v-2h-2v2zm-4 0v-2H7v2z" />
                </svg>
                {{ __('escort_profile.send_message') }}
            </button>
            <x-contact.sms-button 
                :phone="$escort->telephone ?? null"
                :noContactText="__('escort_profile.no_sms_contact')"
            />
            <x-contact.whatsapp-button 
                :phone="$escort->whatsapp ?? null"
                :noContactText="__('escort_profile.no_whatsapp_contact')"
            />
            <x-contact.email-button 
                :email="$escort->email"
                :noEmailText="__('escort_profile.no_email')"
            />

        </div>

        {{-- Escort profile --}}
        <div class="min-w-3/4 px-5 py-5">

            <section>

                {{-- Category --}}
                <div class="flex items-center gap-5 py-5">

                    <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('escort_profile.category') }}</h2>
                    <div class="flex items-center gap-5">
                        @foreach ($escort->getCategoriesAttribute() as $category)
                            <x-service-badge 
                                        :text="$category->getTranslation('nom', app()->getLocale())"
                                        color="green-gs"
                                        hoverColor="fieldBg"
                                        borderColor="supaGirlRose"
                                        bgColor="fieldBg"
                                        textHoverColor="fieldBg"
                                    />
                       
                                @endforeach
                    </div>

                </div>

                {{-- Stories --}}
                @livewire('storie-public-viewer', ['userViewStorie' => $escort->id], key($escort->id))

                {{-- Gallery --}}
                @livewire('gallery-manager', ['user' => $escort], key($escort->id))

                {{-- About Me --}}
                <div class="flex items-center justify-between gap-5 py-5">

                    <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('escort_profile.about_me') }}</h2>
                    <div class="bg-green-gs h-0.5 flex-1"></div>

                </div>
                <div class="flex flex-wrap items-center gap-10">
                    <div class="grid w-full grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                        <x-profile-info-item 
                            icon="age_icon.png"
                            :alt="__('escort_profile.age_icon')"
                            :label="__('escort_profile.age')"
                            :value="Carbon::parse($escort->date_naissance)->age"
                            suffix="{{ __('escort_profile.years_old') }}"
                        />


                        <x-profile-info-item 
                            icon="origine_icon.png"
                            :alt="__('escort_profile.origin_icon')"
                            :label="__('escort_profile.origin')"
                            :value="$escort->origine"
                        />



                        <x-profile-info-item 
                            icon="yeux_icon.png"
                            :alt="__('escort_profile.eye_color_icon')"
                            :label="__('escort_profile.eye_color')"
                            :value="$escort->couleurYeux"
                            translation-path="name"
                        />
                   

                        <x-profile-info-item 
                            icon="cheveux_icon.png"
                            :alt="__('escort_profile.hair_color_icon')"
                            :label="__('escort_profile.hair_color')"
                            :value="$escort->couleurCheveux"
                            translation-path="name"
                        />

                        <x-profile-info-item 
                            icon="tarif_icon.png"
                            :alt="__('escort_profile.rate_icon')"
                            :label="__('escort_profile.rates_from')"
                            :value="$escort->tarif"
                            suffix="CHF"
                        />

                        <x-profile-info-item 
                            icon="taille_icon.png"
                            :alt="__('escort_profile.height_icon')"
                            :label="__('escort_profile.height')"
                            :value="$escort->tailles"
                            suffix="cm"
                        />

                        <x-profile-info-item 
                            icon="poitrine_icon.png"
                            :alt="__('escort_profile.bust_icon')"
                            :label="__('escort_profile.bust')"
                            :value="$escort->poitrine"
                            translation-path="name"
                        />

                        <x-profile-info-item 
                            icon="mobilite.png"
                            :alt="__('escort_profile.mobility_icon')"
                            :label="__('escort_profile.mobility')"
                            :value="$escort->mobilite"
                            translation-path="name"
                        />

                        <x-profile-info-item 
                            icon="mensuration.png"
                            :alt="__('escort_profile.measurements_icon')"
                            :label="__('escort_profile.measurements')"
                            :value="$escort->mensuration"
                            translation-path="name"
                        />

                        <x-profile-info-item 
                            icon="taill_poit.png"
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
                <x-profile.description 
                    :title="__('escort_profile.description')"
                    :content="$escort->apropos"
                />

                {{-- Services --}}
                <div class="flex items-center justify-between gap-5 py-5">

                    <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('escort_profile.services_offered') }}
                    </h2>
                    <div class="bg-green-gs h-0.5 flex-1"></div>

                </div>
                <div class="flex flex-wrap items-center gap-2">
                    @foreach ($escort->services as $service)
                        <x-service-badge 
                                        :text="$service->getTranslation('nom', app()->getLocale())"
                                        color="green-gs"
                                        hoverColor="fieldBg"
                                        borderColor="supaGirlRose"
                                        bgColor="fieldBg"
                                        textHoverColor="fieldBg"
                                    />
                    @endforeach

                </div>

                {{-- Associated Salon --}}
                <div class="flex items-center justify-between gap-5 py-5">

                    <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('escort_profile.associated_salon') }}
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
                            class="text-green-gs font-roboto-slab w-full text-center font-bold">{{ __('escort_profile.no_associated_salon') }}</span>
                    @endif

                </div>

                {{-- Private Gallery --}}
                @guest
                    <x-auth.login-required 
                        :title="__('escort_profile.connect_to_view_private_content')"
                        :buttonText="__('escort_profile.connect_signup')"
                    />
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

@extends('layouts.base')

@php
    use Carbon\Carbon;
@endphp

@section('pageTitle')
    {{ $escort->prenom }}
@endsection


@php
            $avatar = $escort->avatar;
            $avatarSrc = $avatar ? asset('storage/avatars/' . $avatar) : asset('images/icon_logo.png');
            $isPaused = $escort->is_profil_pause ?? false;
        @endphp
@section('content')
    <div x-data="{}"
        x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{ $couverture_image = $escort->couverture_image }}' ? '{{ asset('storage/couvertures/' . $couverture_image) }}' : '{{ asset('images/Logo_lg.png') }}', imgModalDesc: '' })"
        class="relative max-h-[30vh] min-h-[30vh] w-full overflow-hidden"
        style="background: url({{ $escort->couverture_image ? asset('storage/couvertures/' . $escort->couverture_image) : asset('images/Logo_lg.png') }}) center center /cover;">
    </div>

    <div x-data="{}" class="container mx-auto flex flex-col justify-center xl:flex-row">

        {{-- Profile picture and status --}}
        <div class="min-w-1/4 flex flex-col items-center  gap-3 px-4 -mt-26">

          <x-profileAvatar :isPaused="$isPaused" :avatarSrc="$avatarSrc" :gallery="$gallery" :status="$escort->isOnline()" :type="'escort'" />

            <div class=" ml-3 flex flex-col items-center justify-center ">
                <div class="flex items-center gap-2 justify-center mb-2">
                        <p class="flex items-center gap-2 font-bold font-roboto-slab">
                        {{ Str::ucfirst($escort->prenom) }}

                        @if ($escort->profile_verifie === 'verifier')
                            <span class="relative group flex items-center justify-center" title="{{ __('escort_profile.verified_profile') }}">
                                <svg fill="#000000" width="25px" height="25px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                    class="icon flat-line text-green-700">
                                    <rect x="3" y="3" width="18" height="18" rx="9" fill="#f9cdf3" />
                                    <polyline points="8 11.5 11 14.5 16 9.5"
                                            style="fill: none; stroke: #146c33; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;" />
                                    <rect x="3" y="3" width="18" height="18" rx="9"
                                        style="fill: none; stroke: #146c33; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;" />
                                </svg>

                                <span class="absolute bottom-full mb-2 px-2 py-1 text-xs text-white bg-gray-800 rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                                    {{ __('profile.profile_verifie') }}
                                </span>
                            </span>
                        @endif

                    
                    </p>
                    
                </div> 


                <p class="{{ $escort->isOnline() ? 'text-green-gs' : 'text-gray-500' }} text-xs font-roboto-slab">
                    ({{ $escort->last_seen_for_humans }})
                </p>
            </div>
            @if ($escort->genre && $escort->genre->getTranslation('name', app()->getLocale(), 'fr'))
                <x-profile.gender-badge 
                :genderName="Str::ucfirst($escort->genre->getTranslation('name', app()->getLocale(), 'fr'))"
            />
            @endif
            
            
            <x-contact.phone-link 
                :phone="$escort->telephone ?? null"
                :noPhoneText="__('escort_profile.no_phone')"
                :isPause="$escort->is_profil_pause"
            />

            <x-location.escort-location 
                :cantonId="$escort->canton->id ?? null" 
                :cantonName="$escort->canton['nom'] ?? null" 
                :cityName="$escort->ville['nom'] ?? null"
            />
            <hr class="h-2 w-full text-green-gs ">


            @auth
            <livewire:favorite-button :userId='$escort->id' wire:key='{{ $escort->id }}' placement="profile" />
              
            @endauth
            @php
                $isPaused = $escort->is_profil_pause;
            @endphp

            <div class="relative group w-full">
                <button
                    id="chatButtonProfile"
                    data-user-id="{{ $escort->id }}"
                    @if($isPaused) disabled @endif
                    @auth
                        @unless($isPaused)
                            x-on:click="$dispatch('loadForSender', [{{ $escort->id }}])"
                        @endunless
                    @else
                        data-modal-target="authentication-modal"
                        data-modal-toggle="authentication-modal"
                    @endauth
                    class="flex w-full items-center justify-center gap-2 rounded-lg border p-2 text-sm transition-all duration-300
                        @if($isPaused)
                            cursor-not-allowed bg-gray-200 text-gray-500 border-gray-300
                        @else
                            text-green-gs border-green-gs hover:bg-green-gs hover:text-white
                        @endif"
                >
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12 3c5.5 0 10 3.58 10 8s-4.5 8-10 8c-1.24 0-2.43-.18-3.53-.5C5.55 21 2 21 2 21c2.33-2.33 2.7-3.9 2.75-4.5C3.05 15.07 2 13.13 2 11c0-4.42 4.5-8 10-8m5 9v-2h-2v2zm-4 0v-2h-2v2zm-4 0v-2H7v2z" />
                    </svg>
                    {{ __('escort_profile.send_message') }}
                </button>

                @if($isPaused)
                    <x-badgePauseToolTip/>
                @endif
            </div>

            <x-contact.sms-button 
                :phone="$escort->telephone ?? null"
                :noContactText="__('escort_profile.no_sms_contact')"
                :isPause="$escort->is_profil_pause"
            />
            <x-contact.whatsapp-button 
                :phone="$escort->whatsapp ?? null"
                :noContactText="__('escort_profile.no_whatsapp_contact')"
                :isPause="$escort->is_profil_pause"
            />
            <x-contact.email-button 
                :email="$escort->email"
                :noEmailText="__('escort_profile.no_email')"
                :isPause="$escort->is_profil_pause"
            />

        </div>

        {{-- Escort profile --}}
        <div class="min-w-3/4 px-5 py-5">

            <section>

                {{-- Category --}}
                @if($escort->getCategoriesAttribute()->isNotEmpty())
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
                @endif

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
                @if($escort->apropos)
                    <x-profile.description 
                        :title="__('escort_profile.description')"
                        :content="$escort->apropos"
                    />
                @endif
                {{-- Services --}}
                @if($escort->services->isNotEmpty())
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
                @endif
                {{-- Associated Salon  --}}
                <x-associated-swiper :data="$salonAssociers" type="escort" />

                
                {{-- Private Gallery --}}

                @if($escort->galleryCount > 0)
                @guest
                <div class="flex items-center justify-center my-10">
                    <x-auth.login-required 
                        :title="__('escort_profile.connect_to_view_private_content')"
                        :buttonText="__('escort_profile.connect_signup')"
                    />
                </div>
                @endguest
                @endif
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

@extends('layouts.base')

@section('pageTitle')
    {{ __('about.page_title') }}
@endsection

@section('content')

    <div class="h-30 z-0 flex w-full flex-col items-center gap-4 bg-white px-2 py-60 pt-5 text-center xl:min-h-60">
        <h2 class="font-roboto-slab text-green-gs text-2xl font-bold xl:text-5xl">{{ __('about.who_we_are') }}</h2>
        <p class="font-roboto-slab text-textColorParagraph text-sm">{{ __('about.welcome_text') }}</p>
    </div>

    <div class="bg-supaGirlRosePastel min-h-60 w-full pb-4">
        <div class="mx-auto w-full -translate-y-1/2 xl:w-[70%]">
            <img src="images/image_about_deco.png" alt="{{ __('about.decorative_image_alt') }}" />
        </div>
        <div
            class="text-green-gs font-roboto-slab mx-auto grid w-full grid-cols-1 px-10 text-center lg:-mt-20 lg:grid-cols-2 lg:gap-40 xl:w-[65%]">
            <div class="text-wrap text-sm xl:text-base">
                <h3 class="font-roboto-slab mb-10 text-2xl xl:text-5xl">{{ __('about.genesis_of_Supagirl') }}</h3>
                <p class="my-3 text-justify">{{ __('about.genesis_description_1') }}</p>
                <p class="my-3 text-justify">{{ __('about.genesis_description_2') }}</p>
            </div>
            <div class="hidden flex-col gap-5 lg:flex">
                <div class="w-90 h-60" style="background: url('images/girl_deco_about_001.jpg') center center /cover"></div>
                <div class="w-90 h-60" style="background: url('images/girl_deco_about_002.jpg') center center /cover"></div>
            </div>
        </div>
    </div>

    <div
        class="mx-auto flex w-full flex-col items-center justify-center gap-10 bg-white py-20 text-center md:flex-row xl:w-[80%]">
        <x-feature-card icon="images/fi_shield.png" :title="__('about.erotic_entertainment')" :description="__('about.erotic_entertainment_description')"
            alt="{{ __('about.shield_icon_alt') }}" />
        <x-feature-card icon="images/fi_zap.png" :title="__('about.security_confidentiality')" :description="__('about.security_confidentiality_description')" alt="{{ __('about.zap_icon_alt') }}" />
        <x-feature-card icon="images/fi_map-pin.png" :title="__('about.reliable_education')" :description="__('about.reliable_education_description')"
            alt="{{ __('about.map_icon_alt') }}" />
    </div>

    <x-FeedbackSection />

    <x-CallToActionContact />

    <div class="mx-auto my-5 flex flex-col-reverse items-center justify-center gap-10 px-5 lg:container lg:flex-row xl:gap-20"
        x-data="{ loading: false }">
        <div class="flex w-full flex-col gap-10">
            <h3 class="font-roboto-slab text-green-gs text-center text-5xl font-bold">
                {{ __('about.register_in_a_minute') }}
            </h3>
            <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-4 text-sm xl:text-base">
                @csrf

                <input type="hidden" name="profile_type" value="invite">

                <x-form.input-field name="pseudo" :label="__('about.username')" :value="old('pseudo')" autocomplete="username"
                    :error="$errors->has('pseudo')" :errorMessage="$errors->first('pseudo')" required />

                <x-form.input-field name="email" type="email" :label="__('about.email_address')" :value="old('email')" autocomplete="email"
                    :error="$errors->has('email')" :errorMessage="$errors->first('email')" required />

                <x-form.input-field name="date_naissance" type="date" :label="__('about.birth_date')" :value="old('date_naissance')"
                    autocomplete="bday" :error="$errors->has('date_naissance')" :errorMessage="$errors->first('date_naissance')" required />

                <x-form.input-field name="password" type="password" :label="__('about.password')" autocomplete="new-password"
                    :error="$errors->has('password')" :errorMessage="$errors->first('password')" required />

                <x-form.input-field name="password_confirmation" type="password" :label="__('about.confirm_password')"
                    autocomplete="new-password" required />

                <div class="font-roboto-slab text-textColorParagraph flex flex-col gap-2 text-sm">
                    <span class="text-wrap">{{ __('about.terms_conditions') }}
                        <a href="#" class="text-green-gs hover:underline">
                            {{ __('about.terms_conditions_link') }} *
                        </a>
                    </span>
                    <x-form.checkbox name="cgu_accepted" :label="__('about.accept_terms')" required />
                </div>
                <x-form.submit-button :text="__('about.register')" />
            </form>
        </div>
        <div class="flex w-full flex-col items-center justify-center gap-5">
            <x-stat-card :count="__('home.partners_count')" :description="__('home.verified_profiles')" />
            <x-stat-card :count="__('home.amateurs_count')" :description="__('home.amateur_experiences')" />
            <x-stat-card :count="__('home.professional_salons_count')" :description="__('home.professional_salons_offer')" />
        </div>
    </div>

    <x-CallToActionInscription />

@stop

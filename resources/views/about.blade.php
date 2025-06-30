@extends('layouts.base')

@section('pageTitle')
    {{ __('about.page_title') }}
@endsection

@section('content')

    <div class="h-30 z-0 flex w-full flex-col items-center gap-4 bg-white px-2 py-60 pt-5 text-center xl:min-h-60">
        <h2 class="font-dm-serif text-green-gs text-2xl font-bold xl:text-5xl">{{ __('about.who_we_are') }}</h2>
        <p class="text-sm">{{ __('about.welcome_text') }}</p>
    </div>

    <div class="bg-green-gs min-h-60 w-full pb-4">
        <div class="mx-auto w-full -translate-y-1/2 xl:w-[70%]">
            <img src="images/image_about_deco.png" alt="{{ __('about.decorative_image_alt') }}" />
        </div>
        <div
            class="mx-auto grid w-full grid-cols-1 px-10 text-center text-white lg:-mt-20 lg:grid-cols-2 lg:gap-40 xl:w-[65%]">
            <div class="text-wrap text-sm xl:text-base">
                <h3 class="font-dm-serif mb-10 text-2xl xl:text-5xl">{{ __('about.genesis_of_gstuff') }}</h3>
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
        <div class="flex w-full flex-col items-center justify-center gap-5 text-wrap px-2 xl:w-1/3">
            <img src="images/fi_shield.png" alt="{{ __('about.shield_icon_alt') }}" />
            <h3 class="font-dm-serif text-green-gs text-3xl">{{ __('about.erotic_entertainment') }}</h3>
            <span>{{ __('about.erotic_entertainment_description') }}</span>
        </div>
        <div class="flex w-full flex-col items-center justify-center gap-5 text-wrap px-2 xl:w-1/3">
            <img src="images/fi_zap.png" alt="{{ __('about.zap_icon_alt') }}" />
            <h3 class="font-dm-serif text-green-gs text-3xl">{{ __('about.security_confidentiality') }}</h3>
            <span>{{ __('about.security_confidentiality_description') }}</span>
        </div>
        <div class="flex w-full flex-col items-center justify-center gap-5 text-wrap px-2 xl:w-1/3">
            <img src="images/fi_map-pin.png" alt="{{ __('about.map_icon_alt') }}" />
            <h3 class="font-dm-serif text-green-gs text-3xl">{{ __('about.reliable_education') }}</h3>
            <span>{{ __('about.reliable_education_description') }}</span>
        </div>
    </div>

    <x-FeedbackSection />

    <x-CallToActionContact />

    <div
        class="mx-auto my-5 flex flex-col-reverse items-center justify-center gap-10 px-5 lg:container lg:flex-row xl:gap-20">
        <div class="flex w-full flex-col gap-10">
            <h3 class="font-dm-serif text-green-gs text-center text-5xl font-bold">{{ __('about.register_in_a_minute') }}
            </h3>
            <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-4 text-sm xl:text-base">
                @csrf
                <input type="hidden" name="profile_type" value="invite">
                <div class="flex flex-col gap-2">
                    <label for="pseudo">{{ __('about.username') }} *</label>
                    <input type="text" name="pseudo" id="pseudo"
                        class="@error('pseudo') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror rounded-lg border ring-0 focus:border-amber-400"
                        value="{{ old('pseudo') }}" autocomplete="user_name" required>
                    @error('pseudo')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                class="font-medium">{{ __('about.oops') }}</span> {{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label for="Insc_email">{{ __('about.email_address') }} *</label>
                    <input type="email" name="email" id="Insc_email"
                        class="@error('email') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror rounded-lg border ring-0 focus:border-amber-400"
                        value="{{ old('email') }}" autocomplete="email" required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                class="font-medium">{{ __('about.oops') }}</span> {{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label for="date_naissance">{{ __('about.birth_date') }}</label>
                    <input type="date" name="date_naissance" id="date_naissance"
                        class="@error('date_naissance') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror rounded-lg border ring-0 focus:border-amber-400"
                        value="{{ old('date_naissance') }}" autocomplete="date_naissance" required>
                    @error('date_naissance')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                class="font-medium">{{ __('about.oops') }}</span> {{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label for="mdp">{{ __('about.password') }} *</label>
                    <input type="password" name="password" id="mdp"
                        class="@error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror rounded-lg border ring-0 focus:border-amber-400"
                        value="{{ old('password') }}" autocomplete="password" required>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                class="font-medium">{{ __('about.oops') }}</span> {{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <label for="cmdp">{{ __('about.confirm_password') }} *</label>
                    <input type="password" name="password_confirmation" id="cmdp"
                        class="@error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror rounded-lg border ring-0 focus:border-amber-400"
                        value="{{ old('password') }}" autocomplete="password" required>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span
                                class="font-medium">{{ __('about.oops') }}</span> {{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2">
                    <span class="text-wrap">{{ __('about.terms_conditions') }} <a href="#"
                            class="text-green-gs">{{ __('about.terms_conditions_link') }} *</a></span>
                    <div class="flex items-center gap-1">
                        <input type="checkbox" name="cgu_accepted" id="cgu" required>
                        <label for="cgu">{{ __('about.accept_terms') }}</label>
                    </div>
                </div>
                <button type="submit"
                    class="bg-green-gs hover:bg-green-gs/80 cursor-pointer rounded-lg p-2 text-center text-white">{{ __('about.register') }}</button>
            </form>
        </div>
        <div class="flex w-full flex-col items-center justify-center gap-5">
            <div
                class="min-h-30 bg-green-gs flex w-full flex-col items-center justify-center gap-3 rounded-lg p-3 text-3xl font-bold text-white lg:h-[263px] lg:w-[450px] lg:text-4xl">
                <span class="font-dm-serif w-[70%] text-center">{{ __('about.partners_count') }}</span>
                <span
                    class="mx-auto w-[75%] text-center text-sm font-normal lg:text-base">{{ __('about.partners_description') }}</span>
            </div>
            <div
                class="min-h-30 bg-green-gs flex w-full flex-col items-center justify-center gap-3 rounded-lg p-3 text-3xl font-bold text-white lg:ml-10 lg:h-[263px] lg:w-[450px] lg:text-4xl">
                <span class="font-dm-serif w-[70%] text-center">{{ __('about.amateurs_count') }}</span>
                <span
                    class="mx-auto w-[75%] text-center text-sm font-normal lg:text-base">{{ __('about.amateurs_description') }}</span>
            </div>
            <div
                class="min-h-30 bg-green-gs flex w-full flex-col items-center justify-center gap-3 rounded-lg p-3 text-3xl font-bold text-white lg:h-[263px] lg:w-[450px] lg:text-4xl">
                <span class="font-dm-serif w-[70%] text-center">{{ __('about.professional_salons_count') }}</span>
                <span
                    class="mx-auto w-[75%] text-center text-sm font-normal lg:text-base">{{ __('about.professional_salons_description') }}</span>
            </div>
        </div>
    </div>

    <x-CallToActionInscription />

@stop

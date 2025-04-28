@extends('layouts.base')

@section('pageTitle')
    {{__('about.page_title')}}
@endsection

@section('content')

<div class="bg-white flex flex-col items-center gap-4 h-30 xl:min-h-60 w-full text-center pt-5 px-2 py-60 z-0">
    <h2 class="font-dm-serif text-2xl xl:text-5xl font-bold text-green-gs">{{__('about.who_we_are')}}</h2>
    <p class="text-sm">{{__('about.welcome_text')}}</p>
</div>

<div class="bg-green-gs min-h-60 pb-4 w-full">
    <div class="w-full xl:w-[70%] mx-auto -translate-y-1/2">
        <img src="images/image_about_deco.png" alt="{{__('about.decorative_image_alt')}}" />
    </div>
    <div class="grid grid-cols-1 px-10 text-center lg:grid-cols-2 w-full lg:gap-40 xl:w-[65%] mx-auto lg:-mt-20 text-white">
        <div class="text-wrap text-sm xl:text-base">
            <h3 class="text-2xl xl:text-5xl font-dm-serif mb-10">{{__('about.genesis_of_gstuff')}}</h3>
            <p class="text-justify my-3">{{__('about.genesis_description_1')}}</p>
            <p class="text-justify my-3">{{__('about.genesis_description_2')}}</p>
        </div>
        <div class="hidden lg:flex flex-col gap-5">
            <div class="w-90 h-60" style="background: url('images/girl_deco_about_001.jpg') center center /cover"></div>
            <div class="w-90 h-60" style="background: url('images/girl_deco_about_002.jpg') center center /cover"></div>
        </div>
    </div>
</div>

<div class="xl:w-[80%] w-full mx-auto bg-white flex flex-col md:flex-row items-center justify-center text-center gap-10 py-20">
    <div class="flex flex-col items-center justify-center gap-5 text-wrap w-full px-2 xl:w-1/3">
        <img src="images/fi_shield.png" alt="{{__('about.shield_icon_alt')}}" />
        <h3 class="font-dm-serif text-3xl text-green-gs">{{__('about.erotic_entertainment')}}</h3>
        <span>{{__('about.erotic_entertainment_description')}}</span>
    </div>
    <div class="flex flex-col items-center justify-center gap-5 text-wrap w-full px-2 xl:w-1/3">
        <img src="images/fi_zap.png" alt="{{__('about.zap_icon_alt')}}" />
        <h3 class="font-dm-serif text-3xl text-green-gs">{{__('about.security_confidentiality')}}</h3>
        <span>{{__('about.security_confidentiality_description')}}</span>
    </div>
    <div class="flex flex-col items-center justify-center gap-5 text-wrap w-full px-2 xl:w-1/3">
        <img src="images/fi_map-pin.png" alt="{{__('about.map_icon_alt')}}" />
        <h3 class="font-dm-serif text-3xl text-green-gs">{{__('about.reliable_education')}}</h3>
        <span>{{__('about.reliable_education_description')}}</span>
    </div>
</div>

<x-FeedbackSection />

<x-CallToActionContact />

<div class="lg:container mx-auto px-5 flex flex-col-reverse gap-10 lg:flex-row justify-center items-center xl:gap-20 my-5">
    <div class="w-full flex flex-col gap-10">
        <h3 class="text-5xl font-bold font-dm-serif text-green-gs text-center">{{__('about.register_in_a_minute')}}</h3>
        <form action="{{route('register')}}" method="POST" class="flex flex-col gap-4 text-sm xl:text-base">
            @csrf
            <input type="hidden" name="profile_type" value="invite">
            <div class="flex flex-col gap-2">
                <label for="user_name">{{__('about.username')}} *</label>
                <input type="text" name="user_name" id="user_name" class="border rounded-lg focus:border-amber-400 ring-0 @error('user_name') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror" value="{{ old('user_name') }}" autocomplete="user_name" required>
                @error('user_name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{__('about.oops')}}</span> {{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-2">
                <label for="Insc_email">{{__('about.email_address')}} *</label>
                <input type="email" name="email" id="Insc_email" class="border rounded-lg focus:border-amber-400 ring-0 @error('user_name') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror" value="{{ old('user_name') }}" autocomplete="email" required >
                @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{__('about.oops')}}</span> {{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-2">
                <label for="date_naissance">{{__('about.birth_date')}}</label>
                <input type="date" name="date_naissance" id="date_naissance" class="border rounded-lg focus:border-amber-400 ring-0 @error('date_naissance') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror" value="{{ old('date_naissance') }}" autocomplete="date_naissance" required>
                @error('date_naissance')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{__('about.oops')}}</span> {{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-2">
                <label for="mdp">{{__('about.password')}} *</label>
                <input type="password" name="password" id="mdp" class="border rounded-lg focus:border-amber-400 ring-0 @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror" value="{{ old('password') }}" autocomplete="password" required>
                @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{__('about.oops')}}</span> {{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-2">
                <label for="cmdp">{{__('about.confirm_password')}} *</label>
                <input type="password" name="password_confirmation" id="cmdp" class="border rounded-lg focus:border-amber-400 ring-0 @error('password') border-red-500 dark:border-red-500 dark:focus:border-red-500 focus:border-red-500 @enderror" value="{{ old('password') }}" autocomplete="password" required>
                @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{__('about.oops')}}</span> {{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col gap-2">
                <span class="text-wrap">{{__('about.terms_conditions')}} <a href="#" class="text-green-gs">{{__('about.terms_conditions_link')}} *</a></span>
                <div class="flex items-center gap-1">
                    <input type="checkbox" name="cgu_accepted" id="cgu" required>
                    <label for="cgu">{{__('about.accept_terms')}}</label>
                </div>
            </div>
            <button type="submit" class="bg-green-gs text-white text-center p-2 rounded-lg hover:bg-green-gs/80 cursor-pointer">{{__('about.register')}}</button>
        </form>
    </div>
    <div class="w-full flex flex-col gap-5 justify-center items-center">
        <div class="w-full min-h-30 lg:w-[450px] lg:h-[263px] bg-green-gs p-3 flex flex-col text-white text-3xl lg:text-4xl font-bold items-center justify-center gap-3 rounded-lg">
            <span class="text-center font-dm-serif w-[70%]">{{__('about.partners_count')}}</span>
            <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">{{__('about.partners_description')}}</span>
        </div>
        <div class="w-full min-h-30 lg:w-[450px] lg:h-[263px] bg-green-gs p-3 flex flex-col text-white text-3xl lg:text-4xl font-bold items-center justify-center gap-3 rounded-lg lg:ml-10">
            <span class="text-center font-dm-serif w-[70%]">{{__('about.amateurs_count')}}</span>
            <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">{{__('about.amateurs_description')}}</span>
        </div>
        <div class="w-full min-h-30 lg:w-[450px] lg:h-[263px] bg-green-gs p-3 flex flex-col text-white text-3xl lg:text-4xl font-bold items-center justify-center gap-3 rounded-lg">
            <span class="text-center font-dm-serif w-[70%]">{{__('about.professional_salons_count')}}</span>
            <span class="text-center text-sm lg:text-base font-normal w-[75%] mx-auto">{{__('about.professional_salons_description')}}</span>
        </div>
    </div>
</div>

<x-CallToActionInscription />

@stop

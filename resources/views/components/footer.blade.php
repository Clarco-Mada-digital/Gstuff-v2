<?php 
use App\Models\Canton;
?>
<div>
    <div class="relative w-full min-h-[375px] bg-green-gs transition-all mt-10 z-30">
        <div
            class="flex flex-col items-center lg:flex-row justify-center lg:items-start gap-10 lg:gap-40 container mx-auto py-24 text-white text-sm xl:text-base">
            <div class="flex flex-col items-center justify-center w-full lg:w-auto lg:items-start gap-3">
                <a href="{{ route('home') }}" class="w-full">
                    <img class="mx-auto lg:m-0 w-60" src="{{ url('images/Logo_lg.svg') }}" alt="Logo gstuff" />
                </a>
                <p class="w-96 lg:text-start text-center">{{ __('footer.txt_portal') }}</p>
            </div>

            <div class="flex flex-col items-center lg:items-start gap-2">
                <h3 class="font-dm-serif text-4xl font-bold mb-3">{{ __('footer.quick_links') }}</h3>
                @foreach (Canton::all()->slice(0, 5) as $canton)
                    <a href="{{ route('escortes') . '?selectedCanton=' . $canton->id }}">{{ __('footer.escort_girl') }} {{ $canton->nom }}</a>
                @endforeach
            </div>

            <div class="flex flex-col items-center lg:items-start gap-2">
                <h3 class="font-dm-serif text-4xl font-bold mb-3">{{ __('footer.quick_links') }}</h3>
                <a href="{{ route('glossaires.index') }}">{{ __('footer.glossary') }}</a>
                <a href="{{ route('faq') }}">{{ __('footer.faq') }}</a>
                <a href="{{ route('about') }}">{{ __('footer.about_us') }}</a>
                <a href="{{ route('static.cgv') }}">{{ __('footer.cgv') }}</a>
                <a href="{{ route('contact') }}">{{ __('footer.contact') }}</a>
            </div>

        </div>
    </div>
    <div
        class="relative flex items-center justify-center bg-black text-white text-xs lg:text-base py-7 transition-all z-30">
        Copyright {{ now()->year }} - <a href="{{ route('home') }}" class="text-yellow-500 mx-2"> Gstuff </a> -
        <a href="{{ route('static.pdc') }}" class="text-yellow-500 mx-2">{{ __('footer.privacy_policy') }}</a>
    </div>
</div>

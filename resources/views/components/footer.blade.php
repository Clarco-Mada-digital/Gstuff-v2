<?php
use App\Models\Canton;
?>
<div>
    <div class="bg-green-gs relative z-30 mt-10 min-h-[375px] w-full transition-all">
        <div
            class="container mx-auto flex flex-col items-center justify-center gap-10 py-24 text-sm text-white lg:flex-row lg:items-start lg:gap-40 xl:text-base">
            <div class="flex w-full flex-col items-center justify-center gap-3 lg:w-auto lg:items-start">
                <a href="{{ route('home') }}" class="w-full">
                    <img class="mx-auto w-60 lg:m-0" src="{{ url('images/Logo_lg.svg') }}" alt="Logo gstuff" />
                </a>
                <p class="w-[90%] text-wrap text-center lg:text-start">{{ __('footer.txt_portal') }}</p>
            </div>

            <div class="flex flex-col items-center gap-2 lg:items-start">
                <h3 class="font-dm-serif mb-3 text-4xl font-bold">{{ __('footer.quick_links') }}</h3>
                @foreach (Canton::all()->slice(0, 5) as $canton)
                    <a href="{{ route('escortes') . '?selectedCanton=' . $canton->id }}">{{ __('footer.escort_girl') }}
                        {{ $canton->nom }}</a>
                @endforeach
            </div>

            <div class="flex flex-col items-center gap-2 lg:items-start">
                <h3 class="font-dm-serif mb-3 text-4xl font-bold">{{ __('footer.quick_links') }}</h3>
                <a href="{{ route('glossaires.index') }}">{{ __('footer.glossary') }}</a>
                <a href="{{ route('faq') }}">{{ __('footer.faq') }}</a>
                <a href="{{ route('about') }}">{{ __('footer.about_us') }}</a>
                <a href="{{ route('static.cgv') }}">{{ __('footer.cgv') }}</a>
                <a href="{{ route('contact') }}">{{ __('footer.contact') }}</a>
            </div>

        </div>
    </div>
    <div
        class="relative z-30 flex items-center justify-center bg-black py-7 text-xs text-white transition-all lg:text-base">
        Copyright {{ now()->year }} - <a href="{{ route('home') }}" class="mx-2 text-yellow-500"> Gstuff </a> -
        <a href="{{ route('static.pdc') }}" class="mx-2 text-yellow-500">{{ __('footer.privacy_policy') }}</a>
    </div>
</div>

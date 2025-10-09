@php
    $cantons = App\Models\Canton::withCount('users')->orderBy('users_count', 'desc')->get();
@endphp
<div>
    <div class="bg-bgFooter font-roboto-slab relative z-30 mt-10 min-h-[375px] w-full transition-all">
        <div
            class="container mx-auto flex flex-col items-center justify-center gap-12 px-4 py-16 text-sm text-white sm:px-6 lg:flex-row lg:items-start lg:gap-12 lg:py-20 xl:gap-24 xl:px-8 xl:text-base">
            <div
                class="flex w-full max-w-xs flex-col items-center gap-4 text-center sm:max-w-md lg:max-w-none lg:items-start lg:text-left">
                <a href="{{ route('home') }}" class="w-full max-w-[240px]">
                    <img class="mx-auto w-full lg:mx-0" src="{{ url('images/logoSupaHead.png') }}" alt="Logo gstuff" />
                </a>
                <p class=" text-xs sm:text-sm leading-relaxed text-gray-300">{{ __('footer.txt_portal') }}</p>
            </div>

            <div
                class="grid w-full max-w-xs grid-cols-1 gap-8 sm:max-w-2xl sm:grid-cols-2 lg:max-w-none lg:grid-cols-2 lg:gap-12">
                <div class="flex flex-col items-center gap-3 lg:items-start">
                    <h3 class="font-roboto-slab text-sm sm:text-xl font-bold sm:text-3xl lg:text-2xl xl:text-3xl">
                        {{ __('footer.quick_links') }}</h3>
                    <div class="flex flex-col items-center gap-2 lg:items-start">
                        @foreach ($cantons->slice(0, 5) as $canton)
                            <a href="{{ route('escortes') . '?selectedCanton=' . $canton->id }}"
                                class="text-gray-300 transition hover:text-white text-xs sm:text-sm">
                                {{ __('footer.escort_girl') }} {{ $canton->nom }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col items-center gap-3 lg:items-start">
                    <h3 class="font-roboto-slab text-sm sm:text-xl font-bold sm:text-3xl lg:text-2xl xl:text-3xl">
                        {{ __('footer.quick_links') }}</h3>
                    <div class="flex flex-col items-center gap-2 lg:items-start">
                        <a href="{{ route('glossaires.index') }}"
                            class="text-gray-300 transition hover:text-white text-xs sm:text-sm">{{ __('footer.glossary') }}</a>
                        <a href="{{ route('faq') }}"
                            class="text-gray-300 transition hover:text-white text-xs sm:text-sm">{{ __('footer.faq') }}</a>
                        <a href="{{ route('about') }}"
                            class="text-gray-300 transition hover:text-white text-xs sm:text-sm">{{ __('footer.about_us') }}</a>
                        <a href="{{ route('static.page', 'cgv') }}"
                            class="text-gray-300 transition hover:text-white text-xs sm:text-sm">{{ __('footer.cgv') }}</a>
                        <a href="{{ route('contact') }}"
                            class="text-gray-300 transition hover:text-white text-xs sm:text-sm">{{ __('footer.contact') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="font-roboto-slab bg-bgCopyRight text-textColor relative z-30 flex items-center justify-center py-4 text-xs text-white transition-all lg:text-base w-[80%] m-auto">
        <p class="text-textColor flex flex-row items-center gap-2">Copyright {{ now()->year }} - <a href="{{ route('home') }}"
                class="text-supaGirlRose mx-2"> Supagirl </a>
            <a href="{{ route('static.page', 'pdc') }}"
                class="text-supaGirlRose mx-2">{{ __('footer.privacy_policy') }}</a> 
            </p>
    </div>
</div>

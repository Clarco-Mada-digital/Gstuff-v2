@php
    $cantons = App\Models\Canton::withCount('users')->orderBy('users_count', 'desc')->get();
@endphp
<div>
    <div class="bg-bgFooter relative z-30 mt-10 min-h-[375px] w-full font-roboto-slab transition-all">
        <div class="container mx-auto flex flex-col items-center justify-center gap-12 px-4 py-16 text-sm text-white sm:px-6 lg:flex-row lg:items-start lg:gap-12 lg:py-20 xl:gap-24 xl:px-8 xl:text-base">
            <div class="flex w-full max-w-xs flex-col items-center gap-4 text-center sm:max-w-md lg:max-w-none lg:items-start lg:text-left">
                <a href="{{ route('home') }}" class="w-full max-w-[240px]">
                    <img class="mx-auto w-full lg:mx-0" src="{{ url('images/logoSupaHead.png') }}" alt="Logo gstuff" />
                </a>
                <p class="text-sm leading-relaxed text-gray-300">{{ __('footer.txt_portal') }}</p>
            </div>

            <div class="grid w-full max-w-xs grid-cols-1 gap-8 sm:max-w-2xl sm:grid-cols-2 lg:max-w-none lg:grid-cols-2 lg:gap-12">
                <div class="flex flex-col items-center gap-3 lg:items-start">
                    <h3 class="font-roboto-slab text-2xl font-bold sm:text-3xl lg:text-2xl xl:text-3xl">{{ __('footer.quick_links') }}</h3>
                    <div class="flex flex-col items-center gap-2 lg:items-start">
                        @foreach ($cantons->slice(0, 5) as $canton)
                            <a href="{{ route('escortes') . '?selectedCanton=' . $canton->id }}" class="text-gray-300 transition hover:text-white">
                                {{ __('footer.escort_girl') }} {{ $canton->nom }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col items-center gap-3 lg:items-start">
                    <h3 class="font-roboto-slab text-2xl font-bold sm:text-3xl lg:text-2xl xl:text-3xl">{{ __('footer.quick_links') }}</h3>
                    <div class="flex flex-col items-center gap-2 lg:items-start">
                        <a href="{{ route('glossaires.index') }}" class="text-gray-300 transition hover:text-white">{{ __('footer.glossary') }}</a>
                        <a href="{{ route('faq') }}" class="text-gray-300 transition hover:text-white">{{ __('footer.faq') }}</a>
                        <a href="{{ route('about') }}" class="text-gray-300 transition hover:text-white">{{ __('footer.about_us') }}</a>
                        <a href="{{ route('static.page', 'cgv') }}" class="text-gray-300 transition hover:text-white">{{ __('footer.cgv') }}</a>
                        <a href="{{ route('contact') }}" class="text-gray-300 transition hover:text-white">{{ __('footer.contact') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="font-roboto-slab relative z-30 flex items-center justify-center bg-bgCopyRight py-7 text-xs text-white transition-all lg:text-base text-textColor">
        <p class="text-textColor">Copyright {{ now()->year }} - <a href="{{ route('home') }}" class="mx-2 text-supaGirlRose"> Supagirl </a>
        <a href="{{ route('static.page', 'pdc') }}" class="mx-2 text-supaGirlRose">{{ __('footer.privacy_policy') }}</a>
    </div>
</div>

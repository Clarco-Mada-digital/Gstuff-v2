<div class="mx-auto flex flex-col items-center justify-center py-5 sm:py-10 md:py-20 lg:container">
    <div class="flex h-[255px] w-full flex-col justify-center gap-5 px-10 text-white lg:w-[1140px] lg:px-20"
        style="background: linear-gradient(90deg, #7F55B1A3 26.45%, #FDA5D647 80%), url('images/girl_deco_contact.jpg') center center/cover">
        <h2 class="font-roboto-slab text-lg sm:text-xl text-3xl font-bold lg:text-5xl">{{ __('call-to-action-contact.contact_us') }}</h2>
        <p class="text-xs sm:text-sm">{{ __('call-to-action-contact.need_info') }}</p>
        <div class="z-10 mt-5">
            <a href="{{ route('contact') }}" type="button"
                class="bg-complementaryColorViolet focus:ring-supaGirlRose/50 group relative flex w-52 transform cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg px-4 py-2 text-center text-sm font-bold text-white transition-all duration-300 hover:scale-[1.02] hover:bg-opacity-90 hover:shadow-lg focus:outline-none focus:ring-4 lg:text-base">
                <span class="relative z-10 flex items-center gap-2 whitespace-nowrap">
                    <span class="relative text-sm">
                        {{ __('call-to-action-contact.write_us') }}
                        <span class="absolute -bottom-0.5 left-0 h-0.5 w-0 bg-white transition-all duration-300 group-hover:w-full"></span>
                    </span>
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" />
                    </svg>
                </span>
                <span class="pointer-events-none absolute inset-0 flex items-center justify-center">
                    <span class="absolute h-0 w-0 rounded-full bg-white opacity-0 transition-all duration-1000 group-hover:h-32 group-hover:w-full group-hover:opacity-10"></span>
                </span>
                <span class="absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <span class="absolute inset-0 rounded-lg border-2 border-white/80 transition-all duration-300"></span>
                </span>
            </a>
        </div>
    </div>
</div>

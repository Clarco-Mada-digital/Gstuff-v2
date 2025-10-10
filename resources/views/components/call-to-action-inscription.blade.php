<div class="relative flex h-[375px] w-full flex-col items-start justify-center"
    style="background: linear-gradient(90deg, rgba(0, 0, 0, 0.8) 0%, rgba(127, 85, 177, 0.4) 100%), url('images/girl_deco_image_001.jpg') center center/cover">
    <div class="container mx-auto flex flex-col gap-4 px-3 text-white lg:px-10">
        <h3 class="font-roboto-slab w-full text-lg sm:text-xl text-2xl font-bold sm:w-[60%] sm:text-3xl lg:w-[40%] lg:text-5xl xl:w-[50%]">
            {{ __('call-to-action-inscription.register_today') }}</h3>
        <span class="font-roboto-slab text-xs sm:text-sm">{{ __('call-to-action-inscription.register_today2') }}</span>
        <div class="w-45 z-10">
            <a href="{{ route('nextStep') }}" type="button"
                class="bg-complementaryColorViolet focus:ring-supaGirlRose/50 group relative flex transform cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg px-4 py-2 text-center text-xs sm:text-sm font-bold text-white transition-all duration-300 hover:scale-105 hover:bg-opacity-90 hover:shadow-lg focus:outline-none focus:ring-4">
                <span class="relative z-10 flex items-center gap-2 whitespace-nowrap">
                    <span class="relative text-xs xl:text-sm">
                        {{ __('call-to-action-inscription.sign_up') }}
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

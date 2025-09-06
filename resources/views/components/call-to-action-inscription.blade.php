<div class="relative flex h-[375px] w-full flex-col items-start justify-center"
    style="background: linear-gradient(90deg, rgba(0, 0, 0, 0.8) 0%, rgba(127, 85, 177, 0.4) 100%), url('images/girl_deco_image_001.jpg') center center/cover">
    <div class="container mx-auto flex flex-col gap-4 px-3 text-white lg:px-10">
        <h3 class="font-roboto-slab w-full text-2xl font-bold sm:w-[60%] sm:text-3xl lg:w-[40%] lg:text-5xl xl:w-[50%]">
            {{ __('call-to-action-inscription.register_today') }}</h3>
        <span class="font-roboto-slab">{{ __('call-to-action-inscription.register_today2') }}</span>
        <div class="w-45 z-10">
            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button"
                class="bg-complementaryColorViolet focus:ring-supaGirlRose/50 group relative flex transform cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg px-4 py-2 text-center text-sm font-bold text-white transition-all duration-300 hover:scale-105 hover:bg-opacity-90 hover:shadow-lg focus:outline-none focus:ring-4">
                {{ __('call-to-action-inscription.sign_up') }}
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" />
                </svg>
            </button>
        </div>
    </div>
</div>

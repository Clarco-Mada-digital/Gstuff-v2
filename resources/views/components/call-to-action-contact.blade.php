{{-- Nou contactez --}}
<div class="mx-auto flex flex-col items-center justify-center gap-10 py-20 lg:container">
    <div class="flex h-[255px] w-full flex-col justify-center gap-5 px-10 text-white lg:w-[1140px] lg:px-20"
        style="background: linear-gradient(90deg, #7F55B1A3 26.45%, #FDA5D647 80%), url('images/girl_deco_contact.jpg') center center/cover">
        <h2 class="font-roboto-slab text-3xl font-bold lg:text-5xl">{{ __('call-to-action-contact.contact_us') }}</h2>
        <p>{{ __('call-to-action-contact.need_info') }}</p>
        <div class="z-10 mt-5">
            <a href="{{ route('contact') }}" type="button"
                class="bg-complementaryColorViolet focus:ring-supaGirlRose/50 group relative flex w-52 transform cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg px-4 py-2 text-center text-sm font-bold text-white transition-all duration-300 hover:scale-105 hover:bg-opacity-90 hover:shadow-lg focus:outline-none focus:ring-4 lg:text-base">{{ __('call-to-action-contact.write_us') }}
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" />
                </svg>
            </a>
        </div>
    </div>
</div>

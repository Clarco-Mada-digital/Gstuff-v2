@props([
    'href' => '#',
    'text' => '',
])

<a href="{{ $href }}" type="button"
    class="bg-complementaryColorViolet focus:ring-supaGirlRose/50 group relative flex transform cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg px-3 py-2 xl:px-5 xl:py-2.5 text-center text-sm font-bold text-white transition-all duration-300 hover:scale-[1.02] hover:bg-opacity-90 hover:shadow-lg focus:outline-none focus:ring-4">
    <span class="relative z-10 flex items-center gap-2 whitespace-nowrap">
        <span class="relative text-xs xl:text-sm">
            {!! $text !!}
            <span
                class="absolute -bottom-0.5 left-0 h-0.5 w-0 bg-white transition-all duration-300 group-hover:w-full"></span>
        </span>
        <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
            <path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" />
        </svg>
    </span>

    <span class="pointer-events-none absolute inset-0 flex items-center justify-center">
        <span
            class="absolute h-0 w-0 rounded-full bg-white opacity-0 transition-all duration-150 group-hover:h-64 group-hover:w-64 group-hover:opacity-10"></span>
    </span>

    <span class="absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
        <span class="absolute inset-0 rounded-lg border-2 border-white/80 transition-all duration-300"></span>
    </span>
</a>

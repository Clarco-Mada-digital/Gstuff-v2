@props([
    'href' => '#',
    'text' => "",
])


<a href="{{ $href }}" type="button"
                class="cursor-pointer group relative overflow-hidden bg-complementaryColorViolet flex items-center justify-center gap-2 rounded-lg px-4 py-2 text-center text-sm font-bold text-white focus:outline-none focus:ring-4 focus:ring-supaGirlRose/50 hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                <span class="relative z-10 flex items-center gap-2">
                    {{ $text }}
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="m8.006 21.308l-1.064-1.064L15.187 12L6.942 3.756l1.064-1.064L17.314 12z" />
                    </svg>
                </span>
                <span class="absolute inset-0 flex items-center justify-center">
                    <span class="absolute h-0 w-0 rounded-full bg-white opacity-0 transition-all duration-700 group-hover:h-32 group-hover:w-32 group-hover:opacity-10"></span>
                </span>
                <span class="absolute inset-0 animate-pulse opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <span class="absolute inset-0 rounded-lg border-2 border-white opacity-0 group-hover:opacity-100 transition-all duration-300"></span>
                </span>
            </a>
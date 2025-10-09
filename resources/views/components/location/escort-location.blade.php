@props([
    'cantonId' => null,
    'cantonName' => null,
    'cityName' => null,
    'class' => '',
])
@if ($cantonId)
    <div
        class="text-green-gs font-roboto-slab {{ $class }} hover:text-green-gs flex flex-wrap items-center justify-center gap-2">
        @if ($cantonId && $cantonName)
            <a href="{{ route('escortes') }}?selectedCanton={{ $cantonId }}"
                class="flex items-center gap-1 hover:underline text-xs md:text-sm">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="none">
                    <path
                        d="M4 13.2864C2.14864 14.1031 1 15.2412 1 16.5C1 18.9853 5.47715 21 11 21C16.5228 21 21 18.9853 21 16.5C21 15.2412 19.8514 14.1031 18 13.2864M17 7C17 11.0637 12.5 13 11 16C9.5 13 5 11.0637 5 7C5 3.68629 7.68629 1 11 1C14.3137 1 17 3.68629 17 7ZM12 7C12 7.55228 11.5523 8 11 8C10.4477 8 10 7.55228 10 7C10 6.44772 10.4477 6 11 6C11.5523 6 12 6.44772 12 7Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
                {{ $cantonName }}
            </a>
        @endif

        @if ($cityName)
            <span class="text-green-gs flex items-center gap-1 text-xs md:text-sm">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M5 12h.5m3 0H10m3 0h6m-6 6l6-6m-6-6l6 6" />
                </svg>
                {{ $cityName }}
            </span>
        @endif
    </div>
@endif

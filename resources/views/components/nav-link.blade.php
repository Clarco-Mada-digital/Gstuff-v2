@props([
    'href' => '#',
    'active' => false,
    'icon' => null,
])

<a href="{{ $href }}"
    {{ $attributes->merge(['class' => 'font-roboto-slab flex w-full items-center hover:text-complementaryColorViolet justify-between rounded-sm px-3 py-2 text-textColor hover:bg-gray-100 xl:w-auto xl:border-0 xl:p-0 xl:hover:bg-transparent xl:hover:text-complementaryColorViolet transition-colors duration-200' . ($active ? ' text-complementaryColorViolet' : '')]) }}
    @if (isset($dropdown) && $dropdown) data-dropdown-toggle="{{ $dropdown }}" 
       data-dropdown-trigger="hover" 
       data-dropdown-offset-distance="25" @endif>
    {{ $slot }}

    @if (isset($dropdown) && $dropdown)
        <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
        </svg>
    @endif
</a>

@props([
    'name' => null,
    'class' => '',
])

@if ($name)
    @switch($name)
        @case('chevron-down')
            <svg {{ $attributes->merge(['class' => 'h-5 w-5 ' . $class]) }} fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        @break

        {{-- Ajoutez d'autres icônes ici au besoin --}}

        @default
            <span class="{{ $class }} inline-block">
                {{ $name }}
            </span>
    @endswitch
@else
    {{ $slot ?? '' }}
@endif

@props([
    'icon' => null,
    'label' => null,
    'value' => null,
    'iconColor' => 'supaGirlRose',
    'iconViewBox' => '0 0 24 24',
    'iconPath' => '',
])

<span class="font-roboto-slab flex items-center gap-3">
    <span class="bg-{{ $iconColor }}/10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full">
        @if ($icon)
            {!! $icon !!}
        @else
            <svg class="text-{{ $iconColor }} h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="{{ $iconViewBox }}">
                @if (isset($iconPath) && !empty($iconPath))
                    <path fill="currentColor" d="{!! $iconPath !!}" />
                @endif
            </svg>
        @endif
    </span>
    <span class="text-textColor">
        {{ $value ?? $slot }}
    </span>
</span>

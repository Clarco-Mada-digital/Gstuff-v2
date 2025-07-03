@props([
    'icon' => null,
    'label' => null,
    'value' => null,
    'iconColor' => 'supaGirlRose',
    'iconViewBox' => '0 0 24 24',
    'iconPath' => ''
])

<span class="flex items-center gap-3 font-roboto-slab">
    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-{{ $iconColor }}/10">
        @if($icon)
            {!! $icon !!}
        @else
            <svg class="h-5 w-5 text-{{ $iconColor }}" xmlns="http://www.w3.org/2000/svg" viewBox="{{ $iconViewBox }}">
                @if(isset($iconPath) && !empty($iconPath))
                    <path fill="currentColor" d="{!! $iconPath !!}" />
                @endif
            </svg>
        @endif
    </span>
    <span class="text-textColor">
        {{ $value ?? $slot }}
    </span>
</span>

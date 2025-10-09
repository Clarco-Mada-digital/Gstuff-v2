@props([
    'text' => '',
    'color' => 'green-gs',
    'hoverColor' => 'fieldBg',
    'borderColor' => 'supaGirlRose',
    'bgColor' => 'fieldBg',
    'textHoverColor' => 'fieldBg',
])

<span
    {{ $attributes->merge([
        'class' => "font-roboto-slab border-{$borderColor} bg-{$bgColor} text-{$color} hover:bg-{$color} hover:text-{$textHoverColor} rounded-lg border md:px-3 px-2 py-1 transition-colors duration-200 text-xs md:text-sm",
    ]) }}>
    {{ $text }}
</span>

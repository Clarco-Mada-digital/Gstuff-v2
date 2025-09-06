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
        'class' => "font-roboto-slab border-{$borderColor} bg-{$bgColor} text-{$color} hover:bg-{$color} hover:text-{$textHoverColor} rounded-lg border px-3 py-1 transition-colors duration-200",
    ]) }}>
    {{ $text }}
</span>

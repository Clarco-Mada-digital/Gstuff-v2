@props([
    'href' => '#',
    'color' => 'complementaryColorViolet',
    'borderColor' => 'supaGirlRose',
    'bgColor' => 'fieldBg',
    'hoverBgColor' => 'complementaryColorViolet',
    'hoverTextColor' => 'white',
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'text-xs px-2 py-1',
        'md' => 'text-sm px-3 py-2',
        'lg' => 'text-base px-4 py-3',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
    // Gestion des couleurs dynamiques
    $textColor = ($color === 'complementaryColorViolet') ? 'text-complementaryColorViolet' : "text-{$color}";
    $hoverBg = ($hoverBgColor === 'complementaryColorViolet') ? 'hover:bg-complementaryColorViolet' : "hover:bg-{$hoverBgColor}";
    $border = ($borderColor === 'supaGirlRose') ? 'border-supaGirlRose' : "border-{$borderColor}";
    $hoverBorder = ($color === 'complementaryColorViolet') ? 'hover:border-complementaryColorViolet' : "hover:border-{$color}";
    $hoverText = ($hoverTextColor === 'white') ? 'hover:text-white' : "hover:text-{$hoverTextColor}";
    $shadow = ($color === 'complementaryColorViolet') ? 'hover:shadow-complementaryColorViolet/20' : "hover:shadow-{$color}/20";
    
    $classes = "relative overflow-hidden rounded-lg border {$border} bg-{$bgColor} font-roboto-slab {$textColor} transition-all duration-300 hover:scale-105 {$hoverBorder} {$hoverBg} {$hoverText} hover:shadow-lg {$shadow} {$sizeClass}";
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => $classes]) }}>
    <span class="relative z-10">{{ $slot }}</span>
    <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></span>
</a>

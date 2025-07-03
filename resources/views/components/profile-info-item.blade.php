@props([
    'icon',
    'alt',
    'label',
    'value',
    'suffix' => '',
    'translationPath' => null,
    'translationAttribute' => 'name',
])

@php
    $displayValue = $value;
    
    if ($value && $translationPath) {
        try {
            $displayValue = $value->getTranslation($translationAttribute, app()->getLocale());
        } catch (\Exception $e) {
            $displayValue = $value->{$translationAttribute} ?? '-';
        }
    }
    
    $displayValue = $displayValue ?: '-';
    $displayValue = $suffix ? trim("$displayValue $suffix") : $displayValue;
@endphp

<div class="font-roboto-slab flex w-full items-center gap-3 text-textColor">
    <img 
        src="{{ asset('images/icons/' . $icon) }}" 
        alt="{{ $alt }}" 
        class="w-8 h-8"
    />
    <span class="font-roboto-slab text-sm text-textColor">{{ $label }} : {{ $displayValue }}</span>
</div>

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

<div class="font-dm-serif flex w-full items-center gap-3">
    <img 
        src="{{ asset('images/icons/' . $icon) }}" 
        alt="{{ $alt }}" 
    />
    <span>{{ $label }} : {{ $displayValue }}</span>
</div>

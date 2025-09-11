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
@if ($value)
    <div class="font-roboto-slab text-textColor flex w-full items-center gap-3">
        <img src="{{ asset('images/icons/' . $icon) }}" alt="{{ $alt }}" class="md:h-8 md:w-8 h-6 w-6" />
        <span class="font-roboto-slab text-textColor text-xs md:text-sm">{{ $label }} : {{ $displayValue }}</span>
    </div>
@endif

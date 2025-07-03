@props([
    'name',
    'label',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'autocomplete' => null,
    'error' => null,
    'errorMessage' => null,
    'placeholder' => null,
])

<div class="flex flex-col gap-2">
    <label for="{{ $name }}" class="font-roboto-slab text-green-gs text-sm font-bold">{{ $label }} @if($required) <span class="text-red-500">*</span>@endif</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'text-sm text-textColorParagraph rounded-lg border border-supaGirlRose border-2 ring-0 focus:border-supaGirlRose focus:ring-supaGirlRose ' . ($error ? 'border-red-500 focus:border-red-500' : '')]) }}
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($required) required @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
    >
    @if($error && $errorMessage)
        <p class="mt-2 text-sm text-red-600 font-roboto-slab">
            <span class="font-medium">{{ __('about.oops') }}</span> {{ $errorMessage }}
        </p>
    @endif
</div>

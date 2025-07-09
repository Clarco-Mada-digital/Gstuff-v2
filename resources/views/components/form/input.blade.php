@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'required' => false,
    'placeholder' => null,
    'containerClass' => 'mb-4',
    'inputClass' => '',
    'labelClass' => 'block text-sm font-roboto-slab text-green-gs',
    'inputBaseClass' => 'mt-1 block w-full rounded-md border border-gray-300 font-roboto-slab shadow-sm focus:border-green-gs focus:ring-green-gs',
])

<div class="{{ $containerClass }}">
    @if($label)
        <label for="{{ $name }}" class="{{ $labelClass }}">
            {{ $label }}
         
        </label>
    @endif
    
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => $inputBaseClass . ' ' . $inputClass]) }}
    >
    
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

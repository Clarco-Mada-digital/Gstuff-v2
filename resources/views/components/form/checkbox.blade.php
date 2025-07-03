@props([
    'name',
    'label',
    'required' => false,
    'checked' => false,
])

<div class="flex flex-col gap-2">
    <div class="flex items-center gap-1">
        <input 
            type="checkbox" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            {{ $attributes->merge(['class' => 'rounded border-gray-300 text-green-gs focus:ring-green-gs']) }}
            @if($required) required @endif
            @if($checked) checked @endif
        >
        <label for="{{ $name }}">{{ $label }}</label>
    </div>
</div>

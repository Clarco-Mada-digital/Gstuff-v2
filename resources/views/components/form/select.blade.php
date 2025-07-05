@props([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'required' => false,
    'containerClass' => 'mb-4',
    'selectClass' => '',
    'labelClass' => 'block text-sm font-roboto-slab text-green-gs',
    'selectBaseClass' => 'mt-1 block w-full rounded-md text-textColorParagraph border border-supaGirlRosePastel/50 font-roboto-slab shadow-sm focus:border-supaGirlRosePastel/50 focus:ring-supaGirlRosePastel/50',
])

<div class="{{ $containerClass }}">
    @if($label)
        <label for="{{ $name }}" class="{{ $labelClass }}">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => $selectBaseClass . ' ' . $selectClass]) }}
    >
        {{ $slot }}
        
        @foreach($options as $key => $option)
            <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>
    
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

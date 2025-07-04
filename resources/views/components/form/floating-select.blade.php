@props([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'required' => false,
    'placeholder' => '---',
    'optionValue' => 'id',
    'optionLabel' => 'name',
    'translate' => false,
])

<div class="group relative z-0 mb-5 w-full">
    <select 
        name="{{ $name }}" 
        id="floating_{{ $name }}"
        class="font-roboto-slab focus:border-supaGirlRose border-green-gs @error($name) border-red-500 @enderror
               peer block w-full appearance-none border-0 border-b-2 bg-transparent px-2 py-2.5 text-sm text-green-gs 
               focus:outline-none focus:ring-0"
        @if($required) required @endif
    >
        <option value="" disabled {{ !$selected ? 'selected' : '' }}>{{ $placeholder }}</option>
        @foreach($options as $value => $option)
            @if(is_object($option))
                <option value="{{ $option->{$optionValue} }}" {{ $selected == $option->{$optionValue} ? 'selected' : '' }}>
                    {{ $translate ? $option->getTranslation($optionLabel, app()->getLocale()) : $option->{$optionLabel} }}
                </option>
            @else
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endif
        @endforeach
    </select>
    <label 
        for="floating_{{ $name }}"
        class="peer-focus:text-green-gs font-roboto-slab @error($name) text-red-700 peer-focus:text-red-700 @enderror 
               absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm text-green-gs duration-300 
               peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 
               peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto 
               rtl:peer-focus:translate-x-1/4"
    >
        {{ $label }}@if($required) * @endif
    </label>
    @error($name)
        <p class="mt-2 text-sm text-red-600">
            <span class="font-medium">{{ __('escort_register_form.oops') }}</span> {{ $message }}
        </p>
    @enderror
</div>

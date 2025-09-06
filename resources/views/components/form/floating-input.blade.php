@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'autocomplete' => null])

<div class="group relative z-0 mb-5 w-full">
    <input type="{{ $type }}" name="{{ $name }}" id="floating_{{ $name }}"
        class="font-roboto-slab focus:border-supaGirlRose @error($name) border-red-500 @enderror border-green-gs peer block w-full appearance-none border-0 border-b-2 bg-transparent px-0 py-2.5 text-sm text-gray-900 focus:outline-none focus:ring-0"
        placeholder=" " value="{{ old($name, $value) }}"
        @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if ($required) required @endif />
    <label for="floating_{{ $name }}"
        class="peer-focus:text-green-gs @error($name) text-red-700 peer-focus:text-red-700 @enderror text-green-gs absolute top-3 -z-10 origin-[0] -translate-y-6 scale-75 transform text-sm duration-300 peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100 peer-focus:start-0 peer-focus:-translate-y-6 peer-focus:scale-75 peer-focus:font-medium rtl:peer-focus:left-auto rtl:peer-focus:translate-x-1/4">
        {{ $label }}@if ($required)
            *
        @endif
    </label>
    @error($name)
        <p class="mt-2 text-sm text-red-600">
            <span class="font-medium">{{ __('escort_register_form.oops') }}</span> {{ $message }}
        </p>
    @enderror
</div>

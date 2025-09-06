@props([
    'name' => 'terms_accepted',
    'label' => '',
    'termsText' => '',
    'termsLinkText' => '',
    'termsLink' => '#',
    'required' => true,
    'checked' => false,
    'error' => null,
])

<div class="mb-5">
    <div class="font-roboto-slab mb-3 text-sm">
        {{ $termsText }}<br>
        {{ $slot }}
        @if ($termsLinkText)
            <a class="font-roboto-slab text-green-gs text-sm hover:underline" href="{{ $termsLink }}">
                {{ $termsLinkText }}
            </a>
        @endif
    </div>

    <div class="flex items-start">
        <div class="flex h-5 items-center">
            <input id="{{ $name }}" name="{{ $name }}" type="checkbox"
                class="focus:ring-3 focus:ring-green-gs h-4 w-4 rounded-sm border border-gray-300 bg-gray-50"
                {{ $checked ? 'checked' : '' }} @if ($required) required @endif />
        </div>
        <label for="{{ $name }}"
            class="text-textColorParagraph font-roboto-slab @if ($error) text-red-300 @endif ms-2 text-sm font-medium">
            {{ $label }}
        </label>
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600">
            <span class="font-medium">{{ __('escort_register_form.oops') }}</span> {{ $message }}
        </p>
    @enderror
</div>

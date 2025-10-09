@props(['value' => ''])

<div class="mb-4">
    <label class="font-roboto-slab text-green-gs block text-sm">{{ __('profile.address') }}</label>
    <input type="text" name="adresse"
        {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-md text-textColorParagraph border-supaGirlRosePastel/50 font-roboto-slab shadow-sm focus:border-green-gs focus:ring-green-gs']) }}
        value="{{ $value }}">
</div>

@props([
    'villes' => [],
    'selectedVille' => null,
    'class' => '',
    'id' => 'ville-search',
    'label' => null,
    'disabled' => false,
])

<div class="{{ $class }}">
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-green-gs mb-1">
            {{ $label }}
        </label>
    @endif
    <select 
        wire:model.live="selectedVille" 
        id="{{ $id }}" 
        {{ $disabled || ($villes && $villes->isEmpty()) ? 'disabled' : '' }}
        class="block w-full rounded-lg border border-2 border-supaGirlRose bg-gray-50 px-3 py-2 text-green-gs font-roboto-slab focus:border-supaGirlRose/50 focus:ring-supaGirlRose/50 focus:border-transparent"
    >
        <option value="">{{ $villes->isEmpty() ? __('user-search.choose_canton') : __('user-search.cities') }}</option>
        @foreach ($villes as $ville)
            <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
        @endforeach
    </select>
</div>

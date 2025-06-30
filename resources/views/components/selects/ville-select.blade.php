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
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
        </label>
    @endif
    <select 
        wire:model.live="selectedVille" 
        id="{{ $id }}" 
        {{ $disabled || ($villes && $villes->isEmpty()) ? 'disabled' : '' }}
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
    >
        <option value="">{{ $villes->isEmpty() ? __('user-search.choose_canton') : __('user-search.cities') }}</option>
        @foreach ($villes as $ville)
            <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
        @endforeach
    </select>
</div>

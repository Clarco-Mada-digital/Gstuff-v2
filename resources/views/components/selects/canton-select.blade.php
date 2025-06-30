@props([
    'cantons' => [],
    'selectedCanton' => null,
    'chargeVille' => null,
    'class' => '',
    'id' => 'canton-search',
    'label' => null,
])

<div class=" {{ $class }}">
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
        </label>
    @endif
    <select 
        wire:model.live="selectedCanton" 
        wire:change="{{ $chargeVille }}"
        id="{{ $id }}" 
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
    >
        <option value="">{{ __('user-search.cantons') }}</option>
        @foreach ($cantons as $canton)
            <option value="{{ $canton->id }}">{{ $canton->nom }}</option>
        @endforeach
    </select>
</div>

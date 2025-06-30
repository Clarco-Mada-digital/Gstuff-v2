@props([
    'genres' => [],
    'selectedGenre' => null,
    'class' => '',
    'id' => 'genre-search',
    'label' => null,
    'optional' => true,
])

<div class="{{ $class }}">
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
        </label>
    @endif
    <select 
        wire:model.live="selectedGenre" 
        id="{{ $id }}" 
        class="block w-full overflow-hidden truncate rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
    >
        @if($optional)
            <option value="">{{ __('user-search.gender') }}</option>
        @endif
        @foreach ($genres as $genre)
            <option value="{{ $genre->id }}">{{ $genre->getTranslation('name', app()->getLocale()) }}</option>
        @endforeach
    </select>
</div>

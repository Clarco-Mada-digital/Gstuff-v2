@props([
    'villes' => [],
    'selectedVille' => null,
    'class' => '',
    'id' => 'escort-ville-selector',
    'label' => null,
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
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 xl:w-80 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        @if(!$villes || $villes->isEmpty()) disabled @endif
    >
        <option value="">
            @if($villes && $villes->isNotEmpty())
                {{ __('salon-search.villes') }}
            @else
                {{ __('salon-search.select_canton') }}
            @endif
        </option>
        @if(is_iterable($villes))
            @foreach($villes as $ville)
                <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
            @endforeach
        @endif
    </select>
</div>

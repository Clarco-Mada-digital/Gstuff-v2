@props([
    'cantons' => [],
    'villes' => [],
    'selectedCanton' => null,
    'selectedVille' => null,
    'onCantonChange' => 'chargeVille',
    'cantonModel' => 'selectedSalonCanton',
    'villeModel' => 'selectedSalonVille'
])

<div class="flex w-full flex-col items-center justify-center space-y-4 px-4 text-sm sm:flex-row sm:space-x-4 sm:space-y-0">
    <!-- Canton Selector -->
    <div class="w-full min-w-[200px] max-w-xs">
        <select 
            wire:model.live="{{ $cantonModel }}" 
            wire:change="{{ $onCantonChange }}"
            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        >
            <option value="">{{ __('salon-search.cantons') }}</option>
            @foreach ($cantons as $canton)
                <option wire:key='{{ $canton->id }}' value="{{ $canton->id }}">{{ $canton->nom }}</option>
            @endforeach
        </select>
    </div>

    <!-- City Selector -->
    <div class="w-full min-w-[200px] max-w-xs">
        <select 
            wire:model.live="{{ $villeModel }}"
            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
            @if (!$villes) disabled @endif
        >
            <option value="">
                @if ($villes)
                    {{ __('salon-search.villes') }}
                @else
                    {{ __('salon-search.select_canton') }}
                @endif
            </option>
            @if (is_iterable($villes))
                @foreach ($villes as $ville)
                    <option wire:key='{{ $ville->id }}' value="{{ $ville->id }}">{{ $ville->nom }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>

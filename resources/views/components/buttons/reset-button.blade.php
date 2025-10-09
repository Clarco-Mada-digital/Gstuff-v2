@props([
    'loadingText' => null,
    'loadingTarget' => null,
    'class' => '',
    'size' => 'md',
    'variant' => 'default',
    'translation' => 'escort-search.reset_filters',
    'loadingTranslation' => 'escort-search.resetting',
])

@php
    $sizes = [
        'sm' => 'text-sm px-3 py-1.5',
        'md' => 'text-base px-4 py-2',
        'lg' => 'text-lg px-6 py-3',
    ][$size];

    $variants = [
        'default' => 'border-gray-400 bg-white text-gray-600 hover:bg-green-gs hover:text-white',
        'primary' => 'border-transparent bg-blue-600 text-white hover:bg-blue-700',
        'danger' => 'border-transparent bg-red-600 text-white hover:bg-red-700',
    ][$variant];

    $baseClasses =
        'font-roboto-slab group flex items-center justify-center gap-2 rounded-lg text-green-gs border border-2 border-supaGirlRose transition-colors duration-200';
    $buttonClasses = "$baseClasses $sizes $variants $class";

    $loadingText = $loadingText ?? __($loadingTranslation);
@endphp

<button {{ $attributes->merge(['class' => $buttonClasses]) }} wire:loading.attr="disabled">
    <span wire:loading.remove wire:target="{{ $loadingTarget }}" class="text-xs lg:text-sm">
        {{ __($translation) }}
    </span>
    <span wire:loading wire:target="{{ $loadingTarget }}" class="flex items-center text-xs lg:text-sm">
        {{ $loadingText }}
    </span>

    <span wire:loading.remove wire:target="{{ $loadingTarget }}" class="text-xs md:text-sm">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
            <path fill="currentColor"
                d="M22.448 21A10.86 10.86 0 0 0 25 14A10.99 10.99 0 0 0 6 6.466V2H4v8h8V8H7.332a8.977 8.977 0 1 1-2.1 8h-2.04A11.01 11.01 0 0 0 14 25a10.86 10.86 0 0 0 7-2.552L28.586 30L30 28.586Z" />
        </svg>
    </span>
    <span wire:loading wire:target="{{ $loadingTarget }}" class="ml-2 text-xs md:text-sm">
        <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
    </span>
</button>

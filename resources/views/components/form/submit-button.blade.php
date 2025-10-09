@props(['text', 'class' => ''])

<button type="submit" x-data="{ loading: false }" @submit="loading = true"
    {{ $attributes->merge([
        'class' =>
            'font-roboto-slab text-xs md:text-sm bg-green-gs hover:bg-green-gs/80 cursor-pointer rounded-lg p-2 text-center text-white transition-colors duration-200 flex items-center justify-center gap-2 ' .
            $class,
    ]) }}
    :disabled="loading" x-bind:disabled="loading">
    <span x-show="!loading">{{ $text }}</span>
    <div x-show="loading" class="h-5 w-5 animate-spin rounded-full border-b-2 border-white"></div>
</button>

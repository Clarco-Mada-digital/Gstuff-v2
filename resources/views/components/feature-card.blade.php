@props(['icon', 'title', 'description'])

<div
    class="group flex w-full flex-col items-center justify-center gap-5 text-wrap rounded-lg p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg xl:w-1/3">
    <div class="transition-transform duration-300 group-hover:scale-110">
        <img src="{{ $icon }}" alt="{{ $title }}"
            class="transition-transform duration-300 group-hover:scale-110" />
    </div>
    <h3 class="font-roboto-slab text-green-gs group-hover:text-supaGirlRose text-2xl transition-colors duration-300">
        {{ $title }}</h3>
    <span
        class="font-roboto-slab text-sm transition-colors duration-300 group-hover:text-gray-600">{{ $description }}</span>
</div>

@props([
    'categories' => [],
    'selectedCategories' => [],
    'class' => '',
    'id' => 'category-escort-' . uniqid(),
    'label' => null,
])

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(0.98);
        }
    }

    .category-item {
        animation: fadeInUp 0.3s ease-out forwards;
        opacity: 0;
    }

    .category-item:nth-child(1) {
        animation-delay: 0.05s;
    }

    .category-item:nth-child(2) {
        animation-delay: 0.1s;
    }

    .category-item:nth-child(3) {
        animation-delay: 0.15s;
    }

    .category-item:nth-child(4) {
        animation-delay: 0.2s;
    }

    .category-item:nth-child(5) {
        animation-delay: 0.25s;
    }

    .category-item:nth-child(n+6) {
        animation-delay: 0.3s;
    }
</style>

<div class="{{ $class }} mx-4 my-3 flex flex-wrap items-center justify-center gap-2 sm:gap-3 md:my-4">
    @if ($label)
        <div class="mb-2 w-full">
            <label class="text-green-gs font-roboto-slab block text-sm font-medium">
                {{ $label }}
            </label>
        </div>
    @endif

    @foreach ($categories as $index => $categorie)
        <div class="category-item min-w-[120px] flex-1 sm:min-w-[140px] sm:flex-none"
            style="animation-delay: {{ min($index * 0.05, 0.3) }}s">
            <input wire:model.live="selectedCategories" class="peer hidden" type="checkbox"
                id="{{ $id }}-{{ $categorie->id }}" name="{{ $categorie->nom }}" value="{{ $categorie->id }}">
            <label for="{{ $id }}-{{ $categorie->id }}"
                class="hover:bg-green-gs peer-checked:bg-green-gs border-supaGirlRose focus:ring-supaGirlRose text-green-gs font-roboto-slab block w-full cursor-pointer rounded-lg border-2 bg-white p-2 text-center text-xs font-bold transition-all duration-200 hover:scale-[1.02] hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 peer-checked:animate-bounce peer-checked:text-white sm:text-sm md:text-base">
                {{ $categorie->nom }}
            </label>
        </div>
    @endforeach
</div>

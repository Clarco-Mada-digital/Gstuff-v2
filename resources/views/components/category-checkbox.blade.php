@props([
    'categories' => [],
    'selectedValue' => '',
    'model' => '',
    'color' => 'amber',
    'hoverColor' => 'green-gs',
    'prefixId' => 'category',
    'nameField' => 'nom',
    'valueField' => 'id',
    'labelField' => 'nom',
])

@push('scripts')
    <script>
        function toggleCategory(radio) {
            const labels = document.querySelectorAll('.category-label');
            labels.forEach(label => {
                label.classList.remove('peer-checked:bg-' + radio.dataset.hoverColor, 'peer-checked:text-white');
                label.classList.add('bg-white');
            });

            const label = radio.nextElementSibling;
            label.classList.add('peer-checked:bg-' + radio.dataset.hoverColor, 'peer-checked:text-white');
            label.classList.remove('bg-white');
        }
    </script>
@endpush

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

@php
    $baseClasses =
        'category-label border-2 hover:bg-' .
        $hoverColor .
        ' peer-checked:bg-' .
        $hoverColor .
        ' block w-full cursor-pointer sm:rounded-lg rounded-sm border-supaGirlRose bg-white sm:p-2 p-1 text-center text-xs font-bold transition-all duration-200 hover:text-white hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-supaGirlRose focus:ring-offset-2 peer-checked:text-white peer-checked:animate-bounce text-xs sm:text-xs md:text-base text-green-gs font-roboto-slab';
@endphp

<div class="mx-4 my-3 flex flex-wrap items-center justify-center gap-2 sm:gap-3">
    @foreach ($categories as $index => $category)
        @php
            $categoryId = $prefixId . '-' . $category->{$valueField};
            $categoryName = $category->{$nameField};
            $categoryValue = $category->{$valueField};
            $categoryLabel = $category->{$labelField};
            $isChecked = $categoryValue == $selectedValue;
        @endphp

        <div class="category-item min-w-[120px] flex-1 sm:min-w-[140px] sm:flex-none"
            style="animation-delay: {{ min($index * 0.05, 0.3) }}s">
            <input
                @if ($prefixId === 'escort') type="checkbox"
            @else
                type="radio" @endif
                id="{{ $categoryId }}" name="{{ $model }}" value="{{ $categoryValue }}" class="peer hidden"
                wire:model.live="{{ $model }}" wire:loading.attr="disabled" wire:target="{{ $model }}"
                onclick="toggleCategory(this)" data-color="{{ $color }}" data-hover-color="{{ $hoverColor }}"
                {{ $isChecked ? 'checked' : '' }}>
            <label for="{{ $categoryId }}" class="{{ $baseClasses }} truncate">
                {{ $categoryLabel }}
            </label>
        </div>
    @endforeach
</div>

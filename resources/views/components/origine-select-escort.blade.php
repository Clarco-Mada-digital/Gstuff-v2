@props([
    'origineData' => [],
])

<div id="origine-switch-wrapper">
    <h3 class="text-sm font-semibold mb-2 text-green-gs">{{ __('escort-search.origin') }}</h3>

    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
        @foreach ($origineData as $index => $origine)
            @php
                $inputId = 'switch-category-' . $index;
                $isHidden = $index >= 6 ? 'hidden hidden-origine' : '';
            @endphp

            <label for="{{ $inputId }}" class="flex items-center gap-2 cursor-pointer {{ $isHidden }}">
                <div class="relative">
                    <input type="checkbox"
                        id="{{ $inputId }}"
                        class="sr-only peer"
                        wire:model.live="selectedOrigine"
                        name="selectedOrigine[]"
                        value="{{ $origine }}"
                    />

                    <!-- Track -->
                    <div class="w-5 h-3 bg-gray-300 rounded-full peer-checked:bg-supaGirlRose transition-colors"></div>

                    <!-- Thumb -->
                    <div class="absolute top-0.5 left-0.5 w-2 h-2 bg-white rounded-full transition-transform peer-checked:translate-x-2"></div>
                </div>
                <span class="text-xs text-green-gs">{{ $origine }}</span>
            </label>
        @endforeach
    </div>

    @if (count($origineData) > 6)
        <div class="mt-2">
            <button type="button" id="toggle-origine" class="flex items-center gap-1 text-xs text-gray-500 hover:underline focus:outline-none">
                <svg id="toggle-icon" class="w-3 h-3 text-supaGirlRose transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path id="toggle-icon-path" stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
                <span id="toggle-label" class="text-supaGirlRose">{{ __('escort-search.showMore') }}</span>
            </button>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggle-origine');
    const toggleLabel = document.getElementById('toggle-label');
    const toggleIconPath = document.getElementById('toggle-icon-path');
    const hiddenItems = document.querySelectorAll('#origine-switch-wrapper .hidden-origine');
    let expanded = false;

    toggleBtn?.addEventListener('click', () => {
        expanded = !expanded;
        hiddenItems.forEach(item => {
            item.classList.toggle('hidden', !expanded);
        });

        toggleLabel.textContent = expanded ? '{{ __('escort-search.showLess') }}' : '{{ __('escort-search.showMore') }}';
        toggleIconPath.setAttribute('d', expanded ? 'M19 15l-7-7-7 7' : 'M19 9l-7 7-7-7'); // haut ou bas
    });
});
</script>

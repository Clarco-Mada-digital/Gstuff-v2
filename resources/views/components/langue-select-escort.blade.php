@props([
    'langueData' => [],
])

<div id="langue-switch-wrapper">
    <h3 class="text-sm font-semibold mb-2 text-green-gs">{{ __('escort-search.language') }}</h3>

    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
        @foreach ($langueData as $index => $langue)
            @php
                $inputId = 'switch-langue-' . $index;
                $isHidden = $index >= 6 ? 'hidden hidden-langue' : '';
            @endphp

            <label for="{{ $inputId }}" class="flex items-center gap-2 cursor-pointer {{ $isHidden }}">
                <div class="relative">
                    <input type="checkbox"
                        id="{{ $inputId }}"
                        class="sr-only peer"
                        wire:model.live="selectedLangue"
                        name="selectedLangue[]"
                        value="{{ $langue }}"
                    />

                    <!-- Track -->
                    <div class="w-5 h-3 bg-gray-300 rounded-full peer-checked:bg-supaGirlRose transition-colors"></div>

                    <!-- Thumb -->
                    <div class="absolute top-0.5 left-0.5 w-2 h-2 bg-white rounded-full transition-transform peer-checked:translate-x-2"></div>
                </div>
                <span class="text-xs text-green-gs">{{ $langue }}</span>
            </label>
        @endforeach
    </div>

    @if (count($langueData) > 6)
        <div class="mt-2">
            <button type="button" id="toggle-langue" class="flex items-center gap-1 text-xs text-gray-500 hover:underline focus:outline-none">
                <svg id="toggle-icon-langue" class="w-3 h-3 text-gray-500 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path id="toggle-icon-path-langue" stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
                <span id="toggle-label-langue">Afficher plus</span>
            </button>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtnLangue = document.getElementById('toggle-langue');
    const toggleLabelLangue = document.getElementById('toggle-label-langue');
    const toggleIconPathLangue = document.getElementById('toggle-icon-path-langue');
    const hiddenItemsLangue = document.querySelectorAll('#langue-switch-wrapper .hidden-langue');
    let expandedLangue = false;

    toggleBtnLangue?.addEventListener('click', () => {
        expandedLangue = !expandedLangue;
        hiddenItemsLangue.forEach(item => {
            item.classList.toggle('hidden', !expandedLangue);
        });

        toggleLabelLangue.textContent = expandedLangue ? 'Afficher moins' : 'Afficher plus';
        toggleIconPathLangue.setAttribute('d', expandedLangue ? 'M19 15l-7-7-7 7' : 'M19 9l-7 7-7-7');
    });
});
</script>

@props([
    'categories' => [],
    'selectedCategories' => [],
    'class' => '',
    'id' => 'category-escort-' . uniqid(),
    'label' => null,
    'placeholder' => 'Sélectionner des catégories...',
])

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dropdown-item-category {
        animation: fadeInUp 0.2s ease-out forwards;
        opacity: 0;
    }

    .dropdown-menu-category {
        animation: slideDown 0.2s ease-out;
    }

    .selected-badge-category {
        animation: fadeInUp 0.2s ease-out;
    }

    .hidden-category { display: none; }
    .rotate-180-category { transform: rotate(180deg); }
</style>

<div id="{{ $id }}" class="{{ $class }} category-selector relative">
    @if ($label)
        <label class="text-green-gs font-roboto-slab block text-sm font-medium mb-2">
            {{ $label }}
        </label>
    @endif

    <!-- Trigger -->
    <button type="button" class="dropdown-toggle-category border-supaGirlRose focus:ring-supaGirlRose text-green-gs font-roboto-slab w-full cursor-pointer rounded-sm sm:rounded-lg border-2 bg-white p-2 sm:p-3 text-left text-xs sm:text-sm transition-all duration-200 hover:border-green-gs focus:outline-none focus:ring-2 focus:ring-offset-2">
        <div class="selected-items-category flex flex-wrap items-center gap-1 min-h-[20px]">
            <span class="placeholder-category text-gray-500">{{ $placeholder }}</span>
        </div>
        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <svg class="h-4 w-4 text-gray-400 transition-transform duration-200 arrow-icon-category" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </span>
    </button>

    <!-- Dropdown -->
    <div class="dropdown-menu-category hidden-category absolute z-50 mt-1 w-full overflow-hidden rounded-sm sm:rounded-lg border-2 border-supaGirlRose bg-white shadow-lg">
        <div class="max-h-60 overflow-y-auto py-1">
            @foreach ($categories as $index => $categorie)
                <div class="dropdown-item-category" style="animation-delay: {{ min($index * 0.05, 0.3) }}s">
                    <label class="hover:bg-green-gs flex cursor-pointer items-center px-3 py-2 text-sm transition-colors hover:text-white">
                        <input type="checkbox"
                            class="category-checkbox text-green-gs focus:ring-green-gs mr-3 h-4 w-4 rounded border-gray-300 focus:ring-2"
                            value="{{ $categorie->id }}"
                            data-name="{{ $categorie->nom }}"
                            {{ in_array($categorie->id, $selectedCategories) ? 'checked' : '' }}>
                        <span class="font-roboto-slab">{{ $categorie->nom }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        <div class="border-t bg-gray-50 px-3 py-2 text-xs text-gray-500">
            <span class="selected-count-category">0</span>
            <span class="selected-label-category">catégorie sélectionnée</span>
        </div>
    </div>

    <!-- Hidden inputs -->
    <div class="hidden-inputs-category"></div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById(@json($id));
    const toggleBtn = container.querySelector('.dropdown-toggle-category');
    const dropdown = container.querySelector('.dropdown-menu-category');
    const arrow = container.querySelector('.arrow-icon-category');
    const selectedItemsContainer = container.querySelector('.selected-items-category');
    const checkboxes = container.querySelectorAll('.category-checkbox');
    const hiddenInputs = container.querySelector('.hidden-inputs-category');
    const placeholder = container.querySelector('.placeholder-category');
    const countSpan = container.querySelector('.selected-count-category');
    const labelSpan = container.querySelector('.selected-label-category');

    let selectedItems = [];

    checkboxes.forEach(cb => {
        if (cb.checked) selectedItems.push(cb.value);
    });
    updateDisplay();

    let isOpen = false;
    toggleBtn.addEventListener('click', () => {
        isOpen = !isOpen;
        console.log('✅ Toggle clicked. Dropdown open:', isOpen);
        dropdown.classList.toggle('hidden-category', !isOpen);
        arrow.classList.toggle('rotate-180-category', isOpen);
    });

    document.addEventListener('click', function (e) {
        if (!container.contains(e.target)) {
            if (isOpen) {
                console.log('🔒 Click outside. Closing dropdown.');
                isOpen = false;
                dropdown.classList.add('hidden-category');
                arrow.classList.remove('rotate-180-category');
            }
        }
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            const id = cb.value;
            if (cb.checked) {
                if (!selectedItems.includes(id)) selectedItems.push(id);
            } else {
                selectedItems = selectedItems.filter(i => i !== id);
            }
            updateDisplay();
        });
    });

    function updateDisplay() {
        selectedItemsContainer.innerHTML = '';
        hiddenInputs.innerHTML = '';

        if (selectedItems.length === 0) {
            selectedItemsContainer.appendChild(placeholder);
        } else {
            selectedItems.forEach(id => {
                const cb = container.querySelector(`.category-checkbox[value="${id}"]`);
                const name = cb.dataset.name;

                const badge = document.createElement('span');
                badge.className = 'selected-badge-category bg-green-gs text-white inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs';
                badge.innerHTML = `
                    <span>${name}</span>
                    <button type="button" class="hover:bg-green-700 rounded-full p-0.5 transition-colors" data-id="${id}">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/>
                        </svg>
                    </button>
                `;
                selectedItemsContainer.appendChild(badge);

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selectedCategories[]';
                input.value = id;
                hiddenInputs.appendChild(input);
            });
        }

        selectedItemsContainer.querySelectorAll('button[data-id]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = btn.dataset.id;
                selectedItems = selectedItems.filter(i => i !== id);
                container.querySelector(`.category-checkbox[value="${id}"]`).checked = false;
                updateDisplay();
            });
        });

        countSpan.textContent = selectedItems.length;
        labelSpan.textContent = selectedItems.length <= 1 ? 'catégorie sélectionnée' : 'catégories sélectionnées';
    }
});
</script>
@endpush

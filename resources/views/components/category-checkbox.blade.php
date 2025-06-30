@props([
    'categories' => [],
    'selectedValues' => [],
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
    function toggleCategory(checkbox) {
        const label = checkbox.nextElementSibling;
        const isChecked = checkbox.checked;
        
        // Mise à jour immédiate du style
        if (isChecked) {
            label.classList.add('bg-' + checkbox.dataset.hoverColor, 'text-' + checkbox.dataset.color + '-400');
            label.classList.remove('bg-white', 'border-' + checkbox.dataset.color + '-400');
        } else {
            label.classList.remove('bg-' + checkbox.dataset.hoverColor, 'text-' + checkbox.dataset.color + '-400');
            label.classList.add('bg-white', 'border-' + checkbox.dataset.color + '-400');
        }
    }
</script>
@endpush

@php
    $baseClasses = 'p-2 text-center border rounded-lg transition-colors duration-200 cursor-pointer';
    $checkedClasses = "bg-{$hoverColor} text-{$color}-400";
    $uncheckedClasses = "bg-white border-{$color}-400 hover:bg-{$hoverColor} hover:text-{$color}-400";
@endphp

@foreach($categories as $category)
    @php
        $categoryId = $prefixId . '-' . $category->{$valueField};
        $categoryName = $category->{$nameField};
        $categoryValue = $category->{$valueField};
        $categoryLabel = $category->{$labelField};
        $isChecked = in_array($categoryValue, $selectedValues);
        $labelClasses = $baseClasses . ' ' . ($isChecked ? $checkedClasses : $uncheckedClasses);
    @endphp

    <div class="my-2" wire:key="{{ $prefixId }}-{{ $category->{$valueField} }}">
        <input 
            type="checkbox"
            id="{{ $categoryId }}"
            name="{{ $categoryName }}"
            value="{{ $categoryValue }}"
            class="peer hidden"
            wire:model.live="{{ $model }}"
            wire:loading.attr="disabled"
            wire:target="{{ $model }}"
            onclick="toggleCategory(this)"
            data-color="{{ $color }}"
            data-hover-color="{{ $hoverColor }}"
            {{ $isChecked ? 'checked' : '' }}
        >
        <label for="{{ $categoryId }}" class="{{ $labelClasses }}">
            {{ $categoryLabel }}
        </label>
    </div>
@endforeach

<div x-data="multiSelect({{ json_encode($options) }}, {{ json_encode($value) }})" class="w-full">
    {{-- <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label> --}}
    <div class="relative mt-1">
        <!-- Input pour afficher les badges -->
        <div class="flex flex-wrap gap-2 rounded-md border border-gray-300 px-2 shadow-sm" @click="isOpen = true">
            <template x-for="(option, index) in selectedOptions" :key="index">
                <span
                    class="bg-green-gs border-green-gs my-1.5 flex items-center justify-center rounded-md border p-0.5 text-sm font-medium text-white">
                    <span x-text="option"></span>
                    <button type="button" class="ml-2 text-white" @click="removeOption(index)">×</button>
                </span>
            </template>
            <input type="text" placeholder="{{ $label }}..."
                class="flex-1 border-none focus:outline-none focus:ring-0" x-model="search" @input="filterOptions"
                @focus="isOpen = true" @blur="closeDropdown" />
        </div>

        <!-- Liste déroulante des options -->
        <div class="absolute z-10 mt-1 w-full rounded-md border bg-white shadow-lg"
            x-show="isOpen && filteredOptions.length > 0" @mousedown.away="isOpen = false">
            <ul class="py-1 text-sm text-gray-700">
                <template x-for="(option, index) in filteredOptions" :key="index">
                    <li class="cursor-pointer px-4 py-2 hover:bg-teal-100" @click="selectOption(option)"
                        x-text="option"></li>
                </template>
            </ul>
        </div>
    </div>

    <!-- Champ caché pour envoyer les données au backend -->
    <input type="hidden" name="{{ $name }}" x-bind:value="selectedValues().join(',')" />
    {{-- <template x-for="option in selectedOptions" :key="option">
  </template> --}}
</div>

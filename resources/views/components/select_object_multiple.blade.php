<div x-data="multiObjectSelect({{ json_encode($options) }}, {{ json_encode($value) }})" class="w-full">
    <div class="relative mt-1">
        <!-- Input pour afficher les badges -->
        <div class="flex flex-wrap gap-2 rounded-md border border-gray-300 px-2 shadow-sm" @click="isOpen = true">
            <template x-for="(option, index) in selectedOptions" :key="index">
                <span
                    class="bg-green-gs border-green-gs my-1.5 flex items-center justify-center rounded-md border p-0.5 text-sm font-medium text-white">
                    <span x-text="option['nom']"></span>
                    <button type="button" class="ml-2 text-white" @click="removeOption(index)">×</button>
                </span>
            </template>
            <input type="text" :placeholder="'{{ $label }}...'"
                class="flex-1 border-none focus:outline-none focus:ring-0" x-model="search" @input="filterOptions"
                @focus="isOpen = true" @blur="closeDropdown" />
        </div>

        <!-- Liste déroulante des options -->
        <div class="absolute z-10 mt-1 max-h-60 w-full overflow-y-auto rounded-md border bg-white shadow-lg"
            x-show="isOpen && filteredOptions.length > 0" @mousedown.away="isOpen = false">
            <ul class="py-1 text-sm text-gray-700">
                <template x-for="(option, index) in filteredOptions" :key="index">
                    <li class="cursor-pointer px-4 py-2 hover:bg-teal-100" @click="selectOption(option)"
                        x-text="option['nom']"></li>
                </template>
            </ul>
        </div>
    </div>

    <!-- Champ caché pour envoyer les données au backend -->
    <input type="hidden" :name="'{{ $name }}'" x-bind:value="selectedValues()" />
</div>

<script>
    function multiObjectSelect(options, value) {
        return {
            options: options,
            selectedOptions: value || [],
            search: '',
            isOpen: false,
            get filteredOptions() {
                return this.options.filter(option =>
                    option.nom.toLowerCase().includes(this.search.toLowerCase())
                );
            },
            selectOption(option) {
                if (!this.selectedOptions.some(opt => opt.id === option.id)) {
                    this.selectedOptions.push(option);
                }
                this.search = '';
                this.isOpen = false;
            },
            removeOption(index) {
                this.selectedOptions.splice(index, 1);
            },
            selectedValues() {
                return this.selectedOptions.map(option => option.id);
            },
            filterOptions() {
                this.isOpen = true;
            },
            closeDropdown() {
                setTimeout(() => {
                    this.isOpen = false;
                }, 100);
            }
        };
    }
</script>

<div x-data="multiSelectOption({{ json_encode($options) }}, {{ json_encode($value) }})" class="relative w-full" x-init="init()">

    <div class="group relative mt-1">
        <!-- Conteneur d'entrée avec styles améliorés -->
        <div class="focus-within:ring-green-gs focus-within:border-green-gs border-supaGirlRose hover:border-green-gs flex flex-wrap gap-2 rounded-lg border border-2 px-3 py-2 shadow-sm transition-all duration-200 focus-within:ring-2"
            :class="{ 'ring-2 ring-green-gs border-green-gs': isOpen }">

            <!-- Badges des options sélectionnées -->
            <template x-for="(option, index) in selectedOptions" :key="index">
                <div class="group relative">
                    <span
                        class="bg-green-gs hover:bg-yellow-gs flex items-center whitespace-nowrap rounded-sm py-1.5 pl-3 text-sm font-medium text-white shadow-sm transition-colors">
                        <span x-text="option"></span>
                        <button type="button"
                            class="ml-1.5 flex h-5 w-5 items-center justify-center rounded-full transition-colors hover:bg-green-700"
                            @click.stop="removeOption(index)">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                </div>
            </template>

            <!-- Champ de recherche -->
            <input type="text" :placeholder="selectedOptions.length === 0 ? '{{ $label }}...' : ''"
                class="min-w-[100px] flex-1 border-0 p-0 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0"
                x-model="search" @input="filterOptions" @focus="isOpen = true" @click.stop
                @keydown.enter.prevent="handleEnter" @keydown.escape="isOpen = false" x-ref="searchInput">

            <!-- Bouton de déroulement -->
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                <svg class="h-5 w-5 text-gray-400 transition-transform duration-200"
                    :class="{ 'transform rotate-180': isOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <!-- Liste déroulante des options avec styles améliorés -->
        <div class="bg-fieldBg ring-supaGirlRosePastel absolute z-20 mt-1 w-full rounded-lg shadow-lg ring-1 ring-opacity-5"
            x-show="isOpen && filteredOptions.length > 0" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95" @click.away="isOpen = false" style="display: none;">
            <ul class="max-h-60 overflow-auto py-1 text-sm focus:outline-none">
                <template x-for="(option, index) in filteredOptions" :key="index">
                    <li class="text-textColorParagraph hover:bg-supaGirlRose relative cursor-default select-none py-2 pl-3 pr-9"
                        :class="{ 'bg-supaGirlRose': isSelected(option) }" @click.stop="selectOption(option)">
                        <div class="flex items-center">
                            <span x-text="option" class="font-roboto-slab block truncate"></span>
                            <span x-show="isSelected(option)"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-green-600">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </li>
                </template>
                <li x-show="filteredOptions.length === 0" class="px-4 py-2 text-sm text-gray-500">
                    Aucun résultat trouvé
                </li>
            </ul>
        </div>
    </div>

    <!-- Champ caché pour envoyer les données au backend -->
    <input type="hidden" :name="'{{ $name }}'" x-bind:value="selectedValues().join(',')" />
</div>

<script>
    function multiSelectOption(options, value) {
        return {
            options: Array.isArray(options) ? options : [],
            selectedOptions: Array.isArray(value) ? (value.length == 1 ? (value[0] == '' ? [] : value) : value) : (
                value ? value.split(',').map(v => v.trim()) : []),
            search: '',
            isOpen: false,
            init() {
                // Close dropdown when clicking outside
                const handleClickOutside = (e) => {
                    if (!this.$el.contains(e.target)) {
                        this.isOpen = false;
                    }
                };

                document.addEventListener('click', handleClickOutside);
                this.$el._clickOutsideHandler = handleClickOutside;
            },

            beforeDestroy() {
                if (this.$el._clickOutsideHandler) {
                    document.removeEventListener('click', this.$el._clickOutsideHandler);
                }
            },

            isSelected(option) {
                return this.selectedOptions.includes(option);
            },

            get filteredOptions() {
                if (!this.search) return this.options;

                const searchTerm = this.search.toLowerCase().trim();
                if (!searchTerm) return this.options;

                return this.options.filter(option =>
                    option.toLowerCase().includes(searchTerm)
                );
            },

            selectOption(option) {
                if (!this.isSelected(option)) {
                    this.selectedOptions.push(option);
                } else {
                    this.selectedOptions = this.selectedOptions.filter(opt => opt !== option);
                }
                this.search = '';
                this.$nextTick(() => {
                    this.$refs.searchInput?.focus();
                });
            },

            removeOption(index) {
                this.selectedOptions.splice(index, 1);
                this.$nextTick(() => {
                    this.$refs.searchInput?.focus();
                });
            },

            selectedValues() {
                return this.selectedOptions;
            },

            filterOptions() {
                this.isOpen = true;
            },

            handleEnter() {
                if (this.filteredOptions.length > 0) {
                    this.selectOption(this.filteredOptions[0]);
                }
            },

            closeDropdown() {
                setTimeout(() => {
                    this.isOpen = false;
                }, 100);
            }
        };
    }
</script>

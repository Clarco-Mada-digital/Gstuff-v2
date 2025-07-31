<div x-data="singleObjectSelect({{ json_encode($options) }}, {{ json_encode($value) }})" class="relative w-full" x-init="init()">
    <!-- Conteneur principal -->
    <div class="group relative mt-1">
        <!-- Conteneur d'entrée -->
        <div class="focus-within:ring-green-gs focus-within:border-green-gs flex flex-wrap gap-2 rounded-lg border border-supaGirlRose border-2 px-3 py-2 shadow-sm transition-all duration-200 focus-within:ring-2 hover:border-supaGirlRosePastel"
            :class="{ 'ring-2 ring-green-gs border-green-gs': isOpen }">
            <!-- Badge de l'option sélectionnée -->
            <template x-if="selectedOption">
                <div class="group relative">
                    <span
                        class="bg-green-gs hover:bg-supaGirlRose flex items-center whitespace-nowrap rounded-sm py-1.5 pl-3 text-sm font-medium text-white hover:text-green-gs shadow-sm transition-colors">
                        <span
                            x-text="selectedOption.nom?.['{{ app()->getLocale() }}'] ?? selectedOption.nom?.['fr'] ?? selectedOption.nom"></span>
                        <button type="button"
                            class="ml-1.5 flex h-5 w-5 items-center justify-center rounded-full transition-colors hover:bg-blue-800"
                            @click.stop="removeOption()">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                </div>
            </template>
            <!-- Champ de recherche -->
            <input type="text" :placeholder="selectedOption ? '' : '{{ $label }}...'"
                class="min-w-[100px] flex-1 border-0 p-0 text-textColorParagraph placeholder-gray-400 focus:outline-none focus:ring-0"
                x-model="search" @input="filterOptions" @focus="isOpen = true" @click.stop
                @keydown.enter.prevent="handleEnter" @keydown.escape="isOpen = false">
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
        <!-- Liste déroulante des options -->
        <div class="absolute z-20 mt-1 w-full rounded-lg bg-fieldBg shadow-lg ring-1 ring-supaGirlRose ring-opacity-5"
            x-show="isOpen && filteredOptions.length > 0" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95" @click.away="isOpen = false" style="display: none;">
            <ul class="max-h-60 overflow-auto py-1 text-sm focus:outline-none">
                <template x-for="(option, index) in filteredOptions" :key="index">
                    <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-textColorParagraph hover:bg-supaGirlRose"
                        :class="{ 'bg-blue-100': isSelected(option) }" @click.stop="selectOption(option)">
                        <div class="flex items-center">
                            <span x-text="option.nom?.['{{ app()->getLocale() }}'] ?? option.nom?.['fr'] ?? option.nom"
                                class="block truncate font-roboto-slab"></span>
                            <span x-show="isSelected(option)"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600">
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
    <input type="hidden" :name="'{{ $name }}'" x-bind:value="selectedValue()" />
</div>

<script>
    function singleObjectSelect(options, value) {
        return {
            options: Array.isArray(options) ? options : [],
            selectedOption: null,
            search: '',
            isOpen: false,
            init() {
                // Convert initial value to proper format
                if (value) {
                    if (typeof value === 'object') {
                        this.selectedOption = value[0];
                    } else {
                        const id = value.toString().trim();
                        this.selectedOption = this.options.find(option => option.id.toString() === id) || null;
                    }
                }
                // Close dropdown when clicking outside
                const handleClickOutside = (e) => {
                    if (!this.$el.contains(e.target)) {
                        this.isOpen = false;
                    }
                };
                document.addEventListener('click', handleClickOutside);
                // Clean up event listener
                this.$el._clickOutsideHandler = handleClickOutside;
            },
            beforeDestroy() {
                if (this.$el._clickOutsideHandler) {
                    document.removeEventListener('click', this.$el._clickOutsideHandler);
                }
            },
            isSelected(option) {
                return this.selectedOption && this.selectedOption.id === option.id;
            },
            get filteredOptions() {
                if (!this.search) return this.options;
                const searchTerm = this.search.toLowerCase().trim();
                if (!searchTerm) return this.options;
                return this.options.filter(option => {
                    const nom = option.nom;
                    if (!nom) return false;
                    if (typeof nom === 'string') {
                        return nom.toLowerCase().includes(searchTerm);
                    } else if (typeof nom === 'object') {
                        const localizedNom = nom['{{ app()->getLocale() }}'] || nom['fr'] || '';
                        return localizedNom.toLowerCase().includes(searchTerm);
                    }
                    return false;
                });
            },
            selectOption(option) {
                this.selectedOption = option;
                this.search = '';
                this.isOpen = false;
                this.$nextTick(() => {
                    this.$refs.searchInput?.focus();
                });
            },
            removeOption() {
                this.selectedOption = null;
                this.$nextTick(() => {
                    this.$refs.searchInput?.focus();
                });
            },
            selectedValue() {
                return this.selectedOption ? this.selectedOption.id : '';
            },
            filterOptions() {
                this.isOpen = true;
            },
            handleEnter() {
                if (this.filteredOptions.length > 0) {
                    this.selectOption(this.filteredOptions[0]);
                }
            }
        };
    }
</script>

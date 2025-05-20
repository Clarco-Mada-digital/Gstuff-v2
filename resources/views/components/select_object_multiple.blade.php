<div x-data="multiObjectSelecttest({{ json_encode($options) }}, {{ is_array($value) ? json_encode($value) : (is_string($value) ? json_encode(explode(',', $value)) : '[]') }})" 
     class="w-full relative"
     x-init="init()">
    
    <!-- Conteneur principal avec styles améliorés -->
    <div class="relative mt-1 group">
        <!-- Conteneur d'entrée avec styles améliorés -->
        <div class="flex flex-wrap gap-2 rounded-lg border border-gray-300 px-3 py-2 shadow-sm transition-all duration-200
                   focus-within:ring-2 focus-within:ring-green-gs focus-within:border-green-gs
                   hover:border-gray-400"
             :class="{'ring-2 ring-green-gs border-green-gs': isOpen}">
            
            <!-- Badges des options sélectionnées -->
            <template x-for="(option, index) in selectedOptions" :key="index">
                <div class="relative group">
                    <span class="bg-green-gs text-white text-sm font-medium py-1.5 pl-3  rounded-sm 
                               flex items-center whitespace-nowrap shadow-sm hover:bg-yellow-gs transition-colors">
                        <span x-text="option.nom?.['{{ app()->getLocale() }}'] ?? option.nom?.['fr'] ?? option.nom"></span>
                        <button type="button" 
                                class="ml-1.5 w-5 h-5 rounded-full flex items-center justify-center hover:bg-blue-800 transition-colors"
                                @click.stop="removeOption(index)">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                </div>
            </template>
            
            <!-- Champ de recherche -->
            <input type="text" 
                   :placeholder="selectedOptions.length === 0 ? '{{ $label }}...' : ''"
                   class="flex-1 min-w-[100px] border-0 p-0 focus:ring-0 focus:outline-none text-gray-900 placeholder-gray-400"
                   x-model="search" 
                   @input="filterOptions"
                   @focus="isOpen = true"
                   @click.stop
                   @keydown.enter.prevent="handleEnter"
                   @keydown.escape="isOpen = false">
                   
            <!-- Bouton de déroulement -->
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 transition-transform duration-200" 
                     :class="{'transform rotate-180': isOpen}" 
                     xmlns="http://www.w3.org/2000/svg" 
                     viewBox="0 0 20 20" 
                     fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <!-- Liste déroulante des options avec styles améliorés -->
        <div class="absolute z-20 mt-1 w-full rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5"
             x-show="isOpen && filteredOptions.length > 0"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             @click.away="isOpen = false"
             style="display: none;">
            <ul class="max-h-60 overflow-auto py-1 focus:outline-none text-sm">
                <template x-for="(option, index) in filteredOptions" :key="index">
                    <li class="relative cursor-default select-none py-2 pl-3 pr-9 hover:bg-blue-50 text-gray-900"
                        :class="{'bg-blue-100': isSelected(option)}"
                        @click.stop="selectOption(option)">
                        <div class="flex items-center">
                            <span x-text="option.nom?.['{{ app()->getLocale() }}'] ?? option.nom?.['fr'] ?? option.nom"
                                  class="block truncate font-medium"></span>
                            <span x-show="isSelected(option)" 
                                  class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    </li>
                </template>
                <li x-show="filteredOptions.length === 0" 
                    class="px-4 py-2 text-sm text-gray-500">
                    Aucun résultat trouvé
                </li>
            </ul>
        </div>
    </div>

    <!-- Champ caché pour envoyer les données au backend -->
    <input type="hidden" :name="'{{ $name }}'" x-bind:value="selectedValues()" />
</div>

<script>
    function multiObjectSelecttest(options, value) {
        return {
            options: Array.isArray(options) ? options : [],
            selectedOptions: [],
            search: '',
            isOpen: false,
            
            init() {
                // Convert initial value to proper format
                if (Array.isArray(value) && value.length > 0) {
                    if (typeof value[0] === 'object') {
                        this.selectedOptions = value;
                    } else {
                        this.selectedOptions = this.options.filter(option => 
                            value.includes(option.id.toString())
                        );
                    }
                } else if (Array.isArray(value) && value.length === 0) {
                    this.selectedOptions = [];
                } else if (value) {
                    const ids = value.toString().split(',').map(id => id.trim());
                    this.selectedOptions = this.options.filter(option => 
                        ids.includes(option.id.toString())
                    );
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
                return this.selectedOptions.some(opt => opt.id === option.id);
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
                if (!this.isSelected(option)) {
                    this.selectedOptions.push(option);
                } else {
                    this.selectedOptions = this.selectedOptions.filter(opt => opt.id !== option.id);
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
                return this.selectedOptions.map(option => option.id).join(',');
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
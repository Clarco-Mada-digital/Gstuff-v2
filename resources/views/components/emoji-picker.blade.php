@php
    $emojiJson = file_get_contents(database_path('seeders/dataJson/emojis.json'));
    $emojiArray = json_decode($emojiJson, true) ?? [];
    $processedData = [];
    
    foreach ($emojiArray as $category) {
        $emojis = [];
        $emojiItems = $category['emojis'] ?? [];
        $emojiItems = array_slice($emojiItems, 0, 30);
        
        foreach ($emojiItems as $emoji) {
            $emojis[] = [
                'emoji' => $emoji['emoji'] ?? '',
                'name' => $emoji['name'] ?? ''
            ];
        }
        
        $processedData[] = [
            'name' => $category['name'] ?? '',
            'slug' => $category['slug'] ?? '',
            'emojis' => $emojis
        ];
    }
    
    $emojiData = json_encode($processedData, JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

<div x-data="{
    showPicker: false,
    emojiData: {!! $emojiData !!},
    activeCategory: 'smileys_emotion',
    searchQuery: '',
    
    get filteredEmojis() {
        if (!this.emojiData || !this.emojiData.length) return [];
        
        if (this.searchQuery.trim() === '') {
            const category = this.emojiData.find(cat => cat.slug === this.activeCategory);
            return category && category.emojis ? category.emojis : [];
        }
        
        const query = this.searchQuery.toLowerCase();
        return this.emojiData
            .flatMap(category => category.emojis || [])
            .filter(emoji => emoji.name && emoji.name.toLowerCase().includes(query))
            .slice(0, 100);
    },
    
    selectEmoji(emoji) {
        this.$dispatch('emoji-selected', { emoji: emoji });
        this.showPicker = false;
    }
}" x-on:click.away="showPicker = false" class="relative">
    <button type="button" 
            @click="showPicker = !showPicker"
            class="p-2 text-supaGirlRose hover:text-green-gs focus:outline-none">
        <i class="far fa-smile text-xl"></i>
    </button>
    
    <div x-show="showPicker" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute bottom-full right-0 mb-2 w-64 h-80 bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden flex flex-col z-50">
        
        <!-- Barre de recherche -->
        <div class="p-2 border-b border-gray-200">
            <div class="relative">
                <input type="text" 
                       x-model="searchQuery"
                       placeholder="Rechercher un émoji..."
                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
        
        <!-- Catégories -->
        <div class="flex-shrink-0 flex overflow-x-auto border-b border-gray-200 bg-gray-50 px-2" style="scrollbar-width: thin;">
            <template x-for="category in emojiData" :key="category.slug">
                <button @click="activeCategory = category.slug; searchQuery = ''"
                        :class="{'text-blue-500 border-b-2 border-blue-500': activeCategory === category.slug}"
                        class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 whitespace-nowrap focus:outline-none">
                    <span x-text="category.name.split(' ')[0]"></span>
                </button>
            </template>
        </div>
        
        <!-- Liste des émojis -->
        <div class="flex-1 overflow-y-auto p-2">
            <template x-if="searchQuery.trim() === ''">
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 mb-2" x-text="emojiData.find(c => c.slug === activeCategory)?.name"></h3>
                    <div class="grid grid-cols-8 gap-1">
                        <template x-for="emoji in filteredEmojis" :key="emoji.name">
                            <button @click="selectEmoji(emoji.emoji)"
                                    class="emoji-btn text-xl p-1 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    :title="emoji.name">
                                <span x-text="emoji.emoji"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </template>
            
            <template x-if="searchQuery.trim() !== ''">
                <div>
                    <div class="text-xs font-semibold text-gray-500 mb-2">
                        Résultats pour "<span x-text="searchQuery"></span>"
                    </div>
                    <div class="grid grid-cols-8 gap-1">
                        <template x-if="filteredEmojis.length > 0">
                            <template x-for="emoji in filteredEmojis" :key="emoji.name">
                                <button @click="selectEmoji(emoji.emoji)"
                                        class="emoji-btn text-xl p-1 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        :title="emoji.name">
                                    <span x-text="emoji.emoji"></span>
                                </button>
                            </template>
                        </template>
                        <div x-show="filteredEmojis.length === 0" class="col-span-8 text-center text-sm text-gray-500 py-4">
                            Aucun émoji trouvé
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

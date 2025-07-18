@props([
    'placeholder' => '',
    'model' => 'newMessage',
])

<div class="relative flex-1">
    <textarea 
        x-ref="messageInput"
        x-model="{{ $model }}" 
        rows="1" 
        placeholder="{{ $placeholder }}"
        class="w-full h-12 resize-none overflow-hidden rounded-full border border-supaGirlRose border-1 p-3 pr-10 focus:outline-none text-textColor font-roboto-slab focus:border-green-gs focus:ring-green-gs focus:ring-2"
        style="min-height: 48px; max-height: 48px;"
        @input="$el.style.height = '48px'; $el.style.height = Math.min($el.scrollHeight, 192) + 'px'"
    ></textarea>

    <!-- Emoji button -->
    <button 
        type="button" 
        @click="showEmojiPicker = !showEmojiPicker"
        class="absolute right-3 top-3 text-supaGirlRose hover:text-green-gs"
    >
        <i class="far fa-smile"></i>
    </button>

    <!-- Emoji Picker with Categories -->
    <div 
        x-data="emojiPicker()"
        x-init="init()"
        x-show="showEmojiPicker" 
        @click.away="showEmojiPicker = false"
        class="absolute -top-5 right-0 z-10 w-80 -translate-y-full rounded-lg border border-gray-200 bg-white shadow-lg"
    >
        <!-- Search Bar -->
        <div class="border-b border-gray-200 p-2">
            <input 
                type="text" 
                x-model="searchQuery" 
                @input="search()"
                placeholder="Search emojis..."
                class="w-full rounded-md border border-gray-300 px-3 py-1.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"
            >
        </div>

        <!-- Category Tabs -->
        <div class="flex overflow-x-auto border-b border-gray-200 bg-gray-50 px-2" x-show="!searchQuery">
            @if(isset($emojiCategories) && count($emojiCategories) > 0)
                @foreach($emojiCategories as $category)
                    <button 
                        type="button"
                        @click="activeCategory = '{{ $category['slug'] }}'"
                        :class="{ 'border-b-2 border-blue-500 text-blue-600': activeCategory === '{{ $category['slug'] }}', 'text-gray-600 hover:text-gray-800': activeCategory !== '{{ $category['slug'] }}' }"
                        class="flex-shrink-0 whitespace-nowrap px-4 py-2 text-sm font-medium transition-colors"
                        :title="'{{ $category['name'] }}'"
                    >
                        {{ $category['emojis'][0]['char'] ?? '' }}
                    </button>
                @endforeach
            @endif
        </div>

        <!-- Emoji Grid -->
        <div class="h-64 overflow-y-auto p-2">
            <template x-if="searchQuery">
                <div class="search-results flex flex-wrap gap-1">
                    <template x-for="emoji in searchResults" :key="emoji.char">
                        <button 
                            type="button"
                            @click="insertEmoji(emoji.char)"
                            class="m-1 flex h-8 w-8 items-center justify-center rounded-md text-xl hover:bg-gray-100"
                            :title="emoji.name"
                        >
                            <span x-text="emoji.char"></span>
                        </button>
                    </template>
                    <div x-show="searchResults.length === 0" class="p-4 text-center text-gray-500">
                        No emojis found for "<span x-text="searchQuery"></span>"
                    </div>
                </div>
            </template>

            <template x-if="!searchQuery">
                <div class="category-view">
                    @if(isset($emojiCategories) && count($emojiCategories) > 0)
                        @foreach($emojiCategories as $category)
                            <div 
                                x-show="activeCategory === '{{ $category['slug'] }}'"
                                class="emoji-category"
                            >
                                <h3 class="mb-2 mt-3 text-xs font-semibold text-gray-500">{{ $category['name'] }}</h3>
                                <div class="grid grid-cols-8 gap-1">
                                    @foreach($category['emojis'] as $emoji)
                                        <button 
                                            type="button"
                                            @click="insertEmoji('{{ $emoji['char'] }}')"
                                            class="flex h-8 w-8 items-center justify-center rounded-md text-xl hover:bg-gray-100"
                                            title="{{ $emoji['name'] }}"
                                        >
                                            {{ $emoji['char'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex h-full items-center justify-center text-gray-500">
                            No emojis available
                        </div>
                    @endif
                </div>
            </template>
        </div>

        <script>
            function emojiPicker() {
                return {
                    activeCategory: 'smileys_emotion',
                    searchQuery: '',
                    searchResults: [],
                    allEmojis: [
                        @if(isset($emojiCategories) && count($emojiCategories) > 0)
                            @foreach($emojiCategories as $category)
                                @foreach($category['emojis'] as $emoji)
                                    {
                                        char: '{{ $emoji['char'] }}',
                                        name: '{{ $emoji['name'] }}',
                                        slug: '{{ $category['slug'] }}'
                                    },
                                @endforeach
                            @endforeach
                        @endif
                    ],
                    init() {
                        // Initialize any required data
                    },
                    search() {
                        if (!this.searchQuery.trim()) {
                            this.searchResults = [];
                            return;
                        }
                        
                        const query = this.searchQuery.toLowerCase().trim();
                        this.searchResults = this.allEmojis.filter(emoji => 
                            emoji.name.toLowerCase().includes(query)
                        );
                    },
                    insertEmoji(emoji) {
                        // Find the closest parent Alpine component that has the showEmojiPicker state
                        const parentComponent = this.$parent;
                        const textarea = this.$refs.messageInput || document.querySelector('textarea[x-ref="messageInput"]');
                        
                        if (textarea) {
                            const start = textarea.selectionStart;
                            const end = textarea.selectionEnd;
                            const text = textarea.value;
                            const before = text.substring(0, start);
                            const after = text.substring(end, text.length);
                            
                            // Update the value directly
                            textarea.value = before + emoji + after;
                            const newCursorPos = start + emoji.length;
                            
                            // Update the Livewire model
                            const modelName = textarea.getAttribute('x-model');
                            if (modelName && window.Livewire) {
                                window.Livewire.set(modelName, textarea.value);
                            }
                            
                            // Update cursor position and trigger input event
                            setTimeout(() => {
                                textarea.selectionStart = textarea.selectionEnd = newCursorPos;
                                textarea.focus();
                                textarea.dispatchEvent(new Event('input', { bubbles: true }));
                            }, 10);
                        }
                        
                        // Reset search and close picker
                        this.searchQuery = '';
                        this.searchResults = [];
                        if (parentComponent) {
                            parentComponent.showEmojiPicker = false;
                        }
                    }
                };
            }
        </script>
    </div>


</div>

@props([
    'inputSelector' => null, // Optional: CSS selector for the input/textarea to insert emojis into
    'model' => null, // Optional: Livewire model name
    'inputId' => null, // Optional: Direct input ID if not using selector
])

<div 
    x-data="emojiPicker()"
    x-init="init()"
    @click.away="showEmojiPicker = false"
    class="relative inline-block"
    data-input-selector="{{ $inputSelector }}"
    data-input-id="{{ $inputId }}"
    data-model="{{ $model }}"
    {{ $attributes->merge(['class' => 'relative']) }}
>
    <!-- Emoji button -->
    <button 
        type="button" 
        @click="showEmojiPicker = !showEmojiPicker"
        class="text-supaGirlRose hover:text-green-gs focus:outline-none"
        :class="{ 'text-green-gs': showEmojiPicker }"
    >
       <i class="far fa-smile"></i>
    </button>

    <!-- Emoji Picker with Categories -->
    <div 
        x-show="showEmojiPicker" 
        class="absolute bottom-full right-0 z-10 mb-2 w-80 rounded-lg border border-gray-200 bg-white shadow-lg"
        style="display: none;"
        x-cloak
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
    </div>
</div>

@once
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('emojiPicker', () => ({
            showEmojiPicker: false,
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
                this.$watch('showEmojiPicker', value => {
                    if (value) {
                        this.searchQuery = '';
                        this.searchResults = [];
                    }
                });
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
                let targetInput;
                const inputSelector = this.$el.getAttribute('data-input-selector');
                const inputId = this.$el.getAttribute('data-input-id');
                const model = this.$el.getAttribute('data-model');
                
                // Find the target input/textarea
                if (inputSelector) {
                    targetInput = document.querySelector(inputSelector);
                } else if (inputId) {
                    targetInput = document.getElementById(inputId);
                } else {
                    // Fallback: find the closest input/textarea that's not a file input
                    const form = this.$el.closest('form');
                    targetInput = form?.querySelector('input:not([type="file"]), textarea') ||
                                this.$el.parentElement.querySelector('input:not([type="file"]), textarea');
                }
                
                // Only proceed if we have a valid input element that's not a file input
                if (targetInput && targetInput.type !== 'file') {
                    const isTextarea = targetInput.tagName.toLowerCase() === 'textarea';
                    const isTextInput = ['text', 'search', 'email', 'url', 'tel', 'password'].includes(targetInput.type);
                    const isContentEditable = targetInput.isContentEditable;
                    
                    if (isTextarea || isTextInput || isContentEditable) {
                        const start = targetInput.selectionStart;
                        const end = targetInput.selectionEnd;
                        const text = targetInput.value || '';
                        const before = text.substring(0, start);
                        const after = text.substring(end, text.length);
                        
                        // Update the value
                        const newValue = before + emoji + after;
                        
                        if (isContentEditable) {
                            // Handle contenteditable elements
                            targetInput.textContent = newValue;
                        } else {
                            // Handle regular inputs/textarea
                            targetInput.value = newValue;
                        }
                        
                        const newCursorPos = start + emoji.length;
                        
                        // Update the Livewire model if specified
                        const modelName = model || targetInput.getAttribute('x-model');
                        if (modelName && window.Livewire) {
                            window.Livewire.set(modelName, newValue, true);
                        }
                        
                        // Update cursor position and trigger input event
                        setTimeout(() => {
                            if (!isContentEditable) {
                                targetInput.selectionStart = targetInput.selectionEnd = newCursorPos;
                                targetInput.focus();
                            }
                            
                            // Trigger input events
                            const inputEvent = new Event('input', { bubbles: true });
                            const changeEvent = new Event('change', { bubbles: true });
                            targetInput.dispatchEvent(inputEvent);
                            targetInput.dispatchEvent(changeEvent);
                        }, 10);
                    }
                }
                
                // Close the picker after selection
                this.showEmojiPicker = false;
                this.searchQuery = '';
                this.searchResults = [];
            }
        }));
    });
</script>
@endpush
@endonce

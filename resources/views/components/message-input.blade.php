@props([
    'placeholder' => '',
    'model' => 'newMessage',
])

<div class="relative flex-1">
    <textarea 
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

    <!-- Emoji picker -->
    <div 
        x-show="showEmojiPicker" 
        @click.away="showEmojiPicker = false"
        class="absolute -top-5 right-0 z-10 h-48 w-64 -translate-y-full overflow-y-auto rounded-lg border border-gray-200 bg-white p-2 shadow-lg"
    >
        <div class="flex flex-wrap gap-1 gap-3">
            @if(isset($emojis) && is_array($emojis) && count($emojis) > 0)
                @foreach($emojis as $emoji)
                    <button 
                        type="button" 
                        @click="insertEmoji('{{ $emoji }}')"
                        class="rounded p-1 text-xl hover:bg-gray-100"
                    >{{ $emoji }}</button>
                @endforeach
            @else
                <!-- Fallback emojis in case $emojis is not available -->
                @foreach(['😀', '😂', '😍', '👍', '❤️', '🙏', '🔥', '🎉', '🤔', '😎'] as $emoji)
                    <button 
                        type="button" 
                        @click="insertEmoji('{{ $emoji }}')"
                        class="rounded p-1 text-xl hover:bg-gray-100"
                    >{{ $emoji }}</button>
                @endforeach
            @endif
        </div>
    </div>
</div>

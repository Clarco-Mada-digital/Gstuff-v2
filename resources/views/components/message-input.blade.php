@props([
    'placeholder' => '',
    'model' => 'newMessage',
])

<div class="relative flex-1">
    <textarea id="message-input-{{ $model }}" x-ref="messageInput" x-model="{{ $model }}" rows="1"
        placeholder="{{ $placeholder }}"
        class="border-supaGirlRose border-1 text-textColor font-roboto-slab focus:border-green-gs focus:ring-green-gs h-12 w-full resize-none overflow-hidden rounded-full border p-3 pr-10 focus:outline-none focus:ring-2"
        style="min-height: 48px; max-height: 48px;"
        @input="$el.style.height = '48px'; $el.style.height = Math.min($el.scrollHeight, 192) + 'px'"></textarea>

    <!-- Reusable Emoji Picker Component -->
    <div class="absolute right-3 top-3">
        <x-emoji-picker inputId="message-input-{{ $model }}" :model="$model" />
    </div>
</div>

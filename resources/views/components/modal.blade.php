<div x-data="{ show: @entangle($attributes->wire('model')) }" x-show="show" x-on:keydown.escape.window="show = false"
    class="fixed inset-0 z-50 overflow-y-auto" style="display: none">
    <div class="flex min-h-screen items-center justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Modal container -->
        <span class="hidden sm:inline-block sm:align-middle" aria-hidden="true">&#8203;</span>

        <div x-show="show" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="{{ $maxWidthClass() }} inline-block w-full transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:align-middle"
            role="dialog">
            {{ $slot }}
        </div>
    </div>
</div>

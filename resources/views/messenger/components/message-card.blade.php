@php
    $isSender = $message->from_id == auth()->id();
@endphp

<div class="{{ $isSender ? 'justify-end' : 'justify-start' }} mb-3 flex w-full px-2 sm:px-4" data-id="{{ $message->id }}"
    x-data="{ showMenu: false }">
    <div class="{{ $isSender ? 'justify-end' : 'justify-start' }} flex w-full items-start">
        <div
            class="flex max-w-full items-start sm:max-w-[85%] md:max-w-[80%] lg:max-w-[75%] xl:max-w-[70%] 2xl:max-w-[65%]">
            @if ($message->from_id === auth()->user()->id)
                <div class="relative mr-2 flex-shrink-0 self-center">
                    <button @click.stop="showMenu = !showMenu"
                        class="text-gray-400 transition-colors duration-200 hover:text-gray-600 focus:outline-none">
                        <i class="fas fa-ellipsis-v text-sm sm:text-base"></i>
                    </button>
                    <div x-show="showMenu" @click.away="showMenu = false"
                        class="absolute -left-10 z-10 mt-1 rounded-md border border-gray-100 bg-white p-1 shadow-lg">
                        <div class="py-1">
                            <button @click="deleteMessage({{ $message->id }}); showMenu = false"
                                class="block w-full rounded px-3 py-2 text-left text-sm text-red-600 transition-colors duration-200 hover:bg-red-50">
                                <i class="fas fa-trash mr-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            <div
                class="{{ $isSender ? 'bg-[#6366f1] text-white' : 'bg-white' }} rounded-lg p-2 shadow-sm sm:p-3 sm:shadow">
                @if ($attachment)
                    <div class="relative">
                        <img x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{ asset(json_decode($message->attachment)) }}', imgModalDesc: '' })"
                            src="{{ asset(json_decode($message->attachment)) }}"
                            class="mx-auto mb-2 h-auto max-h-40 w-auto max-w-full cursor-pointer rounded-lg object-contain transition-opacity duration-200 hover:opacity-90 sm:max-h-52 sm:max-w-60">

                    </div>
                @endif
                @if ($message->body)
                    <p class="break-words pr-6 text-sm sm:text-base">{{ $message->body }}</p>
                    <p
                        class="{{ $isSender ? 'text-blue-100' : 'text-gray-500' }} xs:text-xs mt-1 flex items-center text-[10px]">
                        {{ $message->created_at->format('H:i') }}
                        @if ($isSender)
                            <i
                                class="fas {{ $message->seen ? 'fa-check-double text-blue-300' : 'fa-check' }} ml-1 text-xs"></i>
                        @endif
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

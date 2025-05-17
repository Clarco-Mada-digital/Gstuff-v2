

@php
    $isSender = $message->from_id == auth()->id();
@endphp

<div class="w-full flex {{ $isSender ? 'justify-end' : 'justify-start' }} mb-3 px-2 sm:px-4" data-id="{{ $message->id }}" x-data="{ showMenu: false }">
    <div class="flex items-start w-full {{ $isSender ? 'justify-end' : 'justify-start' }}">
        <div class="flex items-start max-w-full sm:max-w-[85%] md:max-w-[80%] lg:max-w-[75%] xl:max-w-[70%] 2xl:max-w-[65%]">
            @if ($message->from_id === auth()->user()->id)
                <div class="relative flex-shrink-0 mr-2 self-center">
                    <button @click.stop="showMenu = !showMenu" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200">
                        <i class="fas fa-ellipsis-v text-sm sm:text-base"></i>
                    </button>
                    <div x-show="showMenu" @click.away="showMenu = false"
                        class="absolute -left-10 mt-1 p-1 rounded-md bg-white shadow-lg z-10 border border-gray-100">
                        <div class="py-1">
                            <button @click="deleteMessage({{ $message->id }}); showMenu = false"
                                class="block w-full px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50 rounded transition-colors duration-200">
                                <i class="fas fa-trash mr-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            <div class="{{ $isSender ? 'bg-[#6366f1] text-white' : 'bg-white' }} rounded-lg p-2 sm:p-3 shadow-sm sm:shadow">
                @if ($attachment)
                    <div class="relative">
                        <img x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{ asset(json_decode($message->attachment)) }}', imgModalDesc: '' })"
                            src="{{ asset(json_decode($message->attachment)) }}"
                            class="mb-2 h-auto max-h-40 w-auto max-w-full mx-auto sm:max-h-52 sm:max-w-60 rounded-lg object-contain cursor-pointer hover:opacity-90 transition-opacity duration-200">
                       
                    </div>
                @endif
                @if ($message->body)
                    <p class="pr-6 text-sm sm:text-base break-words">{{ $message->body }}</p>
                    <p class="{{ $isSender ? 'text-blue-100' : 'text-gray-500' }} mt-1 text-[10px] xs:text-xs flex items-center">
                        {{ $message->created_at->format('H:i') }}
                        @if ($isSender)
                            <i class="fas {{ $message->seen ? 'fa-check-double text-blue-300' : 'fa-check' }} ml-1 text-xs"></i>
                        @endif
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

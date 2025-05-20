{{-- @if ($attachment)
    @php
        $imagePath = json_decode($message->attachment);
    @endphp
    <div class="wsus__single_chat_area message-card" data-id="{{ $message->id }}">
        <div class="wsus__single_chat {{ $message->from_id === auth()->user()->id ? 'chat_right' : '' }}">
            <a class="venobox" data-gall="gallery{{ $message->id }}" href="{{ asset($imagePath) }}">
                <img src="{{ asset($imagePath) }}" alt="" class="img-fluid w-100">
            </a>
            @if ($message->body)
                <p class="messages">{{ $message->body }}</p>
            @endif
            <span class="time"> {{ timeAgo($message->created_at) }}</span>
            @if ($message->from_id === auth()->user()->id)
            <a class="action dlt-message" data-id="{{ $message->id }}" href=""><i class="fas fa-trash"></i></a>
            @endif
        </div>
    </div>
@else
    <div class="wsus__single_chat_area message-card" data-id="{{ $message->id }}">
        <div class="wsus__single_chat {{ $message->from_id === auth()->user()->id ? 'chat_right' : '' }}">
            <p class="messages">{{ $message->body }}</p>
            <span class="time"> {{ timeAgo($message->created_at) }}</span>
            @if ($message->from_id === auth()->user()->id)
            <a class="action dlt-message" data-id="{{ $message->id }}" href=""><i class="fas fa-trash"></i></a>
            @endif
        </div>
    </div>
@endif --}}

@php
    $isSender = $message->from_id == auth()->id();
@endphp

<div class="{{ $isSender ? 'justify-end ms-auto' : 'justify-start me-auto' }} message-card group mb-3 flex w-[60%]"
    data-id="{{ $message->id }}" x-data="{ showDelete: false, pressTimer: null }"
    @mousedown="pressTimer = setTimeout(() => showDelete = true, 500)" @mouseup="clearTimeout(pressTimer)"
    @mouseleave="pressTimer = clearTimeout(pressTimer)"
    @touchstart.passive="pressTimer = setTimeout(() => showDelete = true, 500)" @touchend="clearTimeout(pressTimer)"
    @touchcancel="pressTimer = clearTimeout(pressTimer)">
    <div
        class="{{ $isSender ? 'bg-[#6366f1] text-white' : 'bg-white' }} relative max-w-xs rounded-lg p-3 shadow lg:max-w-md">
        @if ($attachment)
            <img x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{ asset(json_decode($message->attachment)) }}', imgModalDesc: '' })"
                src="{{ asset(json_decode($message->attachment)) }}"
                class="mb-2 h-auto max-w-60 rounded-lg object-cover">
        @endif
        @if ($message->body)
            <p>{{ $message->body }}</p>
            <p class="{{ $isSender ? 'text-blue-100' : 'text-gray-500' }} mt-1 text-xs">
                {{ $message->created_at->format('H:i') }}
                @if ($isSender)
                    <i class="fas {{ $message->seen ? 'fa-check-double text-blue-300' : 'fa-check' }} ml-1"></i>
                @endif
            </p>
        @endif
        @if ($message->from_id === auth()->user()->id)
            <button @click.stop="deleteMessage({{ $message->id }}); showDelete = false"
                x-show="showDelete || $el.matches(':hover')" @click.away="showDelete = false"
                class="absolute right-[110%] top-[50%] -translate-y-[50%] cursor-pointer text-red-500"
                data-id="{{ $message->id }}">
                <i class="fas fa-trash"></i>
            </button>
        @endif
    </div>
</div>

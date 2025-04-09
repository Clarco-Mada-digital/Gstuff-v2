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

<div class="flex group w-[60%] {{ $isSender ? 'justify-end ms-auto' : 'justify-start me-auto' }} mb-3 message-card"
    data-id="{{ $message->id }}">
    <div
        class="{{ $isSender ? 'bg-[#6366f1] text-white' : 'bg-white' }} relative rounded-lg p-3 max-w-xs lg:max-w-md shadow">
        @if ($attachment)
            <img x-on:click="$dispatch('img-modal', {  imgModalSrc: '{{ asset(json_decode($message->attachment)) }}', imgModalDesc: '' })"
                src="{{ asset(json_decode($message->attachment)) }}" class="rounded-lg mb-2 max-w-60 object-cover h-auto">
        @endif
        @if ($message->body)
            <p>{{ $message->body }}</p>
            <p class="text-xs mt-1 {{ $isSender ? 'text-blue-100' : 'text-gray-500' }}">
                {{ $message->created_at->format('H:i') }}
                @if ($isSender)
                    <i class="ml-1 fas {{ $message->seen ? 'fa-check-double text-blue-300' : 'fa-check' }}"></i>
                @endif
            </p>
        @endif
        @if ($message->from_id === auth()->user()->id)
            <button @click="deleteMessage({{ $message->id }})"
                class="hidden group-hover:block absolute text-red-500 top-[50%] -translate-y-[50%] right-[110%] cursor-pointer"
                data-id="{{ $message->id }}"><i class="fas fa-trash"></i></button>
        @endif
    </div>
</div>

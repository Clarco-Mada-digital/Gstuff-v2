@php
    use App\Models\User;
@endphp

<div x-data="{ open: @entangle('open') }" class="fixed bottom-10 right-10 z-40" x-cloak>
    @auth
        <button x-show="!open" wire:click="toggleChat" type="button" class="relative inline-flex items-center p-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
            <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
            <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
            </svg>
            <span class="sr-only">Message</span>
            @if ($unseenCounter > 0)
              <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">{{$unseenCounter}}</div>                
            @endif
        </button>

        <div x-show="open" @keydown.window.escape="open = false"
            class="flex flex-col items-center justify-between w-96 h-100 bg-white shadow-lg rounded-lg mb-5">
            <div class="flex justify-between items-center w-full p-4 bg-blue-500 text-white">
                <div class="flex items-center gap-2">
                    <button wire:click="resetSender" class="cursor-pointer"><img class="w-5 object-cover" src="{{asset('images/down-left.png')}}" alt="arrow-left-icon"></button>
                    @if ($userReceved)
                        <img src="@if ($userReceved->avatar) {{ asset('storage/avatars/' . $userReceved->avatar) }}
                    @else
                        {{ asset('images/icon_logo.png') }} @endif"
                            alt="Logo" class="w-10 h-10 rounded-full">
                    @endif
                    <span><strong>{{ $userReceved?->pseudo ?? ($userReceved?->prenom ?? ($userReceved?->nom_salon ?? 'chat')) }}</strong></span>

                </div>
                <button x-on:click="open = false" class="text-2xl cursor-pointer">&times;</button>
            </div>
            @if ($userReceved)
                <div x-data="{ scrollToBottom() { setTimeout(() => { this.$el.scrollTop = this.$el.scrollHeight; }, 100); } }" x-init="$wire.on('messages-loaded', () => scrollToBottom())" @updated.window="scrollToBottom()"
                    class="flex-1 w-full h-3/4 p-4 overflow-y-auto">
                    @forelse($messages as $message)
                        @if ($message->attachment)
                            @php
                                $imagePath = json_decode($message->attachment);
                            @endphp
                            <div class="wsus__single_chat_area message-card" data-id="{{ $message->id }}">
                                <div
                                    class="wsus__single_chat {{ $message->from_id === auth()->user()->id ? 'chat_right' : '' }}">
                                    <a class="venobox"
                                        x-on:click.stop="$dispatch('img-modal', {  imgModalSrc: '{{ asset($imagePath) }}', imgModalDesc: '' })">
                                        <img src="{{ asset($imagePath) }}" alt="" class="w-full object-cover">
                                    </a>
                                    @if ($message->body)
                                        <p class="messages text-sm">{{ $message->body }}</p>
                                    @endif
                                    <span class="time text-xs"> {{ timeAgo($message->created_at) }}</span>
                                    @if ($message->from_id === auth()->user()->id)
                                        <a class="action dlt-message" data-id="{{ $message->id }}" href=""><i
                                                class="fas fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="wsus__single_chat_area message-card" data-id="{{ $message->id }}">
                                <div
                                    class="wsus__single_chat {{ $message->from_id === auth()->user()->id ? 'chat_right' : '' }}">
                                    <p class="messages">{{ $message->body }}</p>
                                    <span class="time"> {{ timeAgo($message->created_at) }}</span>
                                    @if ($message->from_id === auth()->user()->id)
                                        <a wire:click='deleteMessage({{ $message->id }})' class="action dlt-message"
                                            data-id="{{ $message->id }}" href="#"><i class="fas fa-trash"></i></a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="text-center text-gray-500">
                            <p>Selectioné un utilisateur pour commencer la conversation !.</p>
                        </div>
                    @endforelse
                </div>
                <div class="p-4 border-t flex w-full items-center justify-center gap-2">
                    <input type="text" wire:model="message" class="w-full p-2 border rounded"
                        placeholder="Votre message..." />
                    <button wire:click="sendMessage" class="bg-blue-500 text-white p-2 rounded">Envoyer</button>
                </div>
            @else
                <div class="flex-1 w-full">
                    {!! $contacts !!}
                </div>
            @endif
        </div>
    @endauth
</div>

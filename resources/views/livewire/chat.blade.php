@php
    use App\Models\User;
@endphp

<div x-data="{ open: @entangle('open') }" class="fixed bottom-10 right-10 z-40" x-cloak>
    @auth
        <div x-show="!open">
            <button wire:click="toggleChat" class="bg-blue-500 text-white p-3 rounded-full shadow-lg cursor-pointer">
                <span class="text-xl"><svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7"
                        viewBox="0 0 24 24"><!-- Icon from All by undefined - undefined -->
                        <path fill="currentColor"
                            d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2S2 6.477 2 12c0 1.6.376 3.112 1.043 4.453c.178.356.237.763.134 1.148l-.595 2.226a1.3 1.3 0 0 0 1.591 1.592l2.226-.596a1.63 1.63 0 0 1 1.149.133A9.96 9.96 0 0 0 12 22" />
                    </svg></span>
            </button>
        </div>

        <div x-show="open" @keydown.window.escape="open = false"
            class="flex flex-col items-center justify-between w-96 h-100 bg-white shadow-lg rounded-lg mb-5">
            <div class="flex justify-between items-center w-full p-4 bg-blue-500 text-white">
                <div class="flex items-center gap-2">
                    <button wire:click="resetSender" class="cursor-pointer">🔙</button>
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

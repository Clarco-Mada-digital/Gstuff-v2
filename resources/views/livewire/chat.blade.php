@php
    use App\Models\User;
@endphp

<div x-data="{ open: @entangle('open') }" class="fixed bottom-6 right-6 z-50" x-cloak>
    @auth

        <!-- Bouton de chat flottant -->
        <button x-show="!open" wire:click="toggleChat" type="button"
            class="relative inline-flex items-center justify-center rounded-full bg-green-gs p-3 text-white shadow-lg transition-all duration-200 
            cursor-pointer hover:bg-green-gs/80 focus:outline-none"
            aria-label="{{ __('messenger.open_chat') }}">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 16" aria-hidden="true">
                <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                <path
                    d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
            </svg>
            @if ($unseenCounter > 0)
                <span
                    class="absolute -right-1 -top-1 inline-flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-red-500 text-xs font-bold text-white">
                    {{ min($unseenCounter, 99) }}
                </span>
            @endif
        </button>

        <!-- Fenêtre de chat -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4" @keydown.escape="open = false"
            class="flex h-[400px] w-[300px] max-w-sm flex-col overflow-hidden rounded-lg bg-white shadow-xl">

            <!-- En-tête du chat -->
            <div class="flex items-center justify-between bg-green-gs p-4 text-white font-roboto-slab">
                <div class="flex items-center space-x-3">
                    @if ($userReceved)
                        <button wire:click="resetSender" aria-label="{{ __('messenger.back_to_contacts') }}"
                            class="rounded-full p-1 transition-colors hover:bg-green-gs/80">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <img src="{{ $userReceved->avatar ? asset('storage/avatars/' . $userReceved->avatar) : asset('images/icon_logo.png') }}"
                            alt="Avatar de {{ $userReceved->pseudo ?? ($userReceved->prenom ?? ($userReceved->nom_salon ?? 'Utilisateur')) }}"
                            class="h-10 w-10 rounded-full border-2 border-white object-cover">
                        <h2 class="max-w-[180px] truncate font-semibold">
                            {{ $userReceved->pseudo ?? ($userReceved->prenom ?? ($userReceved->nom_salon ?? 'Chat')) }}
                        </h2>
                    @else
                        <h2 class="font-semibold">{{ __('messenger.messages') }}</h2>
                    @endif
                </div>
                <button @click="open = false" aria-label="{{ __('messenger.close_chat') }}"
                    class="rounded-full p-1 transition-colors hover:bg-supaGirlRose font-roboto-slab cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Zone de messages -->
            @if ($userReceved)
                <div x-data="{ scrollToBottom() { this.$el.scrollTop = this.$el.scrollHeight; } }" x-init="scrollToBottom();
                $wire.on('messages-loaded', scrollToBottom)"
                    class="flex-1 space-y-4 overflow-y-auto bg-gray-50 p-4">
                    @forelse($messages as $message)
                        <div class="{{ $message->from_id === auth()->user()->id ? 'justify-end' : 'justify-start' }} flex">
                            <div
                                class="{{ $message->from_id === auth()->user()->id ? 'bg-supaGirlRosePastel/100 text-green-gs' : 'bg-white border border-gray-200' }} max-w-[80%] rounded-lg p-3 font-roboto-slab">
                                @if ($message->attachment)
                                    @php $imagePath = json_decode($message->attachment); @endphp
                                    <a x-on:click.stop="$dispatch('img-modal', { imgModalSrc: '{{ asset($imagePath) }}', imgModalDesc: '' })"
                                        class="mb-2 block cursor-zoom-in">
                                        <img src="{{ asset($imagePath) }}" alt="Image partagée"
                                            class="max-h-60 w-full rounded object-cover">
                                    </a>
                                @endif

                                @if ($message->body)
                                    <p class="break-words whitespace-pre-wrap text-sm font-roboto-slab w-full max-w-full overflow-hidden">{{ $message->body }}</p>
                                @endif

                                <div class="mt-1 flex items-center justify-between text-xs text-gray-500">
                                    <span>{{ timeAgo($message->created_at) }}</span>
                                    @if ($message->from_id === auth()->user()->id)
                                        <button wire:click="deleteMessage({{ $message->id }})"
                                            aria-label="{{ __('messenger.delete_message') }}"
                                            class="ml-2 text-red-500 transition-colors hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex h-full items-center justify-center text-gray-500 font-roboto-slab text-sm">
                            <p>{{ __('messenger.select_user_to_start') }}</p>
                        </div>
                    @endforelse
                </div>

                <!-- Zone de saisie -->
                <div class="border-t border-gray-200 bg-white p-3">
                    <div class="flex space-x-2">
                        <input type="text" wire:model="message" wire:keydown.enter="sendMessage"
                            placeholder="{{ __('messenger.type_message') }}"
                            class="flex-1 rounded-full border border-gray-300 px-4 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-green-gs font-roboto-slab">
                        <button wire:click="sendMessage" @if ($sending) disabled @endif
                            class="rounded-full bg-green-gs px-4 py-2 text-white transition-colors hover:bg-green-gs/80 focus:outline-none font-roboto-slab cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            @else
                <!-- Liste des contacts -->
                <div class="flex-1 overflow-y-auto bg-gray-50 p-2">
                    {!! $contacts !!}
                </div>
            @endif
        </div>
    @endauth
</div>

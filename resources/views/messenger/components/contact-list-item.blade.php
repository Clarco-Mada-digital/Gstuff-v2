<div class="relative flex items-center p-3 shadow-sm hover:bg-gray-50
    {{ $user->is_profil_pause ? 'bg-yellow-50 opacity-80 cursor-not-allowed' : 'cursor-pointer' }}"
    @if (!$user->is_profil_pause) @click="loadChat({{ $user->id }})" @endif>

    <div class="relative">
        <img src="{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : asset('logo-icon.webp') }}"
            alt="{{ ucfirst($user->pseudo ?? ($user->prenom ?? $user->nom_salon)) }}"
            class="h-12 w-12 rounded-full object-cover">

        @if ($isOnline)
            <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-green-500"
                title="{{ __('messenger.online') }}"></span>
        @else
            <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-gray-400"
                title="{{ __('messenger.offline') }}"></span>
        @endif
    </div>

    <div class="ml-3 flex-1 relative">
        <div class="flex items-center justify-between">
            <h3 class="font-medium text-green-gs font-roboto-slab">
                {{ ucfirst($user->pseudo ?? ($user->prenom ?? $user->nom_salon)) }}
            </h3>
            <span class="text-xs text-textColorParagraph font-roboto-slab">
                {{ $lastMessage->created_at->diffForHumans() }}
            </span>
        </div>
        <div class="flex items-center">
            @if ($lastMessage->from_id == auth()->user()->id)
                <span class="text-xs text-textColorParagraph font-roboto-slab">
                    {{ __('messenger.you') }} :&nbsp;
                </span>
            @endif

            <p class="truncate text-sm text-textColorParagraph font-roboto-slab">
                @if ($lastMessage->attachment)
                    {{ __('messenger.image_sent') }}
                @else
                    {{ truncate($lastMessage->body, 10) }}
                @endif
            </p>
        </div>

        {{-- Badge Pause en bas à droite du bloc texte --}}
        @if ($user->is_profil_pause)
            <div class="group absolute bottom-0 right-0 z-10">
                <span class="bg-orange-400 text-white text-[10px] px-2 py-[2px] rounded-full shadow font-semibold">
                    {{ __('gestionPause.chatPauseBadge') }}
                </span>
                <div class="absolute bottom-full right-0 mb-1 w-52 bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    {{ __('gestionPause.chatPause') }}
                </div>
            </div>
        @endif
    </div>

    @if ($unseenCounter > 0)
        <span class="bg-green-gs ml-2 flex h-5 w-5 items-center justify-center rounded-full text-xs text-white">
            {{ $unseenCounter }}
        </span>
    @endif
</div>

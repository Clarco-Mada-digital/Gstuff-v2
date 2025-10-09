@props(['user', 'lastMessage', 'unseenCounter', 'isOnline'])

<div class="flex cursor-pointer items-center p-3 shadow-sm hover:bg-gray-50" @click="loadChat({{ $user->id }})">
    <div class="relative">
        <img src="{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : asset('icon-logo.png') }}"
            alt="{{ $user->pseudo ?? ($user->prenom ?? $user->nom_salon) }}" class="h-12 w-12 rounded-full object-cover">
        @if ($isOnline)
            <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-green-500"
                title="En ligne"></span>
        @else
            <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-gray-400"
                title="Hors ligne"></span>
        @endif
    </div>
    <div class="ml-3 flex-1">
        <div class="flex items-center justify-between">
            <h3 class="font-medium">{{ $user->pseudo ?? ($user->prenom ?? $user->nom_salon) }}</h3>
            <span class="text-xs text-gray-500">{{ $lastMessage->created_at->diffForHumans() }}</span>
        </div>
        <div class="flex items-center">
            @if ($lastMessage->from_id == auth()->user()->id)
                <span class="text-xs text-gray-400">Vous :</span>
            @endif
            <p class="truncate text-sm text-gray-500">{{ $lastMessage->body }}</p>
        </div>
    </div>
    @if ($unseenCounter > 0)
        <span class="bg-primary ml-2 flex h-5 w-5 items-center justify-center rounded-full text-xs text-white">
            {{ $unseenCounter }}
        </span>
    @endif
</div>

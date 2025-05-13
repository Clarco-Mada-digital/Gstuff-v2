@props([
    'user',
    'lastMessage',
    'unseenCounter',
    'isOnline'
])

<div class="p-3 hover:bg-gray-50 cursor-pointer flex items-center shadow-sm" @click="loadChat({{ $user->id }})">
    <div class="relative">
        <img src="{{ $user->avatar ? asset('storage/avatars/' . $user->avatar) : asset('icon-logo.png') }}"
            alt="{{ $user->pseudo ?? ($user->prenom ?? $user->nom_salon) }}" class="w-12 h-12 rounded-full object-cover">
        @if($isOnline)
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white" title="En ligne"></span>
        @else
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-gray-400 rounded-full border-2 border-white" title="Hors ligne"></span>
        @endif
    </div>
    <div class="ml-3 flex-1">
        <div class="flex justify-between items-center">
            <h3 class="font-medium">{{ $user->pseudo ?? ($user->prenom ?? $user->nom_salon) }}</h3>
            <span class="text-xs text-gray-500">{{ $lastMessage->created_at->diffForHumans() }}</span>
        </div>
        <div class="flex items-center">
            @if ($lastMessage->from_id == auth()->user()->id)
                <span class="text-xs text-gray-400">Vous :</span>
            @endif
            <p class="text-sm text-gray-500 truncate">{{ $lastMessage->body }}</p>
        </div>
    </div>
    @if ($unseenCounter > 0)
        <span class="ml-2 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
            {{ $unseenCounter }}
        </span>
    @endif
</div>

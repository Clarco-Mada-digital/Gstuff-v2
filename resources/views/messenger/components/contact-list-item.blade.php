{{-- <div class="wsus__user_list_item messenger-list-item" data-id="{{ $user->id }}">
    <div class="img">
        <img src="@if ($user->avatar)
            {{ asset('storage/avatars/'.$user->avatar) }}
        @else
            {{ asset('icon-logo.png')}}
        @endif" alt="User" class="img-fluid">
        <span class="inactive"></span>
    </div>
    <div class="text">
        <h5>{{ $user->pseudo?? $user->prenom?? $user->nom_salon }}</h5>
        @if ($lastMessage->from_id == auth()->user()->id)
        <p><span>Vous : </span> {{ truncate($lastMessage->body) }}</p>
        @else
        <p>{{ truncate($lastMessage->body) }}</p>

        @endif
    </div>
    @if($unseenCounter !== 0)
        <span class="badge bg-danger text-light unseen_count time">{{ $unseenCounter }}</span>
    @endif
</div> --}}

<div class="p-3 hover:bg-gray-50 cursor-pointer flex items-center" @click="loadChat({{ $user->id }})">
    <div class="relative">
        <img src="{{ $user->avatar ? asset('avatars/' . $user->avatar) : asset('icon-logo.png') }}" alt="{{ $user->pseudo ?? $user->prenom ?? $user->nom_salon }}" class="w-12 h-12 rounded-full object-cover">
        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
    </div>
    <div class="ml-3 flex-1">
        <div class="flex justify-between items-center">
            <h3 class="font-medium">{{ $user->pseudo ?? $user->prenom ?? $user->nom_salon }}</h3>
            <span class="text-xs text-gray-500">{{ $lastMessage->created_at->diffForHumans() }}</span>
        </div>
        <p class="text-sm text-gray-500 truncate">{{ $lastMessage->body }}</p>
    </div>
    @if($unseenCounter > 0)
    <span class="ml-2 bg-primary text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
        {{ $unseenCounter }}
    </span>
    @endif
</div>

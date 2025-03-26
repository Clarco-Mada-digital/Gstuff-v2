<div class="wsus__user_list_item messenger-list-item" data-id="{{ $user->id }}">
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
</div>

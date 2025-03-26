<div class="wsus__user_list_item messenger-list-item" data-id="{{ $record->id }}">
    <div class="img">
        <img src="@if ($record->avatar)
            {{ asset('storage/avatars/'.$record->avatar) }}
        @else
            {{ asset('icon-logo.png')}}
        @endif" alt="User" class="img-fluid">
    </div>
    <div class="text">
        <h5>{{ $record->pseudo?? $record->prenom?? $record->nom_salon }}</h5>
        <p>{{ $record->profile_type }}</p>
    </div>
</div>

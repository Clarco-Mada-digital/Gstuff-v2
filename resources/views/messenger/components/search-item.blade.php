{{-- <div class="wsus__user_list_item messenger-list-item" data-id="{{ $record->id }}">
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
</div> --}}

<div class="p-3 hover:bg-gray-50 cursor-pointer flex items-center" @click="loadChat({{ $record->id }})">
    <img src="{{ $record->avatar ? asset('avatars/'.$record->avatar) : asset('icon-logo.png') }}" alt="{{ $record->pseudo ?? $record->prenom ?? $record->nom_salon }}" class="w-10 h-10 rounded-full object-cover">
    <div class="ml-3">
        <h3 class="font-medium">{{ $record->pseudo ?? $record->prenom ?? $record->nom_salon }}</h3>
        <p class="text-xs text-gray-500">{{ $record->profile_type }}</p>
    </div>
</div>

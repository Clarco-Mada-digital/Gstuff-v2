<div class="flex cursor-pointer items-center p-3 hover:bg-gray-50" @click="loadChat({{ $record->id }})">
    <img src="{{ $record->avatar ? asset('avatars/' . $record->avatar) : asset('logo-icon.webp') }}"
        alt="{{ $record->pseudo ?? ($record->prenom ?? $record->nom_salon) }}"
        class="h-10 w-10 rounded-full object-cover">
    <div class="ml-3">
        <h3 class="text-green-gs font-roboto-slab font-medium">
            {{ $record->pseudo ?? ($record->prenom ?? $record->nom_salon) }}</h3>
        <p class="text-textColorParagraph font-roboto-slab text-xs">{{ $record->profile_type }}</p>
    </div>
</div>

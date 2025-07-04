@props([
    'createButtonText' => '',
    'inviteButtonText' => '',
    'class' => ''
])

<div class="mb-5 flex w-full items-center justify-between pt-10 {{ $class }}">
    <button 
        data-modal-target="createEscorte" 
        data-modal-toggle="createEscorte"
        class="bg-green-gs font-roboto-slab hover:bg-green-gs/90 cursor-pointer rounded-lg px-4 py-2 text-sm text-white transition-colors"
    >
        {{ $createButtonText }}
    </button>
    <button 
        data-modal-target="sendInvitationEscort"
        data-modal-toggle="sendInvitationEscort"
        class="bg-green-gs font-roboto-slab hover:bg-green-gs/90 cursor-pointer rounded-lg px-4 py-2 text-sm text-white transition-colors"
    >
        {{ $inviteButtonText }}
    </button>
</div>

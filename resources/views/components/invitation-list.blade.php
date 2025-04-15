@props(['invitationsRecus' , 'type'])

@if ($invitationsRecus->isNotEmpty())
    <div class="flex items-center justify-between gap-5 py-5">
        <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Invitation</h2>
        <div class="flex-1 h-0.5 bg-green-gs"></div>
    </div>

    <div class="relative w-full overflow-y-auto bg-white border border-gray-100 rounded-lg dark:bg-gray-700 dark:border-gray-600 m-h-50">
        <ul>
            @foreach ($invitationsRecus as $invitationsRecu)
                <li class="border-b border-gray-100 dark:border-gray-600">
                    <a href="#" class="flex items-center w-full px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 justify-between">
                        <div class="flex items-center">
                            <div class="me-3 rounded-full w-11 h-11">
                                <img x-on:click="$dispatch('img-modal', { imgModalSrc: '{{ $avatar = $invitationsRecu->inviter->avatar }}' ? '{{ asset('storage/avatars/' . $avatar) }}' : 'images/icon_logo.png', imgModalDesc: '' })" class="w-full h-full rounded-full object-center object-cover" @if ($avatar=$invitationsRecu->inviter->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                                @else
                                src="{{ asset('images/icon_logo.png') }}" @endif
                                alt="image profile" />
                            </div>
                            <div>
                                @if($type === 'escorte')
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Le salon <span class="font-medium text-gray-900 dark:text-white">{{ $invitationsRecu->inviter->nom_salon }}</span>
                                    vient d'envoyer une invitation pour rejoindre son salon.
                                </p>
                                @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    L'escorte <span class="font-medium text-gray-900 dark:text-white">{{ $invitationsRecu->inviter->prenom }}</span>
                                    vient d'envoyer une invitation pour rejoindre vos salon.
                                </p>
                                @endif
                                <span class="text-xs text-blue-600 dark:text-blue-500">
                                    {{ \Carbon\Carbon::parse($invitationsRecu->created_at)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>
                        <!-- Bouton pour ouvrir le modal et afficher les détails de l'invitation -->
                        <button class="py-2 px-3 w-32 flex items-center justify-center rounded-lg bg-green-gs text-sm xl:text-base text-white cursor-pointer hover:bg-green-800" data-modal-target="detailInvitation" data-modal-toggle="detailInvitation" x-on:click="$dispatch('invitation-detail', {
                            id: '{{ $invitationsRecu->id }}',
                            avatar: '{{ $invitationsRecu->inviter->avatar }}',
                            nomSalon: '{{ $type === 'escorte' ? $invitationsRecu->inviter->nom_salon : $invitationsRecu->inviter->prenom }}',
                            date: '{{ \Carbon\Carbon::parse($invitationsRecu->created_at)->translatedFormat('d F Y') }}',
                            type: '{{ $invitationsRecu->type ?? 'Non spécifié' }}',
                            email: '{{ $invitationsRecu->inviter->email ?? 'Non spécifié' }}'
                        })">
                            Détail
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div x-data="{ id: '', avatar: '', nomSalon: '', date: '', type: '', email: '' }" 
    x-on:invitation-detail.window="id = $event.detail.id; avatar = $event.detail.avatar; nomSalon = $event.detail.nomSalon; date = $event.detail.date; type = $event.detail.type; email = $event.detail.email" 
    id="detailInvitation" 
    tabindex="-1" 
    aria-hidden="true" 
    class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full backdrop-blur-sm">
   <!-- Modal -->
   <div class="bg-white rounded-lg shadow-lg p-6 w-full h-[30vh] md:w-[70vw] xl:w-[40vw] mx-auto overflow-y-auto">
       <h2 class="font-dm-serif font-bold text-2xl text-green-gs">Détails de l'invitation</h2>

       <div class="flex flex-wrap items-center mt-4 justify-between">
           <div class="me-3 rounded-xl w-32 h-32">
               <img :src="avatar ? `{{ asset('storage/avatars') }}/${avatar}` :
                           `{{ asset('images/icon_logo.png') }}`" class="w-full h-full rounded-full object-center object-cover" alt="Avatar salon">
           </div>
           <div class="w-[50%]">
               <p class="text-sm text-gray-500 dark:text-gray-400">Nom du salon : <span class="font-medium text-gray-900 dark:text-white" x-text="nomSalon"></span></p>
               <p class="text-sm text-gray-500 dark:text-gray-400">Email : <span class="font-medium text-gray-900 dark:text-white" x-text="email"></span></p>
               <p class="text-sm text-gray-500 dark:text-gray-400">Date d'envoi : <span class="font-medium text-gray-900 dark:text-white" x-text="date"></span></p>
               <p class="text-sm text-gray-500 dark:text-gray-400">Type : <span class="font-medium text-gray-900 dark:text-white" x-text="type"></span></p>
           </div>
       </div>
       <div class="flex justify-end items-center gap-4">
           <!-- Bouton pour refuser l'invitation -->
           <form :action="`{{ route('annuler.invitation', ':id') }}`.replace(':id', id)" method="POST" class="inline">
               @csrf
               <button class="bg-gray-300 rounded-sm text-black px-4 py-2 hover:bg-gray-400">
                   Refuser
               </button>
           </form>
           <!-- Bouton pour accepter l'invitation -->
           <form :action="`{{ route('accepter.invitation', ':id') }}`.replace(':id', id)" method="POST" class="inline">
               @csrf
               <button class="btn-gs-gradient text-black rounded-sm px-4 py-2 hover:bg-green-700">
                   Accepter
               </button>
           </form>
       </div>
   </div>
</div>

@endif

@props(['user', 'invitationsRecus', 'listInvitationSalons', 'salonAssociers'])

<div class="w-full">
    <button data-modal-target="gestionInvitation" data-modal-toggle="gestionInvitation" class="w-full p-2 text-green-gs text-sm rounded-lg border border-gray-400 cursor-pointer hover:bg-green-gs hover:text-white">Invitation</button>

    <div x-data="" x-init="" id="gestionInvitation" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[90vw] max-h-[90vh] xl:max-w-7xl overflow-y-auto">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Les invitations
                </h3>
            </div>

            <div class="text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <ul class="flex flex-wrap border-b border-gray-200 dark:border-gray-700" data-tabs-toggle="#tabs-content" role="tablist">
                    <li class="me-2">
                        <a href="#" data-tabs-target="#recus" class="inline-flex p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group" aria-controls="recus" role="tab" aria-selected="true">
                            Reçus
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="#" data-tabs-target="#enAttente" class="inline-flex p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group" aria-controls="enAttente" role="tab">
                            En attente
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="#" data-tabs-target="#accepter" class="inline-flex p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group" aria-controls="accepter" role="tab">
                            Accepter
                        </a>
                    </li>
                </ul>
            </div>

            <div id="tabs-content">
                <div id="recus" class="p-4" role="tabpanel" aria-labelledby="dashboard-tab">
                    @if($user->profile_type === 'escorte')
                        <div class="flex items-center mx-auto mb-4">
                            <label for="simple-search-recus" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search-recus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Chercher le nom ou email ..." oninput="filterInvitationsRecus(this.value)">
                            </div>
                        </div>
                        <ul id="invitation-list-recus" class="p-5 divide-y divide-gray-200 dark:divide-gray-700 h-[30vh] md:h-[35vh] xl:h-[40vh] overflow-y-auto">
                            @if($invitationsRecus->isNotEmpty())
                                @foreach ($invitationsRecus as $invitationsRecu)
                                    <li class="border-b border-gray-100 dark:border-gray-600" data-nameSalon-recus="{{ $invitationsRecu->inviter->nom_salon }}" data-emailSalon-recus="{{ $invitationsRecu->inviter->email }}">
                                        <div class="relative w-full overflow-y-auto bg-white border border-gray-100 rounded-lg dark:bg-gray-700 dark:border-gray-600 m-h-50">
                                            <a href="#" class="flex items-center w-full px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 justify-between">
                                                <div class="flex items-center">
                                                    <div class="me-3 rounded-full w-11 h-11">
                                                        <img x-on:click="$dispatch('img-modal', { imgModalSrc: '{{ $avatar = $invitationsRecu->inviter->avatar }}' ? '{{ asset('storage/avatars/' . $avatar) }}' : 'images/icon_logo.png', imgModalDesc: '' })" class="w-full h-full rounded-full object-center object-cover" @if ($avatar=$invitationsRecu->inviter->avatar) src="{{ asset('storage/avatars/' . $avatar) }}" @else src="{{ asset('images/icon_logo.png') }}" @endif alt="image profile" />
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            Le salon <span class="font-medium text-gray-900 dark:text-white">{{ $invitationsRecu->inviter->nom_salon }}</span>
                                                            vient d'envoyer une invitation pour rejoindre son salon.
                                                        </p>
                                                        <span class="text-xs text-blue-600 dark:text-blue-500">
                                                            {{ \Carbon\Carbon::parse($invitationsRecu->created_at)->translatedFormat('d F Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <button class="py-2 px-3 w-32 flex items-center justify-center rounded-lg bg-green-gs text-sm xl:text-base text-white cursor-pointer hover:bg-green-800" data-modal-target="detailInvitation" data-modal-toggle="detailInvitation" x-on:click="$dispatch('invitation-detail', {
                                                    id: '{{ $invitationsRecu->id }}',
                                                    avatar: '{{ $invitationsRecu->inviter->avatar }}',
                                                    nomSalon: '{{ $invitationsRecu->inviter->nom_salon }}',
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
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <div class="flex items-center justify-center py-10">
                                    <p class="text-gray-500 dark:text-gray-400">Aucune invitation reçue.</p>
                                </div>
                            @endif
                        </ul>
                    @else
                        <div class="flex items-center mx-auto mb-4">
                            <label for="simple-search-recus" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search-recus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Chercher le nom ou email ..." oninput="filterInvitationsRecus(this.value)">
                            </div>
                        </div>
                        <ul id="invitation-list-recus" class="p-5 divide-y divide-gray-200 dark:divide-gray-700 h-[30vh] md:h-[35vh] xl:h-[40vh] overflow-y-auto">
                            @if($invitationsRecus->isNotEmpty())
                                @foreach ($invitationsRecus as $invitationsRecu)
                                    <li class="border-b border-gray-100 dark:border-gray-600" data-nameSalon="{{ $invitationsRecu->inviter->nom_salon }}" data-emailSalon="{{ $invitationsRecu->inviter->email }}">
                                        <div class="relative w-full overflow-y-auto bg-white border border-gray-100 rounded-lg dark:bg-gray-700 dark:border-gray-600 m-h-50">
                                            <a href="#" class="flex items-center w-full px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800 justify-between">
                                                <div class="flex items-center">
                                                    <div class="me-3 rounded-full w-11 h-11">
                                                        <img x-on:click="$dispatch('img-modal', { imgModalSrc: '{{ $avatar = $invitationsRecu->inviter->avatar }}' ? '{{ asset('storage/avatars/' . $avatar) }}' : 'images/icon_logo.png', imgModalDesc: '' })" class="w-full h-full rounded-full object-center object-cover" @if ($avatar=$invitationsRecu->inviter->avatar) src="{{ asset('storage/avatars/' . $avatar) }}" @else src="{{ asset('images/icon_logo.png') }}" @endif alt="image profile" />
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            Le salon <span class="font-medium text-gray-900 dark:text-white">{{ $invitationsRecu->inviter->nom_salon }}</span>
                                                            vient d'envoyer une invitation pour rejoindre son salon.
                                                        </p>
                                                        <span class="text-xs text-blue-600 dark:text-blue-500">
                                                            {{ \Carbon\Carbon::parse($invitationsRecu->created_at)->translatedFormat('d F Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <button class="py-2 px-3 w-32 flex items-center justify-center rounded-lg bg-green-gs text-sm xl:text-base text-white cursor-pointer hover:bg-green-800" data-modal-target="detailInvitation" data-modal-toggle="detailInvitation" x-on:click="$dispatch('invitation-detail', {
                                                    id: '{{ $invitationsRecu->id }}',
                                                    avatar: '{{ $invitationsRecu->inviter->avatar }}',
                                                    nomSalon: '{{ $invitationsRecu->inviter->nom_salon }}',
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
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <div class="flex items-center justify-center py-10">
                                    <p class="text-gray-500 dark:text-gray-400">Aucune invitation reçue.</p>
                                </div>
                            @endif
                        </ul>
                    @endif
                </div>

                <div id="enAttente" class="p-4 hidden" role="tabpanel" aria-labelledby="profile-tab">
                    @if($user->profile_type === 'escorte')
                        <div class="flex items-center mx-auto">
                            <label for="simple-search-pending-salon" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search-pending-salon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Chercher le nom ou email ..." oninput="filterSalons(this.value, 'pending')">
                            </div>
                        </div>
                        <ul class="p-5 divide-y divide-gray-200 dark:divide-gray-700 h-[30vh] md:h-[35vh] xl:h-[40vh] overflow-y-auto" id="salon-list-pending">
                            @if($listInvitationSalons->isNotEmpty())
                                @foreach($listInvitationSalons as $invitation)
                                    <li class="pt-3 pb-0 sm:pt-4" data-name="{{ $invitation->invited->nom_salon }}" data-email="{{ $invitation->invited->email }}">
                                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                            <div class="shrink-0">
                                                <img class="w-8 h-8 rounded-full" src="{{ $invitation->invited->avatar ? asset('storage/avatars/'.$invitation->invited->avatar) : asset('images/icon_logo.png') }}" alt="{{ $invitation->invited->prenom }}">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    {{ $invitation->invited->nom_salon }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    {{ $invitation->invited->email }}
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($invitation->created_at)->translatedFormat('d F Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                @if($invitation->created_at->ne($invitation->updated_at))
                                                    <span class="px-2 py-1 text-xs font-semibold bg-red-200 text-red-600 rounded-md">
                                                        Refusée
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold bg-yellow-200 text-yellow-600 rounded-md">
                                                        En attente
                                                    </span>
                                                @endif
                                                <form action="{{ route('invitations.cancel', $invitation->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 mx-2 text-xs font-semibold bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                                        Annuler
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-center text-gray-500 py-4">
                                    Aucune invitation en attente.
                                </li>
                            @endif
                        </ul>
                    @else
                
                        <div class="flex items-center mx-auto">
                            <label for="simple-search-pending-salon" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search-pending-salon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Chercher le nom ou email ..." oninput="filterSalons(this.value, 'pending')">
                            </div>
                        </div>
                        <ul class="p-5 divide-y divide-gray-200 dark:divide-gray-700 h-[30vh] md:h-[35vh] xl:h-[40vh] overflow-y-auto" id="salon-list-pending">
                           
                            @if($listInvitationSalons->isNotEmpty())
                                @foreach($listInvitationSalons as $invitation)
                                    <li class="pt-3 pb-0 sm:pt-4" data-name="{{ $invitation->invited->prenom }}" data-email="{{ $invitation->invited->email }}">
                                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                            <div class="shrink-0">
                                                <img class="w-8 h-8 rounded-full" src="{{ $invitation->invited->avatar ? asset('storage/avatars/'.$invitation->invited->avatar) : asset('images/icon_logo.png') }}" alt="{{ $invitation->invited->prenom }}">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    {{ $invitation->invited->prenom }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    {{ $invitation->invited->email }}
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($invitation->created_at)->translatedFormat('d F Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                @if($invitation->created_at->ne($invitation->updated_at))
                                                    <span class="px-2 py-1 text-xs font-semibold bg-red-200 text-red-600 rounded-md">
                                                        Refusée
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 text-xs font-semibold bg-yellow-200 text-yellow-600 rounded-md">
                                                        En attente
                                                    </span>
                                                @endif
                                                <form action="{{ route('invitations.cancel', $invitation->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 mx-2 text-xs font-semibold bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                                        Annuler
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-center text-gray-500 py-4">
                                    Aucune invitation en attente.
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>

                <div id="accepter" class="p-4 hidden" role="tabpanel" aria-labelledby="settings-tab">
                    <div class="flex items-center mx-auto">
                        <label for="simple-search-pending-Salon" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search-pending-Salon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Chercher le nom ou email ..." oninput="filterSalonsAccepter(this.value)">
                        </div>
                    </div>
                    <ul id="salon-list-accepted" class="p-5 divide-y divide-gray-200 dark:divide-gray-700 h-[30vh] md:h-[35vh] xl:h-[40vh] overflow-y-auto">
                        @if($salonAssociers->isNotEmpty())
                            @foreach ($salonAssociers as $salonAssocier)
                                @if($user->profile_type === 'salon')
                                    @if($salonAssocier->type === "associe au salon")
                                        <li class="pt-3 pb-0 sm:pt-4" data-nameSalon="{{ $salonAssocier->inviter->prenom }}" data-emailSalon="{{ $salonAssocier->inviter->email }}">
                                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                <div class="shrink-0">
                                                    <img class="w-8 h-8 rounded-full" src="{{ $salonAssocier->inviter->avatar ? asset('storage/avatars/'.$salonAssocier->inviter->avatar) : asset('images/icon_logo.png') }}" alt="{{ $salonAssocier->inviter->prenom }}">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                        {{ $salonAssocier->inviter->prenom }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        {{ $salonAssocier->inviter->email }}
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($salonAssocier->created_at)->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <form action="{{ route('invitations.cancel', $salonAssocier->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2 py-1 mx-2 text-xs font-semibold bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                                            Annuler
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @else
                                        <li class="pt-3 pb-0 sm:pt-4" data-nameSalon="{{ $salonAssocier->invited->prenom }}" data-emailSalon="{{ $salonAssocier->invited->email }}">
                                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                <div class="shrink-0">
                                                    <img class="w-8 h-8 rounded-full" src="{{ $salonAssocier->invited->avatar ? asset('storage/avatars/'.$salonAssocier->invited->avatar) : asset('images/icon_logo.png') }}" alt="{{ $salonAssocier->invited->prenom }}">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                        {{ $salonAssocier->invited->prenom }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        {{ $salonAssocier->invited->email }}
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($salonAssocier->created_at)->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <form action="{{ route('invitations.cancel', $salonAssocier->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2 py-1 mx-2 text-xs font-semibold bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                                            Annuler
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @else
                                    @if($salonAssocier->type === "associe au salon")
                                        <li class="pt-3 pb-0 sm:pt-4" data-nameSalon="{{ $salonAssocier->invited->nom_salon }}" data-emailSalon="{{ $salonAssocier->invited->email }}">
                                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                <div class="shrink-0">
                                                    <img class="w-8 h-8 rounded-full" src="{{ $salonAssocier->invited->avatar ? asset('storage/avatars/'.$salonAssocier->invited->avatar) : asset('images/icon_logo.png') }}" alt="{{ $salonAssocier->invited->prenom }}">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                        {{ $salonAssocier->invited->nom_salon }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        {{ $salonAssocier->invited->email }}
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($salonAssocier->created_at)->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <form action="{{ route('invitations.cancel', $salonAssocier->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2 py-1 mx-2 text-xs font-semibold bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                                            Annuler
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @else
                                        <li class="pt-3 pb-0 sm:pt-4" data-nameSalon="{{ $salonAssocier->inviter->prenom }}" data-emailSalon="{{ $salonAssocier->inviter->email }}">
                                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                <div class="shrink-0">
                                                    <img class="w-8 h-8 rounded-full" src="{{ $salonAssocier->inviter->avatar ? asset('storage/avatars/'.$salonAssocier->inviter->avatar) : asset('images/icon_logo.png') }}" alt="{{ $salonAssocier->inviter->prenom }}">
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                        {{ $salonAssocier->inviter->nom_salon }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        {{ $salonAssocier->inviter->email }}
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($salonAssocier->created_at)->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <form action="{{ route('invitations.cancel', $salonAssocier->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-2 py-1 mx-2 text-xs font-semibold bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                                                            Annuler
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        @else
                            <li class="text-center text-gray-500 py-4">
                                Aucune invitation en accepter.
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filterSalons(query, type) {
        const salonItems = document.querySelectorAll(`#salon-list-${type} li`);
        salonItems.forEach(item => {
            const name = item.getAttribute('data-name')?.toLowerCase() || '';
            const email = item.getAttribute('data-email')?.toLowerCase() || '';
            if (name.includes(query.toLowerCase()) || email.includes(query.toLowerCase())) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function filterInvitationsRecus(query) {
        const invitationItems = document.querySelectorAll('#invitation-list-recus li');
        invitationItems.forEach(item => {
            const name = item.getAttribute('data-nameSalon-recus')?.toLowerCase() || '';
            const email = item.getAttribute('data-emailSalon-recus')?.toLowerCase() || '';
            if (name.includes(query.toLowerCase()) || email.includes(query.toLowerCase())) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function filterSalonsAccepter(query) {
        console.log(`Filtering accepted salons with query: ${query}`);
        const salonItems = document.querySelectorAll('#salon-list-accepted li');
        salonItems.forEach(item => {
            const name = item.getAttribute('data-nameSalon')?.toLowerCase() || '';
            const email = item.getAttribute('data-emailSalon')?.toLowerCase() || '';
            if (name.includes(query.toLowerCase()) || email.includes(query.toLowerCase())) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>

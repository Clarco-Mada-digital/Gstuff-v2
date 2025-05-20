@props(['invitationsRecus', 'type'])

@if ($invitationsRecus->isNotEmpty())
    <div class="flex items-center justify-between gap-5 py-5">
        <h2 class="font-dm-serif text-green-gs text-2xl font-bold">Invitation</h2>
        <div class="bg-green-gs h-0.5 flex-1"></div>
    </div>

    <div
        class="m-h-50 relative w-full overflow-y-auto rounded-lg border border-gray-100 bg-white dark:border-gray-600 dark:bg-gray-700">
        <ul>
            @foreach ($invitationsRecus as $invitationsRecu)
                <li class="border-b border-gray-100 dark:border-gray-600">
                    <a href="#"
                        class="flex w-full items-center justify-between px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <div class="flex items-center">
                            <div class="me-3 h-11 w-11 rounded-full">
                                <img x-on:click="$dispatch('img-modal', { imgModalSrc: '{{ $avatar = $invitationsRecu->inviter->avatar }}' ? '{{ asset('storage/avatars/' . $avatar) }}' : 'images/icon_logo.png', imgModalDesc: '' })"
                                    class="h-full w-full rounded-full object-cover object-center"
                                    @if ($avatar = $invitationsRecu->inviter->avatar) src="{{ asset('storage/avatars/' . $avatar) }}"
                                @else
                                src="{{ asset('images/icon_logo.png') }}" @endif
                                    alt="image profile" />
                            </div>
                            <div>
                                @if ($type === 'escorte')
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Le salon <span
                                            class="font-medium text-gray-900 dark:text-white">{{ $invitationsRecu->inviter->nom_salon }}</span>
                                        vient d'envoyer une invitation pour rejoindre son salon.
                                    </p>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        L'escorte <span
                                            class="font-medium text-gray-900 dark:text-white">{{ $invitationsRecu->inviter->prenom }}</span>
                                        vient d'envoyer une invitation pour rejoindre vos salon.
                                    </p>
                                @endif
                                <span class="text-xs text-blue-600 dark:text-blue-500">
                                    {{ \Carbon\Carbon::parse($invitationsRecu->created_at)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>
                        <!-- Bouton pour ouvrir le modal et afficher les détails de l'invitation -->
                        <button
                            class="bg-green-gs flex w-32 cursor-pointer items-center justify-center rounded-lg px-3 py-2 text-sm text-white hover:bg-green-800 xl:text-base"
                            data-modal-target="detailInvitation" data-modal-toggle="detailInvitation"
                            x-on:click="$dispatch('invitation-detail', {
                            id: '{{ $invitationsRecu->id }}',
                            avatar: '{{ $invitationsRecu->inviter->avatar }}',
                            nomSalon: '{{ $type === 'escorte' ? $invitationsRecu->inviter->nom_salon : $invitationsRecu->inviter->prenom }}',
                            date: '{{ \Carbon\Carbon::parse($invitationsRecu->created_at)->translatedFormat('d F Y') }}',
                            type: '{{ $invitationsRecu->type ?? 'Non spécifié' }}',
                            email: '{{ $invitationsRecu->inviter->email ?? 'Non spécifié' }}'
                        })">
                            Détail
                            <svg class="ms-2 h-3.5 w-3.5 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div x-data="{ id: '', avatar: '', nomSalon: '', date: '', type: '', email: '' }"
        x-on:invitation-detail.window="id = $event.detail.id; avatar = $event.detail.avatar; nomSalon = $event.detail.nomSalon; date = $event.detail.date; type = $event.detail.type; email = $event.detail.email"
        id="detailInvitation" tabindex="-1" aria-hidden="true"
        class="z-90 fixed left-0 right-0 top-0 hidden h-full w-full items-center justify-center backdrop-blur-sm">
        <!-- Modal -->
        <div
            class="z-100 mx-auto h-[30vh] w-full overflow-y-auto rounded-lg bg-white p-6 shadow-lg md:w-[70vw] xl:w-[40vw]">
            <h2 class="font-dm-serif text-green-gs text-2xl font-bold">Détails de l'invitation</h2>

            <div class="mt-4 flex flex-wrap items-center justify-between">
                <div class="me-3 h-32 w-32 rounded-xl">
                    <img :src="avatar ? `{{ asset('storage/avatars') }}/${avatar}` :
                        `{{ asset('images/icon_logo.png') }}`"
                        class="h-full w-full rounded-full object-cover object-center" alt="Avatar salon">
                </div>
                <div class="w-[50%]">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nom du salon : <span
                            class="font-medium text-gray-900 dark:text-white" x-text="nomSalon"></span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Email : <span
                            class="font-medium text-gray-900 dark:text-white" x-text="email"></span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Date d'envoi : <span
                            class="font-medium text-gray-900 dark:text-white" x-text="date"></span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Type : <span
                            class="font-medium text-gray-900 dark:text-white" x-text="type"></span></p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-4">
                <!-- Bouton pour refuser l'invitation -->
                <form :action="`{{ route('annuler.invitation', ':id') }}`.replace(':id', id)" method="POST"
                    class="inline">
                    @csrf
                    <button class="rounded-sm bg-red-300 px-4 py-2 text-black hover:bg-red-400">
                        Refuser
                    </button>
                </form>
                <!-- Bouton pour accepter l'invitation -->
                <form :action="`{{ route('accepter.invitation', ':id') }}`.replace(':id', id)" method="POST"
                    class="inline">
                    @csrf
                    <button class="btn-gs-gradient rounded-sm px-4 py-2 text-black hover:bg-green-700">
                        Accepter
                    </button>
                </form>
            </div>
        </div>
    </div>

@endif

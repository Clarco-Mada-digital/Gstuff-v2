@props(['invitationsRecus', 'type'])

@if ($invitationsRecus->isNotEmpty())
    <div class="flex items-center justify-between gap-5 py-5">
        <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('invitations.title') }}</h2>
        <div class="bg-green-gs h-0.5 flex-1"></div>
    </div>

    <div
        class="m-h-50 relative w-full overflow-y-auto rounded-lg border border-gray-100 bg-white dark:border-gray-600 dark:bg-gray-700">
        <ul>
            @foreach ($invitationsRecus as $invitationsRecu)
                <li class="border-b border-gray-100 dark:border-gray-600">
                    <a href="#"
                        class="flex w-full flex-wrap items-center justify-between px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <div class="flex items-center flex-wrap">
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
                                    <p class="text-sm text-gray-500 font-roboto-slab ">
                                       {{ __('invitations.invitation_received.salon', ['name' => $invitationsRecu->inviter->nom_salon ?? $invitationsRecu->inviter->prenom ?? $invitationsRecu->inviter->pseudo]) }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-500 font-roboto-slab ">
                                       {{ __('invitations.invitation_received.escort', ['name' => $invitationsRecu->inviter->prenom ?? $invitationsRecu->inviter->pseudo]) }}
                                    </p>
                                @endif
                                <span class="text-xs text-supaGirlRose font-roboto-slab">
                                    {{ \Carbon\Carbon::parse($invitationsRecu->created_at)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>
                        <!-- Bouton pour ouvrir le modal et afficher les détails de l'invitation -->
                        <button
                            class="bg-green-gs flex w-32 cursor-pointer items-center justify-center rounded-lg px-3 py-2 text-sm text-white hover:bg-green-gs/80
                            font-roboto-slab mt-4"
                            data-modal-target="detailInvitation" data-modal-toggle="detailInvitation"
                            x-on:click="$dispatch('invitation-detail', {
                            id: '{{ $invitationsRecu->id }}',
                            avatar: '{{ $invitationsRecu->inviter->avatar }}',
                            nomSalon: '{{ $type === 'escorte' ? $invitationsRecu->inviter->nom_salon : $invitationsRecu->inviter->prenom }}',
                            date: '{{ \Carbon\Carbon::parse($invitationsRecu->created_at)->translatedFormat('d F Y') }}',
                            type: '{{ $invitationsRecu->type ?? 'Non spécifié' }}',
                            email: '{{ $invitationsRecu->inviter->email ?? 'Non spécifié' }}'
                        })">
                            {{ __('invitations.detail') }}
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
        class="z-90 fixed left-0 right-0 top-0 hidden h-full w-full items-center justify-center backdrop-blur-s px-4 ">
        <!-- Modal -->
        <div
            class="z-100 mx-auto  w-full font-roboto-slab overflow-y-auto rounded-lg bg-white p-6 shadow-lg md:w-[70vw] xl:w-[40vw]">
            <h2 class="font-roboto-slab text-green-gs text-2xl font-bold">{{ __('invitations.detailAll.title') }}</h2>

            <div class="mt-4 flex flex-wrap items-center justify-between">
                <div class="me-3 h-32 w-32 rounded-xl">
                    <img :src="avatar ? `{{ asset('storage/avatars') }}/${avatar}` :
                        `{{ asset('images/icon_logo.png') }}`"
                        class="h-full w-full rounded-full object-cover object-center" alt="Avatar salon">
                </div>
                <div class="w-[50%]">
                    <p class="text-sm text-gray-500 font-roboto-slab  ">{{ __('invitations.detailAll.nomSalon') }} : <span
                            class="font-medium text-gray-900 " x-text="nomSalon"></span></p>
                    <p class="text-sm text-gray-500 font-roboto-slab  ">{{ __('invitations.detailAll.email') }} : <span
                            class="font-medium text-gray-900 " x-text="email"></span></p>
                    <p class="text-sm text-gray-500 font-roboto-slab  ">{{ __('invitations.detailAll.date') }} : <span
                            class="font-medium text-gray-900 " x-text="date"></span></p>
                    <!-- <p class="text-sm text-gray-500  ">{{ __('invitations.detailAll.type') }} : <span
                            class="font-medium text-gray-900 " x-text="type"></span></p> -->
                </div>
            </div>
            <div class="flex items-center justify-center gap-4 mt-4">
                <!-- Bouton pour refuser l'invitation -->
                <form :action="`{{ route('annuler.invitation', ':id') }}`.replace(':id', id)" method="POST"
                    class="inline">
                    @csrf
                    <button class="cursor-pointer rounded-sm bg-white px-4 py-2 text-green-gs hover:bg-fieldBg font-roboto-slab shadow-sm">
                        {{ __('invitations.detailAll.action.decline') }}
                    </button>
                </form>
                <!-- Bouton pour accepter l'invitation -->
                <form :action="`{{ route('accepter.invitation', ':id') }}`.replace(':id', id)" method="POST"
                    class="inline">
                    @csrf
                    <button class="cursor-pointer rounded-sm bg-green-gs px-4 py-2 text-white font-roboto-slab hover:bg-green-gs/80">
                        {{ __('invitations.detailAll.action.accept') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

@endif

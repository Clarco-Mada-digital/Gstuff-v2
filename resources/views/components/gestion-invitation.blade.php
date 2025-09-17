@props(['user', 'invitationsRecus', 'listInvitationSalons', 'salonAssociers'])

<div class="my-2 w-[90%]">
    <button data-modal-target="gestionInvitation" data-modal-toggle="gestionInvitation"
        class="text-green-gs hover:bg-green-gs border-supaGirlRose font-roboto-slab w-full cursor-pointer rounded-lg border p-2 text-xs md:text-sm hover:text-white">{{ __('invitations.title') }}</button>

    <div x-data="" x-init="" id="gestionInvitation" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="max-h-[90vh] w-[90vw] overflow-y-auto rounded-lg bg-white p-6 shadow-lg xl:max-w-7xl">
            <div
                class="font-roboto-slab flex items-center justify-between rounded-t border-b border-gray-200 p-4 md:p-5">
                <h3 class="text-green-gs font-roboto-slab text-xs md:text-sm font-semibold">
                    {{ __('invitations.title') }}
                </h3>
            </div>

            <div class="font-roboto-slab text-center text-xs md:text-sm font-medium text-gray-500">
                <ul class="flex flex-wrap border-b border-gray-200" data-tabs-toggle="#tabs-content" role="tablist">

                    <li class="me-2">
                        <a href="#" data-tabs-target="#enAttente"
                            class="hover:border-green-gs/50 hover:text-green-gs group text-xs md:text-sm  inline-flex rounded-t-lg border-b-2 border-transparent p-4"
                            aria-controls="enAttente" role="tab">
                            {{ __('invitations.tabs.pending') }}
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="#" data-tabs-target="#accepter"
                            class="hover:border-green-gs/50 hover:text-green-gs group text-xs md:text-sm inline-flex rounded-t-lg border-b-2 border-transparent p-4"
                            aria-controls="accepter" role="tab">
                            {{ __('invitations.tabs.accepted') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div id="tabs-content">


                <div id="enAttente" class="hidden p-4" role="tabpanel" aria-labelledby="profile-tab">
                    @if ($user->profile_type === 'escorte')
                        <div class="mx-auto flex items-center">
                            <label for="simple-search-pending-salon"
                                class="sr-only text-xs md:text-sm">{{ __('invitations.search_placeholder') }}</label>
                            <div class="relative w-full">
                                <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search-pending-salon"
                                    class="font-roboto-slab text-green-gs border-supaGirlRose focus:border-green-gs focus:ring-green-gs block w-full rounded-lg border border-2 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900"
                                    placeholder="{{ __('invitations.search_placeholder') }}"
                                    oninput="filterSalons(this.value, 'pending')">
                            </div>
                        </div>
                        <ul class="h-[30vh] divide-y divide-gray-200 overflow-y-auto p-5 md:h-[35vh] xl:h-[40vh] dark:divide-gray-700"
                            id="salon-list-pending">
                            @if ($listInvitationSalons->isNotEmpty())
                                @foreach ($listInvitationSalons as $invitation)
                                    <li class="pb-0 pt-3 sm:pt-4" data-name="{{ $invitation->invited->nom_salon }}"
                                        data-email="{{ $invitation->invited->email }}">
                                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                            <div class="shrink-0">
                                                <img class="h-8 w-8 rounded-full"
                                                    src="{{ $invitation->invited->avatar ? asset('storage/avatars/' . $invitation->invited->avatar) : asset('images/icon_logo.png') }}"
                                                    alt="{{ $invitation->invited->prenom }}">
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $invitation->invited->nom_salon }}
                                                </p>
                                                <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $invitation->invited->email }}
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-xs md:text-sm font-semibold text-gray-900 dark:text-white">
                                                <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($invitation->created_at)->translatedFormat('d F Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                @if ($invitation->created_at->ne($invitation->updated_at))
                                                    <span
                                                        class="rounded-md bg-red-200 px-2 py-1 text-xs font-semibold text-red-600">
                                                        {{ __('invitations.status.refused') }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="rounded-md bg-yellow-200 px-2 py-1 text-xs font-semibold text-yellow-600">
                                                        {{ __('invitations.status.pending') }}
                                                    </span>
                                                @endif
                                                <form action="{{ route('invitations.cancel', $invitation->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="mx-2 rounded-md bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-800 hover:bg-gray-300">
                                                        {{ __('invitations.cancel') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <x-empty-state message="{{ __('invitations.no_pending') }}" />
                            @endif
                        </ul>
                    @else
                        <div class="mx-auto flex items-center">
                            <label for="simple-search-pending-salon"
                                class="sr-only text-xs md:text-sm">{{ __('invitations.search_placeholder') }}</label>
                            <div class="relative w-full">
                                <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search-pending-salon"
                                    class="border-supaGirlRose font-roboto-slab text-green-gs focus:border-green-gs focus:ring-green-gs block w-full rounded-lg border border-2 bg-gray-50 p-2.5 ps-10 text-sm"
                                    placeholder="{{ __('invitations.search_placeholder') }}"
                                    oninput="filterSalons(this.value, 'pending')">
                            </div>
                        </div>
                        <ul class="h-[30vh] divide-y divide-gray-200 overflow-y-auto p-5 md:h-[35vh] xl:h-[40vh] dark:divide-gray-700"
                            id="salon-list-pending">

                            @if ($listInvitationSalons->isNotEmpty())
                                @foreach ($listInvitationSalons as $invitation)
                                    <li class="pb-0 pt-3 sm:pt-4" data-name="{{ $invitation->invited->prenom }}"
                                        data-email="{{ $invitation->invited->email }}">
                                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                            <div class="shrink-0">
                                                <img class="h-8 w-8 rounded-full"
                                                    src="{{ $invitation->invited->avatar ? asset('storage/avatars/' . $invitation->invited->avatar) : asset('images/icon_logo.png') }}"
                                                    alt="{{ $invitation->invited->prenom }}">
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $invitation->invited->prenom }}
                                                </p>
                                                <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $invitation->invited->email }}
                                                </p>
                                            </div>
                                            <div
                                                class="inline-flex items-center text-xs md:text-sm font-semibold text-gray-900 dark:text-white">
                                                <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($invitation->created_at)->translatedFormat('d F Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                @if ($invitation->created_at->ne($invitation->updated_at))
                                                    <span
                                                        class="rounded-md bg-red-200 px-2 py-1 text-xs font-semibold text-red-600">
                                                        {{ __('invitations.status.refused') }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="rounded-md bg-yellow-200 px-2 py-1 text-xs font-semibold text-yellow-600">
                                                        {{ __('invitations.status.pending') }}
                                                    </span>
                                                @endif
                                                <form action="{{ route('invitations.cancel', $invitation->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="mx-2 rounded-md bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-800 hover:bg-gray-300">
                                                        {{ __('invitations.detailAll.action.cancel') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <x-empty-state message="{{ __('invitations.no_pending') }}" />
                            @endif
                        </ul>
                    @endif
                </div>

                <div id="accepter" class="hidden p-4" role="tabpanel" aria-labelledby="settings-tab">
                    <div class="mx-auto flex items-center">
                        <label for="simple-search-pending-Salon" class="sr-only text-xs md:text-sm">Search</label>
                        <div class="relative w-full">
                            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search-pending-Salon"
                                class="border-supaGirlRose font-roboto-slab text-green-gs focus:border-green-gs focus:ring-green-gs block w-full rounded-lg border border-2 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900"
                                placeholder="{{ __('invitations.search_placeholder') }}"
                                oninput="filterSalonsAccepter(this.value)">
                        </div>
                    </div>
                    <ul id="salon-list-accepted"
                        class="h-[30vh] divide-y divide-gray-200 overflow-y-auto p-5 md:h-[35vh] xl:h-[40vh]">
                        @if ($salonAssociers->isNotEmpty())
                            @foreach ($salonAssociers as $salonAssocier)
                                @if ($user->profile_type === 'salon')
                                    @if ($salonAssocier->type === 'associe au salon')
                                        <li class="pb-0 pt-3 sm:pt-4"
                                            data-nameSalon="{{ $salonAssocier->inviter->prenom }}"
                                            data-emailSalon="{{ $salonAssocier->inviter->email }}">
                                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                <div class="shrink-0">
                                                    <img class="h-8 w-8 rounded-full"
                                                        src="{{ $salonAssocier->inviter->avatar ? asset('storage/avatars/' . $salonAssocier->inviter->avatar) : asset('images/icon_logo.png') }}"
                                                        alt="{{ $salonAssocier->inviter->prenom }}">
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p
                                                        class="truncate text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $salonAssocier->inviter->prenom }}
                                                    </p>
                                                    <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $salonAssocier->inviter->email }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="inline-flex items-center text-xs md:text-sm font-semibold text-gray-900 dark:text-white">
                                                    <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($salonAssocier->created_at)->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <form
                                                        action="{{ route('invitations.cancel', $salonAssocier->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="mx-2 rounded-md bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-800 hover:bg-gray-300">
                                                            {{ __('invitations.action.cancel') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @else
                                        <li class="pb-0 pt-3 sm:pt-4"
                                            data-nameSalon="{{ $salonAssocier->invited->prenom }}"
                                            data-emailSalon="{{ $salonAssocier->invited->email }}">
                                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                <div class="shrink-0">
                                                    <img class="h-8 w-8 rounded-full"
                                                        src="{{ $salonAssocier->invited->avatar ? asset('storage/avatars/' . $salonAssocier->invited->avatar) : asset('images/icon_logo.png') }}"
                                                        alt="{{ $salonAssocier->invited->prenom }}">
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p
                                                        class="truncate text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $salonAssocier->invited->prenom }}
                                                    </p>
                                                    <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $salonAssocier->invited->email }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="inline-flex items-center text-xs md:text-sm font-semibold text-gray-900 dark:text-white">
                                                    <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($salonAssocier->created_at)->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <form
                                                        action="{{ route('invitations.cancel', $salonAssocier->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="mx-2 rounded-md bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-800 hover:bg-gray-300">
                                                            {{ __('invitations.action.cancel') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @else
                                    @if ($salonAssocier->type === 'associe au salon')
                                        <li class="pb-0 pt-3 sm:pt-4"
                                            data-nameSalon="{{ $salonAssocier->invited->nom_salon }}"
                                            data-emailSalon="{{ $salonAssocier->invited->email }}">
                                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                <div class="shrink-0">
                                                    <img class="h-8 w-8 rounded-full"
                                                        src="{{ $salonAssocier->invited->avatar ? asset('storage/avatars/' . $salonAssocier->invited->avatar) : asset('images/icon_logo.png') }}"
                                                        alt="{{ $salonAssocier->invited->prenom }}">
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p
                                                        class="truncate text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $salonAssocier->invited->nom_salon }}
                                                    </p>
                                                    <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $salonAssocier->invited->email }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="inline-flex items-center text-xs md:text-sm font-semibold text-gray-900 dark:text-white">
                                                    <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($salonAssocier->created_at)->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <form
                                                        action="{{ route('invitations.cancel', $salonAssocier->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="mx-2 rounded-md bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-800 hover:bg-gray-300">
                                                            {{ __('invitations.action.cancel') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @else
                                        <li class="pb-0 pt-3 sm:pt-4"
                                            data-nameSalon="{{ $salonAssocier->inviter->prenom }}"
                                            data-emailSalon="{{ $salonAssocier->inviter->email }}">
                                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                <div class="shrink-0">
                                                    <img class="h-8 w-8 rounded-full"
                                                        src="{{ $salonAssocier->inviter->avatar ? asset('storage/avatars/' . $salonAssocier->inviter->avatar) : asset('images/icon_logo.png') }}"
                                                        alt="{{ $salonAssocier->inviter->prenom }}">
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p
                                                        class="truncate text-xs md:text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $salonAssocier->inviter->nom_salon }}
                                                    </p>
                                                    <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $salonAssocier->inviter->email }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="inline-flex items-center text-xs md:text-sm font-semibold text-gray-900 dark:text-white">
                                                    <p class="truncate text-xs md:text-sm text-gray-500 dark:text-gray-400">
                                                        {{ \Carbon\Carbon::parse($salonAssocier->created_at)->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <form
                                                        action="{{ route('invitations.cancel', $salonAssocier->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="mx-2 rounded-md bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-800 hover:bg-gray-300">
                                                            {{ __('invitations.action.cancel') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
                        @else
                            <x-empty-state message="{{ __('invitations.no_accepted') }}" />
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

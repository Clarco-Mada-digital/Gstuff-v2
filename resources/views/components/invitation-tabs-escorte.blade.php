
@props(['salonsNoInvited', 'listInvitationSalon'])

<div class="bg-white rounded-lg shadow-lg p-6 w-full h-[60vh] md:w-[70vw] xl:w-[50vw] mx-auto md:h-[55vh] xl:h-[60vh]">
    <ul class="text-sm mb-5 font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400" data-tabs-toggle="#tabs-content-salon" role="tablist">
        <li class="flex-1">
            <button id="new-invitation-tab-salon" data-tabs-target="#new-invitation-salon" type="button" role="tab" aria-controls="new-invitation-salon" aria-selected="true" class="w-full p-4 text-blue-700 bg-gray-100 rounded-l-lg dark:bg-gray-800 dark:text-blue-500">
                Nouvelle invitation
            </button>
        </li>
        <li class="flex-1">
            <button id="pending-invitation-tab-salon" data-tabs-target="#pending-invitation-salon" type="button" role="tab" aria-controls="pending-invitation-salon" aria-selected="false" class="w-full p-4 bg-white hover:bg-gray-100 dark:hover:bg-gray-800 dark:bg-gray-700">
                Invitation en attente
            </button>
        </li>
    </ul>
    <div id="tabs-content-salon" class="md:h-[calc(100%-4rem)] xl:h-[calc(100%-4rem)]">
        <!-- Nouvelle invitation -->
        <form id="new-invitation-salon" role="tabpanel" aria-labelledby="new-invitation-tab-salon" action="{{ route('inviter.salon') }}" method="POST" class="h-full">
            @csrf
            <div class="flex items-center mx-auto">
                <label for="simple-search-salon" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search-new-salon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Chercher le nom ou email ..." oninput="filterSalons(this.value, 'new')">
                </div>
            </div>

            <ul class="p-5 divide-y divide-gray-200 dark:divide-gray-700 h-[30vh] md:h-[30vh] xl:h-[35vh] overflow-y-auto" id="salon-list-new">
                @foreach($salonsNoInvited as $salon)
                    <li class="pt-3 pb-0 sm:pt-4" data-name="{{ $salon->prenom }}" data-email="{{ $salon->email }}">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="shrink-0">
                                <img class="w-8 h-8 rounded-full" src="{{ $salon->avatar ? asset('storage/avatars/'.$salon->avatar) : asset('images/icon_logo.png') }}" alt="{{ $salon->prenom }}">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $salon->nom_salon }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ $salon->email }}
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <input id="salon-{{ $salon->id }}" name="salon_ids[]" type="checkbox" value="{{ $salon->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="flex justify-center">
                <button type="submit" class="p-2.5 my-2 w-full md:w-auto text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Envoyer la demande
                </button>
            </div>
        </form>

        <!-- Pour les invitations en attentes -->
        <div id="pending-invitation-salon" role="tabpanel" aria-labelledby="pending-invitation-tab-salon" class="h-full">
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
                @if($listInvitationSalon->isEmpty())
                    <li class="text-center text-gray-500 py-4">
                        Aucune invitation en attente.
                    </li>
                @else
                    @foreach($listInvitationSalon as $invitation)
                        <li class="pt-3 pb-0 sm:pt-4" data-name="{{ $invitation->invited->prenom }}" data-email="{{ $invitation->invited->email }}">
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
                @endif
            </ul>
        </div>
    </div>
</div>

<script>
    function filterSalons(query, type) {
        const salonItems = document.querySelectorAll(`#salon-list-${type} li`);

        salonItems.forEach(item => {
            const name = item.getAttribute('data-name').toLowerCase();
            const email = item.getAttribute('data-email').toLowerCase();
            if (name.includes(query.toLowerCase()) || email.includes(query.toLowerCase())) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function filterSalonsAccepter(query, type) {
    const salonItems = document.querySelectorAll(`#salon-list-${type} li`);

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
function filterInvitationsRecus(query) {
    const invitationItems = document.querySelectorAll('#invitation-list-recus li');

    invitationItems.forEach(item => {
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

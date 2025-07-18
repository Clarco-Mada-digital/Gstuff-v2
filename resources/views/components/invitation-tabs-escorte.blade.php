@props(['salonsNoInvited', 'listInvitationSalon'])

<div class="mx-auto h-[60vh] w-full rounded-lg bg-white p-6 shadow-lg md:h-[55vh] md:w-[70vw] xl:h-[60vh] xl:w-[50vw]">
    <ul class="mb-5 divide-x divide-gray-200 rounded-lg text-center text-sm font-medium text-gray-500 shadow sm:flex dark:divide-gray-700 dark:text-gray-400"
        data-tabs-toggle="#tabs-content-salon" role="tablist">
        <li class="flex-1">
            <button id="new-invitation-tab-salon" data-tabs-target="#new-invitation-salon" type="button" role="tab"
                aria-controls="new-invitation-salon" aria-selected="true"
                class="w-full rounded-l-lg bg-gray-100 p-4 text-blue-700 dark:bg-gray-800 dark:text-blue-500">
                {{ __('profile.new_invitation') }}
            </button>
        </li>
        <li class="flex-1">
            <button id="pending-invitation-tab-salon" data-tabs-target="#pending-invitation-salon" type="button"
                role="tab" aria-controls="pending-invitation-salon" aria-selected="false"
                class="w-full bg-white p-4 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-800">
                {{ __('profile.pending_invitation') }}
            </button>
        </li>
    </ul>
    <div id="tabs-content-salon" class="md:h-[calc(100%-4rem)] xl:h-[calc(100%-4rem)]">
        <!-- Nouvelle invitation -->
        <form id="new-invitation-salon" role="tabpanel" aria-labelledby="new-invitation-tab-salon"
            action="{{ route('inviter.salon') }}" method="POST" class="h-full">
            @csrf
            <div class="mx-auto flex items-center">
                <label for="simple-search-salon" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search-new-salon"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="{{ __('profile.search_placeholder') }}" oninput="filterSalons(this.value, 'new')">
                </div>
            </div>

            <ul class="h-[30vh] divide-y divide-gray-200 overflow-y-auto p-5 md:h-[30vh] xl:h-[35vh] dark:divide-gray-700"
                id="salon-list-new">
                @foreach ($salonsNoInvited as $salon)
                    <li class="pb-0 pt-3 sm:pt-4" data-name="{{ $salon->prenom }}" data-email="{{ $salon->email }}">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="shrink-0">
                                <img class="h-8 w-8 rounded-full"
                                    src="{{ $salon->avatar ? asset('storage/avatars/' . $salon->avatar) : asset('images/icon_logo.png') }}"
                                    alt="{{ $salon->prenom }}">
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $salon->nom_salon }}
                                </p>
                                <p class="truncate text-sm text-gray-500 dark:text-gray-400">
                                    {{ $salon->email }}
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <input id="salon-{{ $salon->id }}" name="salon_ids[]" type="checkbox"
                                    value="{{ $salon->id }}"
                                    class="h-4 w-4 rounded-sm border-gray-300 bg-gray-100 text-green-gs focus:ring-2 focus:ring-green-gs dark:border-gray-600 ">
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="flex justify-center">
                <button type="submit"
                    class="bg-green-gs border-green-gs my-2 w-full rounded-lg border p-2.5 text-sm font-medium text-white hover:bg-green-gs/80 focus:outline-none focus:ring-4 focus:ring-green-gs/80 md:w-auto ">
                    {{ __('profile.send_request') }}
                </button>
            </div>
        </form>

        <!-- Pour les invitations en attentes -->
        <div id="pending-invitation-salon" role="tabpanel" aria-labelledby="pending-invitation-tab-salon"
            class="h-full">
            <div class="mx-auto flex items-center">
                <label for="simple-search-pending-salon" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search-pending-salon"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="{{ __('profile.search_placeholder') }}"
                        oninput="filterSalons(this.value, 'pending')">
                </div>
            </div>
            <ul class="h-[30vh] divide-y divide-gray-200 overflow-y-auto p-5 md:h-[35vh] xl:h-[40vh] dark:divide-gray-700"
                id="salon-list-pending">
                @if ($listInvitationSalon->isEmpty())
                    <li class="py-4 text-center text-gray-500">
                        {{ __('profile.no_pending_invitations') }}
                    </li>
                @else
                    @foreach ($listInvitationSalon as $invitation)
                        <li class="pb-0 pt-3 sm:pt-4" data-name="{{ $invitation->invited->prenom }}"
                            data-email="{{ $invitation->invited->email }}">
                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                <div class="shrink-0">
                                    <img class="h-8 w-8 rounded-full"
                                        src="{{ $invitation->invited->avatar ? asset('storage/avatars/' . $invitation->invited->avatar) : asset('images/icon_logo.png') }}"
                                        alt="{{ $invitation->invited->prenom }}">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $invitation->invited->nom_salon }}
                                    </p>
                                    <p class="truncate text-sm text-gray-500 dark:text-gray-400">
                                        {{ $invitation->invited->email }}
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    <p class="truncate text-sm text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($invitation->created_at)->translatedFormat('d F Y') }}
                                    </p>
                                </div>
                                <div>
                                    @if ($invitation->created_at->ne($invitation->updated_at))
                                        <span
                                            class="rounded-md bg-red-200 px-2 py-1 text-xs font-semibold text-red-600">
                                            {{ __('profile.refused') }}
                                        </span>
                                    @else
                                        <span
                                            class="rounded-md bg-yellow-200 px-2 py-1 text-xs font-semibold text-yellow-600">
                                            {{ __('profile.pending') }}
                                        </span>
                                    @endif
                                    <form action="{{ route('invitations.cancel', $invitation->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="mx-2 rounded-md bg-gray-200 px-2 py-1 text-xs font-semibold text-gray-800 hover:bg-gray-300">
                                            {{ __('profile.cancel') }}
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
</script>

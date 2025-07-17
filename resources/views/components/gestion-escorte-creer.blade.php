@props(['allrelation'])

@php
    // Convertir la collection en tableau avec les propriétés nécessaires
    $escortes = collect($allrelation)->map(function($item) {
        return [
            'id' => $item->invited->id ?? $item->invited_id,
            'prenom' => $item->invited->prenom ?? 'Inconnu',
            'email' => $item->invited->email ?? '',
            'createbysalon' => $item->type === 'creer par salon',
            'type' => $item->type
        ];
    })->toArray();
@endphp

<div x-data="{
    search: '',
    filteredEscortes: @js($escortes),
    selectedEscorte: null,
    showSupprimerModal: false,
    showSupprimerRelationModal: false,
    showAutonomiserModal: false,
    log() {
        console.log('filteredEscortes', this.filteredEscortes);
    },
    supprimerEscorte(escorte) {
        this.selectedEscorte = escorte;
        this.showSupprimerModal = true;
        this.log();
    },
    supprimerRelation(escorte) {
        this.selectedEscorte = escorte;
        this.showSupprimerRelationModal = true;
        this.log();
    },
    autonomiserEscorte(escorte) {
        this.selectedEscorte = escorte;
        this.showAutonomiserModal = true;
    },
    closeModal() {
        this.showSupprimerModal = false;
        this.showAutonomiserModal = false;
        this.selectedEscorte = null;
        this.showSupprimerRelationModal = false;
    }
}" class="flex w-full flex-col items-center ">
    <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch" data-dropdown-placement="bottom"
        class="flex items-center text-green-gs hover:bg-supaGirlRose flex w-[90%] cursor-pointer items-center  border-b border-gray-400 p-2 text-left font-bold hover:text-green-gs"
        type="button">

        <svg width="27" height="26" viewBox="0 0 27 26" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect y="0.526367" width="25" height="25" rx="12.5" fill="#FED5E9"/>
        <path d="M9 8.52637C7.35 8.52637 6 9.87637 6 11.5264C6 12.5184 6.4885 13.4014 7.2345 13.9484C5.916 14.6024 5 15.9584 5 17.5264H6C6 15.8644 7.338 14.5264 9 14.5264C10.662 14.5264 12 15.8644 12 17.5264H13C13 15.8644 14.338 14.5264 16 14.5264C17.662 14.5264 19 15.8644 19 17.5264H20C20 15.9579 19.084 14.6024 17.7655 13.9484C18.1474 13.6704 18.4583 13.3061 18.6728 12.8852C18.8874 12.4643 18.9994 11.9988 19 11.5264C19 9.87637 17.65 8.52637 16 8.52637C14.35 8.52637 13 9.87637 13 11.5264C13 12.5184 13.4885 13.4014 14.2345 13.9484C13.5039 14.3075 12.8992 14.8794 12.5 15.5889C12.1008 14.8794 11.4961 14.3075 10.7655 13.9484C11.1474 13.6704 11.4583 13.3061 11.6728 12.8852C11.8874 12.4643 11.9994 11.9988 12 11.5264C12 9.87637 10.65 8.52637 9 8.52637ZM9 9.52637C10.1115 9.52637 11 10.4149 11 11.5264C11 12.6379 10.1115 13.5264 9 13.5264C7.8885 13.5264 7 12.6379 7 11.5264C7 10.4149 7.8885 9.52637 9 9.52637ZM16 9.52637C17.1115 9.52637 18 10.4149 18 11.5264C18 12.6379 17.1115 13.5264 16 13.5264C14.8885 13.5264 14 12.6379 14 11.5264C14 10.4149 14.8885 9.52637 16 9.52637Z" fill="#7F55B1"/>
        <path d="M7.59375 6.43262C4.80938 6.43262 2.53125 8.71074 2.53125 11.4951C2.53125 13.1691 3.35559 14.6592 4.61447 15.5822C2.3895 16.6859 0.84375 18.9741 0.84375 21.6201H2.53125C2.53125 18.8155 4.78913 16.5576 7.59375 16.5576C10.3984 16.5576 12.6562 18.8155 12.6562 21.6201H14.3438C14.3438 18.8155 16.6016 16.5576 19.4062 16.5576C22.2109 16.5576 24.4688 18.8155 24.4688 21.6201H26.1562C26.1562 18.9733 24.6105 16.6859 22.3855 15.5822C23.03 15.1131 23.5546 14.4984 23.9166 13.7882C24.2787 13.078 24.4678 12.2923 24.4688 11.4951C24.4688 8.71074 22.1906 6.43262 19.4062 6.43262C16.6219 6.43262 14.3438 8.71074 14.3438 11.4951C14.3438 13.1691 15.1681 14.6592 16.427 15.5822C15.1941 16.1882 14.1737 17.1534 13.5 18.3506C12.8263 17.1534 11.8059 16.1882 10.573 15.5822C11.2175 15.1131 11.7421 14.4984 12.1042 13.7882C12.4662 13.078 12.6553 12.2923 12.6562 11.4951C12.6562 8.71074 10.3781 6.43262 7.59375 6.43262ZM7.59375 8.12012C9.46941 8.12012 10.9688 9.61946 10.9688 11.4951C10.9688 13.3708 9.46941 14.8701 7.59375 14.8701C5.71809 14.8701 4.21875 13.3708 4.21875 11.4951C4.21875 9.61946 5.71809 8.12012 7.59375 8.12012ZM19.4062 8.12012C21.2819 8.12012 22.7812 9.61946 22.7812 11.4951C22.7812 13.3708 21.2819 14.8701 19.4062 14.8701C17.5306 14.8701 16.0312 13.3708 16.0312 11.4951C16.0312 9.61946 17.5306 8.12012 19.4062 8.12012Z" fill="#7F55B1"/>
        </svg>

        <span class="ml-2 font-roboto-slab w-[80%]">{{ __('profile.my_escorts') }}</span>
        <svg class="ms-3 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div id="dropdownSearch"
        class="md:w-xl z-10 hidden w-[90%] rounded-lg bg-white shadow-sm sm:w-[80%] lg:w-96 dark:bg-gray-700">
        <div class="p-3">
            <label for="input-group-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="input-group-search" x-model="search"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-500 dark:bg-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    placeholder="{{ __('profile.search_placeholder') }}">
            </div>
        </div>
        <ul class="h-48 overflow-y-auto px-3 pb-3 text-sm text-gray-700 dark:text-gray-200"
            aria-labelledby="dropdownSearchButton">
            <template x-for="escorte in filteredEscortes" :key="escorte.id">
                <li x-show="escorte.prenom.toLowerCase().includes(search.toLowerCase())" class="my-2">
                    <div
                        class="flex items-center justify-between rounded-lg bg-white px-3 py-2 shadow transition-colors duration-300 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <label class="text-sm font-semibold text-gray-900 dark:text-white"
                                x-text="escorte.prenom"></label>
                        </div>
                        <div class="flex space-x-4">
                            <a href="#" x-show="escorte.createbysalon"
                                @click.prevent="window.location.href = `{{ url('escorte/gerer') }}/${escorte.id}`"
                                class="text-yellow-500 hover:text-yellow-600"
                                :data-tooltip-target="'tooltip-gerer-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-cog"></i>
                            </a>
                            <div :id="'tooltip-gerer-' + escorte.id" role="tooltip" x-show="escorte.createbysalon"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                {{ __('profile.manage') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <a href="#" x-show="!escorte.createbysalon"
                                @click.prevent="window.location.href = `{{ url('escorte') }}/${escorte.id}`"
                                class="text-yellow-500 hover:text-yellow-600"
                                :data-tooltip-target="'tooltip-voir-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-eye"></i>
                            </a>
                            <div :id="'tooltip-voir-' + escorte.id" role="tooltip" x-show="!escorte.createbysalon"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                {{ __('profile.view') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <a href="#" @click.stop.prevent="supprimerRelation(escorte)" x-show="!escorte.createbysalon"
                                class="text-red-500 hover:text-red-700"
                                :data-tooltip-target="'tooltip-supprimer-relation-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-times"></i>
                            </a>
                            <div :id="'tooltip-supprimer-relation-' + escorte.id" role="tooltip" x-show="!escorte.createbysalon"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                {{ __('profile.delete_relation') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <a href="#" @click.stop.prevent="supprimerEscorte(escorte)" x-show="escorte.createbysalon"
                                class="text-red-500 hover:text-red-700"
                                :data-tooltip-target="'tooltip-supprimer-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-trash"></i>
                            </a>
                            <div :id="'tooltip-supprimer-' + escorte.id" role="tooltip" x-show="escorte.createbysalon"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                {{ __('profile.delete') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <a href="#" @click.stop.prevent="autonomiserEscorte(escorte)" x-show="escorte.createbysalon"
                                class="text-green-gs hover:text-green-gs"
                                :data-tooltip-target="'tooltip-autonomiser-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-user-cog"></i>
                            </a>
                            <div :id="'tooltip-autonomiser-' + escorte.id" role="tooltip" x-show="escorte.createbysalon"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                {{ __('profile.autonomize') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                    </div>
                </li>
            </template>
        </ul>
    </div>

    <!-- Modal for Supprimer -->
    <div x-cloak x-show="showSupprimerModal" x-transition.opacity.duration.200ms
        x-trap.inert.noscroll="showSupprimerModal" x-on:keydown.esc.window="showSupprimerModal = false"
        x-on:click.self="showSupprimerModal = false"
        class="z-100 fixed inset-0 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
        role="dialog" aria-modal="true" aria-labelledby="supprimerModalTitle">
        <div x-show="showSupprimerModal"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
            class="relative flex w-auto flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">
            <!--content-->
            <div
                class="relative flex w-full flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">
                <!--header-->
                <div class="flex items-start justify-between rounded-t border-b border-solid border-gray-300 p-5">
                    <h3 class="text-3xl font-semibold">
                        {{ __('profile.delete_escort') }}
                    </h3>
                    <button
                        class="float-right ml-auto border-0 bg-transparent p-1 text-3xl font-semibold leading-none text-black outline-none focus:outline-none"
                        @click="closeModal">
                        <span class="block h-6 w-6 bg-transparent text-2xl text-black outline-none focus:outline-none">
                            ×
                        </span>
                    </button>
                </div>
                <!--body-->
                <div class="relative flex-auto p-6">
                    <p class="my-4 text-lg leading-relaxed text-gray-600">
                        {{ __('profile.are_you_sure') }} <span x-text="selectedEscorte.prenom"></span>?
                    </p>
                </div>
                <!--footer-->
                <div class="flex items-center justify-end rounded-b border-t border-solid border-gray-300 p-6">
                    <button x-on:click="showSupprimerModal = false"
                        class="background-transparent mb-1 mr-1 px-6 py-2 text-sm font-bold uppercase text-red-500 outline-none focus:outline-none"
                        type="button">
                        {{ __('profile.cancel') }}
                    </button>

                    <form x-bind:action="`{{ url('escorte/delete') }}/${selectedEscorte.id}`" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            class="mb-1 mr-1 rounded bg-red-500 px-6 py-3 text-sm font-bold uppercase text-white shadow outline-none hover:shadow-lg focus:outline-none active:bg-red-600"
                            type="submit" x-on:click="console.log('Supprimer', selectedEscorte)">
                            {{ __('profile.delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Autonomiser -->
    <div x-cloak x-show="showAutonomiserModal" x-transition.opacity.duration.200ms
        x-trap.inert.noscroll="showAutonomiserModal" x-on:keydown.esc.window="showAutonomiserModal = false"
        x-on:click.self="showAutonomiserModal = false"
        class="z-100 fixed inset-0 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
        role="dialog" aria-modal="true" aria-labelledby="autonomiserModalTitle">
        <div x-show="showAutonomiserModal"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
            class="rounded-radius bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark flex w-96 flex-col gap-4 overflow-hidden">

            <!--content-->
            <div
                class="relative flex w-full flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">
                <!--header-->
                <div class="flex items-start justify-between rounded-t border-b border-solid border-gray-300 p-5">
                    <h3 class="text-xl font-semibold">
                        {{ __('profile.autonomize_escort') }}
                    </h3>
                    <button
                        class="float-right ml-auto border-0 bg-transparent p-1 text-3xl font-semibold leading-none text-black outline-none focus:outline-none"
                        @click="closeModal">
                        <span class="block h-6 w-6 bg-transparent text-2xl text-black outline-none focus:outline-none">
                            ×
                        </span>
                    </button>
                </div>
                <!--body-->
                <div class="relative flex-auto p-6">
                    <label for="email"
                        class="mb-2 block text-sm leading-relaxed text-gray-300">{{ __('profile.name') }}</label>
                    <h1 class="mb-2 text-lg leading-relaxed text-gray-600" x-text="selectedEscorte.prenom">
                    </h1>
                    <label for="email"
                        class="mb-2 block text-sm leading-relaxed text-gray-300">{{ __('profile.email') }}</label>
                    <h1 class="mb-2 text-lg leading-relaxed text-gray-600" x-text="selectedEscorte.email">
                    </h1>

                    <label for="email"
                        class="mb-2 block text-sm leading-relaxed text-gray-200">{{ __('profile.default_password') }}</label>
                    <h1 class="mb-2 text-lg leading-relaxed text-gray-600">password
                    </h1>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('profile.password_change_notice') }}</p>
                </div>
                <!--footer-->
                <div class="flex items-center justify-end rounded-b border-t border-solid border-gray-300 p-6">
                    <button x-on:click="showAutonomiserModal = false"
                        class="text-green-gs background-transparent mb-1 mr-1 px-6 py-2 text-sm font-bold uppercase outline-none focus:outline-none"
                        type="button">
                        {{ __('profile.cancel') }}
                    </button>

                    <form x-bind:action="`{{ url('escorte/autonomiser') }}/${selectedEscorte.id}`" method="POST">
                        @csrf
                        <button
                            class="bg-green-gs mb-1 mr-1 rounded px-6 py-3 text-sm font-bold uppercase text-white shadow outline-none hover:shadow-lg focus:outline-none active:bg-green-600"
                            type="submit">
                            {{ __('profile.autonomize') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


     <!-- Modal for Supprimer -->
     <div x-cloak x-show="showSupprimerRelationModal" x-transition.opacity.duration.200ms
        x-trap.inert.noscroll="showSupprimerRelationModal" x-on:keydown.esc.window="showSupprimerRelationModal = false"
        x-on:click.self="showSupprimerRelationModal = false"
        class="z-100 fixed inset-0 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8"
        role="dialog" aria-modal="true" aria-labelledby="supprimerRelationModalTitle">
        <div x-show="showSupprimerRelationModal"
            x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
            x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
            class="relative flex w-auto flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">
            <!--content-->
            <div
                class="relative flex w-full flex-col rounded-lg border-0 bg-white shadow-lg outline-none focus:outline-none">
                <!--header-->
                <div class="flex items-start justify-between rounded-t border-b border-solid border-gray-300 p-5">
                    <h3 class="text-3xl font-semibold">
                        {{ __('profile.delete_relation') }}
                    </h3>
                    <button
                        class="float-right ml-auto border-0 bg-transparent p-1 text-3xl font-semibold leading-none text-black outline-none focus:outline-none"
                        @click="closeModal">
                        <span class="block h-6 w-6 bg-transparent text-2xl text-black outline-none focus:outline-none">
                            ×
                        </span>
                    </button>
                </div>
                <!--body-->
                <div class="relative flex-auto p-6">
                    <p class="my-4 text-lg leading-relaxed text-gray-600">
                        {{ __('profile.are_you_sure_delete_relation') }} <span x-text="selectedEscorte.prenom"></span>?
                    </p>
                </div>
                <!--footer-->
                <div class="flex items-center justify-end rounded-b border-t border-solid border-gray-300 p-6">
                    <button x-on:click="showSupprimerRelationModal = false"
                        class="background-transparent mb-1 mr-1 px-6 py-2 text-sm font-bold uppercase text-red-500 outline-none focus:outline-none"
                        type="button">
                        {{ __('profile.cancel') }}
                    </button>
                    <form x-bind:action="`{{ url('/invitations/supprimer') }}/${selectedEscorte.id}`" method="POST">
                        @csrf
                        <button
                            class="mb-1 mr-1 rounded bg-red-500 px-6 py-3 text-sm font-bold uppercase text-white shadow outline-none hover:shadow-lg focus:outline-none active:bg-red-600"
                            type="submit" x-on:click="console.log('Supprimer', selectedEscorte)">
                            {{ __('invitations.detailAll.action.decline') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@props(['escorteCreateByUser'])

<div x-data="{
    search: '',
    filteredEscortes: @js($escorteCreateByUser),
    selectedEscorte: null,
    showSupprimerModal: false,
    showAutonomiserModal: false,
    supprimerEscorte(escorte) {
        this.selectedEscorte = escorte;
        this.showSupprimerModal = true;
    },
    autonomiserEscorte(escorte) {
        this.selectedEscorte = escorte;
        this.showAutonomiserModal = true;
    },
    closeModal() {
        this.showSupprimerModal = false;
        this.showAutonomiserModal = false;
        this.selectedEscorte = null;
    }
}" class="w-full flex flex-col justify-center items-center">
    <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch" data-dropdown-placement="bottom"
        class="text-green-gs hover:bg-green-gs flex w-[90%] cursor-pointer items-center justify-between border-b border-gray-400 p-2 text-left font-bold hover:text-white"
        type="button">
        {{ __('profile.my_escorts') }}
        <svg class="ms-3 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div id="dropdownSearch"
        class="md:w-xl z-10 hidden rounded-lg bg-white shadow-sm w-[90%] sm:w-[80%] lg:w-96 dark:bg-gray-700">
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
                            <a href="#"
                                @click.prevent="window.location.href = `{{ url('escorte/gerer') }}/${escorte.id}`"
                                class="text-yellow-500 hover:text-yellow-600"
                                :data-tooltip-target="'tooltip-gerer-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-cog"></i>
                            </a>
                            <div :id="'tooltip-gerer-' + escorte.id" role="tooltip"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                {{ __('profile.manage') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <a href="#" @click.stop.prevent="supprimerEscorte(escorte)"
                                class="text-red-500 hover:text-red-700"
                                :data-tooltip-target="'tooltip-supprimer-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-trash"></i>
                            </a>
                            <div :id="'tooltip-supprimer-' + escorte.id" role="tooltip"
                                class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                {{ __('profile.delete') }}
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                            <a href="#" @click.stop.prevent="autonomiserEscorte(escorte)"
                                class="text-green-gs hover:text-green-gs"
                                :data-tooltip-target="'tooltip-autonomiser-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-user-cog"></i>
                            </a>
                            <div :id="'tooltip-autonomiser-' + escorte.id" role="tooltip"
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
</div>

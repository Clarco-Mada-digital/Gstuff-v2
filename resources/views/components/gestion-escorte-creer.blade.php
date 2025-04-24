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
}" class="w-full">
    <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch" data-dropdown-placement="bottom" class="flex items-center w-full p-2 text-green-gs border-b border-gray-400 text-left font-bold cursor-pointer hover:bg-green-gs hover:text-white justify-between" type="button">
        Mes escortes
        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div id="dropdownSearch" class="z-10 hidden bg-white rounded-lg shadow-sm  sm:w-full md:w-xl lg:w-96 dark:bg-gray-700">
        <div class="p-3">
            <label for="input-group-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="input-group-search" x-model="search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Rechercher une escorte">
            </div>
        </div>
        <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownSearchButton">
            <template x-for="escorte in filteredEscortes" :key="escorte.id">
                <li x-show="escorte.prenom.toLowerCase().includes(search.toLowerCase())" class="my-2">
                    <div class="flex items-center justify-between px-3 py-2 bg-white rounded-lg shadow dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                        <div class="flex items-center">
                            <label class="text-sm font-semibold text-gray-900 dark:text-white" x-text="escorte.prenom"></label>
                        </div>
                        <div class="flex space-x-4">
                            <a href="#" @click.prevent="window.location.href = `{{ url('escorte/gerer') }}/${escorte.id}`" class="text-blue-500 hover:text-blue-700" :data-tooltip-target="'tooltip-gerer-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-cog"></i>
                            </a>
                            <div :id="'tooltip-gerer-' + escorte.id" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Gérer
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
    
                            <a href="#" @click.stop.prevent="supprimerEscorte(escorte)" class="text-red-500 hover:text-red-700" :data-tooltip-target="'tooltip-supprimer-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-trash"></i>
                            </a>
                            <div :id="'tooltip-supprimer-' + escorte.id" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Supprimer
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
    
                            <a href="#" @click.stop.prevent="autonomiserEscorte(escorte)" class="text-green-500 hover:text-green-700" :data-tooltip-target="'tooltip-autonomiser-' + escorte.id" data-tooltip-placement="top">
                                <i class="fas fa-user-cog"></i>
                            </a>
                            <div :id="'tooltip-autonomiser-' + escorte.id" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Autonomiser
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                    </div>
                </li>
            </template>
        </ul>
    </div>
    

    <!-- Modal for Supprimer -->
    <div x-cloak x-show="showSupprimerModal" x-transition.opacity.duration.200ms x-trap.inert.noscroll="showSupprimerModal" x-on:keydown.esc.window="showSupprimerModal = false" x-on:click.self="showSupprimerModal = false" class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8" role="dialog" aria-modal="true" aria-labelledby="supprimerModalTitle">
        <div x-show="showSupprimerModal" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" class="border-0 rounded-lg shadow-lg relative flex flex-col w-auto bg-white outline-none focus:outline-none">
          
            <!--content-->
            <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <!--header-->
                <div class="flex items-start justify-between p-5 border-b border-solid border-gray-300 rounded-t">
                    <h3 class="text-3xl font-semibold">
                        Supprimer l'escorte
                    </h3>
                    <button class="p-1 ml-auto bg-transparent border-0 text-black float-right text-3xl leading-none font-semibold outline-none focus:outline-none" @click="closeModal">
                        <span class="bg-transparent text-black h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                        </span>
                    </button>
                </div>
                <!--body-->
                <div class="relative p-6 flex-auto">
                    <p class="my-4 text-gray-600 text-lg leading-relaxed">
                        Êtes-vous sûr de vouloir supprimer l'escorte <span x-text="selectedEscorte.prenom"></span>?
                    </p>
                </div>
                <!--footer-->
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">
                    <button x-on:click="showSupprimerModal = false" class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1" type="button" >
                        Annuler
                    </button>
                   

                    <form x-bind:action="`{{ url('escorte/delete') }}/${selectedEscorte.id}`" method="POST">

                        @csrf
                        @method('DELETE')
                        <button 
                        class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" 
                        type="submit"x-on:click="console.log('Supprimer', selectedEscorte)">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Autonomiser -->
    <div x-cloak x-show="showAutonomiserModal" x-transition.opacity.duration.200ms x-trap.inert.noscroll="showAutonomiserModal" x-on:keydown.esc.window="showAutonomiserModal = false" x-on:click.self="showAutonomiserModal = false" class="fixed inset-0 z-30 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-md sm:items-center lg:p-8" role="dialog" aria-modal="true" aria-labelledby="autonomiserModalTitle">
        <div x-show="showAutonomiserModal" x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
         x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100"
          class="flex  w-96 flex-col gap-4 overflow-hidden rounded-radius  bg-surface text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
        
             <!--content-->
             <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <!--header-->
                <div class="flex items-start justify-between p-5 border-b border-solid border-gray-300 rounded-t">
                    <h3 class="text-xl font-semibold">
                        Autonomiser l'escorte
                    </h3>
                    <button class="p-1 ml-auto bg-transparent border-0 text-black float-right text-3xl leading-none font-semibold outline-none focus:outline-none" @click="closeModal">
                        <span class="bg-transparent text-black h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                        </span>
                    </button>
                </div>
                <!--body-->
                <div class="relative p-6 flex-auto">
                    <label for="email" class="block mb-2 text-gray-300 text-sm leading-relaxed">Nom</label>
                    <h1 class="mb-2 text-gray-600 text-lg leading-relaxed" x-text="selectedEscorte.prenom">
                    </h1>
                    <label for="email" class="block mb-2 text-gray-300 text-sm leading-relaxed">Email</label>
                    <h1 class="mb-2 text-gray-600 text-lg leading-relaxed" x-text="selectedEscorte.email">
                    </h1>

                    <label for="email" class="block mb-2 text-gray-200 text-sm leading-relaxed">Mot de passe par defaut</label>
                    <h1 class="mb-2 text-gray-600 text-lg leading-relaxed" >password
                    </h1>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">L'escorte doit modifier le mot de passe par défaut pour sécuriser son compte.</p>
                </div>
                <!--footer-->
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">
                    <button x-on:click="showAutonomiserModal = false" class="text-green-gs background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1" type="button"  >
                        Annuler
                    </button>
                 
                    <form x-bind:action="`{{ url('escorte/autonomiser') }}/${selectedEscorte.id}`" method="POST">

                        @csrf
                        <button  class="bg-green-gs text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="submit"  >
                            Autonomiser
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


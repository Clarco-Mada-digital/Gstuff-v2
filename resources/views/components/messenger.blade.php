<div class="h-[90vh] md:flex md:h-[60vh] md:justify-between" x-data="messenger()" x-init="init()">
    <!-- Sidebar -->
    <div class="flex flex-col rounded-sm bg-white shadow-sm md:mr-2 md:h-full md:w-[30%]">
        <!-- Header -->
        <div class="flex items-center justify-between p-4">
            <h1 class="text-green-gs font-roboto-slab text-sm md:text-xl font-bold">{{ __('messenger.messenger') }}</h1>

            <button x-on:click="modalIsOpen = true" type="button"
                class="bg-green-gs hover:bg-green-gs-dark focus:ring-green-gs-light dark:bg-green-gs-dark dark:hover:bg-green-gs-darker dark:focus:ring-green-gs-light block cursor-pointer rounded-lg px-3 py-1.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>

        </div>

        <!-- Message et recherche -->
        <div>
            <div x-cloak x-show="modalIsOpen" x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen"
                x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false"
                class="z-100 fixed inset-0 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-sm sm:items-center lg:p-8"
                role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
                <!-- Modal Dialog -->
                <div x-show="modalIsOpen"
                    x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity"
                    class="w-[95vw] md:w-[60vw] lg:w-[40vw]">
                    <!-- Dialog Header -->
                    <div class="relative max-h-full w-full p-4">
                        <!-- Modal content -->
                        <div class="relative h-[50vh] rounded-lg bg-white shadow-sm dark:bg-gray-700">
                            <div class="p-4">

                                <div class="relative mt-3">

                                    <input type="text" x-model="searchQuery" @input.debounce.500ms="searchUsers()"
                                        placeholder="{{ __('messenger.search_placeholder') }}"
                                        class="focus:ring-green-gs w-full rounded-lg border border-gray-300 p-2 pl-10 focus:outline-none focus:ring-2">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>
                            <div>
                                <template x-if="searchResults.length === 0">
                                    <div class="text-textColorParagraph font-roboto-slab p-4 text-center text-xs sm:text-sm">
                                        {{ __('messenger.no_results_found') }}
                                    </div>
                                </template>
                                <div class="h-[35vh] overflow-y-auto p-4">
                                    <template
                                        x-for="result in searchResults.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage)"
                                        :key="result.id">
                                        <div x-on:click="loadChat(result.id) ; modalIsOpen = false ; "
                                            class="hover:bg-supaGirlRosePastel/50 font-roboto-slab hover:text-green-gs flex cursor-pointer items-center rounded-sm p-3">
                                            <img :src="result.avatar ? `{{ asset('storage/avatars') }}/` + result.avatar :
                                                '/logo-icon.webp'"
                                                :alt="result.pseudo ? result.pseudo : result.prenom ? result.prenom : result
                                                    .nom_salon"
                                                class="h-10 w-10 rounded-full object-cover">
                                            <div class="ml-3">
                                                <h3 class="text-green-gs hover:text-green-gs font-roboto-slab font-bold font-medium"
                                                    x-text="result.pseudo ? result.pseudo : result.prenom ? result.prenom : result.nom_salon">
                                                </h3>
                                                <p class="text-textColorParagraph hover:text-green-gs font-roboto-slab text-xs"
                                                    x-text="result.profile_type"></p>
                                            </div>
                                        </div>



                                    </template>
                                </div>
                                <!-- Pagination Controls -->
                                <div class="mt-2 flex justify-center space-x-2" x-show="searchResults.length > 0">
                                    <button @click="currentPage = Math.max(1, currentPage - 1)"
                                        class="bg-green-gs hover:bg-green-gs/80 font-roboto-slab rounded px-4 py-2 text-white hover:text-white disabled:cursor-not-allowed disabled:opacity-50"
                                        :disabled="currentPage === 1">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <span x-text="currentPage + ' / ' + Math.ceil(searchResults.length / itemsPerPage)"
                                        class="bg-green-gs font-roboto-slab rounded px-4 py-2 text-sm text-white"></span>
                                    <button
                                        @click="currentPage = Math.min(Math.ceil(searchResults.length / itemsPerPage), currentPage + 1)"
                                        class="bg-green-gs hover:bg-green-gs/80 font-roboto-slab rounded px-4 py-2 text-white hover:text-white disabled:cursor-not-allowed disabled:opacity-50"
                                        :disabled="currentPage === Math.ceil(searchResults.length / itemsPerPage)">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Favoris -->
        <div class="mb-2">
            <h2 class="bg-supaGirlRosePastel/50 font-roboto-slab text-green-gs mb-2 rounded-t-sm px-4 py-2 text-xs sm:text-sm">
                {{ __('messenger.favorites') }}</h2>
            <div class="flex space-x-2 overflow-x-auto p-2">
                <template x-if="favorites.length === 0">
                    <div
                        class="text-textColorParagraph font-roboto-slab flex items-center justify-center p-4 text-center text-xs sm:text-sm">
                        {{ __('messenger.no_favorites') }}
                    </div>
                </template>
                <template x-for="favorite in favorites" :key="favorite.id">
                    <div @click="loadChat(favorite.id)"
                        class="flex flex-shrink-0 cursor-pointer flex-col items-center justify-center gap-2 overflow-hidden">
                        <img :src="favorite.avatar ? `{{ asset('storage/avatars') }}/${favorite.avatar}` : '/logo-icon.webp'"
                            :alt="favorite.pseudo ? favorite.pseudo : favorite.prenom ? favorite.prenom : favorite.nom_salon"
                            class="h-12 w-12 rounded-full object-cover">
                        <span class="font-roboto-slab text-textColorParagraph text-xs sm:text-sm"
                            x-text="favorite.pseudo || favorite.prenom || favorite.nom_salon "></span>
                    </div>
                </template>
            </div>
        </div>

        <!-- Liste des contacts -->
        <div class="relative mb-2 flex-1">
            <h2 class="bg-supaGirlRosePastel/50 font-roboto-slab text-green-gs mb-2 rounded-t-sm px-4 py-2 text-xs sm:text-sm">
                {{ __('messenger.contacts') }}</h2>
            <div x-show="!loadingContacts" id="contacts-list" class="h-[15vh] divide-y overflow-y-auto md:h-[30vh]">

                <!-- Les contacts seront chargés ici -->
            </div>
            <div x-show="loadingContacts" class="flex h-[15vh] items-center justify-center p-4 text-center md:h-[30vh]">
                <i class="fas fa-spinner fa-spin text-supaGirlRosePastel"></i>
            </div>
        </div>
    </div>

    <!-- Zone de chat principale -->
    <div class="relative h-[75vh] w-full md:h-full md:w-[70%]">

        <h2 class="bg-supaGirlRosePastel/50 text-green-gs mb-2 rounded-t-sm px-4 py-2 font-semibold md:hidden">
            {{ __('messenger.messages') }}</h2>

        <div x-show="currentChat" class="bg-supaGirlRosePastel flex items-center justify-between rounded-sm p-4">
            <div class="flex items-center space-x-3">
                <img :src="currentChatUser.avatar ? `{{ asset('storage/avatars') }}/${currentChatUser.avatar}` : '/logo-icon.webp'"
                    :alt="currentChatUser.pseudo" class="h-10 w-10 rounded-full">
                <div>
                    <h2 x-text="currentChatUser.pseudo ? currentChatUser.pseudo : currentChatUser.prenom ? currentChatUser.prenom : currentChatUser.nom_salon"
                        class="font-roboto-slab text-green-gs font-semibold"></h2>
                    <p x-text="currentChatUser.status" class="text-textColorParagraph font-roboto-slab text-xs"></p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button @click="toggleFavorite(currentChatUser.id)"
                    class="text-supaGirlRose hover:text-green-gs cursor-pointer p-2" aria-label="Ajouter aux favoris">
                    <i
                        :class="{
                            'fas fa-star text-supaGirlRose': isFavorite(currentChatUser.id),
                            'far fa-star': !isFavorite(currentChatUser.id)
                        }"></i>
                </button>
                <button @click="toggleInfoPanel()" class="text-supaGirlRose hover:text-green-gs cursor-pointer p-2"
                    aria-label="{{ __('messenger.user_info_panel') }}">
                    <i class="fas fa-info-circle"></i>
                </button>
            </div>
        </div>

        <!-- Panneau d'informations utilisateur -->
        <div x-show="showInfoPanel" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            class="absolute bottom-0 right-0 top-12 z-10 h-[49vh] w-80 overflow-y-auto border-l bg-white shadow-lg shadow-sm md:top-0 md:h-[60vh]">
            <div class="p-6">
                <!-- Bouton de fermeture -->
                <button @click="showInfoPanel = false"
                    class="absolute right-4 top-4 text-gray-500 hover:text-gray-700"
                    aria-label="{{ __('messenger.close_panel') }}">
                    <i class="fas fa-times"></i>
                </button>

                <!-- Avatar et nom -->
                <div class="mb-6 text-center">
                    <img :src="currentChatUser.avatar ? `{{ asset('storage/avatars') }}/${currentChatUser.avatar}` :
                        '/logo-icon.webp'"
                        :alt="currentChatUser.pseudo"
                        class="mx-auto mb-4 h-24 w-24 rounded-full border-4 border-blue-100 object-cover">
                    <h3 class="text-xl font-bold text-gray-800"
                        x-text="currentChatUser.pseudo ? currentChatUser.pseudo : currentChatUser.prenom ? currentChatUser.prenom : currentChatUser.nom_salon">
                    </h3>
                    <p class="text-sm text-gray-500" x-text="currentChatUser.status"></p>
                </div>

                <!-- Statistiques de conversation -->
                <div class="mb-6">
                    <h4 class="mb-3 flex items-center font-semibold text-gray-700">
                        <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                        {{ __('messenger.conversation_stats') }}
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-lg bg-blue-50 p-3 text-center">
                            <div class="text-xl font-bold text-blue-600" x-text="messageCount"></div>
                            <div class="text-xs text-gray-600">{{ __('messenger.messages') }}</div>
                        </div>
                        <div class="rounded-lg bg-purple-50 p-3 text-center">
                            <div class="text-xl font-bold text-purple-600" x-text="mediaCount"></div>
                            <div class="text-xs text-gray-600">{{ __('messenger.media') }}</div>
                        </div>
                        <div class="rounded-lg bg-green-50 p-3 text-center">
                            <div class="text-xl font-bold text-green-600" x-text="sharedLinksCount"></div>
                            <div class="text-xs text-gray-600">{{ __('messenger.links') }}</div>
                        </div>
                        <div class="rounded-lg bg-yellow-50 p-3 text-center">
                            <div class="text-xl font-bold text-yellow-600" x-text="currentChatUser.last_seen"></div>
                            <div class="text-xs text-gray-600">{{ __('messenger.last_activity') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Médias partagés -->
                <div class="mb-6" x-show="mediaCount > 0">
                    <h4 class="mb-3 flex items-center font-semibold text-gray-700">
                        <i class="fas fa-images mr-2 text-blue-500"></i>
                        {{ __('messenger.shared_media') }}
                    </h4>
                    <div class="info_gallery grid grid-cols-3 gap-2">

                    </div>
                </div>

                <!-- Liens partagés -->
                <div x-show="sharedLinksCount > 0">
                    <h4 class="mb-3 flex items-center font-semibold text-gray-700">
                        <i class="fas fa-link mr-2 text-blue-500"></i>
                        {{ __('messenger.shared_links') }}
                    </h4>
                    <div class="space-y-2">
                        <template x-for="(message, index) in sharedLinks" :key="index">
                            <template x-for="(url, idx) in message.urls" :key="idx">
                                <div class="rounded border border-gray-200 bg-gray-50 p-2">
                                    <a :href="url" target="_blank" rel="noopener noreferrer"
                                        class="break-all text-sm text-blue-600 hover:underline">
                                        <span x-text="url"></span>
                                    </a>
                                    <div class="mt-1 text-xs text-gray-500" x-text="formatDate(message.created_at)">
                                    </div>
                                </div>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div x-show="currentChat" x-transition:enter="transition ease-out duration-300 "
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="bg-fieldBg flex-1 overflow-y-auto p-4" id="messages-coverer">
            <div x-show="loadingMessages"
                class="flex h-[30vh] items-center justify-center py-4 text-center md:h-[40vh]">
                <i class="fas fa-spinner fa-spin text-supaGirlRose"></i>
            </div>
            <div x-show="!loadingMessages" id="messages-list" class="h-[30vh] space-y-3 overflow-y-auto md:h-[40vh]">
                <!-- Les messages seront chargés ici -->
            </div>
        </div>
        <!-- Prévisualisation de l'image -->
        <div x-show="preview"
            class="absolute bottom-[260px] left-0 mb-3 w-full bg-gray-100 shadow-sm md:bottom-[70px]">
            <div x-show="preview" class="relative mx-1 my-2 h-[60px] w-[60px]">
                <img :src="preview" alt="Preview" class="h-[60px] w-[60px] rounded-lg">
                <button @click="clearAttachment()"
                    class="absolute right-2 top-2 flex h-4 w-4 items-center justify-center rounded-full bg-gray-800 text-white">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        </div>


        <!-- Input d'envoi -->
        <div x-show='currentChat'
            class="border-supaGirlRose rounded-b-sm border-t-2 bg-white px-3 pb-3 pt-4 shadow-sm">

            <!-- Formulaire d'envoi -->
            <form @submit.prevent="sendMessage(); clearAttachment();" class="flex items-center gap-2">
                <!-- Bouton pièce jointe -->
                <label class="hover:text-green-gs text-supaGirlRose cursor-pointer p-2">
                    <i class="fas fa-paperclip"></i>
                    <input type="file" @change="handleFileUpload" class="attachment-input hidden"
                        accept="image/*">
                </label>

                <!-- Message Input Component -->
                <x-message-input :placeholder="__('messenger.type_message')" :model="'newMessage'" />

                <!-- Bouton d'envoi -->
                <button type="submit" :disabled="(newMessage.length === 0 && !fileToUpload) || sendingMessage"
                    :class="{
                        'bg-green-gs hover:bg-green-gs/80 text-white': (newMessage.length > 0 || fileToUpload) && !
                            sendingMessage,
                        'bg-gray-300 cursor-not-allowed': (newMessage.length === 0 && !fileToUpload) || sendingMessage
                    }"
                    class="text-back flex h-12 w-12 items-center justify-center rounded-full p-3">
                    <i x-show="!sendingMessage" class="fas fa-paper-plane"></i>
                    <i x-show="sendingMessage" class="fas fa-spinner fa-spin"></i>
                </button>
            </form>
        </div>

        <!-- Vue quand aucun chat n'est sélectionné -->
        <div x-show="!currentChat" class="bg-fieldBg flex h-[45vh] w-full items-center justify-center md:h-[60vh]">
            <div class="p-6 text-center">
                <div class="mx-auto mb-4 flex h-24 w-24 items-center justify-center rounded-full bg-gray-200">
                    <i class="fas fa-comments text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-textColorParagraph font-roboto-slab mb-2 text-xl font-semibold">
                    {{ __('messenger.no_conversation') }}</h3>
                <p class="text-textColorParagraph font-roboto-slab">{{ __('messenger.select_conversation') }}</p>
            </div>
        </div>
    </div>
</div>

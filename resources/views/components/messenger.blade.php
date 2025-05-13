<div class="h-[90vh] md:flex md:justify-between md:h-[60vh] " x-data="messenger()" x-init="init()">
    <!-- Sidebar -->
    <div class="  bg-white flex flex-col md:w-[30vw] md:h-full md:mr-2 shadow-sm rounded-sm ">
        <!-- Header -->
        <div class="p-4  flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">{{ __('messenger.messenger') }}</h1>
                
            <button x-on:click="modalIsOpen = true" type="button" class="block text-white bg-green-gs hover:bg-green-gs-dark focus:ring-4 focus:outline-none focus:ring-green-gs-light font-medium rounded-lg text-sm px-3 py-1.5 text-center dark:bg-green-gs-dark dark:hover:bg-green-gs-darker dark:focus:ring-green-gs-light">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>

        </div>

        <div >
            <div x-cloak x-show="modalIsOpen" 
            x-transition.opacity.duration.200ms x-trap.inert.noscroll="modalIsOpen" 
            x-on:keydown.esc.window="modalIsOpen = false" x-on:click.self="modalIsOpen = false" 
            class="fixed inset-0 z-100 flex items-end justify-center bg-black/20 p-4 pb-8 backdrop-blur-sm sm:items-center lg:p-8" 
            role="dialog" aria-modal="true" aria-labelledby="defaultModalTitle">
                <!-- Modal Dialog -->
                <div x-show="modalIsOpen" 
                x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" 
            class="w-[95vw] md:w-[60vw] lg:w-[40vw] ">
                    <!-- Dialog Header -->
                    <div class="relative p-4 w-full max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 h-[50vh]">
                <div class="p-4">
                
                    <div class="relative mt-3">
                        <input type="text" x-model="searchQuery" @input.debounce.500ms="searchUsers()"
                            placeholder="{{ __('messenger.search_placeholder') }}"
                            class="w-full p-2 pl-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-gs">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
                <div>
                        <template x-if="searchResults.length === 0">
                            <div class="p-4 text-center text-gray-500">
                                {{ __('messenger.no_results_found') }}
                            </div>
                        </template>
                        <div class="h-[35vh]  overflow-y-auto p-4">
                        <template x-for="result in searchResults.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage)" :key="result.id" >
                            <div x-on:click="loadChat(result.id) ; modalIsOpen = false ; " 
                                class="p-3 hover:bg-green-gs hover:text-white cursor-pointer flex items-center rounded-sm">
                                <img :src="result.avatar ? `{{ asset('storage/avatars') }}/` + result.avatar : '/icon-logo.png'"
                                    :alt="result.pseudo ? result.pseudo : result.prenom ? result.prenom : result.nom_salon"
                                    class="w-10 h-10 rounded-full object-cover">
                                <div class="ml-3">
                                    <h3 class="font-medium hover:text-white font-bold"
                                        x-text="result.pseudo ? result.pseudo : result.prenom ? result.prenom : result.nom_salon"></h3>
                                    <p class="text-xs text-gray-500 hover:text-gray-300" x-text="result.profile_type"></p>
                                </div>
                            </div>



                        </template>
                        </div>
                                    <!-- Pagination Controls -->
                                    <div class="flex justify-center space-x-2 mt-2" x-show="searchResults.length > 0">
                                    <button @click="currentPage = Math.max(1, currentPage - 1)"
                                        class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                        :disabled="currentPage === 1">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <span x-text="currentPage + ' / ' + Math.ceil(searchResults.length / itemsPerPage)" class="px-4 py-2 text-sm rounded bg-gray-100"></span>
                                    <button @click="currentPage = Math.min(Math.ceil(searchResults.length / itemsPerPage), currentPage + 1)"
                                        class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed"
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
            <h2 class="font-semibold px-4 py-2 text-gray-700 mb-2 bg-gray-100 rounded-t-sm">{{ __('messenger.favorites') }}</h2>
            <div class="flex space-x-2 overflow-x-auto p-2">
                <template x-if="favorites.length === 0">
                    <div class="p-4 text-center text-gray-500">
                        {{ __('messenger.no_favorites') }}
                    </div>
                </template>
                <template x-for="favorite in favorites" :key="favorite.id">
                    <div @click="loadChat(favorite.id)"
                        class="flex flex-col gap-2 flex-shrink-0 cursor-pointer items-center justify-center overflow-hidden ">
                        <img :src="favorite.avatar ? `{{ asset('storage/avatars') }}/${favorite.avatar}` : '/icon-logo.png'"
                            :alt="favorite.pseudo ? favorite.pseudo : favorite.prenom ? favorite.prenom : favorite.nom_salon"
                            class="w-12 h-12 rounded-full object-cover">
                        <span
                            x-text="favorite.pseudo || favorite.prenom || favorite.nom_salon "></span>
                    </div>
                </template>
            </div>
        </div>

        <!-- Liste des contacts -->
        <div class="flex-1  relative mb-2">
            <h2 class="font-semibold px-4 py-2 text-gray-700 mb-2 bg-gray-100 rounded-t-sm">{{ __('messenger.contacts') }}</h2>
            <div  x-show="!loadingContacts" id="contacts-list" class="divide-y overflow-y-auto h-[15vh] md:h-[30vh]">
                
                <!-- Les contacts seront chargés ici -->
            </div>
            <div x-show="loadingContacts" class=" flex items-center justify-center p-4 text-center h-[15vh] md:h-[30vh]">
                <i class="fas fa-spinner fa-spin text-primary"></i>
            </div>
        </div>
    </div>

    <!-- Zone de chat principale -->
    <div class="w-full h-[75vh] relative md:w-[60vw] md:h-full">

    <h2 class="font-semibold px-4 py-2 text-gray-700 mb-2 bg-gray-100 rounded-t-sm md:hidden">{{ __('messenger.messages') }}</h2>
     
        <div x-show="currentChat" class="p-4 flex items-center justify-between bg-gray-100 rounded-sm">
            <div class="flex items-center space-x-3 ">
                <img :src="currentChatUser.avatar ? `{{ asset('storage/avatars') }}/${currentChatUser.avatar}` : '/icon-logo.png'"
                    :alt="currentChatUser.pseudo" class="w-10 h-10 rounded-full">
                <div>
                    <h2 x-text="currentChatUser.pseudo ? currentChatUser.pseudo : currentChatUser.prenom ? currentChatUser.prenom : currentChatUser.nom_salon"
                        class="font-semibold"></h2>
                    <p x-text="currentChatUser.status" class="text-xs text-gray-500"></p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button @click="toggleFavorite(currentChatUser.id)"
                    class="p-2 text-gray-500 hover:text-yellow-500 cursor-pointer" aria-label="Ajouter aux favoris">
                    <i
                        :class="{
                            'fas fa-star text-yellow-500': isFavorite(currentChatUser.id),
                            'far fa-star': !isFavorite(currentChatUser.id)
                        }"></i>
                </button>
                <button @click="toggleInfoPanel()" class="p-2 text-gray-500 hover:text-blue-500 cursor-pointer"
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
            class="absolute top-12 right-0 bottom-0 w-80 bg-white border-l z-10 shadow-lg h-[49vh] md:h-[60vh] md:top-0  overflow-y-auto shadow-sm">
            <div class="p-6">
                <!-- Bouton de fermeture -->
                <button @click="showInfoPanel = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700"
                    aria-label="{{ __('messenger.close_panel') }}">
                    <i class="fas fa-times"></i>
                </button>

                <!-- Avatar et nom -->
                <div class="text-center mb-6">
                    <img :src="currentChatUser.avatar ? `{{ asset('storage/avatars') }}/${currentChatUser.avatar}` :
                        '/icon-logo.png'"
                        :alt="currentChatUser.pseudo"
                        class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-4 border-blue-100">
                    <h3 class="text-xl font-bold text-gray-800"
                        x-text="currentChatUser.pseudo ? currentChatUser.pseudo : currentChatUser.prenom ? currentChatUser.prenom : currentChatUser.nom_salon">
                    </h3>
                    <p class="text-sm text-gray-500" x-text="currentChatUser.status"></p>
                </div>

                <!-- Statistiques de conversation -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                        {{ __('messenger.conversation_stats') }}
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-3 rounded-lg text-center">
                            <div class="text-blue-600 font-bold text-xl" x-text="messageCount"></div>
                            <div class="text-xs text-gray-600">{{ __('messenger.messages') }}</div>
                        </div>
                        <div class="bg-purple-50 p-3 rounded-lg text-center">
                            <div class="text-purple-600 font-bold text-xl" x-text="mediaCount"></div>
                            <div class="text-xs text-gray-600">{{ __('messenger.media') }}</div>
                        </div>
                        <div class="bg-green-50 p-3 rounded-lg text-center">
                            <div class="text-green-600 font-bold text-xl" x-text="sharedLinksCount"></div>
                            <div class="text-xs text-gray-600">{{ __('messenger.links') }}</div>
                        </div>
                        <div class="bg-yellow-50 p-3 rounded-lg text-center">
                            <div class="text-yellow-600 font-bold text-xl" x-text="currentChatUser.last_seen"></div>
                            <div class="text-xs text-gray-600">{{ __('messenger.last_activity') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Médias partagés -->
                <div class="mb-6" x-show="mediaCount > 0">
                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-images mr-2 text-blue-500"></i>
                        {{ __('messenger.shared_media') }}
                    </h4>
                    <div class="grid grid-cols-3 gap-2 info_gallery">

                    </div>
                </div>

                <!-- Liens partagés -->
                <div x-show="sharedLinksCount > 0">
                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-link mr-2 text-blue-500"></i>
                        {{ __('messenger.shared_links') }}
                    </h4>
                    <div class="space-y-2">
                        <template
                            x-for="(message, index) in sharedLinks"
                            :key="index">
                        <template
                            x-for="(url, idx) in message.urls"
                            :key="idx">
                            <div class="p-2 bg-gray-50 rounded border border-gray-200">
                                <a :href="url" target="_blank"
                                    rel="noopener noreferrer" class="text-blue-600 hover:underline text-sm break-all">
                                    <span x-text="url"></span>
                                </a>
                                <div class="text-xs text-gray-500 mt-1" x-text="formatDate(message.created_at)"></div>
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
            class="flex-1 overflow-y-auto p-4 bg-gray-50" id="messages-container">
            <div x-show="loadingMessages" class="flex items-center justify-center text-center py-4 h-[30vh] md:h-[40vh]">
                <i class="fas fa-spinner fa-spin text-primary"></i>
            </div>
            <div x-show="!loadingMessages" id="messages-list" class="space-y-3 h-[30vh] overflow-y-auto md:h-[40vh]">
                <!-- Les messages seront chargés ici -->
            </div>
        </div>
         <!-- Prévisualisation de l'image -->
          <div  x-show="preview" class="absolute bottom-[260px] left-0 mb-3 w-full bg-gray-100 shadow-sm md:bottom-[70px]">
          <div x-show="preview" class="relative my-2 w-[60px] h-[60px] mx-1 ">
                <img :src="preview" alt="Preview" class="w-[60px] h-[60px] rounded-lg">
                <button @click="clearAttachment()"
                    class="absolute top-2 right-2 bg-gray-800 text-white rounded-full w-4 h-4 flex items-center justify-center">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
          </div>
        

        <!-- Input d'envoi -->
        <div x-show='currentChat' class="border-t bg-white px-3 pt-4 pb-3 shadow-sm rounded-b-sm">
           
            <!-- Formulaire d'envoi -->
            <form @submit.prevent="sendMessage(); clearAttachment();" class="flex items-center gap-2">
                <!-- Bouton pièce jointe -->
                <label class="cursor-pointer text-gray-500 hover:text-primary p-2">
                    <i class="fas fa-paperclip"></i>
                    <input type="file" @change="handleFileUpload" class="hidden attachment-input"
                        accept="image/*">
                </label>

                <!-- Champ de message -->
                <div class="relative flex-1">
                    <textarea x-model="newMessage" rows="1" placeholder="{{ __('messenger.type_message') }}"
                        class="w-full p-3 pr-10 rounded-full border border-gray-300 focus:outline-none resize-none overflow-hidden"
                        @input="autoResize($el)"></textarea>

                    <!-- Bouton emoji -->
                    <button type="button" @click="showEmojiPicker = !showEmojiPicker"
                        class="absolute right-3 top-3 text-gray-400 hover:text-yellow-500">
                        <i class="far fa-smile"></i>
                    </button>

                    <!-- Picker d'emoji simple -->
                    <div x-show="showEmojiPicker" @click.away="showEmojiPicker = false"
                        class="absolute -top-5 -translate-y-full right-0 bg-white border border-gray-200 rounded-lg shadow-lg p-2 w-64 h-48 overflow-y-auto z-10">
                        <div class="flex flex-wrap gap-3 gap-1">
                            <template
                                x-for="emoji in ['😀', '😂', '😍', '👍', '❤️', '🙏', '🔥', '🎉', '🤔', '😎',  '👩‍💼', '👨‍💼', '☺️', '☝️', '🕵️', '💄', '💋', '👄',  '🥵', '😏', '😉','🤤', '😵', '🍑', '🌶️', '🔞',  '😈', '💃', '👀', '🍷', '🎷', '🌇']">
                                <button type="button" @click="insertEmoji(emoji)"
                                    class="text-xl hover:bg-gray-100 rounded p-1" x-text="emoji"></button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Bouton d'envoi -->
                <button type="submit" :disabled="(!newMessage.trim() && !fileToUpload) || sendingMessage"
                    :class="{
                        'btn-gs-gradient': (newMessage.trim() || fileToUpload) && !sendingMessage,
                        'bg-gray-300 cursor-not-allowed': (!newMessage.trim() && !fileToUpload) || sendingMessage
                    }"
                    class="text-back p-3 rounded-full w-12 h-12 flex items-center justify-center">
                    <i x-show="!sendingMessage" class="fas fa-paper-plane"></i>
                    <i x-show="sendingMessage" class="fas fa-spinner fa-spin"></i>
                </button>
            </form>
        </div>

        <!-- Vue quand aucun chat n'est sélectionné -->
        <div x-show="!currentChat" class="h-[45vh] flex items-center justify-center bg-gray-50 md:h-[60vh]">
            <div class="text-center p-6">
                <div class="mx-auto w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-comments text-gray-400 text-3xl"></i>
                </div>
                <!-- <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ __('messenger.no_chat_selected') }}</h3>
                <p class="text-gray-500 text-sm">{{ __('messenger.select_contact_to_start') }}</p> -->
                <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('messenger.no_conversation') }}</h3>
                <p class="text-gray-500">{{ __('messenger.select_conversation') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="flex h-[60vh]" x-data="messenger()" x-init="init()">
    <!-- Sidebar -->
    <div class="w-1/4 border-r bg-white flex flex-col">
        <!-- Header -->
        <div class="p-4 border-b">
            <h1 class="text-xl font-bold text-gray-800">Messagerie</h1>
            <div class="relative mt-3">
                <input type="text" x-model="searchQuery" @input.debounce.500ms="searchUsers()"
                    placeholder="Rechercher..."
                    class="w-full p-2 pl-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>

        <!-- Favoris -->
        <div class="p-4 border-b">
            <h2 class="font-semibold text-gray-700 mb-2">Favoris</h2>
            <div class="flex space-x-2 overflow-x-auto pb-2">
                <template x-for="favorite in favorites" :key="favorite.id">
                    <div @click="loadChat(favorite.id)"
                        class="flex flex-col gap-2 flex-shrink-0 cursor-pointer items-center justify-center">
                        <img :src="favorite.avatar ? `{{ asset('avatars/') }}${favorite.avatar}` : '/icon-logo.png'"
                            :alt="favorite.pseudo ? favorite.pseudo : favorite.prenom ? favorite.prenom : favorite.nom_salon"
                            class="w-12 h-12 rounded-full object-cover">
                        <span
                            x-text="favorite.pseudo ? favorite.pseudo : favorite.prenom ? favorite.prenom : favorite.nom_salon"></span>
                    </div>
                </template>
            </div>
        </div>

        <!-- Liste des contacts -->
        <div class="flex-1 overflow-y-auto relative">
            <div id="search-list" class="divide-y absolute h-full w-full inset-0 bg-white z-10"
                x-show="searchQuery.length > 0 && !loadingContacts">
                <!-- Les contacts seront chargés ici -->
            </div>
            <div id="contacts-list" class="divide-y">
                <!-- Les contacts seront chargés ici -->
            </div>
            <div x-show="loadingContacts" class="p-4 text-center">
                <i class="fas fa-spinner fa-spin text-primary"></i>
            </div>
        </div>
    </div>

    <!-- Zone de chat principale -->
    <div class="flex-1 flex flex-col relative">
        <!-- En-tête du chat -->
        <div x-show="currentChat" class="p-4 border-b bg-white flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img :src="currentChatUser.avatar ? `{{ asset('avatars/') }}${currentChatUser.avatar}` : '/icon-logo.png'"
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
                    aria-label="Afficher les informations">
                    <i class="fas fa-info-circle"></i>
                </button>
            </div>
        </div>

        <!-- Panneau d'informations utilisateur -->
        <div x-show="showInfoPanel" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-full"
            class="absolute top-0 right-0 bottom-0 w-80 bg-white border-l z-10 shadow-lg overflow-y-auto">
            <div class="p-6">
                <!-- Bouton de fermeture -->
                <button @click="showInfoPanel = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700"
                    aria-label="Fermer le panneau">
                    <i class="fas fa-times"></i>
                </button>

                <!-- Avatar et nom -->
                <div class="text-center mb-6">
                    <img :src="currentChatUser.avatar ? `{{ asset('storage/avatars/') }}${currentChatUser.avatar}` :
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
                        Statistiques de la conversation
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-3 rounded-lg text-center">
                            <div class="text-blue-600 font-bold text-xl" x-text="messageCount"></div>
                            <div class="text-xs text-gray-600">Messages</div>
                        </div>
                        <div class="bg-purple-50 p-3 rounded-lg text-center">
                            <div class="text-purple-600 font-bold text-xl" x-text="mediaCount"></div>
                            <div class="text-xs text-gray-600">Médias</div>
                        </div>
                        <div class="bg-green-50 p-3 rounded-lg text-center">
                            <div class="text-green-600 font-bold text-xl" x-text="sharedLinksCount"></div>
                            <div class="text-xs text-gray-600">Liens</div>
                        </div>
                        <div class="bg-yellow-50 p-3 rounded-lg text-center">
                            <div class="text-yellow-600 font-bold text-xl" x-text="currentChatUser.last_seen"></div>
                            <div class="text-xs text-gray-600">Dernière activité</div>
                        </div>
                    </div>
                </div>

                <!-- Médias partagés -->
                <div class="mb-6" x-show="mediaCount > 0">
                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-images mr-2 text-blue-500"></i>
                        Médias partagés
                    </h4>
                    <div class="grid grid-cols-3 gap-2 info_gallery">

                    </div>
                </div>

                <!-- Liens partagés -->
                <div x-show="sharedLinksCount > 0">
                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-link mr-2 text-blue-500"></i>
                        Liens partagés
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
        <div x-show="currentChat" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="flex-1 overflow-y-auto p-4 bg-gray-50" id="messages-container">
            <div x-show="loadingMessages" class="text-center py-4">
                <i class="fas fa-spinner fa-spin text-primary"></i>
            </div>
            <div id="messages-list" class="space-y-3">
                <!-- Les messages seront chargés ici -->
            </div>
        </div>

        <!-- Input d'envoi -->
        <div x-show='currentChat' class="border-t bg-white p-3">
            <!-- Prévisualisation de l'image -->
            <div x-show="preview" class="relative mb-3">
                <img :src="preview" alt="Preview" class="max-w-64 rounded-lg">
                <button @click="clearAttachment()"
                    class="absolute top-2 right-2 bg-gray-800 text-white rounded-full w-6 h-6 flex items-center justify-center">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

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
                    <textarea x-model="newMessage" rows="1" placeholder="Tapez un message..."
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
                <button type="submit" :disabled="!newMessage.trim() && !fileToUpload"
                    :class="{
                        'btn-gs-gradient': newMessage.trim() || fileToUpload,
                        'bg-gray-300 cursor-not-allowed': !
                            newMessage.trim() && !fileToUpload
                    }"
                    class="text-back p-3 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>

        <!-- Vue quand aucun chat n'est sélectionné -->
        <div x-show="!currentChat" class="flex-1 flex items-center justify-center bg-gray-50">
            <div class="text-center p-6">
                <div class="mx-auto w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-comments text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Pas de conversation sélectionnée</h3>
                <p class="text-gray-500">Sélectionnez une conversation ou recherchez un contact pour commencer à
                    discuter</p>
            </div>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie</title>
    {{-- js import --}}
    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs-focus/3.14.9/cdn.min.js"
        integrity="sha512-cbnb6RLeH6MQInYpFTaBZhIvqoV1SQMCT7gS/lcz5U5EbifRo1yHOlDHZOP0i/2oo7G9rSNpSGuqHdK3jByq2Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs-intersect/3.14.9/cdn.min.js"
        integrity="sha512-zUi+vHO/A+Mh3PQDYpAhzo3GGnrSTdOdyUkFby6I2p+k5kOhVNDMJMnhaJgZtecorfhS/+Y5PbkDu7iWsnk8+A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
    <script src="{{ asset('assets/js/emojionearea.min.js') }}"></script>

    <!--font-awesome js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"
        integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>

    <!-- Alpine Core -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @livewireStyles
    @livewireScripts
    <link rel="stylesheet" href="{{ asset('assets/css/emojionearea.min.css') }}">
    {{ Vite::useBuildDirectory('build')->withEntryPoints(['resources/js/app.js', 'resources/css/app.css']) }}

    <style>
        /* Custom styles */
        [x-cloak] {
            display: none !important;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen" x-data="messenger()" x-init="init()">
        <!-- Sidebar -->
        <div class="flex w-1/4 flex-col border-r bg-white">
            <!-- Header -->
            <div class="border-b p-4">
                <h1 class="text-xl font-bold text-gray-800">Messagerie</h1>
                <div class="relative mt-3">
                    <input type="text" x-model="searchQuery" @input.debounce.500ms="searchUsers()"
                        placeholder="Rechercher..."
                        class="focus:ring-primary w-full rounded-lg border border-gray-300 p-2 pl-10 focus:outline-none focus:ring-2">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Favoris -->
            <div class="border-b p-4">
                <h2 class="mb-2 font-semibold text-gray-700">Favoris</h2>
                <div class="flex space-x-2 overflow-x-auto pb-2">
                    <template x-for="favorite in favorites" :key="favorite.id">
                        <div @click="loadChat(favorite.id)"
                            class="flex flex-shrink-0 cursor-pointer flex-col items-center justify-center gap-2">
                            <img :src="favorite.avatar ? `{{ asset('avatars/') }}${favorite.avatar}` : '/icon-logo.png'"
                                :alt="favorite.pseudo" class="h-12 w-12 rounded-full object-cover">
                            <span
                                x-text="favorite.pseudo ? favorite.pseudo : favorite.prenom ? favorite.prenom : favorite.nom_salon"></span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Liste des contacts -->
            <div class="relative flex-1 overflow-y-auto">
                <div id="search-list" class="absolute inset-0 z-10 h-full w-full divide-y bg-white"
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
        <div class="flex flex-1 flex-col">
            <!-- En-tête du chat -->
            <div x-show="currentChat" class="flex items-center justify-between border-b bg-white p-4">
                <div class="flex items-center space-x-3">
                    <img :src="currentChatUser.avatar ? `{{ asset('avatars/') }}${currentChatUser.avatar}` : '/icon-logo.png'"
                        :alt="currentChatUser.pseudo" class="h-10 w-10 rounded-full">
                    <div>
                        <h2 x-text="currentChatUser.pseudo ? currentChatUser.pseudo : currentChatUser.prenom ? currentChatUser.prenom : currentChatUser.nom_salon"
                            class="font-semibold"></h2>
                        <p x-text="currentChatUser.status" class="text-xs text-gray-500"></p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button @click="toggleFavorite(currentChatUser.id)" class="p-2 text-gray-500 hover:text-yellow-500">
                        <i
                            :class="{
                                'fas fa-star text-yellow-500': isFavorite(currentChatUser.id),
                                'fas fa-star': !isFavorite(
                                    currentChatUser.id)
                            }"></i>
                    </button>
                </div>
            </div>

            <!-- Messages -->
            <div x-show="currentChat" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                class="flex-1 overflow-y-auto bg-gray-50 p-4" id="messages-container">
                <div x-show="loadingMessages" class="py-4 text-center">
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
                        class="absolute right-2 top-2 flex h-6 w-6 items-center justify-center rounded-full bg-gray-800 text-white">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>

                <!-- Formulaire d'envoi -->
                <form @submit.prevent="sendMessage(); clearAttachment();" class="flex items-center gap-2">
                    <!-- Bouton pièce jointe -->
                    <label class="hover:text-primary cursor-pointer p-2 text-gray-500">
                        <i class="fas fa-paperclip"></i>
                        <input type="file" @change="handleFileUpload" class="attachment-input hidden"
                            accept="image/*">
                    </label>

                    <!-- Champ de message -->
                    <div class="relative flex-1">
                        <textarea x-model="newMessage" rows="1" placeholder="Tapez un message..."
                            class="w-full resize-none overflow-hidden rounded-full border border-gray-300 p-3 pr-10 focus:outline-none"
                            @input="autoResize($el)"></textarea>

                        <!-- Bouton emoji -->
                        <button type="button" @click="showEmojiPicker = !showEmojiPicker"
                            class="absolute right-3 top-3 text-gray-400 hover:text-yellow-500">
                            <i class="far fa-smile"></i>
                        </button>

                        <!-- Picker d'emoji simple -->
                        <div x-show="showEmojiPicker" @click.away="showEmojiPicker = false"
                            class="absolute -top-5 right-0 z-10 h-48 w-64 -translate-y-full overflow-y-auto rounded-lg border border-gray-200 bg-white p-2 shadow-lg">
                            <div class="flex flex-wrap gap-1 gap-3">
                                <template x-for="emoji in ['😀', '😂', '😍', '👍', '❤️', '🙏', '🔥', '🎉', '🤔', '😎']">
                                    <button type="button" @click="insertEmoji(emoji)"
                                        class="rounded p-1 text-xl hover:bg-gray-100" x-text="emoji"></button>
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
                        class="text-back flex h-12 w-12 items-center justify-center rounded-full p-3">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>

            <!-- Vue quand aucun chat n'est sélectionné -->
            <div x-show="!currentChat" class="flex flex-1 items-center justify-center bg-gray-50">
                <div class="p-6 text-center">
                    <div class="mx-auto mb-4 flex h-24 w-24 items-center justify-center rounded-full bg-gray-200">
                        <i class="fas fa-comments text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-gray-700">Pas de conversation sélectionnée</h3>
                    <p class="text-gray-500">Sélectionnez une conversation ou recherchez un contact pour commencer à
                        discuter</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function messenger() {
            return {
                searchQuery: '',
                typingIndicator: false,
                favorites: {!! $favoriteList->map(function ($fav) {
                        return [
                            'id' => $fav->user->id,
                            'pseudo' => $fav->user->pseudo,
                            'prenom' => $fav->user->prenom,
                            'nom_salon' => $fav->user->nom_salon,
                            'avatar' => $fav->user->avatar,
                        ];
                    })->toJson() !!},
                currentChat: null,
                currentChatUser: null,
                newMessage: '',
                loadingContacts: false,
                loadingMessages: false,
                fileToUpload: null,
                preview: null,
                showEmojiPicker: false,

                init() {
                    this.loadContacts();
                    this.setupEventListeners();
                },

                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    if (file && file.type.match('image.*')) {
                        // this.attachment = file;
                        this.fileToUpload = file;

                        // Créer une prévisualisation
                        const reader = new FileReader();
                        reader.onload = (e) => this.preview = e.target.result;
                        reader.readAsDataURL(file);
                        handleFileUpload(event);
                    } else {
                        alert('Veuillez sélectionner une image valide');
                        return;
                    };
                },

                clearAttachment() {
                    this.newMessage = '';
                    this.fileToUpload = null;
                    this.preview = null;
                    document.querySelector('.attachment-input').value = '';
                },

                insertEmoji(emoji) {
                    this.newMessage += emoji;
                    this.showEmojiPicker = false;
                },

                setupEventListeners() {
                    // Écouteur pour le scroll des messages
                    document.getElementById('messages-container').addEventListener('scroll', (e) => {
                        if (e.target.scrollTop === 0 && this.currentChat) {
                            this.loadMoreMessages();
                        }
                    });
                },

                async searchUsers() {
                    if (!this.searchQuery.trim()) return;

                    try {
                        const response = await axios.get('/messenger/search', {
                            params: {
                                query: this.searchQuery
                            }
                        });
                        document.getElementById('search-list').innerHTML = response.data.records;
                    } catch (error) {
                        console.error(error);
                    }
                },

                async loadContacts(page = 1) {
                    this.loadingContacts = true;
                    try {
                        const response = await axios.get('/messenger/fetch-contacts', {
                            params: {
                                page
                            }
                        });
                        document.getElementById('contacts-list').innerHTML = response.data.contacts;
                    } catch (error) {
                        console.error(error);
                    } finally {
                        this.loadingContacts = false;
                    }
                },

                async loadChat(userId) {
                    this.currentChat = userId;
                    this.loadingMessages = true;

                    try {
                        // Récupérer les infos de l'utilisateur
                        const userResponse = await axios.get('/messenger/id-info', {
                            params: {
                                id: userId
                            }
                        });
                        this.currentChatUser = userResponse.data.fetch;

                        // Récupérer les messages
                        const messagesResponse = await axios.get('/messenger/fetch-messages', {
                            params: {
                                id: userId
                            }
                        });
                        document.getElementById('messages-list').innerHTML = messagesResponse.data.messages;

                        // Marquer comme lu
                        await axios.post('/messenger/make-seen', {
                            id: userId
                        });

                        // Scroll vers le bas
                        this.scrollToBottom();
                    } catch (error) {
                        console.error(error);
                    } finally {
                        this.loadingMessages = false;
                    }
                },

                async sendMessage() {
                    if (!this.newMessage.trim() && !this.fileToUpload) return;

                    const formData = new FormData();
                    formData.append('id', this.currentChat);
                    formData.append('message', this.newMessage);
                    formData.append('temporaryMsgId', Date.now());

                  

                    if (this.fileToUpload) {
                        formData.append('attachment', this.fileToUpload);
                    }

                    try {
                        const response = await axios.post('/messenger/send-message', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });

                        // Ajouter le nouveau message
                        let messagesList = document.getElementById('messages-list');
                        messagesList.insertAdjacentHTML('beforeend', response.data.message);

                        // Réinitialiser
                        this.clearAttachment();
                        this.loadContacts();

                        // Scroll vers le bas
                        this.scrollToBottom();
                    } catch (error) {
                        console.error(error);
                        showToast('Erreur lors de l\'envoi du message', 'error');
                    }
                },

                async deleteMessage(messageId) {
                    try {
                        const response = await axios.delete('/messenger/delete-message', {
                            params: {
                                message_id: messageId
                            }
                        });



                        if (response.data.status === 'success') {
                            const messageElement = document.querySelector(`.message-card[data-id="${messageId}"]`);
                            if (messageElement) {
                                messageElement.remove();
                            }
                            showToast(response.data.message, 'success');
                        } else {
                            showToast('Erreur lors de la suppression du message', 'error');
                        }
                    } catch (error) {
                        console.error(error);
                    }
                },

                scrollToBottom() {
                    const container = document.getElementById('messages-container');
                    container.scrollTop = container.scrollHeight;
                },

                async toggleFavorite(userId) {
                    try {
                        const response = await axios.post('/messenger/favorite', {
                            id: userId
                        });

                        if (response.data.status === 'added') {
                            this.favorites.push({
                                id: userId,
                                pseudo: this.currentChatUser.pseudo,
                                avatar: this.currentChatUser.avatar
                            });
                        } else {
                            this.favorites = this.favorites.filter(fav => fav.id !== userId);
                        }
                    } catch (error) {
                        console.error(error);
                    }
                },

                isFavorite(userId) {
                    return this.favorites.some(fav => fav.id === userId);
                },

                startTyping() {
                    this.typing = true;
                    Echo.private(`chat.${this.currentChat}`)
                        .whisper('typing', {
                            userId: this.currentUser.id
                        });
                },
                stopTyping() {
                    this.typing = false;
                    // Envoyer un événement pour indiquer l'arrêt de la saisie
                },

                async loadMoreMessages() {
                    // Implémentez le chargement des messages plus anciens
                }

            }
        }

        // Fonction pour redimensionner automatiquement le textarea
        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = (textarea.scrollHeight) + 'px';
        }

        // Fonction utilitaire
        function showToast(message, type = 'success') {
            console.log('ccccccccccccccccccccccccccccc');
            if (!message || message.trim() === '') {
                return;
            }
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg text-white ${
              type === 'success' ? 'bg-green-500' : 'bg-red-500'
          }`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>
</body>

</html>

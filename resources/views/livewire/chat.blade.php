<style>
    #messagesContainer {
        display: flex;
        flex-direction: column-reverse;
        overflow-y: auto;
        max-height: 300px;
        position: relative; /* Assurez-vous que le conteneur est positionné relativement */
    }
    .message-received {
        background-color:rgb(249, 215, 230);
        margin-left: auto;
        margin-right: 10px;
        max-width: 70%;
        border-radius: 18px 18px 0 18px;
        padding: 8px 12px;
        margin-bottom: 10px;
    }
    .message-sent {
        background-color: #f0f0f0;
        margin-right: auto;
        margin-left: 10px;
        max-width: 70%;
        border-radius: 18px 18px 18px 0;
        padding: 8px 12px;
        margin-bottom: 10px;
    }
    .loading {
        display: none;
        position: absolute; /* Position absolue pour le spinner */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        justify-content: center;
        align-items: center;
    }

    .image-container {
    max-width: 300px; /* ou toute autre taille souhaitée */
    max-height: 300px; /* ou toute autre taille souhaitée */
    overflow: hidden; /* pour s'assurer que l'image ne dépasse pas */
    display: flex;
    justify-content: center;
    align-items: center;
}

.message-attachment {
    max-width: 100%;
    max-height: 100%;
}
    /* Pour les messages envoyés et reçus */
    .message-sent .message-attachment,
    .message-received .message-attachment {
        max-width: 80%; /* L'image prend au maximum 80% de la largeur du conteneur */
    }
    .modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.9);
  overflow: auto;
}

.modal-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  max-width: 80%;
  max-height: 80%;
  display: block;
}

.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}


</style>

@if($user)
<div id="chatContainer" class="fixed bottom-6 right-6 z-50">
    <!-- Bouton de chat flottant -->
    <button id="chatButton" type="button"
        class="relative inline-flex items-center justify-center rounded-full bg-green-gs p-3 text-white shadow-lg transition-all duration-200 cursor-pointer hover:bg-green-gs/80 focus:outline-none"
        aria-label="Open chat">
        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 16" aria-hidden="true">
            <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
            <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
        </svg>
        <span id="unreadCountBadge"
         style="display: none"
        class="absolute -right-1 -top-1 inline-flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-red-500 text-xs font-bold text-white">
         0
        </span>
    </button>
    <!-- Fenêtre de chat -->
    <div id="chatWindow" class="flex h-[400px] w-[300px] max-w-sm flex-col overflow-hidden rounded-lg bg-white shadow-xl" style="display: none;">
        <!-- En-tête du chat -->
        <div class="flex items-center justify-between bg-green-gs p-4 text-white">
            <div class="flex items-center space-x-3">
                <button id="resetSender" aria-label="Back to contacts"
                    class="rounded-full p-1 transition-colors hover:bg-supaGirlRose" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <img id="userAvatar" src="" alt="Avatar de l'utilisateur"
                    class="h-10 w-10 rounded-full border-2 border-white object-cover" style="display: none;">
                <h2 id="userName" class="max-w-[180px] truncate font-semibold">
                    {{ __('chat.messages') }}
                </h2>
            </div>
            <button id="closeChat" aria-label="Close chat"
                class="rounded-full p-1 transition-colors hover:bg-supaGirlRose">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <!-- Zone de messages -->
        <div id="messagesContainer" class="flex-1 space-y-4 overflow-y-auto bg-gray-50 p-4" style="display: none;">
            <!-- Les messages seront ajoutés ici dynamiquement -->
            
        </div>
        <div id="messagesContainerLoading" class="flex w-full h-full overflow-y-auto bg-gray-50 p-4 flex items-center justify-center text-center " style="display: none;">
           <div class="flex items-center justify-center h-full w-full">
            <i class="fa-solid fa-spinner fa-spin text-supaGirlRose"></i>
           </div>
        </div>

        <div id="containerSpinner" class="flex-1 space-y-4 overflow-y-auto bg-gray-50 p-4 flex items-center justify-center " style="display: flex;">
            <i class="fa-solid fa-spinner fa-spin text-supaGirlRose"></i>
        </div>

    
        <!-- Zone de saisie -->
        <div id="messageInputContainer" class="border-t border-gray-200 bg-white p-3" style="display: none;" x-data="{
            showEmojiPicker: false,
            activeCategory: 'smileys_emotion',
            searchQuery: '',
            searchResults: [],
            allEmojis: [
                @if(isset($emojiCategories) && count($emojiCategories) > 0)
                    @foreach($emojiCategories as $category)
                        @foreach($category['emojis'] as $emoji)
                            {
                                char: '{{ $emoji['char'] }}',
                                name: '{{ $emoji['name'] }}',
                                slug: '{{ $category['slug'] }}',
                                category: '{{ $category['name'] }}'
                            },
                        @endforeach
                    @endforeach
                @endif
            ],
            init() {
                this.$watch('showEmojiPicker', value => {
                    if (value) {
                        this.searchQuery = '';
                        this.searchResults = [];
                    }
                });
            },
            search() {
                if (!this.searchQuery.trim()) {
                    this.searchResults = [];
                    return;
                }
                
                const query = this.searchQuery.toLowerCase().trim();
                this.searchResults = this.allEmojis.filter(emoji => 
                    emoji.name.toLowerCase().includes(query)
                );
            },
            insertEmoji(emoji) {
                const input = document.getElementById('messageInput');
                const start = input.selectionStart;
                const end = input.selectionEnd;
                const value = input.value;
                
                // Insert the emoji at cursor position
                input.value = value.substring(0, start) + emoji + value.substring(end);
                
                // Move cursor to after the inserted emoji
                const newPos = start + emoji.length;
                input.focus();
                input.setSelectionRange(newPos, newPos);
                
                // Trigger input event for any listeners
                input.dispatchEvent(new Event('input'));
                
                // Close picker after selection
                // this.showEmojiPicker = false;
            },
            filteredEmojis() {
                if (this.searchQuery) {
                    return this.searchResults;
                }
                return this.allEmojis.filter(emoji => emoji.slug === this.activeCategory);
            }
        }">
            <div class="relative">
                <!-- Emoji Picker Dropdown -->
                <div x-show="showEmojiPicker" 
                     @click.away="showEmojiPicker = false"
                     class="absolute bottom-full mb-2 left-0 w-64 h-64 bg-white overflow-y-auto rounded-lg shadow-lg border border-supaGirlRose z-50"
                     style="display: none;">
                    <!-- Search Bar -->
                    <div class="p-2 border-b border-supaGirlRose">
                        <input type="text" 
                               x-model="searchQuery" 
                               @input="search()"
                               placeholder="Search emojis..."
                               class="w-full px-2 py-1 text-sm border rounded border-supaGirlRose">
                    </div>
                    
                    <!-- Categories -->
                    <div class="flex overflow-x-auto border-b border-gray-200 bg-fieldBg px-2" x-show="!searchQuery">
                                @if(isset($emojiCategories) && count($emojiCategories) > 0)
                                    @foreach($emojiCategories as $category)
                                        <button 
                                            type="button"
                                            @click="activeCategory = '{{ $category['slug'] }}'"
                                            :class="{ 'border-b-2 border-green-gs text-green-gs': activeCategory === '{{ $category['slug'] }}', 'text-gray-600 hover:text-gray-800': activeCategory !== '{{ $category['slug'] }}' }"
                                            class="flex-shrink-0 whitespace-nowrap px-4 py-2 text-sm font-medium transition-colors"
                                            :title="'{{ $category['name'] }}'"
                                        >
                                            {{ $category['emojis'][0]['char'] ?? '' }}
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                    
                    <!-- Emojis Grid -->
                    <div class="p-2 max-h-40   overflow-y-auto">
                        <template x-if="searchQuery && searchResults.length === 0">
                            <div class="p-2 text-center text-gray-500">No emojis found</div>
                        </template>
                        
                        <template x-if="!searchQuery || searchResults.length > 0">
                            <div class="grid grid-cols-8 gap-1">
                                <template x-for="emoji in (searchQuery ? searchResults : filteredEmojis)" :key="emoji.char">
                                    <button 
                                        @click="insertEmoji(emoji.char)"
                                        :title="emoji.name"
                                        class="p-1 text-xl hover:bg-gray-100 rounded flex items-center justify-center"
                                        style="width: 36px; height: 36px">
                                        <span x-text="emoji.char"></span>
                                    </button>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
                
                <!-- Message Input -->
                <div class="flex ">
                  
                    
                    <input type="text" 
                           id="messageInput" 
                           placeholder="{{ __('chat.type_message') }}"
                           class="text-sm flex-1 rounded-full border border-green-gs px-4 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-green-gs">
                    


                    <button 
                        @click="showEmojiPicker = !showEmojiPicker"
                        type="button"
                        class="rounded-full p-2 text-gray-500 hover:text-green-gs focus:outline-none">
                        <i class="far fa-smile text-lg text-green-gs"></i>
                    </button>
                    <button id="sendMessage" class="rounded-full bg-green-gs px-3 py-2 text-white transition-colors hover:bg-green-gs/80 focus:outline-none">
                        <i class="far fa-paper-plane text-lg w-4 h-4"></i>
                    </button>
                  
                </div>
            </div>
        </div>
        <!-- Liste des contacts -->
        <div id="contactsContainer" class="flex-1 overflow-y-auto bg-gray-50 p-2">
            <!-- Les contacts seront ajoutés ici dynamiquement -->
            <div id="contactsLoading" class="loading">
                <i class="fa-solid fa-spinner fa-spin text-supaGirlRose"></i>
            </div>
        </div>
    </div>

<!-- Modal pour afficher l'image -->
<div id="imageModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50">
  <span class="absolute right-4 top-4 cursor-pointer bg-supaGirlRose text-white hover:text-gray-400 rounded-full p-1 transition-colors hover:bg-green-gs/80 py-2 px-4">
    <i class="fa-solid fa-xmark text-white text-sm"></i>
  </span>
  <div class="flex items-center justify-center max-h-[80vh] max-w-[80vw]">
    <img id="modalImage" class="max-h-[80vh] max-w-full object-contain">
  </div>
</div>



</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatButton = document.getElementById('chatButton');
        const chatButtonProfile = document.getElementById('chatButtonProfile');
        const chatWindow = document.getElementById('chatWindow');
        const closeChat = document.getElementById('closeChat');
        const resetSender = document.getElementById('resetSender');
        const userAvatar = document.getElementById('userAvatar');
        const userName = document.getElementById('userName');
        const messagesContainer = document.getElementById('messagesContainer');
        const messagesContainerLoading = document.getElementById('messagesContainerLoading');
        const containerSpinner = document.getElementById('containerSpinner');
        const messageInputContainer = document.getElementById('messageInputContainer');
        const contactsContainer = document.getElementById('contactsContainer');
        const messageInput = document.getElementById('messageInput');
        const sendMessageButton = document.getElementById('sendMessage');
        const unreadCountBadge = document.getElementById('unreadCountBadge');
        const messagesLoading = document.getElementById('messagesLoading');
        const contactsLoading = document.getElementById('contactsLoading');
        let currentUserId = null;
        let oldUser = null;
        let emplacement = null;

        
        chatButton.addEventListener('click', function () {
            chatWindow.style.display = 'flex';
            chatButton.style.display = 'none';
            
            // console.log('chatButton clicked');
            fetchContacts();
            emplacement = 'chat';
        });

     

        closeChat.addEventListener('click', function () {
            // console.log('closeChat clicked');
            fetchUnreadCounts();
            setTimeout(() => {
                chatWindow.style.display = 'none';
                chatButton.style.display = 'block';
            }, 150);
        });

        resetSender.addEventListener('click', function () {
            // console.log('resetSender clicked');
            fetchContacts();
            messagesContainer.style.display = 'none';
            messageInputContainer.style.display = 'none';
            containerSpinner.style.display = 'none';
            contactsContainer.style.display = 'block';
            resetSender.style.display = 'none';
            userAvatar.style.display = 'none';
            userName.textContent = "Messages";
        });

        sendMessageButton.addEventListener('click', function () {
            // console.log('sendMessageButton clicked');
            if (currentUserId && messageInput.value.trim() !== '') {
                sendMessage(currentUserId, messageInput.value);
                messageInput.value = '';
            }
        });

        messageInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter' && currentUserId && messageInput.value.trim() !== '') {
            sendMessage(currentUserId, messageInput.value);
            messageInput.value = '';
        }
    });

    // Ajoutez un écouteur d'événement pour activer/désactiver le bouton d'envoi
    messageInput.addEventListener('input', function() {
        if (messageInput.value.trim() !== '') {
            sendMessageButton.disabled = false;
        } else {
            sendMessageButton.disabled = true;
        }
    });

    // Désactivez le bouton d'envoi au chargement initial
    sendMessageButton.disabled = true;

        fetchUnreadCounts();
        const unreadCountsInterval = setInterval(fetchUnreadCounts, 30000);

        function fetchUnreadCounts() {
            fetch('/api/fetch-unread-counts')
                .then(response => response.json())
                .then(data => {
                    updateUnreadBadges(data.unread_counts);
                    updateTotalUnreadCount(data.unread_counts);
                })
                .catch(error => console.error('Error fetching unread counts:', error));
        }

        
        function fetchUserInfo(userId) {
            fetch('/api/fetch-user-info/' + userId, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    // console.log(data.user);
                    showMessages(data.user);
                })
                .catch(error => console.error('Error fetching unread counts:', error));
        }

        function updateUnreadBadges(unreadCounts) {
            const contactElements = document.querySelectorAll('#contactsContainer > div');
            contactElements.forEach(contactElement => {
                const userId = contactElement.getAttribute('data-user-id');
                const unreadCount = unreadCounts[userId] || 0;
                let badge = contactElement.querySelector('.unread-badge');
                if (unreadCount > 0) {
                    if (!badge) {
                        badge = document.createElement('span');
                        badge.className = 'absolute -right-1 -top-1 inline-flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-red-500 text-xs font-bold text-white';
                        contactElement.querySelector('.relative').appendChild(badge);
                    }
                    badge.textContent = unreadCount;
                } else if (badge) {
                    badge.remove();
                }
            });
        }

        unreadCountBadge.style.display = 'none';

        function updateTotalUnreadCount(unreadCounts) {
            const totalUnreadCount = Object.values(unreadCounts).reduce((sum, count) => sum + count, 0);
            unreadCountBadge.textContent = totalUnreadCount;
            if (totalUnreadCount === 0) {
                unreadCountBadge.style.display = 'none';
            } else {
                unreadCountBadge.style.display = 'inline-flex';
            }
        }

        function fetchContacts() {
    containerSpinner.style.display = 'none';
    contactsLoading.style.display = 'flex';

    fetch('/api/fetch-contacts')
        .then(response => response.json())
        .then(data => {
            contactsContainer.innerHTML = '';

            if (data.contacts === 'No contacts found') {
                contactsContainer.innerHTML = '<p class="text-center">{{ __('chat.no_contacts_found') }}</p>';
            } else {
                // Assurez-vous que les contacts sont triés par last_message_time en ordre décroissant
                data.contacts.sort((a, b) => new Date(b.last_message_time) - new Date(a.last_message_time));
                // console.log(data.contacts);
             
                data.contacts.forEach(user => {
                    const contactElement = document.createElement('div');
                    contactElement.className = 'flex cursor-pointer items-center p-3 shadow-sm hover:bg-gray-100';
                    contactElement.setAttribute('data-user-id', user.id);
                    contactElement.onclick = () => showMessages(user);

                    const formattedTimeAgo = formatTimeAgo(user.last_message_time);
                    contactElement.innerHTML = `
                        <div class="relative">
                            <img src="${user.avatar ? `/storage/avatars/${user.avatar}` : '/images/icon_logo.png'}" alt="${user.pseudo || user.prenom || user.nom_salon}" class="h-12 w-12 rounded-full object-cover">
                            ${user.is_online ? `<span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-green-500" title="Online"></span>` : ''}
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="font-medium text-green-gs">${user.pseudo || user.prenom || user.nom_salon}</h3>
                            <div class="flex items-center justify-between">
                                <p class="text-xs">
                                    ${user.from_id !== user.viewer_id ? '{{ __("chat.you") }}' : user.pseudo || user.prenom || user.nom_salon}
                                    ${user.last_message ? user.last_message.substring(0, 6) + (user.last_message.length > 6 ? '...' : '') : user.last_message.attachment ? '{{ __("chat.attachment") }}' : '{{ __("chat.no_messages_yet") }}'}
                                </p>
                                <p class="text-xs text-textColorParagraph">${formattedTimeAgo}</p>
                            </div>
                        </div>
                    `;
                    contactsContainer.appendChild(contactElement);
                });


                fetchUnreadCounts();
            }
        })
        .catch(error => console.error('Error fetching contacts:', error))
        .finally(() => {
            contactsLoading.style.display = 'none';
        });
}


        function showMessages(user) {
            // messagesLoading.style.display = 'flex';
            containerSpinner.style.display = 'flex';
            messagesContainer.innerHTML = '';
            messagesContainerLoading.style.display = 'block';




            loadMessages(user);
            containerSpinner.style.display = 'none';

        }

       


function loadMessages(user) {
    currentUserId = user.id;
    userAvatar.src = user.avatar ? `/storage/avatars/${user.avatar}` : '/images/icon_logo.png';
    userName.textContent = user.pseudo || user.prenom || user.nom_salon || 'Utilisateur';
    resetSender.style.display = 'block';
    userAvatar.style.display = 'block';
    messagesContainer.style.display = 'block';
    messageInputContainer.style.display = 'block';
    contactsContainer.style.display = 'none';
   

    axios.post('/api/make-seen', { id: user.id });
    fetch(`/api/fetch-messages?id=${user.id}`)
        .then(response => response.json())
        .then(data => {
            // console.log(data.messages);
            messagesContainerLoading.style.display = 'none';
            messagesContainer.innerHTML = '';
            if (data.messages && data.messages.data && Array.isArray(data.messages.data)) {
                const messages = data.messages.data.reverse();
                messages.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.className = message.from_id === currentUserId ? 'message-sent' : 'message-received';

                    // Clear previous content
                    messageElement.innerHTML = '';

                    // Handle text content
                    if (message.body && message.attachment == null) {
                        const textElement = document.createElement('p');
                        textElement.textContent = message.body;
                        messageElement.appendChild(textElement);
                    }

                    // Handle image attachment
                    if (message.attachment) {
                        const imageContainer = document.createElement('div');
                        imageContainer.className = 'image-container';

                        const img = document.createElement('img');
                        let cleanUrl = message.attachment.replace(/^"|"$/g, '').replace(/[\/\\]+/g, '/').replace(/^\/+/, '');
                        console.log(cleanUrl);
                        if (emplacement === 'profile') {
                            const currentUrl = window.location.href;
                            const baseUrl = currentUrl.match(/https?:\/\/[^\/]+/)[0];
                            img.src = baseUrl + '/'+ cleanUrl;
                        }else{
                            img.src = cleanUrl;
                        }
                        img.alt = 'Attachment';
                        img.className = 'message-attachment';
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '100%';
                        img.style.objectFit = 'contain';

                        // Ajouter un gestionnaire d'événements pour ouvrir la modale
                        img.onclick = function() {
                            openModal(cleanUrl);
                        };

                        imageContainer.appendChild(img);
                        messageElement.appendChild(imageContainer);

                        // Ajouter du texte sous l'image si disponible
                        if (message.body) {
                            const textElement = document.createElement('p');
                            textElement.textContent = message.body;
                            messageElement.appendChild(textElement);
                        }
                    }
                    // If neither body nor attachment is present
                    if (!message.body && !message.attachment) {
                        messageElement.textContent = 'No message content';
                    }

                    messagesContainer.appendChild(messageElement);
                });
            } else {
                messagesContainer.innerHTML = '<p class="text-center">{{ __('chat.no_messages_yet') }}</p>';
            }

            setTimeout(() => {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }, 150);
        })
        .catch(error => console.error('Error fetching messages:', error))
        .finally(() => {
            messagesLoading.style.display = 'none';
        });
}


function openModal(imageUrl) {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");

    modal.classList.remove("hidden");
    modalImg.src = imageUrl;

    const span = document.querySelector("#imageModal .fa-xmark");
    span.onclick = function() {
        modal.classList.add("hidden");
    };
}


        function sendMessage(toId, message) {
            fetch('/api/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id: toId, message: message })
            })
            .then(response => response.json())
            .then(data => {
                // console.log('Message sent:', data);
                const currentUserName = userName.textContent;
                const currentAvatarUrl = userAvatar.src;
                loadMessages({ id: toId });
                userName.textContent = currentUserName;
                userAvatar.src = currentAvatarUrl;
                setTimeout(() => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 150);
            })
            .catch(error => console.error('Error sending message:', error));
        }

        chatButtonProfile.addEventListener('click', function () {
            containerSpinner.style.display = 'none';
            contactsLoading.style.display = 'flex';
            chatWindow.style.display = 'flex';
            chatButton.style.display = 'none';
            currentUserId = chatButtonProfile.getAttribute('data-user-id');
            // console.log('chatButtonProfile clicked avec load' + currentUserId);
            // fetchContacts();
            fetchUserInfo(currentUserId);
            emplacement = 'profile';
        });

        // function formatTimeAgo(dateString) {
        //     const now = new Date();
        //     const date = new Date(dateString);
        //     const diffInSeconds = Math.floor((now - date) / 1000);
            
        //     // Définir les intervalles de temps en secondes
        //     const minute = 60;
        //     const hour = minute * 60;
        //     const day = hour * 24;
        //     const month = day * 30;
        //     const year = day * 365;

        //     // Fonction pour formater avec la traduction
        //     function formatTranslation(key, count) {
        //         const translations = {
        //             'just_now': "{{ __('chat.just_now') }}",
        //             'second_1': "{{ __('chat.second_ago', ['count' => 1]) }}",
        //             'second_n': "{{ __('chat.seconds_ago', ['count' => 2]) }}".replace('2', count),
        //             'minute_1': "{{ __('chat.minute_ago', ['count' => 1]) }}",
        //             'minute_n': "{{ __('chat.minutes_ago', ['count' => 2]) }}".replace('2', count),
        //             'hour_1': "{{ __('chat.hour_ago', ['count' => 1]) }}",
        //             'hour_n': "{{ __('chat.hours_ago', ['count' => 2]) }}".replace('2', count),
        //             'day_1': "{{ __('chat.day_ago', ['count' => 1]) }}",
        //             'day_n': "{{ __('chat.days_ago', ['count' => 2]) }}".replace('2', count),
        //             'month_1': "{{ __('chat.month_ago', ['count' => 1]) }}",
        //             'month_n': "{{ __('chat.months_ago', ['count' => 2]) }}".replace('2', count),
        //             'year_1': "{{ __('chat.year_ago', ['count' => 1]) }}",
        //             'year_n': "{{ __('chat.years_ago', ['count' => 2]) }}".replace('2', count)
        //         };
        //         return translations[key] || '';
        //     }

        //     // Calculer les différences
        //     if (diffInSeconds < minute) {
        //         if (diffInSeconds <= 0) return formatTranslation('just_now');
        //         return diffInSeconds === 1 
        //             ? formatTranslation('second_1')
        //             : formatTranslation('second_n', diffInSeconds);
        //     }
            
        //     if (diffInSeconds < hour) {
        //         const minutes = Math.floor(diffInSeconds / minute);
        //         return minutes === 1 
        //             ? formatTranslation('minute_1')
        //             : formatTranslation('minute_n', minutes);
        //     }
            
        //     if (diffInSeconds < day) {
        //         const hours = Math.floor(diffInSeconds / hour);
        //         return hours === 1 
        //             ? formatTranslation('hour_1')
        //             : formatTranslation('hour_n', hours);
        //     }
            
        //     if (diffInSeconds < month) {
        //         const days = Math.floor(diffInSeconds / day);
        //         return days === 1 
        //             ? formatTranslation('day_1')
        //             : formatTranslation('day_n', days);
        //     }
            
        //     if (diffInSeconds < year) {
        //         const months = Math.floor(diffInSeconds / month);
        //         return months === 1 
        //             ? formatTranslation('month_1')
        //             : formatTranslation('month_n', months);
        //     }
            
        //     const years = Math.floor(diffInSeconds / year);
        //     return years === 1 
        //         ? formatTranslation('year_1')
        //         : formatTranslation('year_n', years);
        // }

        function formatTimeAgo(diffInSeconds, locale = navigator.language) {
            const rtf = new Intl.RelativeTimeFormat(locale, { numeric: 'auto' });

            const minute = 60;
            const hour = 60 * minute;
            const day = 24 * hour;
            const month = 30 * day;
            const year = 365 * day;

            if (diffInSeconds < minute) {
                return rtf.format(-diffInSeconds, 'second');
            } else if (diffInSeconds < hour) {
                return rtf.format(-Math.floor(diffInSeconds / minute), 'minute');
            } else if (diffInSeconds < day) {
                return rtf.format(-Math.floor(diffInSeconds / hour), 'hour');
            } else if (diffInSeconds < month) {
                return rtf.format(-Math.floor(diffInSeconds / day), 'day');
            } else if (diffInSeconds < year) {
                return rtf.format(-Math.floor(diffInSeconds / month), 'month');
            } else {
                return rtf.format(-Math.floor(diffInSeconds / year), 'year');
            }
        }




    });
</script>

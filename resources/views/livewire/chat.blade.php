<style>
    #messagesContainer {
        display: flex;
        flex-direction: column-reverse;
        overflow-y: auto;
        max-height: 300px;
    }
    .message-received {
        background-color: #e3fcef;
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
</style>

<div id="chatContainer" class="fixed bottom-6 right-6 z-50">
    <!-- Bouton de chat flottant -->
    <button id="chatButton" type="button"
        class="relative inline-flex items-center justify-center rounded-full bg-green-500 p-3 text-white shadow-lg transition-all duration-200 cursor-pointer hover:bg-green-400 focus:outline-none"
        aria-label="Open chat">
        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 16" aria-hidden="true">
            <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
            <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
        </svg>
        <span id="unreadCountBadge" class="absolute -right-1 -top-1 inline-flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-red-500 text-xs font-bold text-white">
         0
        </span>
    </button>

    <!-- Fenêtre de chat -->
    <div id="chatWindow" class="flex h-[400px] w-[300px] max-w-sm flex-col overflow-hidden rounded-lg bg-white shadow-xl" style="display: none;">
        <!-- En-tête du chat -->
        <div class="flex items-center justify-between bg-green-500 p-4 text-white">
            <div class="flex items-center space-x-3">
                <button id="resetSender" aria-label="Back to contacts"
                    class="rounded-full p-1 transition-colors hover:bg-green-400" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <img id="userAvatar" src="" alt="Avatar de l'utilisateur"
                    class="h-10 w-10 rounded-full border-2 border-white object-cover" style="display: none;">
                <h2 id="userName" class="max-w-[180px] truncate font-semibold">
                    Messages
                </h2>
            </div>
            <button id="closeChat" aria-label="Close chat"
                class="rounded-full p-1 transition-colors hover:bg-red-400">
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
        <!-- Zone de saisie -->
        <div id="messageInputContainer" class="border-t border-gray-200 bg-white p-3" style="display: none;">
            <div class="flex space-x-2">
                <input type="text" id="messageInput" placeholder="Type your message..."
                    class="flex-1 rounded-full border border-gray-300 px-4 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-green-500">
                <button id="sendMessage" class="rounded-full bg-green-500 px-4 py-2 text-white transition-colors hover:bg-green-400 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Liste des contacts -->
        <div id="contactsContainer" class="flex-1 overflow-y-auto bg-gray-50 p-2">
            <!-- Les contacts seront ajoutés ici dynamiquement -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatButton = document.getElementById('chatButton');
        const chatWindow = document.getElementById('chatWindow');
        const closeChat = document.getElementById('closeChat');
        const resetSender = document.getElementById('resetSender');
        const userAvatar = document.getElementById('userAvatar');
        const userName = document.getElementById('userName');
        const messagesContainer = document.getElementById('messagesContainer');
        const messageInputContainer = document.getElementById('messageInputContainer');
        const contactsContainer = document.getElementById('contactsContainer');
        const messageInput = document.getElementById('messageInput');
        const sendMessageButton = document.getElementById('sendMessage');
        const unreadCountBadge = document.getElementById('unreadCountBadge');
        let currentUserId = null;

        chatButton.addEventListener('click', function () {
            chatWindow.style.display = 'flex';
            chatButton.style.display = 'none';
            fetchContacts(); // Charger les contacts lorsque le chat est ouvert
        });

        closeChat.addEventListener('click', function () {
            chatWindow.style.display = 'none';
            chatButton.style.display = 'block';
        });

        resetSender.addEventListener('click', function () {
            messagesContainer.style.display = 'none';
            messageInputContainer.style.display = 'none';
            contactsContainer.style.display = 'block';
            resetSender.style.display = 'none';
            userAvatar.style.display = 'none';
            userName.textContent = "Messages";
        });

        sendMessageButton.addEventListener('click', function () {
            if (currentUserId && messageInput.value.trim() !== '') {
                sendMessage(currentUserId, messageInput.value);
                messageInput.value = ''; // Efface le champ de saisie après l'envoi
            }
        });

        function fetchUnreadCounts() {
            fetch('/api/fetch-unread-counts')
                .then(response => response.json())
                .then(data => {
                    updateUnreadBadges(data.unread_counts);
                    updateTotalUnreadCount(data.unread_counts);
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

        function updateTotalUnreadCount(unreadCounts) {
            const totalUnreadCount = Object.values(unreadCounts).reduce((sum, count) => sum + count, 0);
            unreadCountBadge.textContent = totalUnreadCount;
        }

        function fetchContacts() {
            fetch('/api/fetch-contacts')
                .then(response => response.json())
                .then(data => {
                    contactsContainer.innerHTML = ''; // Efface les contacts précédents
                    if (data.contacts === 'No contacts found') {
                        contactsContainer.innerHTML = '<p class="text-center">No contacts found</p>';
                    } else {
                        data.contacts.forEach(user => {
                            const contactElement = document.createElement('div');
                            contactElement.className = 'flex cursor-pointer items-center p-3 shadow-sm hover:bg-gray-100';
                            contactElement.setAttribute('data-user-id', user.id);
                            contactElement.onclick = () => loadMessages(user);

                            contactElement.innerHTML = `
                                <div class="relative">
                                    <img src="${user.avatar ? `/storage/avatars/${user.avatar}` : '/images/icon_logo.png'}" alt="${user.pseudo || user.prenom || user.nom_salon}" class="h-12 w-12 rounded-full object-cover">
                                    <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-green-500" title="Online"></span>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="font-medium text-green-500">${user.pseudo || user.prenom || user.nom_salon}</h3>
                                    <p class="truncate text-sm text-gray-500">Last message preview</p>
                                </div>
                            `;
                            contactsContainer.appendChild(contactElement);
                        });
                        fetchUnreadCounts(); // Appeler pour obtenir les comptes de messages non lus
                    }
                })
                .catch(error => console.error('Error fetching contacts:', error));
        }

        function loadMessages(user) {
            currentUserId = user.id;
            userAvatar.src = user.avatar ? `/storage/avatars/${user.avatar}` : '/images/icon_logo.png';
            userName.textContent = user.pseudo || user.prenom || user.nom_salon || 'Utilisateur';
            // Afficher les éléments de l'en-tête et les zones de messages et de saisie
            resetSender.style.display = 'block';
            userAvatar.style.display = 'block';
            messagesContainer.style.display = 'block';
            messageInputContainer.style.display = 'block';
            contactsContainer.style.display = 'none';

            axios.post('/api/make-seen', { id: user.id });

            // Charger les messages pour l'utilisateur sélectionné
            fetch(`/api/fetch-messages?id=${user.id}`)
                .then(response => response.json())
                .then(data => {
                    messagesContainer.innerHTML = ''; // Efface les messages précédents
                    if (data.messages && data.messages.data && Array.isArray(data.messages.data)) {
                        // Inverser l'ordre des messages pour afficher les plus récents en bas
                        const messages = data.messages.data.reverse();
                        messages.forEach(message => {
                            const messageElement = document.createElement('div');
                            messageElement.className = message.from_id === currentUserId ? 'message-sent' : 'message-received';
                            messageElement.textContent = message.body;
                            messagesContainer.appendChild(messageElement);
                        });
                    } else {
                        messagesContainer.innerHTML = '<p>No messages found or invalid data format</p>';
                    }
                })
                .catch(error => console.error('Error fetching messages:', error));
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
                console.log('Message sent:', data);
                // Conserver le nom du contact
                const currentUserName = userName.textContent;
                const currentAvatarUrl = userAvatar.src;
                // Recharger les messages pour afficher le nouveau message
                loadMessages({ id: toId });
                // Rétablir le nom du contact
                userName.textContent = currentUserName;
                userAvatar.src = currentAvatarUrl;
                // Faire défiler vers le bas pour afficher le dernier message
                setTimeout(() => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 100); // Un petit délai pour s'assurer que les messages sont chargés
            })
            .catch(error => console.error('Error sending message:', error));
        }
    });
</script>

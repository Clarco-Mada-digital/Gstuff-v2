<template>
  <div class="chat-container">
    <div class="messages">
      <div v-for="message in messages" :key="message.id" :class="{'message-sent': message.sender_id == userId, 'message-received': message.sender_id != userId}">
        <span class="message-content">{{ message.message }}</span>
        <span class="message-time">{{ formatTime(message.created_at) }}</span>
      </div>
    </div>
    <div class="input-area">
      <input type="text" v-model="newMessage" @keyup.enter="sendMessage" placeholder="Écrivez un message...">
      <button @click="sendMessage">Envoyer</button>
    </div>
  </div>
</template>

<script>
import moment from 'moment'; // Assurez-vous d'installer moment: npm install moment

export default {
  props: {
    receiverId: {
      type: Number,
      required: true
    },
    userId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      messages: [],
      newMessage: ''
    };
  },
  mounted() {
    this.fetchMessages();
    this.listenForNewMessages();
    this.scrollToBottom(); // Scroll initial au bas des messages
  },
  watch: {
    messages() {
      this.$nextTick(() => { // S'assurer que les messages sont rendus avant de scroller
        this.scrollToBottom();
      });
    }
  },
  methods: {
    fetchMessages() {
      axios.get(`/messages/${this.receiverId}`)
        .then(response => {
          this.messages = response.data;
        });
    },
    sendMessage() {
      if (this.newMessage.trim() === '') return; // Empêcher l'envoi de messages vides

      axios.post('/send-message', {
        receiver_id: this.receiverId,
        message: this.newMessage
      })
      .then(response => {
        this.messages.push(response.data.message); // Ajouter le message immédiatement à l'UI
        this.newMessage = '';
      });
    },
    listenForNewMessages() {
      Echo.private(`chat.${this.userId}`)
          .listen('.message.created', (event) => {
              if (event.message.sender_id != this.userId && event.message.sender_id == this.receiverId) { // Vérifier que le message est pour l'utilisateur actuel et vient du bon expéditeur
                  this.messages.push(event.message);
              }
          });
    },
    scrollToBottom() {
      const messagesContainer = this.$el.querySelector('.messages');
      if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
      }
    },
    formatTime(dateTime) {
      return moment(dateTime).format('HH:mm'); // Formater l'heure avec moment.js
    }
  }
};
</script>

<style scoped>
.chat-container {
  border: 1px solid #ccc;
  border-radius: 5px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  height: 400px; /* Ajustez selon vos besoins */
}
.messages {
  flex-grow: 1;
  padding: 10px;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
}
.message-sent {
  background-color: #DCF8C6;
  padding: 8px 12px;
  border-radius: 10px;
  align-self: flex-end;
  margin-bottom: 5px;
  word-wrap: break-word; /* Pour les longs messages */
  max-width: 80%; /* Pour limiter la largeur des messages */
}
.message-received {
  background-color: #FFF;
  padding: 8px 12px;
  border-radius: 10px;
  align-self: flex-start;
  margin-bottom: 5px;
  border: 1px solid #ddd; /* Ajout d'une bordure pour les messages reçus */
  word-wrap: break-word;
  max-width: 80%;
}
.message-content {
  display: block; /* Assurer que le contenu et l'heure sont sur des lignes différentes si nécessaire */
}
.message-time {
  display: block;
  font-size: 0.8em;
  color: #777;
  text-align: right; /* Aligner l'heure à droite dans le message */
  margin-top: 2px;
}
.input-area {
  padding: 10px;
  border-top: 1px solid #ccc;
  display: flex;
}
.input-area input[type="text"] {
  flex-grow: 1;
  padding: 8px;
  border-radius: 5px;
  border: 1px solid #ccc;
}
.input-area button {
  margin-left: 10px;
  padding: 8px 15px;
  border-radius: 5px;
  border: none;
  background-color: #007bff;
  color: white;
  cursor: pointer;
}
</style>

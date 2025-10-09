/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    // wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    // wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    // wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    encrypted: true,
    // enabledTransports: ['ws', 'wss'],
});


Echo.channel('message.' + userId)
    .listen('message.sent', (event) => {
        // Ici, tu peux mettre à jour ton chat en temps réel
        console.log(event.message);
    });

// Vérification de la variable userId
// if (typeof userId !== 'undefined' && userId) {
//     Echo.channel('message.' + userId)
//         .listen('message.sent', (event) => {
//             // Mise à jour du chat en temps réel
//             console.log(event.message);
//         });
// } else {
//     console.warn('userId est null ou undefined. Vérifiez sa valeur avant de l’utiliser.');
// }

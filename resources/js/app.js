import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist'
// import './livewire-redirect-fix.js';

window.Alpine = Alpine;
Alpine.plugin(persist);

function setupCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!token) {
        console.warn('CSRF token meta tag not found');
        return;
    }

    return {
        getToken: () => token,
        fetchWithCsrf: (url, options = {}) => {
            options.headers = {
                ...options.headers,
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest'
            };
            return fetch(url, options);
        }
    };
}

// Initialisation
const csrf = setupCsrfToken();

// Utilisation
csrf.fetchWithCsrf('/api/data', {
    method: 'POST',
    body: JSON.stringify({ key: 'value' })
});

document.addEventListener('alpine:init', () => {    
    Alpine.data('realTimeStories', () => ({
        init() {
            // Configuration Pusher
            const pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
                cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                encrypted: true
            });

            // Abonnement au canal
            const channel = pusher.subscribe('stories-channel');

            // Écoute des événements
            channel.bind('new-story', (data) => {
                this.call('refreshStories');
            });

            channel.bind('story-viewed', (data) => {
                this.updateStoryViews(data.storyId);
            });
        },

        updateStoryViews(storyId) {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                if (bar.dataset.storyId === storyId) {
                    bar.querySelector('.progress-fill').style.width = '100%';
                }
            });
        }
    }));
});


Alpine.start();

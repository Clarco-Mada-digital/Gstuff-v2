import './bootstrap';

import Alpine from 'alpinejs';
// import './livewire-redirect-fix.js';

window.Alpine = Alpine;

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

document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour vérifier l'URL et rediriger si nécessaire
    function checkAndRedirect() {
        // Vérifie si l'URL contient 'livewire/update'
        if (window.location.href.includes('livewire/update')) {
            console.log('URL livewire/update détectée, redirection...');
            
            // Récupère l'URL précédente depuis l'historique si disponible
            if (document.referrer && document.referrer !== '') {
                window.location.href = document.referrer;
            } else {
                // Si pas d'URL précédente, rediriger vers la page d'accueil
                // Vous pouvez remplacer cette URL par votre page d'accueil
                window.location.href = window.location.origin;
            }
        }
    }

    // Vérifie immédiatement au chargement de la page
    checkAndRedirect();

    // Surveille également les changements d'URL via history API
    const originalPushState = window.history.pushState;
    window.history.pushState = function() {
        originalPushState.apply(this, arguments);
        checkAndRedirect();
    };

    const originalReplaceState = window.history.replaceState;
    window.history.replaceState = function() {
        originalReplaceState.apply(this, arguments);
        checkAndRedirect();
    };

    // Surveille également les événements de navigateur (boutons précédent/suivant)
    window.addEventListener('popstate', function() {
        checkAndRedirect();
    });

    // Pour les requêtes AJAX de Livewire
    document.addEventListener('livewire:load', function() {
        if (typeof window.Livewire !== 'undefined') {
            // Avant que Livewire n'envoie une requête
            window.Livewire.hook('message.sent', () => {
                // Vérifie l'URL après un court délai pour laisser le temps à la redirection
                setTimeout(checkAndRedirect, 100);
            });
            
            // Après que Livewire ait reçu une réponse
            window.Livewire.hook('message.received', () => {
                setTimeout(checkAndRedirect, 100);
            });
        }
    });
});

Alpine.start();

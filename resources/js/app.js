import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

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

import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/messenger.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/resources', // Change ce répertoire si nécessaire
        manifest: true,              // Génère un manifest.json
        rollupOptions: {
          input: '/resources/js/app.js', // Le fichier d'entrée principal
        },
      },
});

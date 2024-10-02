import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: 'pedalea-comodoro.local', // Tu dominio local
        hmr: {
            host: 'pedalea-comodoro.local', // También configurado para HMR
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});

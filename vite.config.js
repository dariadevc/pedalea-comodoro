import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: 'pedalea-comodoro.local', // Nuestro dominio local
        hmr: {
            host: 'pedalea-comodoro.local', // También configurado para que se actualice automaticamente al hacer cambios en el código
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
<<<<<<< HEAD
                'resources/js/layout-app.js'
=======
                'resources/js/alquilar.js',
                'resources/js/reservar.js',
>>>>>>> 16deefb3d38a1325a5d8c761a4f0d1f5cfc936de
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            $: 'jquery',
        },
    },
});
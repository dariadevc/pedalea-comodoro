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
                'resources/js/layout-app.js',
                'resources/js/alquilar.js',
                'resources/js/reservar.js',
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
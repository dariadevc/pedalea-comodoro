import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                "pc-rojo": "#cd3f4b",
                "pc-naranja": "#eb7c6c",
                "pc-azul": "#0097a7",
                "pc-celeste": "#66bba8",
                "pc-texto-h": "#302929",
                "pc-texto-p": "#413c3c",
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans], //Esto estaba en el merge de iniciar sesión, asique lo dejé
            },
        },
        fontFamily: {
            Montserrat: ['Montserrat', 'sans-serif']
        },
        container: {
            center: true,
            padding: "1rem",
            screens: {
                lg: "1124px",
                xl: "1124px",
                "2xl": "1124px",
            },
        },
    },

    plugins: [forms],
};

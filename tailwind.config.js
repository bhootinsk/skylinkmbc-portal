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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                skylink: {
                    50: '#f0f7ff',
                    100: '#e0effe',
                    200: '#b9dffd',
                    300: '#7cc4fb',
                    400: '#36a5f6',
                    500: '#0c87e7',
                    600: '#006bc4',
                    700: '#0155a0',
                    800: '#064884',
                    900: '#0b3d6e',
                    950: '#072749',
                },
            },
        },
    },

    plugins: [forms],
};

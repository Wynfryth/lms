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
              "bookmark-purple": "#5267DF",
              "bookmark-red": "#FA5959",
              "bookmark-blue": "#2424A5",
              "bookmark-grey": "#9194A2",
              "bookmark-white": "#f7f7f7",
            }
        },
        fontFamily: {
          sans: ['Figtree', ...defaultTheme.fontFamily.sans],
          Poppins: ['Poppins, sans-serif'],
          Outfit: ['Outfit, sans-serif']
        },
        container: {
          center: true,
          padding: '1rem',
          screens : {
            lg: '1124px',
            xl: '1124px',
            "2xl": '1124px'
          }
        }
    },

    plugins: [forms],
    darkMode: 'false'
};

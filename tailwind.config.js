import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                theme: {
                    bg: "var(--theme-bg-main)",
                    card: "var(--theme-bg-card)",
                    hover: "var(--theme-bg-hover)",
                    border: "var(--theme-border)",
                    text: {
                        main: "var(--theme-text-main)",
                        muted: "var(--theme-text-muted)",
                    },
                    primary: {
                        DEFAULT: "var(--theme-primary)",
                        hover: "var(--theme-primary-hover)",
                        light: "var(--theme-primary-light)",
                    },
                },
            },
        },
    },

    plugins: [forms],
};

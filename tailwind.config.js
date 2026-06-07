/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/**/*.blade.php",
        "./resources/**/**/*.js",
        "./app/View/Components/**/**/*.php",
        "./app/Livewire/**/**/*.php",

        "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
    ],
    theme: {
        extend: {},
    },

    // Add daisyUI
    plugins: [require("daisyui")]
}

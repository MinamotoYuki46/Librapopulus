/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./app/Views/**/*.{php, html, js, css}",
        './public/**/*.{html, css, js, php}',
        './app/Controllers/**/*.php',
        "./src/**/*.{html,js}",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require("flowbite/plugin")
    ],
}

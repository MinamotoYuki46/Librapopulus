/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./app/Views/**/*.{php, html, js, css}",
        './public/**/*.{html, css, js, php}',
        './app/Controllers/**/*.php',
        "./src/**/*.{html,js}",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}

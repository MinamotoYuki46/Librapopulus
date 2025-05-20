/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./app/Views/**/*.{php, html, js}",
        './public/**/*.{html, css, js, php}',
        './app/Controllers/**/*.php'
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}

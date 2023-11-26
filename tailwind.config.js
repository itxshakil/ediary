/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "app/**/*.php",
    "resources/**/*.html",
    "resources/**/*.js",
    "resources/**/*.jsx",
    "resources/**/*.ts",
    "resources/**/*.tsx",
    "resources/**/*.php",
    "resources/**/*.vue",
    "resources/**/*.twig",
  ],
  theme: {
    extend: {
      flex: {
        'feature': '1 1 320px',
      },
      width: {
        '96': '24rem',
      }
    },
  },
  plugins: [],
}

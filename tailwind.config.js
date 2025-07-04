/** @type {import('tailwindcss').Config} */
export default {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
      colors: {
        primary: "#000000",
        secondary: "#FFFFFF",
        tertiary: "#000000",
        dark: '#242b33'
      },

      },
    },
    plugins: [],
  }
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
        "pc-rojo": "#cd3f4b",
        "pc-naranja": "#eb7c6c",
        "pc-azul": "#0097a7",
        "pc-celeste": "#66bba8",
        "pc-texto-h": "#302929",
        "pc-texto-p": "#413c3c",
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
  plugins: [],
}


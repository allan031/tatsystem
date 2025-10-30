/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./admin/**/*.php",
    "./pages/**/*.php",
    "./class/**/*.php",
    "./**/*.php",
    "./**/*.js"
  ],
  theme: {
    extend: {
      screens: {
        xs: { min: "1px", max: "320px" },
        sm: { min: "321px", max: "480px" },
        md: { min: "481px", max: "768px" },
        lg: { min: "769px", max: "1279px" },
        xl: { min: "1280px", max: "1536px" },
        xl1: { min: "1537px", max: "2559px" },
        xl2: { min: "2560px" },
      },
      colors: {
        first: "#5C63A5",
        second: "#8C93BC",
        third: "#2A358F",
        fourth: "#FEFEFE",
        fifth: "#eedee2",
        primary: "#f48786",
      },
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [],
};

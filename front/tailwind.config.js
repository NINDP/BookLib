/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue, js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        brown: "#855B32",
        green: "#1F7C65",
        bgcolor: "#FBFBFB",
      },
      spacing: {
        "170px": "170px",
      },
    },
  },
  plugins: [],
};


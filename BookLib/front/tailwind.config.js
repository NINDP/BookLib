/** @type {import('tailwindcss').Config} */
export default {
    content: ["./index.html", "./src/**/*.{vue, js,ts,jsx,tsx}"],
    theme: {
        extend: {
            colors: {
                green1: "#1F7C65",
                bgcolor: "#FBFBFB",
                caramel: "#E5B863",
                brown: "#BD8F63",
                black_text: "#272727",
            },
        },
    },
    plugins: [],
};


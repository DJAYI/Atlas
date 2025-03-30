import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // "1c66af",
                primary: {
                    // Variants of "1c66af",
                    50: "#e1f0ff",
                    100: "#b3d4ff",
                    200: "#80b1ff",
                    300: "#4d8eff",
                    400: "#1a6bff",
                    500: "#0052e6",
                    600: "#0041b3",
                    700: "#003380",
                    800: "#00224d",
                    900: "#00161a",
                    DEFAULT: "#1c66af",
                },

                // c31a1f
                secondary: {
                    // Variants of "c31a1f",
                    50: "#fce8e9",
                    100: "#f9c6c8",
                    200: "#f39da2",
                    300: "#ef7480",
                    400: "#ec4b5e",
                    500: "#c31a1f",
                    600: "#a5151b",
                    700: "#7e1116",
                    800: "#590d12",
                    900: "#34090d",
                    DEFAULT: "#c31a1f",
                },
            },
        },
    },

    plugins: [forms],
};

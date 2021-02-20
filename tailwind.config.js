const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Open Sans", ...defaultTheme.fontFamily.sans],
            },
            minWidth: {
                "1/2": "50%",
            },
            colors: {
                teal: {
                    50: "#eef9f9",
                    100: "#d7f7f5",
                    200: "#abefea",
                    300: "#70e4df",
                    400: "#2acfcc",
                    500: "#57afad", // Hauptfarbe
                    600: "#0c9597",
                    700: "#12787a",
                    800: "#145d5e",
                    900: "#134b4b",
                },
                orange: {
                    50: "#f9f6e7",
                    100: "#faf1c1",
                    200: "#f6e780",
                    300: "#f1d53c",
                    400: "#e9b01f", //Sekundärfarbe
                    500: "#df9806",
                    600: "#cc7404",
                    700: "#a95708",
                    800: "#89440e",
                    900: "#6f3710",
                },
                mango: {
                    50: "#faf6ee",
                    100: "#fbefd8",
                    200: "#f8dfac",
                    300: "#f6c56d",
                    400: "#f39e31",
                    500: "#f27615",
                    600: "#e6520e",
                    700: "#ba4b18", // Akzentfarbe 1
                    800: "#9e3118",
                    900: "#802818",
                },
                cerise: {
                    50: "#fafafa",
                    100: "#f8f5f7",
                    200: "#efe4ec",
                    300: "#e6cade",
                    400: "#d99cc5",
                    500: "#c770a4",
                    600: "#a14b7c",
                    700: "#72395f",
                    800: "#593351", // Akzentfarbe 2
                    900: "#3c2437",
                },

                sepiaGray: {
                    50: "#f8f8f6",
                    100: "#f4f2ee",
                    200: "#f2e8dd", // bg
                    300: "#dccfc1",
                    400: "#c4ac97",
                    500: "#aa856d",
                    600: "#8a614f",
                    700: "#6c4a45",
                    800: "#533a3c",
                    900: "#422f32",
                },
            },
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};

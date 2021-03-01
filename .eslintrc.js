module.exports = {
    env: {
        browser: true,
        es2021: true,
        amd: true, // allow require
    },
    extends: ["eslint:recommended", "plugin:vue/vue3-essential"],
    parserOptions: {
        ecmaVersion: 12,
        sourceType: "module",
    },
    plugins: ["vue"],
    rules: {},

    globals: {
        route: false,
        axios: false,
    },
};

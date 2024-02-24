module.exports = {
    env: {
        browser: true,
        es2021: true,
    },
    extends: ["eslint:recommended", "plugin:vue/vue3-essential"],
    overrides: [
        {
            files: ["resources/**/*.vue"],
            extends: ["plugin:vue/vue3-strongly-recommended"],
            plugins: ["vue"],
            rules: {
                "vue/multi-word-component-names": "off",
            },
        },
    ],
    parserOptions: {
        ecmaVersion: "latest",
        sourceType: "module",
    },
    plugins: ["vue"],
    rules: {},
};

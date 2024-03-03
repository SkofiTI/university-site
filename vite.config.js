import { dirname } from "path";
import { fileURLToPath } from "url";

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            "@": dirname(fileURLToPath(import.meta.url)) + "/resources",
            "@src": dirname(fileURLToPath(import.meta.url)) + "/resources/js",
            "@assets": dirname(fileURLToPath(import.meta.url)) + "/resources/assets",
        },
    },
});

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import viteCompression from 'vite-plugin-compression'
import legacy from '@vitejs/plugin-legacy'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        viteCompression(),
        legacy({
            targets: ['defaults', 'not IE 11'],
        }),

    ]
});

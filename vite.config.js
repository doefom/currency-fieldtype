import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import statamic from '@statamic/cms/vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/currency-fieldtype.js',
                // 'resources/css/addon.css'
            ],
            publicDirectory: 'resources/dist',
        }),
        statamic(),
    ],
});

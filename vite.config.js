import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { PrimeVueResolver } from '@primevue/auto-import-resolver';
import Components from 'unplugin-vue-components/vite';

export default defineConfig({
    server: {
        host: '192.168.22.90',
        // port: 8089,
        strictPort: true, // Prevents Vite from trying to use an alternative port if 8089 is in use
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        Components({
            resolvers: [PrimeVueResolver()]
        })
    ],
});

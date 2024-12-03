import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            publicDirectory: 'public',
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery',
            '@': '/resources/js',
            '~': '/resources/style_files',
            'vue': 'vue/dist/vue.esm-bundler.js'
        }
    },
    optimizeDeps: {
        include: ['jquery', 'slick-carousel']
    },
    build: {
        commonjsOptions: {
            include: [/node_modules/],
        },
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue', 'jquery', 'slick-carousel'],
                },
            },
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});

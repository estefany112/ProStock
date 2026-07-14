import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],

    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        origin: 'https://unpraiseworthy-joni-laconically.ngrok-free.dev/',
        hmr: {
            protocol: 'wss',
            host: 'unpraiseworthy-joni-laconically.ngrok-free.dev',
        },
    },
})
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/main.scss',
                'resources/sass/codebase/themes/corporate.scss',
                'resources/sass/codebase/themes/earth.scss',
                'resources/sass/codebase/themes/elegance.scss',
                'resources/sass/codebase/themes/flat.scss',
                'resources/sass/codebase/themes/pulse.scss',
                'resources/scss/main.scss',
                'resources/js/codebase/app.js',
                'resources/js/app.js',
                'resources/js/pages/datatables.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',     // listen inside the container
        port: 5173,
        strictPort: true,
        cors: true,
        watch: { usePolling: true }, // helpful inside Docker
        hmr: {
            host: 'localhost', // change if you browse via 127.0.0.1 or a dev domain
            port: 5173,
            protocol: 'ws',
        },
        origin: 'http://localhost:5173', // match what your browser uses
        // Proxy WebSocket connections to avoid CORS issues
        proxy: {
            '/app': {
                target: 'ws://localhost:8081',
                ws: true,
                changeOrigin: true
            }
        }
    },
})

import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/products.css',
                'resources/css/product-detail.css',
                'resources/css/reviews.css',
                'resources/css/fonts.css',
                'resources/css/dark-mode.css',
                'resources/js/app.js',
                'resources/js/admin-products.js',
                'resources/js/dark-mode.js',
                'resources/js/promo.js',
            ],
            refresh: true,
        }),
    ],
})

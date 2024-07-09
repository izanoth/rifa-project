import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    /*plugins: [
        laravel({
            input: ['storage/app/public/css/app.css', 'storage/app/public/js/app.js'],
            refresh: true,
        }),
    ],*/
    build: {
        minify: true,
        rollupOptions: {
            input: {
                js_app: 'storage/app/public/js/app.js',
                js_checkout_app: 'storage/app/public/js/myfunctions_checkout.js',
                js_infoup: 'storage/app/public/js/infoup.js',
                js_stripe_app: 'storage/app/public/js/stripe-script.js',
                css_app: 'storage/app/public/css/app.css',
                css_stripe: 'storage/app/public/css/stripe.css',
            }
        },
        build: {
            outDir: 'public_html'
        }
    },
});

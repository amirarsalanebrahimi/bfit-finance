import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import { VitePWA } from 'vite-plugin-pwa';

export default () => {
    const manifestIcons = [
        {
            src: '/pwa-64x64.png',
            sizes: '64x64',
            type: 'image/png',
        },
        {
            src: '/pwa-192x192.png',
            sizes: '192x192',
            type: 'image/png',
        },
        {
            src: '/pwa-512x512.png',
            sizes: '512x512',
            type: 'image/png',
            purpose: 'any',
        },
        {
            src: '/maskable-icon-512x512.png',
            sizes: '512x512',
            type: 'image/png',
            purpose: 'maskable',
        },
    ];
    const publicIcons = [{ src: '/favicon.ico' }, { src: '/favicon.svg' }, { src: '/apple-touch-icon-180x180.png' }];
    const additionalImages = [];

    return defineConfig({
        plugins: [
            laravel({
                input: ['resources/js/app.ts'],
                ssr: 'resources/js/ssr.ts',
                refresh: true,
            }),
            tailwindcss(),
            wayfinder({
                formVariants: true,
            }),
            vue({
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            VitePWA({
                buildBase: '/build/',
                scope: '/',
                base: '/',
                registerType: 'prompt', //autoUpdate
                devOptions: {
                    enabled: false,
                },
                includeAssets: [],

                workbox: {
                    // Add all the assets built by Vite into the public/build/assets
                    // folder to the SW cache.
                    globPatterns: ["**/*.{js,css,html,ico,jpg,png,svg,woff,woff2,ttf,eot}"],

                    // Define the root URL as the entrypoint for the offline app.
                    // vue-router can then takes over and shows the correct page
                    // if you are using it.
                    navigateFallback: "/",

                    // Stops various paths being intercepted by the service worker
                    // if they're not available offline. Telescope is a good
                    // example, if you are using that.
                    navigateFallbackDenylist: [/^\/telescope/],

                    // Add some explicit URLs to the SW precache. This helps us
                    // work with the laravel/vite-plugin setup.
                    additionalManifestEntries: [
                        // Cache the root URL to get hold of the PWA HTML entrypoint
                        // defined in welcome.blade.php. Ref:
                        // https://github.com/vite-pwa/vite-plugin-pwa/issues/431#issuecomment-1703151065
                        { url: "/", revision: `${Date.now()}` },

                        // Cache the icons defined above for the manifest
                        ...manifestIcons.map((i) => {
                            return { url: i.src, revision: `${Date.now()}` }
                        }),

                        // Cache the other offline icons defined above
                        ...publicIcons.map((i) => {
                            return { url: i.src, revision: `${Date.now()}` }
                        }),

                        // Cache any additional images defined above
                        ...additionalImages.map((i) => {
                            return { url: i.src, revision: `${Date.now()}` }
                        })
                    ],

                    // Ensure the JS build does not get dropped from the cache.
                    // This allows it to be as big as 3MB
                    maximumFileSizeToCacheInBytes: 3000000
                },

                manifest: {
                    name: 'BFit Finance',
                    short_name: 'BFit Finance',
                    description: 'BFit Sports Group',
                    theme_color: '#ffffff',
                    background_color: '#ffffff',
                    orientation: 'portrait',
                    display: 'standalone',
                    scope: '/',
                    start_url: '/',
                    id: '/',
                    icons: manifestIcons,
                },
            }),
        ],
    });
};

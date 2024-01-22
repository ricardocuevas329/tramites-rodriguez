import { join } from 'node:path'
import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import {fileURLToPath, URL} from "url";
import viteCompression from 'vite-plugin-compression';
import WindiCSS from 'vite-plugin-windicss'

export default defineConfig({
    optimizeDeps: {
        exclude: [
            'node_modules',
            'vendor',
            'app',
            'boostrap',
            'config',
            'database',
            'lang',
            'routes',
            'public',
            'storage',
            'test',
        ]
    },
    server: {
        hmr: { overlay: false },
    },
    plugins: [
        WindiCSS({
            onOptionsResolved: (options) => {
                options.scanOptions.extraTransformTargets.css.push(join(__dirname, 'excluded', 'included.css'))
            },
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        viteCompression({
            verbose: true,
            disable: false,
            threshold: 10240,
            algorithm: "gzip",
            ext: ".gz",
        }),
        // tsconfigPaths(),
        laravel({
            publicDirectory: 'public',
            buildDirectory: 'build',
            input: [  'resources/js/app.js', 'resources/js/external.js'],
            //refresh: true,
        }),
    ],
    resolve: {

        alias: {
            "@": fileURLToPath(new URL("./resources/js", import.meta.url)),
        },
        optimizeDeps: {
            entries: [
                './resources/js/**/*.vue',
            ],
        },
        extensions: ['.js', '.ts', 'd.ts', '.json', '.vue'],
    },
    build: {
      //  minify: 'terser',
        manifest: true,
        rollupOptions: {

            output: {

                chunkFileNames: "static/js/[name]-[hash].js",
                entryFileNames: "static/js/[name]-[hash].js",
                assetFileNames: "static/[ext]/[name]-[hash].[ext]"
                /* manualChunks: (id) => {
                     if (id.includes('node_modules')) {
                         return 'vendor';
                     }
                 }*/
            }
            /*
               chunkFileNames: "static/js/[name]-[hash].js",
                entryFileNames: "static/js/[name]-[hash].js",
                assetFileNames: "static/[ext]/[name]-[hash].[ext]",*/

        }
    }
});

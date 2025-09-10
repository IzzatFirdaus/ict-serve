<<<<<<< HEAD
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
// React plugin removed

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        // React plugin removed
    ],
=======
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/theme.js'
      ],
      refresh: true,
    }),
  ],
>>>>>>> bdd2474 (Finish UI views, Livewire components, API docs, and repo housekeeping for loan module)
});

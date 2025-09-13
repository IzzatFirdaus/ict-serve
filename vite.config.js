<<<<<<< HEAD
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
=======
<<<<<<< HEAD
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
// React plugin removed
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< HEAD
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
=======
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        // React plugin removed
>>>>>>> 6d94ec6966122a01c5eff96f247c9667922ef5f9
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

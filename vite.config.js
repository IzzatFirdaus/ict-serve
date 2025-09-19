import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        // Main app assets
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/theme.js',

        // Shared JavaScript components
        'resources/js/shared/theme-prevention.js',
        'resources/js/shared/layout-stores.js',
        'resources/js/shared/toast-manager.js',
        'resources/js/shared/modal-focus-trap.js',

        // Component-specific JavaScript
        'resources/js/components/file-upload-alpine.js',

        // Page-specific JavaScript
        'resources/js/pages/demo-dashboard.js',

        // Shared CSS
        'resources/css/shared/skip-links.css',

        // Page-specific CSS
        'resources/css/pages/demo-dashboard.css',

        // Document CSS
        'resources/css/documents/loan-application.css',

        // Email CSS
        'resources/css/emails/email-templates.css',
      ],
      refresh: true,
    }),
  ],
});

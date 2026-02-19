import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',  // your Tailwind entry
        'resources/js/app.js'     // your JS (with Alpine import)
      ],
      refresh: true,              // enables Blade hot-reload
    }),
  ],
});

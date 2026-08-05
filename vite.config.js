import { defineConfig } from 'vite';

export default defineConfig({
  base: '/build/',
  publicDir: false,
  build: {
    outDir: 'public/build',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: 'resources/js/storefront.js',
    },
  },
  server: {
    host: '127.0.0.1',
    port: 5173,
    strictPort: true,
    cors: {
      origin: 'http://127.0.0.1:8032',
    },
  },
});

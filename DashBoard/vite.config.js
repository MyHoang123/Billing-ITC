import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [react()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src'),
    },
  },
  base: '/',
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `@use "@/styles/variables" as *;`
      }
    }
  },
  build: {
    outDir: '../assets/dist',
    emptyOutDir: true,
    rollupOptions: {
      output: {
        entryFileNames: 'dashboardMbbank.js',        // 👈 JS chính
        chunkFileNames: 'chunk.js',         // 👈 chunk
        assetFileNames: 'dashboardMbbank.[ext]',      // 👈 CSS
      },
    },
  },
});

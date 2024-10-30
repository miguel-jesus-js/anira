import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js', // Alias para habilitar runtime + template compilation
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
    //Habilitar para docker
    /*server: {
        host: '0.0.0.0', // Escucha en todas las interfaces de red
        port: 5173,       // Puerto de Vite
        strictPort: true, // Asegura que use este puerto
        watch: {
            usePolling: true,    // Habilita polling para la recarga en caliente en Docker
            interval: 100
        },
        hmr: {
            port: 5173,          // Asegúrate de que coincida con el puerto que has mapeado
        },
    },*/
});

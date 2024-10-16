import { createApp } from 'vue';
import MenuComponent from './components/Menu.vue';
import './../css/app.css'

const app = createApp({});

// Registra el componente
app.component('menu-component', MenuComponent);

// Monta la aplicación en el div con id "app"
app.mount('#app');

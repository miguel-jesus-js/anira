import { createApp } from 'vue';
import router from './router';
import MenuComponent from './components/Menu.vue';
import './../css/app.css'

const app = createApp({});

app.component('menu-component', MenuComponent);
app.use(router)
app.mount('#app');

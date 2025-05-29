import { createApp } from 'vue';
import router from './router';
import App from './components/App.vue';
import './../css/app.css';
import './../css/styles.css';

createApp(App).use(router).mount('#app');

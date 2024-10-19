import {createRouter, createWebHistory} from 'vue-router';
import employees from './components/Employess/Employees.vue';
import Home from './components/Home.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/employees',
        name: 'Employees',
        component: employees
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;

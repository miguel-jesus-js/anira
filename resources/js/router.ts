import {createRouter, createWebHistory} from 'vue-router';
import employees from './components/Employess/Employees.vue';
import EmployeeDetails from "./components/Employess/EmployeeDetails.vue";
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
    },
    {
        path: '/employee-detalles/:id',
        name: 'EmployeeDetails',
        component: EmployeeDetails
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;

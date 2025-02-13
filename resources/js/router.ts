import {createRouter, createWebHistory} from 'vue-router';
import Employees from './components/Employess/Employees.vue';
import EmployeeDetails from "./components/Employess/EmployeeDetails.vue";
import Home from './components/Home.vue';
import Customer from "./components/Customers/Customer.vue";
import CustomerDetails from "./components/Customers/CustomerDetails.vue";
import TypeEmployee from "./components/Customers/TypeEmployee.vue";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/tipo-de-empleados',
        name: 'TypeEmployees',
        component: TypeEmployee
    },
    {
        path: '/empleados',
        name: 'Employees',
        component: Employees
    },
    {
        path: '/empleado-detalle/:id',
        name: 'EmployeeDetails',
        component: EmployeeDetails
    },
    {
        path: '/clientes',
        name: 'Customers',
        component: Customer
    },
    {
        path: '/cliente-detalle/:id',
        name: 'CustomerDetails',
        component: CustomerDetails
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;

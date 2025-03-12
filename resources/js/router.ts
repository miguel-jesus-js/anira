import {createRouter, createWebHistory} from 'vue-router';
import Employees from './components/Employess/Employees.vue';
import EmployeeDetails from "./components/Employess/EmployeeDetails.vue";
import Home from './components/Home.vue';
import Customer from "./components/Customers/Customer.vue";
import CustomerDetails from "./components/Customers/CustomerDetails.vue";
import TypeEmployee from "./components/TypeEmployees/TypeEmployee.vue";
import TypeEmployeesDetails from "./components/TypeEmployees/TypeEmployeeDetails.vue";
import TypeCustomer from "./components/TypeCustomer/TypeCustomer.vue";
import TypeCustomerDetails from "./components/TypeCustomer/TypeCustomerDetails.vue";


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
        path: '/tipo-de-empleado-detalle/:id',
        name: 'TypeEmployeesDetails',
        component: TypeEmployeesDetails
    },
    {
        path: '/tipo-de-clientes',
        name: 'TypeCustomer',
        component: TypeCustomer
    },
    {
        path: '/tipo-de-cliente-detalle/:id',
        name: 'TypeCustomerDetails',
        component: TypeCustomerDetails
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

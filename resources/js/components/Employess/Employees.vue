<template>
  <!-- component -->
  <section class="mx-10 mt-5 bg-white p-4 rounded-md">
    <HeaderModule :total-records="response ? response.total : 0">
        <template #section1>
            <Button icon="IconCloudUpload" label="Importar" button-class="border rounded-lg"></Button>
            <Button :onClick="openModal" buttonClass="border rounded-lg bg-blue-500 text-white hover:bg-blue-600" icon="IconPlus" label="Agregar empleado"></Button>
        </template>
        <template #section2>
            <Button icon="IconCloudDownload" button-class="border-0" label="Exportar"></Button>
            <Button icon="IconFilterPlus" button-class="border-0" label="Filtros"></Button>
            <Button :onClick="fetchEmployees" button-class="border-0" icon="IconRefresh" label="Recargar"></Button>
        </template>
        <template #section3>
            <CustomInput icon="IconSearch" v-model="filters.email" @input-change="handleInputChange" required="false" placeholder="Buscar..."  name="search" id="search"></CustomInput>
        </template>
    </HeaderModule>
    <TableModule :columns="columns" :is-fetch="isFetchEmployees" :data="employees" :response="response" :onClick="fetchEmployees">

    </TableModule>
  </section>
    <!-- Modal -->
    <div v-if="isModalOpen" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-5xl">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            AGREGAR EMPLEADO
                        </h3>
                        <button
                            @click="closeModal"
                            type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <form class="max-w-5xl" @submit.prevent="fetchCreateUser">
                            <!-- Pestañas (Botones) -->
                            <div class="flex border-b border-gray-300">
                                <button
                                    v-for="(tab, index) in tabs"
                                    :key="index"
                                    :class="['py-2 px-4 text-sm font-medium focus:outline-none', selectedTab === tab ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600']"
                                    @click="selectedTab = tab"
                                    type="button">
                                    {{ tab }}
                                </button>
                            </div>

                            <div class="mt-4">
                                <div v-show="selectedTab === 'Datos personales'">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4 ">
                                        <CustomInput
                                            placeholder="Nombre(s)"
                                            name="first_name"
                                            id="first_name"
                                            label="Nombre(s)"
                                            required="true"
                                            v-model="employee.people.first_name"
                                            icon="IconUser"
                                            :errors="errors['people.first_name']"
                                            >
                                        </CustomInput>
                                        <CustomInput
                                            placeholder="Apellido(s)"
                                            name="last_name"
                                            id="last_name"
                                            label="Apellido(s)"
                                            required="true"
                                            v-model="employee.people.last_name"
                                            icon="IconUser"
                                            :errors="errors['people.last_name']"
                                            >
                                        </CustomInput>
                                        <vue3-phone-input
                                            v-model="phone"
                                            placeholder="Número de teléfono"
                                            required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                                        <p class="pl-1 text-red-500 text-sm py-1" v-for="(error, index) in errors['people.phone_number']" :key="index">{{ error }}</p>
                                        <CustomSelect
                                            icon="IconId"
                                            name="type_employee_id"
                                            id="type_employee_id"
                                            label="Tipo de empleado"
                                            v-model="employee.type_employee_id"
                                            :options="typeEmployees"
                                            :errors="errors['type_employee_id'] ? errors['type_employee_id'] : []"
                                            >
                                        </CustomSelect>
                                        <CustomInput
                                            placeholder="DNI"
                                            name="dni"
                                            id="dni"
                                            label="DNI"
                                            required="true"
                                            v-model="employee.people.dni"
                                            icon="IconId"
                                            :errors="errors['people.dni']"
                                        >
                                        </CustomInput>
                                    </div>
                                </div>
                                <div v-show="selectedTab === 'Datos de acceso'">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4 ">
                                        <CustomInput
                                            placeholder="Correo"
                                            name="email"
                                            id="email"
                                            label="Correo"
                                            type="email"
                                            required=""
                                            v-model="employee.people.email"
                                            icon="IconMail"
                                            :errors="errors['people.email']"
                                            >
                                        </CustomInput>
                                        <CustomInput
                                            placeholder="Nombre de usuario"
                                            name="user_name"
                                            id="user_name"
                                            label="Nombre de usuario"
                                            required="true"
                                            v-model="employee.user.user_name"
                                            icon="IconUser"
                                            :errors="errors['user.user_name']"
                                            >
                                        </CustomInput>
                                        <CustomInput
                                            placeholder="Contraseña"
                                            name="password"
                                            id="password"
                                            label="Contraseña"
                                            type="password"
                                            required="true"
                                            v-model="employee.user.password"
                                            icon="IconKey"
                                            :errors="errors['user.password']"
                                            >
                                        </CustomInput>
                                        <CustomInput
                                            placeholder="Repetir contraseña"
                                            name="password_repeat"
                                            id="password_repeat"
                                            label="Repetir contraseña"
                                            type="password"
                                            required="true"
                                            v-model="employee.user.password_repeat"
                                            icon="IconKey"
                                            :errors="errors['user.password_repeat']"
                                            >
                                        </CustomInput>
                                    </div>
                                </div>
                                <div v-show="selectedTab === 'Direcciónes'">
                                    <p>Contenido del Tab 3</p>
                                </div>
                                <div v-show="selectedTab === 'Permisos'">
                                    <p>Contenido del Tab 3</p>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="submit" class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Agregar</button>
                                <button @click="closeModal" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup lang="ts">
    import {onMounted, computed, ref, markRaw } from 'vue';
    import axios from 'axios';
    import {Employee, CreateEmployee} from '@/types/Employees/Employee';
    import {Response} from '@/types/Response';
    import {StatusEmployeeEnum} from "@/types/Employees/StatusEmployeeEnum";
    import CustomInput from '../CustomInput.vue'
    import CustomSelect from '../CustomSelect.vue';
    import Vue3PhoneInput from 'vue3-phone-input';
    import {TypeEmployee} from "@/types/TypeEmployees/TypeEmployee";
    import {showAlert} from "@/composables/SweetAlert";
    import HeaderModule from "@/components/Modules/HeaderModule.vue";
    import Button from "@/components/Button.vue";
    import TableModule from "@/components/Modules/TableModule.vue";
    import {Column} from "@/types/TableModule/Column";
    import SpanStatus from "@/components/Modules/SpanStatus.vue";

    const employees = ref<Employee>([]);
    const response = ref<Response<Employee> | null>(null);
    const isModalOpen = ref(false);
    const tabs = ['Datos personales', 'Datos de acceso', 'Direcciónes', 'Permisos'];
    const selectedTab = ref('Datos personales');
    const typeEmployees = ref<TypeEmployee[]>([]);
    const phone = ref({country_code: '', phone_number: ''});
    const errors = ref({});
    const isFetchEmployees = ref(false);
    const employee = ref<CreateEmployee>({
        type_employee_id: '0',
        user: {
            user_name: '',
            password: '',
            password_repeat: '',
        },
        people: {
            first_name: '',
            last_name: '',
            email: '',
            dni: '0',
            country_code: '',
            phone_number: ''
        }
    });
    const columns = ref<Column>([
        {key: 'id', label: 'ID'},
        {key: 'people.first_name', label: 'NOMBRE(S)'},
        {key: 'people.last_name', label: 'APELLIDO(S)'},
        {key: 'people.email', label: 'CORREO'},
        {key: 'people.phone_number', label: 'TELÉFONO'},
        {key: 'type_employee.type', label: 'TIPO'},
        {key: 'status', label: 'ESTADO', enum: StatusEmployeeEnum, rowRenderer: markRaw(SpanStatus)
        },
    ]);
    const filters = ref({
        email: '',
    });

    const fetchEmployees = async (pageUrl: string = '/api/employees') => {
        employees.value = [];
        isFetchEmployees.value = true;
        try {
            const res = await axios.get<Response<Employee>>(pageUrl,{
                params: {filters: filters.value}
            });
            employees.value = res.data.data.data;
            response.value = res.data.data;
            isFetchEmployees.value = false;
        } catch (error) {
            isFetchEmployees.value = false;
            console.error('Error fetching users:', error);
        }
    };
    const fetchTypeEmployees = async (pageUrl: string = '/api/type-employees') => {
        try {
            const res = await axios.get<Response<TypeEmployees>>(pageUrl);
            typeEmployees.value = res.data.data;
        } catch (error) {
            console.error('Error fetching type employees:', error);
        }
    };
    const fetchCreateUser = async () => {
        employee.value.people.country_code = phone.value.callingCode;
        employee.value.people.phone_number = phone.value.nationalNumber;
        try {
            const res = await axios.post('api/users', employee.value);
            showAlert(res.data.type, res.data.title, res.data.message);
            if(res.data.type === 'success'){
                fetchEmployees();
                closeModal();
            }
        } catch (error) {
            if(error.response && error.response.data.errors){
                showAlert('warning', 'Advertencia', 'Tienes errores en algunos campos');
                errors.value = error.response.data.errors;
            }
        }
    }
    const handleInputChange = (value) => {
        fetchEmployees();
    }
    const openModal = () => {
        isModalOpen.value = true;
        fetchTypeEmployees();
    };
    const closeModal = () => {
        isModalOpen.value = false;
    };

    onMounted(() => {
        fetchEmployees();
    })

</script>

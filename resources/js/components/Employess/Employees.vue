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
    <TableModule :columns="columns" :is-fetch="isFetchEmployees" :data="employees" :response="response" :onClick="fetchEmployees" url-view="EmployeeDetails" url-edit="EmployeeDetails">

    </TableModule>
    <Modal title="AGREGAR EMPLEADO" :is-modal-open="isModalOpen" @close="closeModal">
        <form class="max-w-5xl" @submit.prevent="fetchCreateUser">
            <!-- Pestañas (Botones) -->
            <div class="flex border-b border-gray-300">
                <Button
                    v-for="(tab, index) in tabs"
                    :key="index"
                    :class="['py-2 px-4 text-sm font-medium focus:outline-none', selectedTab === index ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600']"
                    @click="selectedTab = index"
                    :label="tab.label"
                    :icon="tab.icon"
                >
                </Button>
            </div>

            <div class="mt-4">
                <div v-show="selectedTab === 0">
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
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"/>
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
                <div v-show="selectedTab === 1">
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
                <div v-show="selectedTab === 2">
                    <p>Contenido del Tab 3</p>
                </div>
                <div v-show="selectedTab === 3">
                    <p>Contenido del Tab 4</p>
                </div>
            </div>
            <div class="flex justify-end">
                <Button v-if="selectedTab != 0" :on-click="previousTabs" class="mx-2 py-1 bg-gray-400 rounded-lg text-white" label="Anterior"></Button>
                <Button v-if="selectedTab + 1 < tabs.length" :on-click="nextTab" class="mx-2 py-1 bg-green-400 rounded-lg text-white" label="Siguiente"></Button>
                <Button v-if="selectedTab + 1 == tabs.length" :on-click="fetchCreateUser" icon="IconDeviceFloppy" class="mx-2 py-1 bg-blue-400 rounded-lg text-white" label="Registrar"></Button>

            </div>
        </form>
    </Modal>
  </section>

</template>

<script setup lang="ts">
    import {onMounted, ref, markRaw } from 'vue';
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
    import Modal from "@/components/Modal.vue";

    const employees = ref<Employee>([]);
    const response = ref<Response<Employee> | null>(null);
    const isModalOpen = ref(false);
    const tabs = [
        {label: 'Datos personales', icon: 'IconNotes'},
        {label: 'Datos de acceso', icon: 'IconKey'},
        {label: 'Direcciónes', icon: 'IconMapPin'},
        {label: 'Permisos', icon: 'IconLock'}
    ];
    const selectedTab = ref(0);
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
        {key: 'status', label: 'ESTADO', enum: StatusEmployeeEnum, rowRenderer: markRaw(SpanStatus)},
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
            if(res.data.type === 'success'){
                showAlert(res.data.type, res.data.title, res.data.message);
                fetchEmployees();
                closeModal();
            }else{
                showAlert(res.data.type, res.data.title, res.data.message);
            }
        } catch (error) {
            if(error.response && error.response.data.errors){
                showAlert('warning', 'Advertencia', 'Tienes errores en algunos campos');
                errors.value = error.response.data.errors;
            }
        }
    }
    const handleInputChange = () => {
        fetchEmployees();
    }
    const nextTab = () => {
        selectedTab.value = selectedTab.value + 1;
    }
    const previousTabs = () => {
        selectedTab.value = selectedTab.value - 1;
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

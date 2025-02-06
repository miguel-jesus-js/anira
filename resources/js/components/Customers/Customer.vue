<template>
    <!-- component -->
    <section class="p-4">
        <HeaderModule :total-records="response ? response.total : 0" title="CLIENTES">
            <template #section1>
                <Button icon="IconCloudUpload" label="Importar" button-class="border rounded-lg bg-white"></Button>
                <Button :onClick="openModal" buttonClass="border rounded-lg bg-[#A97E59] text-[#F2E9E0] hover:bg-blue-600" icon="IconPlus" label="Agregar cliente"></Button>
            </template>
            <template #section2>
                <Button :on-click="toggleModalExport" icon="IconCloudDownload" button-class="border-0 text-[#F2E9E0]" label="Exportar"></Button>
                <Button icon="IconFilter" button-class="border-0 text-[#F2E9E0]" label="Filtros" :on-click="toggleDrawer"></Button>
                <Button :onClick="fetchCustomers" button-class="border-0 text-[#F2E9E0]" icon="IconRefresh" label="Recargar"></Button>
            </template>
            <template #section3>
                <CustomInput input-class="border text-gray-900 bg-gray-50 border-gray-300 " icon="IconSearch" v-model="filters.email" @input-change="handleInputChange" required="false" placeholder="Buscar..."  name="search" id="search"></CustomInput>
            </template>
        </HeaderModule>
        <TableModule :columns="columns" :is-fetch="isFetchCustomers" :data="customers" :response="response" :onClick="fetchCustomers" url-view="CustomerDetails" url-edit="CustomerDetails" url-delete="api/customers/">

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
                                v-model="customer.people.first_name"
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
                                v-model="customer.people.last_name"
                                icon="IconUser"
                                :errors="errors['people.last_name']"
                            >
                            </CustomInput>
                            <div class="block">
                                <label  class="block mb-2 text-sm font-sm text-gray-500">Télefono</label>
                                <vue3-phone-input
                                    v-model="phone"
                                    placeholder="Número de teléfono"
                                    required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 h-10"/>
                                <p class="pl-1 text-red-500 text-sm py-1" v-for="(error, index) in errors['people.phone_number']" :key="index">{{ error }}</p>
                            </div>
                            <CustomSelect
                                icon="IconId"
                                name="type_customer_id"
                                id="type_customer_id"
                                label="Tipo de empleado"
                                v-model="customer.type_customer_id"
                                :options="typeCustomers"
                                :errors="errors['type_customer_id'] ? errors['type_customer_id'] : []"
                            >
                            </CustomSelect>
                            <CustomInput
                                placeholder="DNI"
                                name="dni"
                                id="dni"
                                label="DNI"
                                required="true"
                                v-model="customer.people.dni"
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
                                v-model="customer.people.email"
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
                                v-model="customer.user.user_name"
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
                                v-model="customer.user.password"
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
                                v-model="customer.user.password_repeat"
                                icon="IconKey"
                                :errors="errors['user.password_repeat']"
                            >
                            </CustomInput>
                        </div>
                    </div>
                    <div v-show="selectedTab === 2">
                        <Button button-class="bg-green-500 text-white rounded-lg" :on-click="addItemAddresses" icon="IconPlus" label="Agregar dirección"></Button>
                        <div v-for="(item, index) in itemAddresses" :key="index" class="border rounded my-2 grid grid-cols-[90%_10%]">
                            <div>
                                <div @click="toggleAddress(index)" class="flex justify-between items-center p-4">
                                    <div class="w-full">
                                        <div class="mb-3">
                                            <dt class="text-sm text-gray-900">Dirección completa</dt>
                                            <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.address }}</dd>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4">
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Calle</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.street }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Colonia</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.neighborhood }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">N° interior</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.interior_number }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">N° Exterior</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.outer_number }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Ciudad</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.city }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Estado</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.state }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Localidad</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.locality }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Código postal</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.cp }}</dd>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex">
                                <Button button-class="bg-transparent text-red-700" :on-click="() => removeItemAddresses(index)" icon="IconTrashFilled"></Button>
                            </div>
                        </div>
                    </div>
                    <div v-show="selectedTab === 3">
                        <p>Contenido del Tab 8</p>
                    </div>
                </div>
                <div class="flex justify-end">
                    <Button v-if="selectedTab != 0" :on-click="previousTabs" class="mx-2 py-1 bg-gray-400 rounded-lg text-white" label="Anterior"></Button>
                    <Button v-if="selectedTab + 1 < tabs.length" :on-click="nextTab" class="mx-2 py-1 bg-green-400 rounded-lg text-white" label="Siguiente"></Button>
                    <Button v-if="selectedTab + 1 == tabs.length" :on-click="fetchCreateUser" icon="IconDeviceFloppy" class="mx-2 py-1 bg-blue-400 rounded-lg text-white" label="Registrar"></Button>
                </div>
            </form>
        </Modal>
        <Modal title="AGREGAR DIRECCIÓN" width="sm:max-w-2xl" :is-modal-open="isModalAddressOpen" @close="closeModalAddress" >
            <form class="max-w-5xl" @submit.prevent="fetchValidateAddress">
                <CustomInput
                    ref="autocompleteInput"
                    label="Direccion"
                    id="address"
                    icon="IconLocationFilled"
                    v-model="address.address"
                    required="true"
                    placeholder="Dirección"
                    name="address"
                    :errors="errorsAddress['address']">
                </CustomInput>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4 my-3">
                    <CustomInput
                        label="Calle"
                        id=""
                        icon="IconSmartHome"
                        v-model="address.street"
                        required="true"
                        placeholder="Anira 18"
                        name="street"
                        :errors="errorsAddress['street']">
                    </CustomInput>
                    <CustomInput
                        label="Colonia"
                        id=""
                        icon="IconSmartHome"
                        v-model="address.neighborhood"
                        required="true"
                        placeholder="Albania alta"
                        name="neighborhood"
                        :errors="errorsAddress['neighborhood']">
                    </CustomInput>
                    <CustomInput
                        label="N° interior"
                        id=""
                        icon="IconNumber"
                        v-model="address.interior_number"
                        placeholder="S/N"
                        name="interior_number"
                        :errors="errorsAddress['interior_number']">
                    </CustomInput>
                    <CustomInput
                        label="N° exterior"
                        id=""
                        icon="IconNumber"
                        v-model="address.outer_number"
                        placeholder="S/N"
                        name="outer_number"
                        :errors="errorsAddress['outer_number']">
                    </CustomInput>
                    <CustomInput
                        label="Ciudad"
                        id=""
                        icon="IconBuildingSkyscraper"
                        v-model="address.city"
                        required="true"
                        placeholder="Mexico"
                        name="city"
                        :errors="errorsAddress['city']">
                    </CustomInput>
                    <CustomInput
                        label="Estado"
                        id=""
                        icon="IconBuildings"
                        v-model="address.state"
                        required="true"
                        placeholder="Chiapas"
                        name="state"
                        :errors="errorsAddress['state']">
                    </CustomInput>
                    <CustomInput
                        label="Localidad"
                        id=""
                        icon="IconMap"
                        v-model="address.locality"
                        required="true"
                        placeholder="Tuxtla Gutierrez"
                        name="locality"
                        :errors="errorsAddress['locality']">
                    </CustomInput>
                    <CustomInput
                        label="CP"
                        id=""
                        icon="IconMapCode"
                        v-model="address.cp"
                        required="true"
                        placeholder="29950"
                        name="cp"
                        :errors="errorsAddress['cp']">
                    </CustomInput>
                </div>
                <Button button-class="bg-green-500 rounded text-white" icon="IconPlus" label="Guardar" type="submit"></Button>
            </form>
        </Modal>
        <Modal title="EXPORTAR" :is-modal-open="isModalExport" width="sm:max-w-xl" @close="toggleModalExport">
            <form @submit.prevent="fetchExport">
                <p class="mb-5 text-md text-gray-600">Datos a exportar</p>
                <div class="flex gap-10 mb-5">
                    <div class="inline-flex items-center">
                        <label class="relative flex items-center cursor-pointer" for="html">
                            <input name="data_export" type="radio" value="all" v-model="dataExport" id="export-all" class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all" required>
                            <span class="absolute bg-slate-800 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    </span>
                        </label>
                        <label class="ml-2 text-slate-600 cursor-pointer text-sm" for="export-all">Todos</label>
                    </div>

                    <div class="inline-flex items-center">
                        <label class="relative flex items-center cursor-pointer">
                            <input name="data_export" type="radio" value="filters" v-model="dataExport" id="export-filters" class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all" required>
                            <span class="absolute bg-slate-800 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    </span>
                        </label>
                        <label class="ml-2 text-slate-600 cursor-pointer text-sm" for="export-filters">Filtros aplicados</label>
                    </div>
                </div>
                <p class="mb-5 text-md text-gray-600">Formato</p>
                <div class="flex gap-10 mb-5">
                    <div class="inline-flex items-center">
                        <label class="relative flex items-center cursor-pointer" for="html">
                            <input name="format" type="radio" value="xlsx" v-model="format" id="format-excel" class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all" required>
                            <span class="absolute bg-slate-800 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    </span>
                        </label>
                        <label class="ml-2 text-slate-600 cursor-pointer text-sm" for="format-excel">Excel</label>
                    </div>

                    <div class="inline-flex items-center">
                        <label class="relative flex items-center cursor-pointer">
                            <input name="format" type="radio" value="pdf" v-model="format" id="format-pdf" class="peer h-5 w-5 cursor-pointer appearance-none rounded-full border border-slate-300 checked:border-slate-400 transition-all" required>
                            <span class="absolute bg-slate-800 w-3 h-3 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    </span>
                        </label>
                        <label class="ml-2 text-slate-600 cursor-pointer text-sm" for="format-pdf">PDF</label>
                    </div>
                </div>
                <p class="mb-5 text-md text-gray-600">Información a exportar</p>
                <div class="mb-3">
                    <nav class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 grid-rows-1 gap-2">
                        <div
                            v-for="(column, index) in columnsExport"
                            :key="index"
                            role="button"
                            class="flex w-full items-center rounded-lg p-0 transition-all hover:bg-slate-100 focus:bg-slate-100 active:bg-slate-100"
                        >
                            <label class="flex w-full cursor-pointer items-center space-x-2 px-3 py-2">
                                <div class="relative flex items-center">
                                    <input
                                        type="checkbox"
                                        :value="index"
                                        name="columns[]"
                                        v-model="columnsSelected"
                                        class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                                    />
                                    <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                    <TablerIcon size="22" icon="IconCheck"></TablerIcon>
                                </span>
                                </div>
                                <span class="text-slate-600 text-sm">{{ column }}</span>
                            </label>
                        </div>
                    </nav>
                </div>

                <div class="flex justify-end">
                    <Button button-class="bg-green-600 text-white rounded-lg" icon="IconFileDownload" label="Exportar" type="submit"></Button>
                </div>
            </form>
        </Modal>
        <Drawer title="FILTROS AVANZADOS" :is-drawer-open="isDrawerOpen" @close="toggleDrawer">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 grid-rows-1 gap-4 ">
                <CustomInput
                    placeholder="Nombre(s)"
                    name="first_name"
                    id="first_name"
                    label="Nombre(s)"
                    required="true"
                    v-model="filters.first_name"
                    icon="IconUser"
                >
                </CustomInput>
                <CustomInput
                    placeholder="Apellido(s)"
                    name="last_name"
                    id="last_name"
                    label="Apellido(s)"
                    required="true"
                    v-model="filters.last_name"
                    icon="IconUser"
                >
                </CustomInput>
                <div class="block">
                    <label  class="block mb-2 text-sm font-sm text-gray-500">Télefono</label>
                    <vue3-phone-input
                        v-model="filterPhone"
                        placeholder="Número de teléfono"
                        required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 h-10"/>
                </div>
                <CustomSelect
                    icon="IconId"
                    name="type_customer_id"
                    id="type_customer_id"
                    label="Tipo de empleado"
                    v-model="filters.type_customer_id"
                    :options="typeCustomers"
                >
                </CustomSelect>
                <CustomInput
                    placeholder="DNI"
                    name="dni"
                    id="dni"
                    label="DNI"
                    required="true"
                    v-model="filters.dni"
                    icon="IconId"
                >
                </CustomInput>
                <CustomInput
                    placeholder="Correo"
                    name="email"
                    id="email"
                    label="Correo"
                    type="email"
                    required=""
                    v-model="filters.email"
                    icon="IconMail"
                >
                </CustomInput>
                <CustomInput
                    placeholder="Nombre de usuario"
                    name="user_name"
                    id="user_name"
                    label="Nombre de usuario"
                    required="true"
                    v-model="filters.user_name"
                    icon="IconUser"
                >
                </CustomInput>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-4">
                <Button button-class="border bg-white text-red-600 rounded-lg mb-3 hover:bg-red-600 hover:text-white" :on-click="cleanFilters" icon="IconTrashFilled" label="Limpiar filtros" type="button"></Button>
                <Button button-class="border bg-white text-blue-600 rounded-lg mb-3 hover:bg-blue-600 hover:text-white" :on-click="fetchCustomers" icon="IconFilterSearch" label="Aplicar filtros" type="button"></Button>
            </div>
        </Drawer>
    </section>

</template>

<script setup lang="ts">
import {onMounted, ref, markRaw, nextTick } from 'vue';
import axios from 'axios';
import {Customer, CreateCustomer, ColumnsExportAnsFilters} from '../../types/Customers/Customer';
import {Response} from '../../types/Response';
import {StatusEmployeeEnum} from "../../types/Employees/StatusEmployeeEnum";
import CustomInput from '../CustomInput.vue'
import CustomSelect from '../CustomSelect.vue';
import Vue3PhoneInput from 'vue3-phone-input';
import {TypeCustomer} from "../../types/TypeCustomers/TypeCustomer";
import {showAlert} from "../../composables/SweetAlert";
import HeaderModule from "../../components/Modules/HeaderModule.vue";
import Button from "../../components/Button.vue";
import TableModule from "../../components/Modules/TableModule.vue";
import {Column} from "../../types/TableModule/Column";
import SpanStatus from "../../components/Modules/SpanStatus.vue";
import Modal from "../../components/Modal.vue";
import TablerIcon from "../TablerIcon.vue";
import {Address} from "../../types/Addresses/Address";
import Drawer from "../Drawer.vue";
import {apiGet, apiPost} from "../../src/services/api";

const customers = ref<Customer>([]);
const response = ref<Response<Customer> | null>(null);
const isModalOpen = ref(false);
const isModalAddressOpen = ref(false);
const isModalExport = ref(false);
const tabs = [
    {label: 'Datos personales', icon: 'IconNotes'},
    {label: 'Datos de acceso', icon: 'IconKey'},
    {label: 'Direcciónes', icon: 'IconMapPin'},
    {label: 'Permisos', icon: 'IconLock'}
];
const selectedTab = ref(0);
const typeCustomers = ref<TypeCustomer[]>([]);
const phone = ref({country_code: '', phone_number: ''});
const filterPhone = ref({});
const errors = ref({});
const errorsAddress = ref({});
const isFetchCustomers = ref(false);
const itemAddresses = ref<Address[]>([]);
const customer = ref<CreateCustomer>({
    type_customer_id: '0',
    type_entity: 'customer',
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
    },
    addresses: itemAddresses
});
const columnsExport = ref<ColumnsExportAnsFilters>({
    first_name: '',
    last_name: '',
    email:'',
    dni:  '',
    phone_number: '',
    user_name: '',
    type_customer_id: '',
    status: '',
});
const columns = ref<Column>([
    {key: 'id', label: 'ID'},
    {key: 'people.first_name', label: 'NOMBRE(S)'},
    {key: 'people.last_name', label: 'APELLIDO(S)'},
    {key: 'people.email', label: 'CORREO'},
    {key: 'people.phone_number', label: 'TELÉFONO'},
    {key: 'type_customer.type', label: 'TIPO'},
    {key: 'status', label: 'ESTADO', enum: StatusEmployeeEnum, rowRenderer: markRaw(SpanStatus)},
]);
const dataExport = ref('');
const format = ref('');
const columnsSelected = ref([]);
const filters = ref<ColumnsExportAnsFilters>({
    first_name: '',
    last_name: '',
    email:'',
    dni:  '',
    phone_number: '',
    user_name: '',
    type_customer_id: '0',
    status: '',
})
const autocompleteInput = ref(null);
const address = ref<Address>({
    address: '',
    street: '',
    neighborhood: '',
    interior_number: '',
    outer_number: '',
    city: '',
    state: '',
    locality: '',
    cp: '0',
    latitude: '',
    longitude: ''
});
const isDrawerOpen = ref(false);
const fetchCustomers = async (pageUrl: string = 'customers') => {
    customers.value = [];
    isFetchCustomers.value = true;
    if(Object.keys(filterPhone.value).length !== 0){
        filters.value.phone_number = filterPhone.value.callingCode + filterPhone.value.nationalNumber;
    }
    try {
        const res = await apiGet(pageUrl, filters.value, true)
        customers.value = res.data.data;
        response.value = res.data;
        columnsExport.value = res.columnsExport;
        isFetchCustomers.value = false;
    } catch (error) {
        isFetchCustomers.value = false;
        showAlert('error', 'Error externo', 'Ocurrió un error al procesar los datos');
    }
};
const fetchTypeCustomers = async () => {
    try {
        const res = await apiGet<TypeCustomer>('type-customers');
        typeCustomers.value = res;
    } catch (error) {
        console.error('Error fetching type customers:', error);
    }
};
const fetchCreateUser = async () => {
    customer.value.people.country_code = phone.value.callingCode;
    customer.value.people.phone_number = phone.value.nationalNumber;
    try {
        const res = await apiPost('users', customer.value);
        if(res.type === 'success'){
            showAlert(res.type, res.title, res.message);
            fetchCustomers();
            closeModal();
        }else{
            showAlert(res.type, res.title, res.message);
        }
    } catch (error) {
        if(error.response && error.response.data.errors){
            showAlert('warning', 'Advertencia', 'Tienes errores en algunos campos');
            errors.value = error.response.data.errors;        }
    }
}
const fetchExport = async () => {
    try {
        const res = await axios.get('api/customers-export', {
            params: {
                data_export: dataExport.value,
                filters: filters.value,
                format: format.value,
                columns_selected: columnsSelected.value
            },
        });
        if(res.data.type === 'success'){
            // Extraer datos del JSON
            const { file, mime } = res.data.data;

            // Decodificar el archivo base64
            const byteCharacters = atob(file);
            const byteNumbers = new Array(byteCharacters.length).fill(0).map((_, i) => byteCharacters.charCodeAt(i));
            const byteArray = new Uint8Array(byteNumbers);

            // Crear un Blob con el contenido del archivo
            const blob = new Blob([byteArray], { type: mime });

            // Crear URL y desencadenar la descarga
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'Empleados' + format.value); // Usar el nombre proporcionado por el backend
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            showAlert(res.data.type, res.data.title, res.data.message);
            toggleModalExport()
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
const fetchValidateAddress = async () => {
    try {
        const res = await apiPost('address-validate', address.value);
        if(res.type === 'success'){
            addAddress();
            showAlert(res.type, res.title, res.message);
            closeModalAddress();
        }else{
            showAlert(res.type, res.title, res.message);
        }
    } catch (error) {
        if(error.response && error.response.errors){
            showAlert('warning', 'Advertencia', 'Tienes errores en algunos campos');
            errorsAddress.value = error.response.errors;
        }
    }
}
const handleInputChange = () => {
    fetchCustomers();
}
const addItemAddresses = () => {
    isModalAddressOpen.value = true;
    initAutocomplete();
}
const removeItemAddresses = (index) => {
    itemAddresses.value.splice(index, 1);
}
const addAddress = () => {
    itemAddresses.value.push({ ...address.value });
    isModalAddressOpen.value = false;
    address.value = {
        address: '',
        street: '',
        neighborhood: '',
        interior_number: '',
        outer_number: '',
        city: '',
        state: '',
        locality: '',
        cp: '0',
        latitude: '',
        longitude: ''
    };
}
const toggleAddress = (index) => {
    itemAddresses.value.forEach((item, i) => {
        if (i !== index) {
            item.isOpen = false;
        }
    });
    itemAddresses.value[index].isOpen = !itemAddresses.value[index].isOpen;
};
const cleanFilters = () => {
    filters.value = {
        first_name: '',
        last_name: '',
        email:'',
        dni:  '',
        phone_number: '',
        user_name: '',
        type_customer_id: '0',
        status: '',
    }
    filterPhone.value = {};
    fetchCustomers();
}
const nextTab = () => {
    selectedTab.value = selectedTab.value + 1;
}
const previousTabs = () => {
    selectedTab.value = selectedTab.value - 1;
}
const openModal = () => {
    isModalOpen.value = true;
    fetchTypeCustomers();
};
const closeModal = () => {
    isModalOpen.value = false;
};
const closeModalAddress = () => {
    isModalAddressOpen.value = false;
};
const toggleModalExport = () => {
    isModalExport.value = !isModalExport.value;
}
const toggleDrawer = () => {
    fetchTypeCustomers();
    isDrawerOpen.value = !isDrawerOpen.value;
}
const initAutocomplete = async () => {
    await nextTick();
    const input = document.getElementById("address");

    if (!window.google || !window.google.maps) {
        console.error("Google Maps no cargado");
        return;
    }

    const autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['address']
    });

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        place.address_components.forEach(component => {
            const types = component.types;
            if (types.includes("route")) {
                address.value.street = component.long_name;
            }
            if (types.includes("sublocality_level_1")) {
                address.value.neighborhood = component.long_name;
            }
            if (types.includes("street_number")) {
                address.value.outer_number = component.long_name;
            }
            if (types.includes("subpremise")) {
                address.value.interior_number = component.long_name;
            }
            if (types.includes("country")) {
                address.value.city = component.long_name;
            }
            if (types.includes("administrative_area_level_1")) {
                address.value.state = component.long_name;
            }
            if (types.includes("locality")) {
                address.value.locality = component.long_name;
            }
            if (types.includes("postal_code")) {
                address.value.cp = component.long_name;
            }
        });
        address.value.latitude = place.geometry.location.lat();
        address.value.longitude = place.geometry.location.lng();
    });
};
onMounted(() => {
    fetchCustomers();
})

</script>

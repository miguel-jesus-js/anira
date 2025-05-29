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
        <TableModule :columns="columns" :is-fetch="isFetchCustomers" :data="customers" :response="response" :onClick="fetchCustomers" url-view="CustomerDetails" url-delete="api/customers/">

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
                                value_name="type_customer"
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
                        <ViewAddressComponent :add-item-addresses="addItemAddresses" :item-addresses="itemAddresses" :edit-address="editAddress" :remove-item-addresses="removeItemAddresses"></ViewAddressComponent>
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
        <Modal :title="isEditingAddress ? 'EDITAR DIRECCIÓN' : 'AGREGAR DIRECCIÓN'" width="sm:max-w-2xl" :is-modal-open="isModalAddressOpen" @close="closeModalAddress">
            <AddressComponent :submit="validateAddress" :address="address" :errors-address="errorsAddress"></AddressComponent>
        </Modal>
        <Modal title="EXPORTAR" :is-modal-open="isModalExport" width="sm:max-w-xl" @close="toggleModalExport">
            <form @submit.prevent="handleExport">
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
    import {Customer, CreateCustomer, ColumnsExportAnsFilters} from '../../types/Customers/Customer';
    import {Response} from '../../types/Response';
    import {StatusEmployeeEnum} from "../../types/Employees/StatusEmployeeEnum";
    import CustomInput from '../CustomInput.vue'
    import CustomSelect from '../CustomSelect.vue';
    import Vue3PhoneInput from 'vue3-phone-input';
    import {TypeCustomer} from "../../types/TypeCustomers/TypeCustomer";
    import {defaultError, defaultErrorUser, showAlert} from "../../composables/SweetAlert";
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
    import AddressComponent from "../Addresses/AddressComponent.vue";
    import {useAddressValidation, useAutocomplete} from "../../composables/AddressValidation";
    import ViewAddressComponent from "../Addresses/ViewAddressComponent.vue";
    import {useExport} from "../../composables/Export";

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
    const isFetchCustomers = ref(false);
    const itemAddresses = ref<Address[]>([]);
    const isEditingAddress = ref(false);
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
    const { fetchValidateAddress, errorsAddress } = useAddressValidation();
    const { initAutocomplete } = useAutocomplete();
    const { fetchExport, format } = useExport();
    const isDrawerOpen = ref(false);
    const fetchCustomers = async (pageUrl: string = 'customers') => {
        customers.value = [];
        isFetchCustomers.value = true;
        if(Object.keys(filterPhone.value).length !== 0){
            filters.value.phone_number = filterPhone.value.callingCode + filterPhone.value.nationalNumber;
        }
        try {
            const payload = {filters: filters.value, paginate: true};
            const res = await apiGet(pageUrl, payload);
            customers.value = res.data.customers.data;
            response.value = res.data.customers;
            columnsExport.value = res.data.columnsExport;
            isFetchCustomers.value = false;
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
            isFetchCustomers.value = false;
        }
    };
    const fetchTypeCustomers = async () => {
        try {
            const res = await apiGet<TypeCustomer>('type-customers');
            typeCustomers.value = res.data.type_customers;
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
        }
    };
    const fetchCreateUser = async () => {
        customer.value.people.country_code = phone.value.callingCode;
        customer.value.people.phone_number = phone.value.nationalNumber;
        try {
            const res = await apiPost('users', customer.value);
            if(res.type === 'success'){
                showAlert(res.type, res.title, res.message);
                await fetchCustomers();
                closeModal();
                customer.value = {};
            }else{
                showAlert(res.type, res.title, res.message);
            }
        } catch (error) {
            if(error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }
            if(error.response && error.response.data.errors){
                defaultErrorUser();
                errors.value = error.response.data.errors;
            }else{
                defaultError();
            }
        }
    }
    const handleInputChange = () => {
        fetchCustomers();
    }
    const handleExport = () => {
        const payload = {
            data_export: dataExport.value,
            filters: filters.value,
            format: format.value,
            columns_selected: columnsSelected.value
        };
        fetchExport('employees-export', payload, toggleModalExport);
    }
    const addItemAddresses = () => {
        isModalAddressOpen.value = true;
        initAutocomplete(address);
    }
    const validateAddress = async () => {
        await fetchValidateAddress(address.value, addAddress, closeModalAddress);
    }
    const removeItemAddresses = (index: number) => {
        itemAddresses.value.splice(index, 1);
    }
    const editAddress = (dataAddress: Address) => {
        isEditingAddress.value = true;
        address.value = dataAddress;
        isModalAddressOpen.value = true;
        initAutocomplete(dataAddress);
    }
    const addAddress = () => {
        if(!isEditingAddress.value){
            itemAddresses.value.push({ ...address.value });
        }
        isModalAddressOpen.value = false;
        address.value = {};
    }
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
    onMounted(() => {
        fetchCustomers();
    })

</script>

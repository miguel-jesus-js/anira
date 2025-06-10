<template>
    <!-- component -->
    <section class="p-4">
        <HeaderModule
            :total-records="response ? response.total : 0"
            title="SUCURSALES"
            add-text-button="Agregar sucursal"
            :open-modal="openModal"
            :open-modal-export="toggleModalExport"
            :reload="fetchBranches"
        >
        </HeaderModule>
        <TableModule
            :columns="columns"
            :is-fetch="isFetchBranch"
            :data="branches"
            :row-number="perPage"
            :response="response"
            :onClick="fetchBranches"
            :fetch="fetchBranches"
            :clean-filters="cleanFilters"
            :filters="filters"
            url-view="BranchDetails"
            url-delete="branches/"
            @onOptionChange="handleSelectRow"
        >
            <template #address_id="{row}">
                <p class="line-clamp-6 sm:line-clamp-none">
                    <small>{{ row.address?.address ?? 'Sin dirección' }}</small>
                </p>
            </template>
          <template #status="{row}">
              <SpanStatus :status="StatusBase[row.status]"></SpanStatus>
          </template>
        </TableModule>
        <Modal title="AGREGAR SUCURSAL" :is-modal-open="isModalOpen" @close="closeModal">
            <form class="max-w-5xl" @submit.prevent="fetchCreateBranch">
                <div class="flex bg-gray-100 rounded p-2">
                    <Button
                        v-for="(tab, index) in tabs"
                        :key="index"
                        :button-class="['py-4 text-sm font-medium w-full rounded text-gray-600 w-full', selectedTab === index ? 'bg-white shadow-md' : '']"
                        :on-click="() => selectedTab = index"
                        :label="tab.label"
                        :icon="tab.icon"
                    >
                    </Button>
                </div>
                <div class="mt-8">
                    <div v-show="selectedTab === 0">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4">
                            <DropdownSearch id="employee_id" name="employee_id" label="Encargado" :options="options" placeholder="Buscar empleado..." @select="handleSelect" />
                            <CustomInput
                                placeholder="Sucursal 1"
                                name="name"
                                id="name"
                                label="Nombre"
                                required=""
                                v-model="branch.name"
                                icon="IconBuilding"
                                :errors="errors['name']">
                            </CustomInput>
                            <CustomInput
                                placeholder="sucrusal1@gmail.com"
                                name="email"
                                id="email"
                                label="Correo"
                                type="email"
                                required=""
                                v-model="branch.email"
                                icon="IconMail"
                                :errors="errors['email']">
                            </CustomInput>
                            <div class="block">
                                <label  class="block mb-2 text-sm font-sm text-gray-500">Téléfono</label>
                                <vue3-phone-input
                                    v-model="phone"
                                    placeholder="9191513420"
                                    required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 h-10"/>
                                <p class="pl-1 text-red-500 text-sm py-1" v-for="(error, index) in errors['phone_number']" :key="index">{{ error }}</p>
                            </div>
                        </div>
                    </div>
                    <div v-show="selectedTab === 1">
                        <ViewAddressComponent :add-item-addresses="addItemAddresses" :item-addresses="itemAddresses" :edit-address="editAddress" :remove-item-addresses="removeItemAddresses"></ViewAddressComponent>
                    </div>
                </div>
                <div class="flex justify-end">
                    <Button v-if="selectedTab != 0" :on-click="previousTabs" icon="IconChevronLeft" button-class="mx-2 py-1 bg-gray-400 rounded-lg text-white" label="Anterior"></Button>
                    <Button v-if="selectedTab + 1 < tabs.length" :on-click="nextTab" icon="IconChevronRight" button-class="btn-primary" label="Siguiente"></Button>
                    <Button v-if="selectedTab + 1 == tabs.length" :on-click="fetchCreateBranch" icon="IconDeviceFloppy" button-class="btn-primary" label="Registrar"></Button>
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
    </section>

</template>

<script setup lang="ts">
import {onMounted, ref} from 'vue';
    import {Branch, createBranch, ColumnsExportAnsFilters} from '../../types/Branches/Branch';
    import {Response} from '../../types/Response';
    import CustomInput from '../CustomInput.vue';
    import Vue3PhoneInput from 'vue3-phone-input';
    import {defaultError, defaultErrorUser, showAlert} from "../../composables/SweetAlert";
    import HeaderModule from "../Modules/HeaderModule.vue";
    import Button from "../Button.vue";
    import TableModule from "../Modules/TableModule.vue";
    import {Column} from "../../types/TableModule/Column";
    import SpanStatus from "../Modules/SpanStatus.vue";
    import Modal from "../Modal.vue";
    import TablerIcon from "../TablerIcon.vue";
    import {apiGet, apiPost} from "../../src/services/api";
    import DropdownSearch from "../DropdownSearch.vue";
    import {Employee} from "../../types/Employees/Employee";
    import {OptionSelect} from "../../types/General/OptionSelect";
    import ViewAddressComponent from "../Addresses/ViewAddressComponent.vue";
    import {Address} from "../../types/Addresses/Address";
    import {useAddressValidation, useAutocomplete} from "../../composables/AddressValidation";
    import AddressComponent from "../Addresses/AddressComponent.vue";
    import {StatusBase} from "../../src/enum/StatusBase";
    import {useExport} from "../../composables/Export";

    const branches = ref<Branch>([]);
    const response = ref<Response<Branch> | null>(null);
    const perPage = ref(10);
    const employees = ref<Employee[]>([]);
    const options = ref<OptionSelect[]>([]);
    const isModalOpen = ref(false);
    const isModalAddressOpen = ref(false);
    const isEditingAddress = ref(false);
    const { fetchValidateAddress, errorsAddress } = useAddressValidation();
    const { initAutocomplete } = useAutocomplete();
    const {fetchExport, format} = useExport();
    const isModalExport = ref(false);
    const selectedTab = ref(0);
    const tabs = [
        {label: 'Información', icon: 'IconBuilding'},
        {label: 'Dirección', icon: 'IconMapPin'},
    ];
    const errors = ref([]);
    const isFetchBranch = ref(false);
    const itemAddresses = ref<Address[]>([]);
    const getInitialBranch = (): createBranch => ({
        employee_id: '',
        name: '',
        email: '',
        phone_number: '',
        address: itemAddresses.value
    });
    const getInitialAddress = (): Address => ({
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
    })
    const branch = ref<createBranch>(getInitialBranch());
    const address = ref<Address>(getInitialAddress());
    const phone = ref({country_code: '', phone_number: ''});
    const columnsExport = ref<ColumnsExportAnsFilters>([]);
    const getInitFilters = (): ColumnsExportAnsFilters => ({
        id: '',
        address_id: '',
        employee_id: '',
        name: '',
        email: '',
        phone_number: '',
        status: ''
    });
    const filters = ref(getInitFilters());
    const statusBaseArray: OptionSelect[] = [
        {id: StatusBase.Inactivo, label: StatusBase[StatusBase.Inactivo],},
        {id: StatusBase.Activo, label: StatusBase[StatusBase.Activo],}
    ];
    const columns = ref<Column>([
        {
            key: 'id',
            label: 'ID',
            customInput: {
                type: 'input',
                dataType: 'text',
                id: 'id',
                placeholder: 'ID',
            }
        },
        {
            key: 'address.address',
            label: 'DIRECCIÓN',
            alias: 'address_id',
            customInput: {
                type: 'input',
                dataType: 'text',
                id: 'address_id',
                placeholder: 'Calle 18...',
            }},
        {
            key: 'employee.people.first_name',
            label: 'ENCARGADO',
            customInput: {
                type: 'input',
                dataType: 'text',
                id: 'employee_id',
                placeholder: 'Jesus',
            }},
        {
            key: 'name',
            label: 'NOMBRE',
            customInput: {
                type: 'input',
                dataType: 'text',
                id: 'sucursal',
                placeholder: 'Sucursal 1',
            }},
        {
            key: 'email',
            label: 'CORREO',
            customInput: {
                type: 'input',
                dataType: 'text',
                id: 'email',
                placeholder: 'sucursal@gmail.com',
            }},
        {
            key: 'phone_number',
            label: 'TELÉFONO',
            customInput: {
                type: 'input',
                dataType: 'text',
                id: 'phone_number',
                placeholder: '9191513420',
            }},
        {
            key: 'status',
            label: 'ESTADO',
            customInput: {
                type: 'select',
                dataType: 'text',
                data: statusBaseArray,
                id: 'status',
                placeholder: 'ID',
            }
        },
    ]);
    const dataExport = ref('');
    const columnsSelected = ref([]);

    const handleSelect = (option: OptionSelect) => {
        branch.value.employee_id = option.id;
    };
    const handleSelectRow = (rowNumber: number) => {
        perPage.value = rowNumber;
        fetchBranches();
    };
    const fetchBranches = async () => {
        branches.value = [];
        isFetchBranch.value = true;
        try {
            const payload = {filters: filters.value, paginate: true, perPage: perPage.value};
            const res = await apiGet('branches', payload);
            branches.value = res.data.branches.data;
            response.value = res.data.branches;
            columnsExport.value = res.data.columns_export;
            isFetchBranch.value = false;
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
            isFetchBranch.value = false;
        }
    };
    const fetchEmployees = async () => {
        try {
            const res = await apiGet<Employee>('employees');
            employees.value = res.data.employees;
            employees.value.forEach(item => {
                options.value.push({id: item.id, label: item.people.first_name + ' ' + item.people.last_name});
            });
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
        }
    };
    const fetchCreateBranch = async () => {
        branch.value.country_code = phone.value.callingCode;
        branch.value.phone_number = phone.value.nationalNumber;
        errors.value = [];
        try {
            const res = await apiPost('branches', branch.value);
            showAlert(res.type, res.title, res.message);
            await fetchBranches();
            closeModal();
            itemAddresses.value = [];
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
    const handleExport = () => {
        const payload = {
            data_export: dataExport.value,
            filters: filters.value,
            format: format.value,
            columns_selected: columnsSelected.value
        };
        fetchExport('branches-export', payload, toggleModalExport);
    }
    const addItemAddresses = () => {
        if(itemAddresses.value.length > 0){
            showAlert('warning', 'Advertencia', 'La sucursal solo puede tener una dirección');
        }else{
            isModalAddressOpen.value = true;
            initAutocomplete(address);
        }
    }
    const validateAddress = async () => {
        await fetchValidateAddress(address.value, addAddress, closeModalAddress);
    }
    const editAddress = (dataAddress: Address) => {
        isEditingAddress.value = true;
        address.value = dataAddress;
        initAutocomplete(dataAddress);
    }
    const addAddress = () => {
        if(!isEditingAddress.value){
            itemAddresses.value.push({ ...address.value });
        }
        isModalAddressOpen.value = false;
        address.value = getInitialAddress();
        errors.value = [];
    }
    const removeItemAddresses = (index: number) => {
        itemAddresses.value.splice(index, 1);
    }
    const cleanFilters = () => {
        filters.value = getInitFilters();
        fetchBranches();
    }
    const nextTab = () => {
        selectedTab.value = selectedTab.value + 1;
    }
    const previousTabs = () => {
        selectedTab.value = selectedTab.value - 1;
    }
    const openModal = () => {
        isModalOpen.value = true;
        fetchEmployees();
    };
    const closeModal = () => {
        branch.value = getInitialBranch();
        phone.value = {country_code: '', phone_number: ''};
        isModalOpen.value = false;
        errors.value = [];
    };
    const closeModalAddress = () => {
        isModalAddressOpen.value = false;
        isEditingAddress.value = false;
    };
    const toggleModalExport = () => {
        isModalExport.value = !isModalExport.value;
        dataExport.value = '';
        format.value = '';
        columnsSelected.value = [];
    }
    onMounted(() => {
        fetchBranches();
    })

</script>

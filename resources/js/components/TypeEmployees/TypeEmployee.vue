<template>
    <!-- component -->
    <section class="p-4">
        <HeaderModule
            :total-records="response ? response.total : 0"
            title="TIPO DE EMPLEADOS"
            add-text-button="Agregar tipo"
            :open-modal="openModal"
            :open-modal-export="toggleModalExport"
            :reload="fetchTypeEmployees"
        >

        </HeaderModule>
        <TableModule
            :columns="columns"
            :is-fetch="isFetchTypeEmployee"
            :data="typeEmployees"
            :row-number="perPage"
            :response="response"
            :onClick="fetchTypeEmployees"
            :fetch="fetchTypeEmployees"
            :clean-filters="cleanFilters"
            :filters="filters"
            url-view="TypeEmployeesDetails"
            url-delete="type-employees/"
            @onOptionChange="handleSelectRow"
        >

        </TableModule>
        <Modal title="AGREGAR TIPO DE EMPLEADO" :is-modal-open="isModalOpen" @close="closeModal">
            <form class="max-w-5xl" @submit.prevent="fetchCreateTypeEmployee">
                <CustomInput
                    placeholder="Administrador"
                    name="type_employee"
                    id="type_employee"
                    label="Tipo de empleado"
                    required=""
                    v-model="typeEmployee.type_employee"
                    icon="IconMail"
                    :errors="errors['type_employee']"
                >
                </CustomInput>
                <div class="flex justify-end mt-4">
                    <Button :on-click="fetchCreateTypeEmployee" icon="IconDeviceFloppy" button-class="mx-2 py-1 bg-blue-400 rounded-lg text-white" label="Registrar"></Button>
                </div>
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
    </section>

</template>

<script setup lang="ts">
    import {onMounted, ref, markRaw } from 'vue';
    import axios from 'axios';
    import {TypeEmployee, CreateTypeEmployee, ColumnsExportAnsFilters} from '../../types/TypeEmployees/TypeEmployee';
    import {Response} from '../../types/Response';
    import {StatusEmployeeEnum} from "../../types/Employees/StatusEmployeeEnum";
    import CustomInput from '../CustomInput.vue'
    import {defaultError, defaultErrorUser, showAlert} from "../../composables/SweetAlert";
    import HeaderModule from "../Modules/HeaderModule.vue";
    import Button from "../Button.vue";
    import TableModule from "../Modules/TableModule.vue";
    import {Column} from "../../types/TableModule/Column";
    import SpanStatus from "../Modules/SpanStatus.vue";
    import Modal from "../Modal.vue";
    import TablerIcon from "../TablerIcon.vue";
    import {apiGet, apiPost} from "../../src/services/api";
    import {OptionSelect} from "../../types/General/OptionSelect";
    import {StatusBase} from "../../src/enum/StatusBase";
    import {createBranch} from "../../types/Branches/Branch";

    const typeEmployees = ref<TypeEmployee>([]);
    const response = ref<Response<TypeEmployee> | null>(null);
    const perPage = ref(10);
    const isModalOpen = ref(false);
    const isModalExport = ref(false);
    const errors = ref({});
    const isFetchTypeEmployee = ref(false);
    const getInitialTypeEmployee = (): CreateTypeEmployee => ({
        type_employee: ''
    });
    const typeEmployee = ref(getInitialTypeEmployee());
    const columnsExport = ref<ColumnsExportAnsFilters>({
        type_employee: '',
    });
    const getInitFilters = (): ColumnsExportAnsFilters => ({
        id: '',
        type_employee: '',
        status: ''
    });
    const dataExport = ref('');
    const format = ref('');
    const columnsSelected = ref([]);
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
            key: 'type_employee',
            label: 'TIPO DE EMPLEADO',
            customInput: {
                type: 'input',
                dataType: 'text',
                id: 'type_employee',
                placeholder: 'Vendedor',
            }
        },
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
    const handleSelectRow = (rowNumber: number) => {
        perPage.value = rowNumber;
        fetchTypeEmployees();
    };
    const fetchTypeEmployees = async (pageUrl: string = 'type-employees') => {
        typeEmployees.value = [];
        isFetchTypeEmployee.value = true;
        try {
            const payload = {filters: filters.value, paginate: true};
            const res = await apiGet(pageUrl, payload);
            typeEmployees.value = res.data.type_employees.data;
            response.value = res.data.type_employees;
            columnsExport.value = res.data.columns_export;
            isFetchTypeEmployee.value = false;
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
            isFetchTypeEmployee.value = false;
        }
    };

    const fetchCreateTypeEmployee = async () => {
        try {
            const res = await apiPost('type-employees', typeEmployee.value);
            showAlert(res.type, res.title, res.message);
            await fetchTypeEmployees();
            closeModal();
            typeEmployee.value = {};
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
    const fetchExport = async () => {
        try {
            const payload = {
                data_export: dataExport.value,
                filters: filters.value,
                format: format.value,
                columns_selected: columnsSelected.value
            }
            const res = await apiGet('type-employees-export', payload);
            if(res.type === 'success'){
                // Extraer datos del JSON
                const { file, mime } = res.data;

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
                showAlert(res.type, res.title, res.message);
                toggleModalExport()
            }else{
                showAlert(res.type, res.title, res.message);
            }
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError()
            }
        }
    }
    const cleanFilters = () => {
        filters.value = getInitFilters();
        fetchTypeEmployees();
    }
    const handleInputChange = () => {
        fetchTypeEmployees();
    }
    const openModal = () => {
        isModalOpen.value = true;
    };
    const closeModal = () => {
        typeEmployee.value = getInitialTypeEmployee();
        isModalOpen.value = false;
        errors.value = [];
    };
    const toggleModalExport = () => {
        isModalExport.value = !isModalExport.value;
        dataExport.value = '';
        format.value = '';
        columnsSelected.value = [];
    }
    onMounted(() => {
        fetchTypeEmployees();
    })

</script>

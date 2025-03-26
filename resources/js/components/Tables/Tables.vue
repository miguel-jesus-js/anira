<template>
  <!-- component -->
  <section>
    <HeaderModule :total-records="response ? response.total : 0" title="MESAS">
        <template #section1>
            <Button icon="IconCloudUpload" label="Importar" button-class="border rounded-lg bg-white"></Button>
            <Button :onClick="openModal" buttonClass="border rounded-lg bg-[#fd6868] text-[#F2E9E0] hover:bg-blue-600" icon="IconPlus" label="Agregar empleado"></Button>
        </template>
        <template #section2>
            <Button :on-click="toggleModalExport" icon="IconCloudDownload" button-class="border-0 text-[#F2E9E0]" label="Exportar"></Button>
            <Button icon="IconFilter" button-class="border-0 text-[#F2E9E0]" label="Filtros" :on-click="toggleDrawer"></Button>
            <Button :onClick="fetchTables" button-class="border-0 text-[#F2E9E0]" icon="IconRefresh" label="Recargar"></Button>
        </template>
        <template #section3>
            <CustomInput input-class="border text-gray-900 bg-gray-50 border-gray-300 " icon="IconSearch" v-model="filters.name" @input-change="handleInputChange" required="false" placeholder="Buscar..."  name="search" id="search"></CustomInput>
        </template>
    </HeaderModule>
    <TableModule :columns="columns" :is-fetch="isFetchTables" :data="tables" :response="response" :onClick="fetchTables" url-view="TableDetails" url-delete="tables/">

    </TableModule>
    <Modal title="AGREGAR MESA" :is-modal-open="isModalOpen" @close="closeModal">
        <form class="max-w-5xl" @submit.prevent="fetchCreateTable">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4 ">
                <CustomSelect
                    icon="IconId"
                    name="type_table_id"
                    id="type_table_id"
                    label="Tipo de mesa"
                    v-model="table.type_table_id"
                    :options="typeTables"
                    value_name="type_table"
                    :errors="errors['type_table_id'] ? errors['type_table_id'] : []"
                >
                </CustomSelect>
                <CustomInput
                    type="number"
                    placeholder="1"
                    name="number"
                    id="number"
                    label="N° de mesa"
                    required="true"
                    v-model="table.number"
                    icon="IconNumber"
                    :errors="errors['number']">
                </CustomInput>
                <CustomInput
                    placeholder="Mesa 1"
                    name="name"
                    id="name"
                    label="Nombre"
                    required="true"
                    v-model="table.name"
                    icon="IconTable"
                    :errors="errors['name']">
                </CustomInput>
                <CustomInput
                    type="number"
                    placeholder="4"
                    name="capacity"
                    id="capacity"
                    label="Capacidad"
                    required="true"
                    v-model="table.capacity"
                    icon="IconFriends"
                    :errors="errors['capacity']">
                </CustomInput>
                <CustomInput
                    placeholder="Mesa en la terraza"
                    name="description"
                    id="description"
                    label="Descripción"
                    required="true"
                    v-model="table.description"
                    icon="IconFileDescription"
                    :errors="errors['description']">
                </CustomInput>
            </div>
            <div class="flex justify-end mt-4">
                <Button :on-click="fetchCreateTable" icon="IconDeviceFloppy" class="mx-2 py-1 bg-blue-400 rounded-lg text-white" label="Registrar"></Button>
            </div>
        </form>
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
            <CustomSelect
                icon="IconId"
                name="type_table_id"
                id="type_table_id"
                label="Tipo de mesa"
                v-model="filters.type_table_id"
                :options="typeTables"
                value_name="type_table"
                :errors="errors['type_table_id'] ? errors['type_table_id'] : []"
            >
            </CustomSelect>
            <CustomInput
                type="number"
                placeholder="1"
                name="number"
                id="number"
                label="N° de mesa"
                required="true"
                v-model="filters.number"
                icon="IconNumber"
                :errors="errors['number']">
            </CustomInput>
            <CustomInput
                placeholder="Mesa 1"
                name="name"
                id="name"
                label="Nombre"
                required="true"
                v-model="filters.name"
                icon="IconTable"
                :errors="errors['name']">
            </CustomInput>
            <CustomInput
                type="number"
                placeholder="4"
                name="capacity"
                id="capacity"
                label="Capacidad"
                required="true"
                v-model="filters.capacity"
                icon="IconFriends"
                :errors="errors['capacity']">
            </CustomInput>
            <CustomInput
                placeholder="Mesa en la terraza"
                name="description"
                id="description"
                label="Descripción"
                required="true"
                v-model="filters.description"
                icon="IconFileDescription"
                :errors="errors['description']">
            </CustomInput>
        </div>
        <div class="grid grid-cols-2 gap-2 mt-4">
            <Button button-class="border bg-white text-red-600 rounded-lg mb-3 hover:bg-red-600 hover:text-white" :on-click="cleanFilters" icon="IconTrashFilled" label="Limpiar filtros" type="button"></Button>
            <Button button-class="border bg-white text-blue-600 rounded-lg mb-3 hover:bg-blue-600 hover:text-white" :on-click="fetchTables" icon="IconFilterSearch" label="Aplicar filtros" type="button"></Button>
        </div>
    </Drawer>
  </section>

</template>

<script setup lang="ts">
    import {onMounted, ref, markRaw } from 'vue';
    import {Table, CreateTable, ColumnsExportAnsFilters} from '../../types/Tables/Table';
    import {TypeTable} from "../../types/TypeTables/TypeTable";
    import {Response} from '../../types/Response';
    import {StatusEmployeeEnum} from "../../types/Employees/StatusEmployeeEnum";
    import CustomInput from '../CustomInput.vue'
    import {defaultError, defaultErrorUser, showAlert} from "../../composables/SweetAlert";
    import HeaderModule from "../../components/Modules/HeaderModule.vue";
    import Button from "../../components/Button.vue";
    import TableModule from "../../components/Modules/TableModule.vue";
    import {Column} from "../../types/TableModule/Column";
    import SpanStatus from "../../components/Modules/SpanStatus.vue";
    import Modal from "../../components/Modal.vue";
    import TablerIcon from "../TablerIcon.vue";
    import Drawer from "../Drawer.vue";
    import {apiGet, apiPost} from "../../src/services/api";
    import {useExport} from "../../composables/Export";
    import CustomSelect from "../CustomSelect.vue";

    const tables = ref<Table>([]);
    const response = ref<Response<Table> | null>(null);
    const isModalOpen = ref(false);
    const isModalExport = ref(false);
    const errors = ref({});
    const isFetchTables = ref(false);
    const typeTables = ref<TypeTable[]>([]);

    const table = ref<CreateTable>({
        type_table_id: 0,
        number: 1,
        name: '',
        description: '',
        capacity: 4,
    });
    const columnsExport = ref<ColumnsExportAnsFilters>([]);
    const columns = ref<Column>([
        {key: 'id', label: 'ID'},
        {key: 'type_table.type_table', label: 'TIPO DE MESA'},
        {key: 'number', label: 'N DE MESA'},
        {key: 'name', label: 'NOMBRE'},
        {key: 'capacity', label: 'CAPACIDAD'},
        {key: 'description', label: 'DESCRIPCIÓN'},
        {key: 'status', label: 'ESTADO', enum: StatusEmployeeEnum, rowRenderer: markRaw(SpanStatus)},
    ]);
    const filters = ref<ColumnsExportAnsFilters>({
        type_table_id: 0,
        number: 1,
        name: '',
        description: '',
        capacity: 4,
    })
    const { fetchExport, columnsSelected, format, dataExport } = useExport();
    const isDrawerOpen = ref(false);

    const fetchTables = async (pageUrl: string = 'tables') => {
        tables.value = [];
        isFetchTables.value = true;
        try {
            const payload = {filters: filters.value, paginate: true};
            const res = await apiGet(pageUrl, payload);
            tables.value = res.data.tables.data;
            response.value = res.data.tables;
            columnsExport.value = res.data.columns_export;
            isFetchTables.value = false;
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
            isFetchTables.value = false;
        }
    };
    const fetchTypeTables = async () => {
        try {
            const res = await apiGet<TypeTable>('type-tables');
            typeTables.value = res.data.type_tables;
        } catch (error) {
            if(error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else if(error.response && error.response.data.errors){
                defaultErrorUser();
                errorsAddress.value = error.response.data.errors;
            }else{
                defaultError();
            }
        }
    };
    const fetchCreateTable = async () => {
        try {
            const res = await apiPost('tables', table.value);
            if(res.type === 'success'){
                showAlert(res.type, res.title, res.message);
                await fetchTables();
                closeModal();
                table.value = {};
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
    const handleExport = () => {
        const payload = {
            data_export: dataExport.value,
                filters: filters.value,
                format: format.value,
                columns_selected: columnsSelected.value
        };
        fetchExport('tables-export', payload, toggleModalExport);
    }
    const handleInputChange = () => {
        fetchTables();
    }
    const cleanFilters = () => {
        filters.value = {
            type_table_id: 0,
            number: '1',
            name: '',
            description: '',
            capacity: '1',
        }
        fetchTables();
    }
    const openModal = () => {
        isModalOpen.value = true;
        fetchTypeTables();
    };
    const closeModal = () => {
        isModalOpen.value = false;
    };
    const toggleModalExport = () => {
        isModalExport.value = !isModalExport.value;
    }
    const toggleDrawer = () => {
        isDrawerOpen.value = !isDrawerOpen.value;
    }
    onMounted(() => {
        fetchTables();
    })

</script>

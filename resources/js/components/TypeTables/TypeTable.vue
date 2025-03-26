<template>
    <!-- component -->
    <section class="p-4">
        <HeaderModule :total-records="response ? response.total : 0" title="TIPO DE MESAS">
            <template #section1>
                <Button icon="IconCloudUpload" label="Importar" button-class="border rounded-lg bg-white"></Button>
                <Button :onClick="openModal" buttonClass="border rounded-lg bg-[#A97E59] text-[#F2E9E0] hover:bg-blue-600" icon="IconPlus" label="Agregar tipo"></Button>
            </template>
            <template #section2>
                <Button :on-click="toggleModalExport" icon="IconCloudDownload" button-class="border-0 text-[#F2E9E0]" label="Exportar"></Button>
                <Button :onClick="fetchTypeTable" button-class="border-0 text-[#F2E9E0]" icon="IconRefresh" label="Recargar"></Button>
            </template>
            <template #section3>
                <CustomInput input-class="border text-gray-900 bg-gray-50 border-gray-300 " icon="IconSearch" v-model="filters.type_table" @input-change="handleInputChange" required="false" placeholder="Buscar..."  name="search" id="search"></CustomInput>
            </template>
        </HeaderModule>
        <TableModule :columns="columns" :is-fetch="isFetchTypeTable" :data="typeTables" :response="response" :onClick="fetchTypeTable" url-view="TypeTableDetails" url-delete="type-tables/">

        </TableModule>
        <Modal title="AGREGAR TIPO DE MESA" :is-modal-open="isModalOpen" @close="closeModal">
            <form class="max-w-5xl" @submit.prevent="fetchCreateTypeTable">
                <CustomInput
                    placeholder="Premium"
                    name="type"
                    id="type"
                    label="Tipo de mesa"
                    required=""
                    v-model="typeTable.type_table"
                    icon="IconMail"
                    :errors="errors['type_table']"
                >
                </CustomInput>
                <div class="flex justify-end mt-4">
                    <Button :on-click="fetchCreateTypeTable" icon="IconDeviceFloppy" class="mx-2 py-1 bg-blue-400 rounded-lg text-white" label="Registrar"></Button>
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
    </section>
</template>

<script setup lang="ts">
    import {onMounted, ref, markRaw } from 'vue';
    import {TypeTable, CreateTypeEmployee, ColumnsExportAnsFilters} from '../../types/TypeTables/TypeTable';
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
    import {useExport} from "../../composables/Export";

    const typeTables = ref<TypeTable>([]);
    const response = ref<Response<TypeCuTypeTablestomer> | null>(null);
    const isModalOpen = ref(false);
    const isModalExport = ref(false);
    const errors = ref({});
    const isFetchTypeTable = ref(false);
    const typeTable = ref<CreateTypeEmployee>({
        type_table: '',
    });
    const columnsExport = ref<ColumnsExportAnsFilters>({
        type_table: '',
    });
    const columns = ref<Column>([
        {key: 'id', label: 'ID'},
        {key: 'type_table', label: 'TIPO DE CLIENTE'},
        {key: 'status', label: 'ESTADO', enum: StatusEmployeeEnum, rowRenderer: markRaw(SpanStatus)},
    ]);
    const dataExport = ref('');
    const format = ref('');
    const columnsSelected = ref([]);
    const filters = ref<ColumnsExportAnsFilters>({
        type_table: ''
    })
    const { fetchExport } = useExport();
    const fetchTypeTable = async (pageUrl: string = 'type-tables') => {
        typeTables.value = [];
        isFetchTypeTable.value = true;
        try {
            const payload = {filters: filters.value, paginate: true};
            const res = await apiGet(pageUrl, payload);
            typeTables.value = res.data.type_tables.data;
            response.value = res.data.type_tables;
            columnsExport.value = res.data.columns_export;
            isFetchTypeTable.value = false;
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
            isFetchTypeTable.value = false;
        }
    };

    const fetchCreateTypeTable = async () => {
        try {
            const res = await apiPost('type-tables', typeTable.value);
            showAlert(res.type, res.title, res.message);
            await fetchTypeTable();
            closeModal();
            typeTable.value = {};
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
        fetchExport('type-tables-export', payload, format.value, toggleModalExport);
    }
    const handleInputChange = () => {
        fetchTypeTable();
    }
    const openModal = () => {
        isModalOpen.value = true;
    };
    const closeModal = () => {
        isModalOpen.value = false;
    };
    const toggleModalExport = () => {
        isModalExport.value = !isModalExport.value;
    }
    onMounted(() => {
        fetchTypeTable();
    })

</script>
